@extends('layouts.app')

@section('title', __('assessment.nav.label'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item"><a href="{{ route('assessment') }}">{{ __('assessment.nav.label') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('general.actions.list') }}</li>
                    </ol>
                </nav>
                <h3>{{ __('assessment.nav.label') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center  mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ __('assessment.nav.table.title') }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('assessment.columns.no') }}</th>
                                    <th scope="col">{{ __('assessment.columns.name') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th scope="col">{{ $criteria->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if ($citizens->isEmpty())
                                    <tr>
                                        <td colspan="{{ 2 + $criterias->count() }}" class="text-center">
                                            {{ __('criteria.columns.empty') }}</td>
                                    </tr>
                                @else
                                    @foreach ($citizens as $key => $citizen)
                                        <tr>
                                            <td>
                                                {{ ($citizens->currentpage() - 1) * $citizens->perpage() + $loop->index + 1 }}
                                            </td>
                                            <td>
                                                <a href="{{ route('citizen.edit', $citizen->code) }}">
                                                    {{ $citizen->name }}
                                                </a>
                                            </td>
                                            @foreach ($criterias as $criteria)
                                                <td>
                                                    @php
                                                        $subCriteria = $citizen->subCriterias->firstWhere(
                                                            'criteria.code',
                                                            $criteria->code,
                                                        );
                                                    @endphp
                                                    {{ $subCriteria ? $subCriteria->weight : __('general.label.unfilled') }}
                                                </td>
                                            @endforeach
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
@endsection
