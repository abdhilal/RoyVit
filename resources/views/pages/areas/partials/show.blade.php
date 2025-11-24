@extends('layouts.app')
@section('title')
    {{ __('Area details') }}
@endsection
@section('subTitle')
    {{ __('Area details') }}
@endsection
@section('breadcrumb')
    {{ __('Areas') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Area details') }}</h5>
                    <div>
                        <x-back :action="route('areas.index')" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <td>{{ $area->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $area->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Warehouse') }}</th>
                                    <td>{{ $area->warehouse?->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ $stats['transactions_count'] ?? 0 }}</div>
                                    <div class="text-muted">{{ __('Transactions') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ number_format($stats['value_income'] ?? 0, 2) }}</div>
                                    <div class="text-muted">{{ __('Value Income') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ number_format($stats['value_output'] ?? 0, 2) }}</div>
                                    <div class="text-muted">{{ __('Value Output') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ number_format($stats['value_gift'] ?? 0, 2) }}</div>
                                    <div class="text-muted">{{ __('Gift Value') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-2 mb-3">{{ __('Representatives') }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($area->representatives as $index => $rep)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ $rep->type == 'medical' ? route('representativesMedical.show', $rep) : route('representatives.show', $rep) }}"
                                                class="text-decoration-none">{{ $rep->name }}</a></td>
                                        <td>{{ __($rep->type) }}</td>
                                        <td>{{ $rep->warehouse?->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No representatives found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-2 mb-3">{{ __('Pharmacies') }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Representative') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($area->pharmacies as $index => $pharmacy)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ route('pharmacies.show', $pharmacy) }}"
                                                class="text-decoration-none">{{ $pharmacy->name }}</a></td>
                                        <td><a href="{{ route('representatives.show', $pharmacy->representative) }}"
                                                class="text-decoration-none">{{ $pharmacy->representative?->name }}</a>
                                        </td>
                                        <td>{{ $pharmacy->warehouse?->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No pharmacies found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
