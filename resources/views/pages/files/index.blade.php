@extends('layouts.app')
@section('title')
    {{ __('Files Manager') }}
@endsection
@section('subTitle')
    {{ __('Files') }}
@endsection
@section('breadcrumb')
    {{ __('Files') }}
@endsection
@section('breadcrumbActive')
    {{ __('Files') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5>{{ __('Files Manager') }}</h5>
          <x-create :action="route('files.create')" />
        </div>
      </div>
      <div class="card-body">
        <div class="mb-4">
          <h4 class="mb-3">{{ __('Quick Access') }}</h4>
          <ul class="d-flex flex-wrap gap-3 list-unstyled">
            <li>
              <div class="quick-box"><i class="fa-brands fa-youtube text-danger"></i></div>
              <h6 class="mb-2">{{ __('Videos') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-table-cells text-info"></i></div>
              <h6 class="mb-2">{{ __('Apps') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-file text-secondary"></i></div>
              <h6 class="mb-2">{{ __('Document') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-music text-warning"></i></div>
              <h6 class="mb-2">{{ __('Music') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-download text-primary"></i></div>
              <h6 class="mb-2">{{ __('Download') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-folder text-info"></i></div>
              <h6 class="mb-2">{{ __('Folder') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-file-zipper text-secondary"></i></div>
              <h6 class="mb-2">{{ __('Zip') }}</h6>
            </li>
            <li>
              <div class="quick-box"><i class="fa-solid fa-trash text-danger"></i></div>
              <h6 class="mb-2">{{ __('Trash') }}</h6>
            </li>
          </ul>
        </div>
        <div class="mb-4">
          <h4 class="mt-2 mb-3">{{ __('Folders') }}</h4>
          <ul class="folder list-unstyled d-flex flex-wrap gap-4">
            @forelse (($folders ?? []) as $folder)
              <li class="folder-box">
                <div class="d-block">
                  <i class="fa-solid fa-folder text-secondary fs-1"></i>
                  <i class="fa-solid fa-ellipsis-vertical ellips me-0"></i>
                  <div class="mt-3">
                    <h6 class="mb-2">{{ $folder->name ?? '-' }}</h6>
                    <p>{{ ($folder->files_count ?? 0) }} {{ __('file') }}<span class="pull-right"><i class="fa-solid fa-clock"></i> {{ ($folder->updated_at ?? '') }}</span></p>
                  </div>
                </div>
              </li>
            @empty
              <li class="folder-box">
                <div class="d-block">
                  <i class="fa-solid fa-folder text-secondary fs-1"></i>
                  <div class="mt-3">
                    <h6 class="mb-2">{{ __('No folders') }}</h6>
                    <p>0 {{ __('file') }}</p>
                  </div>
                </div>
              </li>
            @endforelse
          </ul>
        </div>
        <div>
          <h4 class="mt-2 mb-3">{{ __('Files') }}</h4>
          <ul class="d-flex flex-row flex-wrap files-content list-unstyled gap-3">
            @forelse (($files ?? []) as $file)
              <li class="folder-box d-flex align-items-center">
                <div class="d-flex align-items-center files-list">
                  <div class="flex-shrink-0 file-left"><i class="fa-solid fa-file text-info fs-4"></i></div>
                  <div class="flex-grow-1 ms-3">
                    <h5 class="f-w-600">{{ $file->name ?? '-' }}</h5>
                    <p>{{ ($file->updated_at ?? '') }}, {{ ($file->size_human ?? '') }}</p>
                  </div>
                </div>
              </li>
            @empty
              <li class="folder-box d-flex align-items-center">
                <div class="d-flex align-items-center files-list">
                  <div class="flex-shrink-0 file-left"><i class="fa-solid fa-file text-secondary fs-4"></i></div>
                  <div class="flex-grow-1 ms-3">
                    <h5 class="f-w-600">{{ __('No files found') }}</h5>
                  </div>
                </div>
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection