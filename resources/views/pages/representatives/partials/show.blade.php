@extends('layouts.app')
@section('title')
    {{ __('Representative details') }}
@endsection
@section('subTitle')
    {{ __('Representative details') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Representative details') }}</h5>
        <div>
          <x-edit :action="route('representatives.edit', $representative)" />
          <x-back :action="route('representatives.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $representative->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $representative->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Area') }}</th>
                <td>{{ $representative->area?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Warehouse') }}</th>
                <td>{{ $representative->warehouse?->name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <hr />
        <h5 class="mt-4 mb-3">{{ __('Pharmacies') }}</h5>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Area') }}</th>
                <th>{{ __('Warehouse') }}</th>
                <th>{{ __('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($representative->pharmacies as $index => $pharmacy)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    <a href="{{ route('pharmacies.show', $pharmacy) }}" class="text-decoration-none">
                      {{ $pharmacy->name }}
                    </a>
                  </td>
                  <td>{{ $pharmacy->area?->name }}</td>
                  <td>{{ $pharmacy->warehouse?->name }}</td>
                  <td>
                    <x-show :action="route('pharmacies.show', $pharmacy)" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">{{ __('No pharmacies found') }}</td>
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
