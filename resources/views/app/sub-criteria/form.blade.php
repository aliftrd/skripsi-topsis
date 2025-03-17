@extends('layouts.app')

@php
    $actions = isset($subcriteria) ? __('general.actions.edit') : __('general.actions.create');
    $title = $actions . ' ' . __('criteria.nav.subcriteria.label');
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
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('criteria.edit', $criteria->code) }}">{{ __('criteria.nav.subcriteria.label') }}</a>
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
                        <a href="{{ route('criteria.edit', $criteria->code) }}" class="btn btn-warning d-flex">
                            <x-heroicon-o-chevron-left />
                            <span class="pl-2">{{ __('general.actions.back') }}</span>
                        </a>
                    </div>
                    <form method="POST"
                        action="{{ isset($subcriteria) ? route('criteria.sub-criteria.update', [$criteria->code, $subcriteria->code]) : route('criteria.sub-criteria.store', $criteria->code) }}">
                        @csrf
                        @if (isset($subcriteria))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="code">{{ __('criteria.field.code') }}</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                id="code" value="{{ old('code', $subcriteria->code ?? '') }}" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('criteria.field.name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $subcriteria->name ?? '') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="weight">{{ __('criteria.field.weight') }}</label>
                            <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror"
                                id="weight" value="{{ old('weight', $subcriteria->weight ?? '') }}" required>
                            @error('weight')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button
                            type="submit"class="btn btn-sm btn-primary">{{ isset($subcriteria) ? __('general.actions.edit') : __('general.actions.save') }}</button>
                        @if (!isset($subcriteria))
                            <button type="submit" class="btn btn-sm btn-secondary" name="continue"
                                value="1">{{ __('general.actions.create_and_add_another') }}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
