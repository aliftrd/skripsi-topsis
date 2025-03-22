@extends('layouts.app')

@php
    $actions = __('general.actions.show');
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
                    <div class="form-group">
                        <label for="code">{{ __('criteria.field.code') }}</label>
                        <input type="text" name="code" class="form-control" id="code"
                            value="{{ $criteria->code }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ __('criteria.field.name') }}</label>
                        <input type="text" name="name" class="form-control" id="name"
                            value="{{ $criteria->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ __('criteria.field.weight') }}</label>
                        <input type="number" name="weight" class="form-control" id="weight"
                            value="{{ $criteria->weight }}" readonly>
                    </div>
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
