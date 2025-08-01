@extends('admin.master_layout')
@section('title')
    <title>{{ __('Withdraw Method') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Withdraw Method') }}</h1>
            </div>

            <div class="section-body">
                <a href="{{ route('admin.withdraw-method.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                    {{ __('Add New') }}</a>
                <div class="row mt-4">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.withdraw-method.index') }}" method="GET"
                                    onchange="this.submit()" class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <div class="search_wrapper">
                                                <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                    class="form-control" placeholder="{{ __('Search') }}">
                                                <button class="search_button" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <select name="status" id="status" class="form-select">
                                                <option value="">{{ __('Select Status') }}</option>
                                                <option value="active"
                                                    {{ request('status') == 'active' ? 'selected' : '' }}>
                                                    {{ __('Active') }}
                                                </option>
                                                <option value="inactive"
                                                    {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                                    {{ __('In-Active') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <select name="order_by" id="order_by" class="form-select">
                                                <option value="">{{ __('Order By') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>
                                                    {{ __('ASC') }}
                                                </option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>
                                                    {{ __('DESC') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <select name="par-page" id="par-page" class="form-select">
                                                <option value="">{{ __('Per Page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                                <option value="all"
                                                    {{ 'all' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('All') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Minimum Amount') }}</th>
                                                <th>{{ __('Maximum Amount') }}</th>
                                                <th>{{ __('Charge') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($methods as $index => $method)
                                                <tr>
                                                    <td>{{ $methods->firstItem() + $index }}</td>
                                                    <td>{{ $method->name }}</td>
                                                    <td>
                                                        {{ currency($method->min_amount) }}

                                                    </td>
                                                    <td>
                                                        {{ currency($method->max_amount) }}

                                                    </td>
                                                    <td>{{ $method->withdraw_charge }}%</td>
                                                    <td>
                                                        @if ($method->status == 'active')
                                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ __('InActive') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.withdraw-method.edit', $method->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"
                                                                aria-hidden="true"></i></a>
                                                        <a href="javascript:;" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal" class="btn btn-danger btn-sm"
                                                            onclick="deleteData({{ $method->id }})"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></a>

                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Method')" route="admin.withdraw-method.create"
                                                    create="yes" :message="__('No data found!')" colspan="7"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if (request()->get('par-page') !== 'all')
                                    <div class="float-right">
                                        {{ $methods->onEachSide(3)->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <script>
        "use strict"

        function deleteData(id) {
            $("#deleteForm").attr("action", '{{ url('admin/withdraw-method/') }}' + "/" + id)
        }
    </script>
@endsection
