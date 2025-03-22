<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <h5 class="card-title mr-auto mb-0">{{ __('criteria.nav.table.sub.title') }}</h5>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('criteria.sub-criteria.create', $criteria->code) }}" class="btn btn-primary d-flex">
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
                        @if (!$subcriterias->isEmpty() && Auth::user()->isAdmin())
                            <td>{{ __('criteria.columns.action') }}</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($subcriterias->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">{{ __('criteria.columns.empty') }}</td>
                        </tr>
                    @else
                        @foreach ($subcriterias as $subcriteria)
                            <tr>
                                <td>{{ $subcriteria->code }}</td>
                                <td>{{ $subcriteria->name }}</td>
                                <td>{{ $subcriteria->weight }}</td>
                                @if (Auth::user()->isAdmin())
                                    <td>
                                        <a href="{{ route('criteria.sub-criteria.edit', [$criteria->code, $subcriteria->code]) }}"
                                            class="btn btn-warning mb-2">
                                            <x-heroicon-o-pencil width="14px" />
                                            <span class="pl-2">{{ __('general.actions.edit') }}</span>
                                        </a>
                                        <form
                                            action="{{ route('criteria.sub-criteria.destroy', [$criteria->code, $subcriteria->code]) }}"
                                            method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-button"
                                                data-id="{{ $subcriteria->code }}">
                                                <x-heroicon-o-trash width="14px" />
                                                <span class="pl-2">{{ __('general.actions.delete') }}</span>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
