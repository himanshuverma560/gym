@extends('admin.master_layout')
@section('title')
    <title>{{ __('Custom CSS & JS') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('Custom CSS & JS') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Custom CSS & JS') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="border rounded">
                                        <div class="m-0 card">
                                            <div class="card-body">
                                                <form action="{{ route('admin.update-custom-code') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">{{ __('Custom CSS') }}</label>
                                                                <textarea name="css" id="css-editor" cols="30" rows="5" class="form-control text-area-5">{{ old('css', $customCode->css) }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">{{ __('Custom JS') }}</label>
                                                                <textarea name="javascript" id="js-editor" cols="30" rows="5" class="form-control text-area-5">{{ old('javascript', $customCode->javascript) }}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <x-admin.update-button :text="__('Update')">
                                            </x-admin.update-button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/codemirror/codemirror.css') }}">
@endpush

@push('js')
    <script src="{{ asset('backend/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('backend/codemirror/javascript.js') }}"></script>
    <script src="{{ asset('backend/codemirror/css.js') }}"></script>

    <script>
        "use strict";
        var editor = CodeMirror.fromTextArea(document.getElementById('css-editor'), {
            mode: "css",
            lineNumbers: true,
            lineWrapping: true,
            autocorrect: true,
        });
        editor.save()
        var editorJs = CodeMirror.fromTextArea(document.getElementById('js-editor'), {
            mode: "javascript",
            lineNumbers: true,
            lineWrapping: true,
            autocorrect: true,
        });
        editorJs.save()
    </script>
@endpush
