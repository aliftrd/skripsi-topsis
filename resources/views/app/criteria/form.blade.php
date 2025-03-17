@extends('layouts.app')

@php
    $actions = isset($criteria) ? __('general.actions.edit') : __('general.actions.create');
    $title = $actions . ' ' . __('criteria.nav.label');
@endphp

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('criteria.index') }}">{{ __('criteria.nav.label') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $actions }}</li>
                    </ol>
                </nav>
                <h3>{{ $title }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center  mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ $title }}</h5>
                        <a href="{{ route('criteria.index') }}" class="btn btn-warning d-flex">
                            <x-heroicon-o-chevron-left />
                            <span class="pl-2">{{ __('general.actions.back') }}</span>
                        </a>
                    </div>
                    <form method="POST"
                        action="{{ isset($criteria) ? route('criteria.update', $criteria->code) : route('criteria.store') }}">
                        @csrf
                        @if (isset($criteria))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="code">{{ __('criteria.field.code') }}</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                id="code" value="{{ old('code', $criteria->code ?? '') }}" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('criteria.field.name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $criteria->name ?? '') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('criteria.field.weight') }}</label>
                            <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror"
                                id="weight" value="{{ old('weight', $criteria->weight ?? '') }}" min="1"
                                max="5" required>
                            @error('weight')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button
                            type="submit"class="btn btn-sm btn-primary">{{ isset($criteria) ? __('general.actions.edit') : __('general.actions.save') }}</button>
                        @if (!isset($criteria))
                            <button type="submit" class="btn btn-sm btn-secondary" name="continue"
                                value="1">{{ __('general.actions.create_and_add_another') }}</button>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>

    @isset($criteria)
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center  mb-3">
                            <h5 class="card-title mr-auto mb-0">{{ __('criteria.nav.table.sub.title') }}</h5>
                            <a href="{{ route('criteria.sub-criteria.create', $criteria->code) }}"
                                class="btn btn-primary d-flex">
                                <x-heroicon-o-plus />
                                <span class="pl-2">{{ __('general.actions.create') }}</span>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td scope="col">{{ __('criteria.columns.no') }}</td>
                                        <td scope="col">{{ __('criteria.columns.description') }}</td>
                                        <td scope="col">{{ __('criteria.columns.weight') }}</td>
                                        @if (!$subcriterias->isEmpty())
                                            <td>{{ __('criteria.columns.action') }}</td>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($subcriterias->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center">{{ __('criteria.columns.empty') }}</td>
                                        </tr>
                                    @else
                                        @foreach ($subcriterias as $key => $subcriteria)
                                            <tr>
                                                <td>
                                                    {{ ($subcriterias->currentPage() - 1) * $subcriterias->perPage() + $loop->index + 1 }}
                                                </td>
                                                <td>{{ $subcriteria->name }}</td>
                                                <td>{{ $subcriteria->weight }}</td>
                                                <td>
                                                    <a href="{{ route('criteria.sub-criteria.edit', [$criteria->code, $subcriteria->code]) }}"
                                                        class="btn btn-warning mb-2">
                                                        <x-heroicon-o-pencil width="14px" />
                                                        <span class="pl-2">{{ __('general.actions.edit') }}</span>
                                                    </a>
                                                    <form
                                                        action="{{ route('criteria.sub-criteria.destroy', [$criteria->code, $subcriteria->code]) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger delete-button"
                                                            data-id="{{ $subcriteria->code }}">
                                                            <x-heroicon-o-trash width="14px" />
                                                            <span class="pl-2">{{ __('general.actions.delete') }}</span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
