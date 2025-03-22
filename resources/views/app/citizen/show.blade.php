@extends('layouts.app')

@php
    $actions = __('general.actions.show');
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
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ $title }}</h5>
                        <a href="{{ route('citizen.index') }}" class="btn btn-warning d-flex">
                            <x-heroicon-o-chevron-left />
                            <span class="pl-2">{{ __('general.actions.back') }}</span>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code">{{ __('citizen.field.code') }}</label>
                                <input type="text" name="code" class="form-control" id="code"
                                    value="{{ $citizen->code }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nik">{{ __('citizen.field.nik') }}</label>
                                <input type="number" name="nik" class="form-control" id="nik"
                                    value="{{ $citizen->nik }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('citizen.field.name') }}</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $citizen->name }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="province">{{ __('citizen.field.province') }}</label>
                                <input type="text" name="province" class="form-control" id="province"
                                    value="{{ $citizen->province }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="district">{{ __('citizen.field.district') }}</label>
                                <input type="text" name="district" class="form-control" id="district"
                                    value="{{ $citizen->district }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subdistrict">{{ __('citizen.field.subdistrict') }}</label>
                                <input type="text" name="subdistrict" class="form-control" id="subdistrict"
                                    value="{{ $citizen->subdistrict }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="village">{{ __('citizen.field.village') }}</label>
                                <input type="text" name="village" class="form-control" id="village"
                                    value="{{ $citizen->village }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rt">{{ __('citizen.field.rt') }}</label>
                                <input type="number" name="rt" class="form-control" id="rt"
                                    value="{{ $citizen->rt }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rw">{{ __('citizen.field.rw') }}</label>
                                <input type="number" name="rw" class="form-control" id="rw"
                                    value="{{ $citizen->rw }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">{{ __('citizen.field.address') }}</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    value="{{ $citizen->address }}" readonly required>
                            </div>
                        </div>

                        @foreach ($criterias as $criteria)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="criteria_{{ $criteria->code }}">{{ $criteria->name }}</label>
                                    <select name="criteria[{{ $criteria->code }}]" id="criteria_{{ $criteria->code }}"
                                        class="form-control" disabled>
                                        <option selected disabled>{{ __('general.label.select.default') }}</option>
                                        @foreach ($criteria->subcriterias as $subcriteria)
                                            <option value="{{ $subcriteria->code }}"
                                                {{ isset($selectedCriteria[$criteria->code]) && $selectedCriteria[$criteria->code] == $subcriteria->code ? 'selected' : '' }}>
                                                {{ $subcriteria->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
