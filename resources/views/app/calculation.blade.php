@extends('layouts.app')

@section('title', __('calculation.nav.label'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <h3>{{ __('calculation.nav.label') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center  mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.ranks') }}</h5>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            {{ __('calculation.nav.label.detail') }}
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('calculation.columns.no') }}</th>
                                    <th scope="col">{{ __('calculation.columns.name') }}</th>
                                    <th scope="col">P</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($citizenRanks as $citizen)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>{{ $citizen->name }}</td>
                                        <td>{{ $preferenceValue[$citizen->code] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <p>{{ __('calculation.label.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('calculation.nav.label.detail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.title') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('calculation.columns.no') }}</th>
                                            <th scope="col">{{ __('calculation.columns.name') }}</th>
                                            @foreach ($criterias as $criteria)
                                                <th scope="col">{{ $criteria->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($citizens as $citizen)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>{{ $citizen->name }}</td>
                                                @foreach ($criterias as $criteria)
                                                    <td>
                                                        {{ $citizen->subCriterias->firstWhere('criteria.code', $criteria->code)->weight ?? 0 }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.normalize') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('calculation.columns.no') }}</th>
                                            <th scope="col">{{ __('calculation.columns.name') }}</th>
                                            @foreach ($criterias as $criteria)
                                                <th scope="col">{{ $criteria->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($citizens as $citizen)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>{{ $citizen->name }}</td>
                                                @foreach ($criterias as $criteria)
                                                    <td>
                                                        {{ $normalizeMatrix[$citizen->code][$criteria->code] }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">{{ __('calculation.columns.total') }}</td>
                                            @foreach ($criterias as $criteria)
                                                <td>
                                                    {{ $normalizeMatrix['total'][$criteria->code] }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td colspan="2">{{ __('calculation.columns.sqrt') }}</td>
                                            @foreach ($criterias as $criteria)
                                                <td>
                                                    {{ $normalizeMatrix['sqrt'][$criteria->code] }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.normalize_rij') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('calculation.columns.no') }}</th>
                                            <th scope="col">{{ __('calculation.columns.name') }}</th>
                                            @foreach ($criterias as $criteria)
                                                <th scope="col">{{ $criteria->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($citizens as $citizen)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>{{ $citizen->name }}</td>
                                                @foreach ($criterias as $criteria)
                                                    <td>
                                                        {{ $matrixRij[$citizen->code][$criteria->code] }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.normalize_weight') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('calculation.columns.no') }}</th>
                                            <th scope="col">{{ __('calculation.columns.name') }}</th>
                                            @foreach ($criterias as $criteria)
                                                <th scope="col">{{ $criteria->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($citizens as $citizen)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>{{ $citizen->name }}</td>
                                                @foreach ($criterias as $criteria)
                                                    <td>
                                                        {{ $normalizeMatrixWeight[$citizen->code][$criteria->code] }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.matrix_max_min') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            @foreach ($criterias as $criteria)
                                                <th scope="col">{{ $criteria->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>A+</strong></td>
                                            @foreach ($criterias as $criteria)
                                                <td>{{ $minMax['plus'][$criteria->code] ?? '-' }}</td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>A-</strong></td>
                                            @foreach ($criterias as $criteria)
                                                <td>{{ $minMax['minus'][$criteria->code] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <h5 class="card-title mr-auto mb-0">{{ __('calculation.nav.table.preferences') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('calculation.columns.no') }}</th>
                                            <th scope="col">{{ __('calculation.columns.name') }}</th>
                                            <th scope="col">+</th>
                                            <th scope="col">-</th>
                                            <th scope="col">P</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($citizens as $citizen)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>{{ $citizen->name }}</td>
                                                <td>{{ $idealMinMaxDistance['plus'][$citizen->code] ?? '-' }}</td>
                                                <td>{{ $idealMinMaxDistance['minus'][$citizen->code] ?? '-' }}</td>
                                                <td>{{ $preferenceValue[$citizen->code] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
