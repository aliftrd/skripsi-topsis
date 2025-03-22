@extends('layouts.app')

@section('title', __('citizen.nav.label'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item"><a href="{{ route('citizen.index') }}">{{ __('citizen.nav.label') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('general.actions.list') }}</li>
                    </ol>
                </nav>
                <h3>{{ __('citizen.nav.label') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ __('citizen.nav.table.title') }}</h5>
                        @if (Auth::user()->isAdmin())
                            <button type="button" class="btn btn-success d-flex mr-2" data-toggle="modal"
                                data-target="#importModal">
                                <x-heroicon-o-arrow-up-tray />
                                <span class="pl-2">{{ __('general.actions.import') }}</span>
                            </button>
                            <a href="{{ route('citizen.create') }}" class="btn btn-primary d-flex">
                                <x-heroicon-o-plus />
                                <span class="pl-2">{{ __('general.actions.create') }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('citizen.columns.no') }}</th>
                                    <th scope="col">{{ __('citizen.columns.code') }}</th>
                                    <th scope="col">{{ __('citizen.columns.nik') }}</th>
                                    <th scope="col">{{ __('citizen.columns.name') }}</th>
                                    <th scope="col">{{ __('citizen.columns.rt') }}</th>
                                    <th scope="col">{{ __('citizen.columns.rw') }}</th>
                                    <th scope="col">{{ __('citizen.columns.province') }}</th>
                                    <th scope="col">{{ __('citizen.columns.district') }}</th>
                                    <th scope="col">{{ __('citizen.columns.subdistrict') }}</th>
                                    <th scope="col">{{ __('citizen.columns.village') }}</th>
                                    <th scope="col">{{ __('citizen.columns.address') }}</th>
                                    @if (!$citizens->isEmpty())
                                        <td>{{ __('citizen.columns.action') }}</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($citizens->isEmpty())
                                    <tr>
                                        <td colspan="11" class="text-center">{{ __('citizen.columns.empty') }}</td>
                                    </tr>
                                @else
                                    @foreach ($citizens as $key => $citizen)
                                        <tr>
                                            <td>
                                                {{ ($citizens->currentpage() - 1) * $citizens->perpage() + $loop->index + 1 }}
                                            </td>
                                            <td>{{ $citizen->code }}</td>
                                            <td>{{ $citizen->nik }}</td>
                                            <td>{{ $citizen->name }}</td>
                                            <td>{{ $citizen->rt }}</td>
                                            <td>{{ $citizen->rw }}</td>
                                            <td>{{ $citizen->province }}</td>
                                            <td>{{ $citizen->district }}</td>
                                            <td>{{ $citizen->subdistrict }}</td>
                                            <td>{{ $citizen->village }}</td>
                                            <td>{{ $citizen->address }}</td>
                                            <td>
                                                <a href="{{ route('citizen.show', $citizen->code) }}"
                                                    class="btn btn-info mb-2">
                                                    <x-heroicon-o-eye width="14px" />
                                                    <span class="pl-2">{{ __('general.actions.show') }}</span>
                                                </a>
                                                @if (Auth::user()->isAdmin())
                                                    <a href="{{ route('citizen.edit', $citizen->code) }}"
                                                        class="btn btn-warning mb-2">
                                                        <x-heroicon-o-pencil width="14px" />
                                                        <span class="pl-2">{{ __('general.actions.edit') }}</span>
                                                    </a>
                                                    <form action="{{ route('citizen.destroy', $citizen->code) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger delete-button"
                                                            data-id="{{ $citizen->code }}">
                                                            <x-heroicon-o-trash width="14px" />
                                                            <span class="pl-2">{{ __('general.actions.delete') }}</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        {{ $citizens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">{{ __('general.actions.import') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('citizen.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="custom-file mb-3">
                                <input type="file" name="importFile"
                                    class="custom-file-input form-control @error('importFile') is-invalid @enderror"
                                    id="upload-file" accept=".xls,.xlsx,.csv">
                                <label class="custom-file-label" for="upload-file"
                                    aria-describedby="upload-file">{{ __('general.field.choose-file') }}</label>
                                @error('importFile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <button class="btn btn-primary">{{ __('general.actions.import') }}</button>
                            <a href="{{ asset('example/import-example.xlsx') }}" download
                                class="btn btn-success">{{ __('general.actions.download.example') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
