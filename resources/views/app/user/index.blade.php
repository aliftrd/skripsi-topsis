@extends('layouts.app')

@section('title', __('user.nav.label'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{ __('user.nav.label') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('general.actions.list') }}</li>
                    </ol>
                </nav>
                <h3>{{ __('user.nav.label') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="card-title mr-auto mb-0">{{ __('user.nav.table.title') }}</h5>
                        @if (Auth::user()->isAdmin() || Auth::user()->isSAdmin())
                            <a href="{{ route('user.create') }}" class="btn btn-primary d-flex">
                                <x-heroicon-o-plus />
                                <span class="pl-2">{{ __('general.actions.create') }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('user.columns.no') }}</th>
                                    <th scope="col">{{ __('user.columns.name') }}</th>
                                    <th scope="col">{{ __('user.columns.email') }}</th>
                                    <th scope="col">{{ __('user.columns.role') }}</th>
                                    @if (!$users->isEmpty())
                                        <td>{{ __('user.columns.action') }}</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="11" class="text-center">{{ __('user.columns.empty') }}</td>
                                    </tr>
                                @else
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>
                                                {{ ($users->currentpage() - 1) * $users->perpage() + $loop->index + 1 }}
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role->getLabel() }}</td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning mb-2">
                                                    <x-heroicon-o-pencil width="14px" />
                                                    <span class="pl-2">{{ __('general.actions.edit') }}</span>
                                                </a>

                                                @php
                                                    $authUser = Auth::user();
                                                    $userRole = $user->role->value;
                                                    $canDelete = false;

                                                    if (
                                                        $authUser->isSAdmin() &&
                                                        $userRole != App\Enums\UserRoleEnums::SADMIN->value
                                                    ) {
                                                        // Super admin can delete any user except other super admins
                                                        $canDelete = true;
                                                    } elseif (
                                                        $authUser->isAdmin() &&
                                                        $userRole != App\Enums\UserRoleEnums::ADMIN->value &&
                                                        $userRole != App\Enums\UserRoleEnums::SADMIN->value
                                                    ) {
                                                        // Admin can delete regular users, but not admins or super admins
                                                        $canDelete = true;
                                                    }
                                                @endphp

                                                @if ($canDelete)
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger delete-button"
                                                            data-id="{{ $user->id }}">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
