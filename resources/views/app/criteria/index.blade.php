@extends('layouts.app')

@section('title', __('criteria.nav.label'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item"><a href="{{ route('criteria.index') }}">{{ __('criteria.nav.label') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('general.actions.list') }}</li>
                    </ol>
                </nav>
                <h3>{{ __('criteria.nav.label') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center  mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ __('criteria.nav.table.title') }}</h5>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('criteria.create') }}" class="btn btn-primary d-flex">
                                <x-heroicon-o-plus />
                                <span class="pl-2">{{ __('general.actions.create') }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td scope="col">{{ __('criteria.columns.code') }}</td>
                                    <td scope="col">{{ __('criteria.columns.description') }}</td>
                                    <td scope="col">{{ __('criteria.columns.weight') }}</td>
                                    @if (!$criterias->isEmpty())
                                        <td>{{ __('criteria.columns.action') }}</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($criterias->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('criteria.columns.empty') }}</td>
                                    </tr>
                                @else
                                    @foreach ($criterias as $key => $criteria)
                                        <tr>
                                            <td>{{ $criteria->code }}</td>
                                            <td>{{ $criteria->name }}</td>
                                            <td>{{ $criteria->weight }}</td>
                                            <td>
                                                <a href="{{ route('criteria.show', $criteria->code) }}"
                                                    class="btn btn-info mb-2">
                                                    <x-heroicon-o-eye width="14px" />
                                                    <span class="pl-2">{{ __('general.actions.show') }}</span>
                                                </a>
                                                @if (Auth::user()->isAdmin())
                                                    <a href="{{ route('criteria.edit', $criteria->code) }}"
                                                        class="btn btn-warning mb-2">
                                                        <x-heroicon-o-pencil width="14px" />
                                                        <span class="pl-2">{{ __('general.actions.edit') }}</span>
                                                    </a>
                                                    <form action="{{ route('criteria.destroy', $criteria->code) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger delete-button"
                                                            data-id="{{ $criteria->code }}">
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
                        {{ $criterias->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
