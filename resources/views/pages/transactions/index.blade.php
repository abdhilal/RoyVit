@extends('layouts.app')
@section('title')
    {{ __('Transactions') }}
@endsection
@section('subTitle')
    {{ __('Transactions') }}
@endsection
@section('breadcrumb')
    {{ __('Transactions') }}
@endsection
@section('breadcrumbActive')
    {{ __('Transactions') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5>{{ __('Transactions') }}</h5>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Pharmacy') }}</th>
                                    <th>{{ __('Representative') }}</th>
                                    <th>{{ __('Value Income') }}</th>
                                    <th>{{ __('Value Output') }}</th>
                                    <th>{{ __('Quantity Product') }}</th>
                                    <th>{{ __('Quantity Gift') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $index => $transaction)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ __($transaction->type) }}</td>
                                        <td>{{ $transaction->pharmacy?->name }}</td>
                                        <td>{{ $transaction->representative?->name }}</td>
                                        <td>{{ $transaction->value_income }}</td>
                                        <td>{{ $transaction->value_output }}</td>
                                        <td>{{ $transaction->quantity_product }}</td>
                                        <td>{{ $transaction->quantity_gift }}</td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">{{ __('No transactions found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $transactions->count())
                    <div class="card-footer">
                        @include('layouts.partials.pagination', ['page' => $transactions])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
