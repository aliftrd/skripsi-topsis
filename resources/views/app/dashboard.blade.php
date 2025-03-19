@extends('layouts.app')

@section('title', __('dashboard.nav.label'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <h3>{{ __('dashboard.nav.label') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('dashboard.total.citizen') }}</h5>
                    <h2 class="float-right">{{ $totalCitizen }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('dashboard.total.criteria') }}</h5>
                    <h2 class="float-right">{{ $totalCriteria }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">{{ __('dashboard.label.number-per-stage') }}</h5>
                        <form action="{{ route('dashboard') }}" method="get">
                            <div class="input-group">
                                <select name="year" id="year" class="form-control" required>
                                    <option selected disabled>{{ __('general.label.select.default') }}</option>
                                    @foreach ($availableYears as $value)
                                        <option value="{{ $value }}"
                                            {{ request()->input('year') != $value ?: 'selected' }}>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        {{ __('general.actions.search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (!$groupedCitizenByStage->isEmpty())
                        <canvas id="stage-chart">Your browser does not support the canvas element.</canvas>
                    @else
                        <p>{{ __('general.label.unavailable') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('dashboard.label.number-per-rt') }}</h5>
                    <canvas id="rt-chart">Your browser does not support the canvas element.</canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center  mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ __('dashboard.table.ten-citizens') }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('dashboard.columns.no') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.code') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.nik') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.name') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.rt') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.rw') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.province') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.district') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.subdistrict') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.village') }}</th>
                                    <th scope="col">{{ __('dashboard.columns.address') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tenCitizens->isEmpty())
                                    <tr>
                                        <td colspan="11" class="text-center">{{ __('dashboard.columns.empty') }}</td>
                                    </tr>
                                @else
                                    @foreach ($tenCitizens as $citizen)
                                        <tr>
                                            <td>
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td>{{ $citizen->code }}</td>
                                            <td>{{ $citizen->nik }}</td>
                                            <td>{{ $citizen->name }}</td>
                                            <td>{{ $citizen->rt }}</td>
                                            <td>{{ $citizen->rw }}</td>
                                            <td>{{ $citizen->province }}</td>
                                            <td>{{ $citizen->district }}</td>
                                            <td>{{ $citizen->subdistrict }}</td>
                                            <td>{{ $citizen->village }}</td>
                                            <td>{{ $citizen->address }}</td>
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
@endsection

@section('script')
    @php
        $groupedCitizenByStageLabel = $groupedCitizenByStage
            ->pluck('stage')
            ->map(function ($stage) {
                return $stage ? __('dashboard.columns.stage') . $stage : __('general.label.unavailable');
            })
            ->toArray();
        $groupedCitizenByStageCount = $groupedCitizenByStage->pluck('total')->toArray();
        $groupedCitizenByRTLabel = $groupedCitizenByRT
            ->pluck('rt')
            ->map(function ($stage) {
                return $stage ? __('dashboard.columns.rt') . $stage : __('general.label.unavailable');
            })
            ->toArray();
        $groupedCitizenByRTCount = $groupedCitizenByRT->pluck('total')->toArray();
    @endphp
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Chart(document.getElementById("stage-chart"), {
                type: "doughnut",
                data: {
                    labels: {!! json_encode($groupedCitizenByStageLabel) !!},
                    datasets: [{
                        label: `{!! __('dashboard.label.number-per-stage') !!}`,
                        data: {!! json_encode($groupedCitizenByStageCount) !!},
                        backgroundColor: [
                            "rgb(255, 99, 132)",
                            "rgb(54, 162, 235)",
                            "rgb(255, 205, 86)",
                            "rgb(75, 192, 192)",
                            "rgb(153, 102, 255)",
                            "rgb(255, 159, 64)"
                        ]
                    }]
                }
            });
            new Chart(document.getElementById("rt-chart"), {
                type: "bar",
                data: {
                    labels: {!! json_encode($groupedCitizenByRTLabel) !!},
                    datasets: [{
                        label: `{!! __('dashboard.label.number-per-rt') !!}`,
                        data: {!! json_encode($groupedCitizenByRTCount) !!},
                        fill: false,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(255, 159, 64, 0.2)",
                            "rgba(255, 205, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                            "rgba(201, 203, 207, 0.2)"
                        ],
                        borderColor: [
                            "rgb(255, 99, 132)",
                            "rgb(255, 159, 64)",
                            "rgb(255, 205, 86)",
                            "rgb(75, 192, 192)",
                            "rgb(54, 162, 235)",
                            "rgb(153, 102, 255)",
                            "rgb(201, 203, 207)"
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection
