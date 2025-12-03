@extends('layouts.app')
@section('title')
    {{ __('Tree Products Manager') }}
@endsection
@section('subTitle')
    {{ __('Tree Products') }}
@endsection
@section('breadcrumb')
    {{ __('Tree Products') }}
@endsection
@section('breadcrumbActive')
    {{ __('Tree Products Manager') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Tree Products Manager') }}</h5>


                    </div>



                </div>
                <div class="card-body">
                    <h4 class="mt-2 mb-3">{{ __('Tree Products') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Date') }}</th>

                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (($dates ?? []) as $index => $date)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ __('Tree Products') }}</td>

                                        <td>{{ $date }}</td>


                                        <td>

                                            <x-delete-form :action="route('TreeProducts.destroy', $date)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No Tree Products found') }}</td>
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
