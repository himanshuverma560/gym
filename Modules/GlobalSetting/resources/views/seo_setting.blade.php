@extends('admin.master_layout')
@section('title')
    <title>{{ __('SEO Setup') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>{{ __('SEO Setup') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('SEO Setup') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    <ul class="nav nav-pills flex-column" id="seo_tab" role="tablist">
                                        @foreach ($pages as $index => $page)
                                            <li class="nav-item border rounded mb-1">
                                                <a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                    id="error-tab-{{ $page->id }}" data-bs-toggle="tab"
                                                    href="#errorTab-{{ $page->id }}" role="tab"
                                                    aria-controls="errorTab-{{ $page->id }}"
                                                    aria-selected="true">{{ $page->page_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-9">
                                    <div class="border rounded">
                                        <div class="tab-content no-padding" id="settingsContent">
                                            @foreach ($pages as $index => $page)
                                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                                    id="errorTab-{{ $page->id }}" role="tabpanel"
                                                    aria-labelledby="error-tab-{{ $page->id }}">
                                                    <div class="card m-0">
                                                        <div class="card-body">
                                                            <form
                                                                action="{{ route('admin.update-seo-setting', $page->id) }}"
                                                                method="POST">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="">{{ __('Seo Title') }}<span
                                                                                    class="text-danger">*</span>
                                                                            </label>
                                                                            <input type="text" name="seo_title"
                                                                                class="form-control"
                                                                                value="{{ $page->seo_title }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="">{{ __('SEO Description') }}<span
                                                                                    class="text-danger">*</span></label>
                                                                            <textarea name="seo_description" id="" cols="30" rows="5" class="form-control text-area-5">{{ $page->seo_description }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <x-admin.update-button :text="__('Update')">
                                            </x-admin.update-button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
@push('js')
    <script>
        $(document).ready(function() {
            "use strict";
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#seo_tab a[href="#' + activeTab + '"]').tab('show');
            } else {
                $('#seo_tab a:first').tab('show');
            }

            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                var newTab = $(e.target).attr('href').substring(1);
                localStorage.setItem('activeTab', newTab);
            });
        });
    </script>
@endpush
