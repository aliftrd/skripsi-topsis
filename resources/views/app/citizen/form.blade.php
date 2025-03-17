@extends('layouts.app')

@php
    $actions = isset($citizen) ? __('general.actions.edit') : __('general.actions.create');
    $title = $actions . ' ' . __('citizen.nav.label');
@endphp

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('citizen.index') }}">{{ __('citizen.nav.label') }}</a>
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
                        <a href="{{ route('citizen.index') }}" class="btn btn-warning d-flex">
                            <x-heroicon-o-chevron-left />
                            <span class="pl-2">{{ __('general.actions.back') }}</span>
                        </a>
                    </div>
                    <form method="POST"
                        action="{{ isset($citizen) ? route('citizen.update', $citizen->code) : route('citizen.store') }}">
                        @csrf
                        @if (isset($citizen))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="code">{{ __('citizen.field.code') }}</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                id="code" value="{{ old('code', $citizen->code ?? '') }}" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">{{ __('citizen.field.nik') }}</label>
                            <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                id="nik" value="{{ old('nik', $citizen->nik ?? '') }}" required>
                            @error('nik')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('citizen.field.name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $citizen->name ?? '') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="province">{{ __('citizen.field.province') }}</label>
                            <input type="text" name="province"
                                class="form-control @error('province') is-invalid @enderror" id="province"
                                value="{{ old('province', $citizen->province ?? '') }}" required>
                            @error('province')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="district">{{ __('citizen.field.district') }}</label>
                            <input type="text" name="district"
                                class="form-control @error('district') is-invalid @enderror" id="district"
                                value="{{ old('district', $citizen->district ?? '') }}" required>
                            @error('district')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subdistrict">{{ __('citizen.field.subdistrict') }}</label>
                            <input type="text" name="subdistrict"
                                class="form-control @error('subdistrict') is-invalid @enderror" id="subdistrict"
                                value="{{ old('subdistrict', $citizen->subdistrict ?? '') }}" required>
                            @error('subdistrict')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="village">{{ __('citizen.field.village') }}</label>
                            <input type="text" name="village" class="form-control @error('village') is-invalid @enderror"
                                id="village" value="{{ old('village', $citizen->village ?? '') }}" required>
                            @error('village')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rt">{{ __('citizen.field.rt') }}</label>
                            <input type="number" name="rt" class="form-control @error('rt') is-invalid @enderror"
                                id="rt" value="{{ old('rt', $citizen->rt ?? '') }}" required>
                            @error('rt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rw">{{ __('citizen.field.rw') }}</label>
                            <input type="number" name="rw" class="form-control @error('rw') is-invalid @enderror"
                                id="rw" value="{{ old('rw', $citizen->rw ?? '') }}" required>
                            @error('rw')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('citizen.field.address') }}</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address" value="{{ old('address', $citizen->address ?? '') }}" min="1"
                                max="5" required>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @foreach ($criterias as $criteria)
                            <div class="form-group">
                                <label for="criteria_{{ $criteria->code }}">{{ $criteria->name }}</label>
                                <select name="criteria[{{ $criteria->code }}]" id="criteria_{{ $criteria->code }}"
                                    class="form-control @error('criteria.' . $criteria->code) is-invalid @enderror"
                                    required>
                                    <option selected disabled>{{ __('general.label.select.default') }}</option>
                                    @foreach ($criteria->subcriterias as $subcriteria)
                                        <option value="{{ $subcriteria->code }}"
                                            {{ isset($selectedCriteria[$criteria->code]) && $selectedCriteria[$criteria->code] == $subcriteria->code ? 'selected' : '' }}>
                                            {{ $subcriteria->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('criteria.' . $criteria->code)
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach

                        <button
                            type="submit"class="btn btn-sm btn-primary">{{ isset($citizen) ? __('general.actions.edit') : __('general.actions.save') }}</button>
                        @if (!isset($citizen))
                            <button type="submit" class="btn btn-sm btn-secondary" name="continue"
                                value="1">{{ __('general.actions.create_and_add_another') }}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
