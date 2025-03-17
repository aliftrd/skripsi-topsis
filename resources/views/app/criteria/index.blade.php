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
                        <a href="{{ route('criteria.create') }}" class="btn btn-primary d-flex">
                            <x-heroicon-o-plus />
                            <span class="pl-2">{{ __('general.actions.create') }}</span>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('criteria.columns.no') }}</th>
                                    <th scope="col">{{ __('criteria.columns.code') }}</th>
                                    <th scope="col">{{ __('criteria.columns.description') }}</th>
                                    <th scope="col">{{ __('criteria.columns.weight') }}</th>
                                    @if (!$criterias->isEmpty())
                                        <td>{{ __('criteria.columns.action') }}</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($criterias->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('criteria.columns.empty') }}</td>
                                    </tr>
                                @else
                                    @foreach ($criterias as $key => $criteria)
                                        <tr>
                                            <td>
                                                {{ ($criterias->currentpage() - 1) * $criterias->perpage() + $loop->index + 1 }}
                                            </td>
                                            <td>{{ $criteria->code }}</td>
                                            <td>{{ $criteria->name }}</td>
                                            <td>{{ $criteria->weight }}</td>
                                            <td>
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
