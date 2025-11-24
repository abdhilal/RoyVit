@extends('layouts.app')
@section('title')
    {{ __('Pharmacies') }}
@endsection
@section('subTitle')
    {{ __('Pharmacies') }}
@endsection
@section('breadcrumb')
    {{ __('Pharmacies') }}
@endsection
@section('breadcrumbActive')
    {{ __('Pharmacies') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <h5 class="mb-0">{{ __('Pharmacies') }}</h5>
                            <form action="{{ route('pharmacies.index') }}" method="GET"
                                class="d-flex align-items-center gap-2">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    style="width: 300px;" placeholder="{{ __('Search by pharmacy name or area') }}" />

                                <button type="submit" class="btn btn-secondary btn-sm">{{ __('Search') }}</button>
                                @if (request('search'))
                                    <a href="{{ route('pharmacies.index') }}"
                                        class="btn btn-light btn-sm">{{ __('Reset') }}</a>
                                @endif
                            </form>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Representative') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pharmacies as $index => $pharmacy)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ route('pharmacies.show', $pharmacy) }}"
                                                class="text-decoration-none">{{ $pharmacy->name }}</a></td>
                                        <td>{{ $pharmacy->warehouse?->name }}</td>
                                        <td>{{ $pharmacy->area?->name }}</td>
                                        <td>{{ $pharmacy->representative?->name }}</td>
                                        <td>
                                            @can('show-pharmacy')
                                                <x-show :action="route('pharmacies.show', $pharmacy)" />
                                            @endcan
                                         
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('No pharmacies found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($pharmacies->count())
                    <div class="card-footer">
                        @include('layouts.partials.pagination', ['page' => $pharmacies])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
