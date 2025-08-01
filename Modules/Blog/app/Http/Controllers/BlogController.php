<?php

namespace Modules\Blog\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Blog\app\Http\Requests\PostRequest;
use Modules\Blog\app\Models\Blog;
use Modules\Blog\app\Models\BlogCategory;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class BlogController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        checkAdminHasPermissionAndThrowException('blog.view');
        $posts = Blog::with('category.translation', 'translation')->latest()->paginate(15);
        return view('blog::Post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        checkAdminHasPermissionAndThrowException('blog.create');
        $categories = BlogCategory::where('status', 1)->get();
        return view('blog::Post.create', ['categories' => $categories]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('blog.store');
        $blog = Blog::create(array_merge(['admin_id' => Auth::guard('admin')->user()->id], $request->validated()));

        if ($blog && $request->hasFile('image')) {
            $file_name = file_upload($request->image, $blog->image, 'uploads/website-images/');
            $blog->image = $file_name;
            $blog->save();
        }

        $this->generateTranslations(
            TranslationModels::Blog,
            $blog,
            'blog_id',
            $request,
        );

        return $this->redirectWithMessage(
            RedirectType::CREATE->value,
            'admin.blogs.edit',
            [
                'blog' => $blog->id,
                'code' => allLanguages()->first()->code,
            ]
        );
    }

    public function show($id)
    {
        checkAdminHasPermissionAndThrowException('blog.view');
        return view('blog::show');
    }

    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('blog.edit');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::where('status', 1)->get();
        $languages = allLanguages();
        return view('blog::Post.edit', compact('blog', 'code', 'categories', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        checkAdminHasPermissionAndThrowException('blog.update');
        $validatedData = $request->validated();

        $blog = Blog::findOrFail($id);

        if ($blog && $request->hasFile('image')) {
            $file_name = file_upload($request->image, $blog->image, 'uploads/website-images/');
            $blog->image = $file_name;
            $blog->save();
        }

        $blog->update($validatedData);

        $this->updateTranslations(
            $blog,
            $request,
            $validatedData,
        );

        return $this->redirectWithMessage(
            RedirectType::UPDATE->value,
            'admin.blogs.edit',
            ['blog' => $blog->id, 'code' => $request->code]
        );
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('blog.delete');

        $blog = Blog::findOrFail($id);

        $blog->translations()->each(function ($translation) {
            $translation->post()->dissociate();
            $translation->delete();
        });

        if ($blog->image) {
            if (File::exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
        }

        $blog->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.blogs.index');
    }

    public function statusUpdate($id)
    {
        checkAdminHasPermissionAndThrowException('blog.update');

        $blog = Blog::find($id);
        $status = $blog->status == 1 ? 0 : 1;
        $blog->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}
