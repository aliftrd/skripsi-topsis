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
                <x-criteria.subcriteria-table :criteria="$criteria" :subcriterias="$subcriterias" />
            </div>
        </div>
    @endisset
@endsection
