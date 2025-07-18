<div class="tab-pane fade" id="cookie_consent_tab" role="tabpanel">
    <form action="{{ route('admin.update-cookie-consent') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Status') }}<span class="text-danger">*</span></label>
                    <select name="cookie_status" id="" class="form-select">
                        <option {{ $setting->cookie_status == 'active' ? 'selected' : '' }} value="active">
                            {{ __('Enable') }}</option>
                        <option {{ $setting->cookie_status == 'inactive' ? 'selected' : '' }} value="inactive">
                            {{ __('Disable') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Border') }}<span class="text-danger">*</span></label>
                    <select name="border" id="" class="form-select">
                        <option {{ $setting->border == 'none' ? 'selected' : '' }} value="none">
                            {{ __('None') }}</option>
                        <option {{ $setting->border == 'thin' ? 'selected' : '' }} value="thin">
                            {{ __('Thin') }}</option>
                        <option {{ $setting->border == 'normal' ? 'selected' : '' }} value="normal">
                            {{ __('Normal') }}</option>
                        <option {{ $setting->border == 'thick' ? 'selected' : '' }} value="thick">
                            {{ __('Thick') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Corner') }}<span class="text-danger">*</span></label>
                    <select name="corners" id="" class="form-select">
                        <option {{ $setting->corners == 'none' ? 'selected' : '' }} value="none">
                            {{ __('None') }}</option>
                        <option {{ $setting->corners == 'small' ? 'selected' : '' }} value="small">
                            {{ __('Small') }}</option>
                        <option {{ $setting->corners == 'normal' ? 'selected' : '' }} value="normal">
                            {{ __('Normal') }}</option>
                        <option {{ $setting->corners == 'large' ? 'selected' : '' }} value="large">
                            {{ __('Large') }}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="bg_color">{{ __('Background Color') }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="color" name="background_color" id="bg_color"
                        value="{{ $setting->background_color }}">

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="text_color">{{ __('Text Color') }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="color" name="text_color" id="text_color"
                        value="{{ $setting->text_color }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="border_color">{{ __('Border Color') }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="color" name="border_color" id="border_color"
                        value="{{ $setting->border_color }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="btn_bg_color">{{ __('Button Color') }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="color" name="btn_bg_color" id="btn_bg_color"
                        value="{{ $setting->btn_bg_color }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="btn_text_color">{{ __('Button Text Color') }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="color" name="btn_text_color" id="btn_text_color"
                        value="{{ $setting->btn_text_color }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Link Text') }}<span class="text-danger">*</span></label>
                    <input type="text" name="link_text" value="{{ $setting->link_text }}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{ __('Button Text') }}<span class="text-danger">*</span></label>
                    <input type="text" name="btn_text" value="{{ $setting->btn_text }}" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">{{ __('Link') }}<span class="text-danger">*</span></label>
                    <input type="text" name="link" value="{{ $setting->link }}" class="form-control">
                </div>
            </div>

        </div>
        <div class="form-group">
            <label for="cookie_text">{{ __('Message') }}<span class="text-danger">*</span></label>
            <textarea class="form-control text-area-5" name="message" id="cookie_text" cols="30" rows="5">{{ $setting->message }}</textarea>
        </div>
        <x-admin.update-button :text="__('Update')"></x-admin.update-button>
    </form>
</div>
