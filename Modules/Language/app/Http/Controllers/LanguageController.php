<?php

namespace Modules\Language\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Language\app\Enums\AllCountriesDetailsEnum;
use Modules\Language\app\Enums\SyncLanguageType;
use Modules\Language\app\Http\Requests\LanguageRequest;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\LanguageTrait;
use Modules\Language\app\Traits\SyncModelsTrait;

class LanguageController extends Controller
{
    use LanguageTrait, RedirectHelperTrait, SyncModelsTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        checkAdminHasPermissionAndThrowException('language.view');
        Paginator::useBootstrap();
        $languages = Language::paginate(15);

        return view('language::index', [
            'languages' => $languages,
        ]);
    }

    public function create(): View
    {
        checkAdminHasPermissionAndThrowException('language.create');
        $all_languages = AllCountriesDetailsEnum::getLanguages();

        return view('language::create', compact('all_languages'));
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('language.store');

        DB::beginTransaction();
        $data = $request->validated();
        $data['direction'] = $this->rtlCodeList($request->code) ? 'rtl' : 'ltr';
        $language = Language::create($data);



        if ($language) {
            $code = $language->code;
            $parentDir = dirname(resource_path());

            $sourcePath = $parentDir . '/resources/lang/en.json';
            $destinationPath = $parentDir . "/resources/lang/{$code}.json";
            if (File::exists($sourcePath) && !File::exists($destinationPath)) {
                $jsonData = File::get($sourcePath);
                File::put($destinationPath, $jsonData);
            }
        }

        $this->syncModels(SyncLanguageType::CREATE->value, boolval(SyncLanguageType::isQueueable()), $language->code);
        DB::commit();
        return $this->redirectWithMessage(
            RedirectType::CREATE->value,
            'admin.languages.index',
        );
    }

    public function edit(Language $language): View
    {
        checkAdminHasPermissionAndThrowException('language.edit');
        $all_languages = AllCountriesDetailsEnum::getLanguages();

        return view('language::edit', compact('language', 'all_languages'));
    }

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('language.update');
        $oldCode = $language->code;
        $data = $request->validated();
        $data['direction'] = $this->rtlCodeList($request->code) ? 'rtl' : 'ltr';
        $language->update($data);


        $code = $language->code;

        if ($language && ($oldCode !== $code) && ($code !== 'en')) {
            $parentDir = dirname(resource_path());

            $sourcePath = $parentDir . '/resources/lang/en.json';
            $destinationPath = $parentDir . "/resources/lang/{$code}.json";

            if (File::exists($sourcePath) && !File::exists($destinationPath)) {
                $jsonData = File::get($sourcePath);
                File::put($destinationPath, $jsonData);
            }

            if ($oldCode !== $code && $code !== 'en') {
                $destinationPath = $parentDir . "/resources/lang/{$oldCode}.json";
                try {
                    File::delete($destinationPath);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        $this->syncModels(SyncLanguageType::UPDATE->value, boolval(SyncLanguageType::isQueueable()), $language->code, $oldCode);

        return $this->redirectWithMessage(
            RedirectType::UPDATE->value,
            'admin.languages.index',
        );
    }

    public function destroy(Language $language): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('language.delete');
        if ($language->id == 1) {
            return $this->redirectWithMessage(
                RedirectType::ERROR->value,
                'admin.languages.index',
            );
        }

        $code = $language->code;
        if ($code == app()->getLocale() || $code == 'en') {
            return $this->redirectWithMessage(
                RedirectType::ERROR->value,
                'admin.languages.index',
            );
        }

        if ($language->icon) {
            if (File::exists(public_path($language->icon))) {
                unlink(public_path($language->icon));
            }
        }

        if ($code !== 'en' && $deleted = $language->delete()) {
            $destinationPath = dirname(resource_path()) . "/resources/lang/{$code}.json";

            File::delete($destinationPath);
        }

        if ($deleted) {
            $this->syncModels(SyncLanguageType::DELETE->value, boolval(SyncLanguageType::isQueueable()), $code);
        }

        return $this->redirectWithMessage(
            RedirectType::DELETE->value,
            'admin.languages.index',
        );
    }

    public function updateStatus(Language $language): JsonResponse
    {
        checkAdminHasPermissionAndThrowException('language.update');


        if (request('column') == 'is_default') {
            $isDefault = $language->is_default ? 0 : 1;
            if ($isDefault == 0) {
                $languages = Language::where('is_default', 1)->get();
                if ($languages->count() == 1) {
                    return response()->json([
                        'status' => false,
                        'message' => __('Should Have At Least One Default Language!')
                    ]);
                }
            }
            Language::where('is_default', 1)->update(['is_default' => 0]);

            $language->is_default = $isDefault;

            if ($language->status == 0) {
                $language->status = 1;
            }

            cache()->forget('defaultLanguage');
            session()->forget('lang');
        } elseif (request('column') == 'status') {
            $status = $language->status ? 0 : 1;

            if ($status == 0) {
                $languages = Language::where('status', 1)->get();
                if ($languages->count() == 1) {
                    return response()->json([
                        'status' => false,
                        'message' => __('Should Have At Least One Active Language!')
                    ]);
                }
                if ($language->code == session('lang')) {
                    session()->put('lang', getDefaultLanguage());
                }
            }
            if ($language->is_default == 1) {
                $language->status = 1;
            } else {
                $language->status = $status;
            }
        }

        $action = $language->save();
        Artisan::call('cache:clear');

        return response()->json([
            'status' => $action,
            'message' => $action ? __('Language Updated Successfully!') : __('Language Updating Failed!'),
        ]);
    }

    protected function rtlCodeList($lang = null)
    {
        $lists = [
            'ar',
            'arc',
            'dv',
            'fa',
            'ha',
            'he',
            'khw',
            'ks',
            'ku',
            'ps',
            'ur',
            'yi'
        ];

        if ($lang) {
            return in_array($lang, $lists) ? true : false;
        }
        return $lists;
    }
}
