@extends('layouts.app')

@php
    $actions = isset($user) ? __('general.actions.edit') : __('general.actions.create');
    $title = $actions . ' ' . __('user.nav.label');
@endphp

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-separator-1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.index') }}">{{ __('user.nav.label') }}</a>
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
                        <a href="{{ route('user.index') }}" class="btn btn-warning d-flex">
                            <x-heroicon-o-chevron-left />
                            <span class="pl-2">{{ __('general.actions.back') }}</span>
                        </a>
                    </div>
                    <form method="POST"
                        action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="name">{{ __('user.field.name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('user.field.email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">{{ __('user.field.role') }}</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" id="role"
                                required>
                                <option selected disabled>{{ __('general.label.select.default') }}</option>
                                @foreach (App\Enums\UserRoleEnums::cases() as $role)
                                    <option value="{{ $role }}"
                                        {{ isset($user) && $user->role == $role ? 'selected' : '' }}>
                                        {{ $role->getLabel() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('user.field.password') }}</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button
                            type="submit"class="btn btn-sm btn-primary">{{ isset($user) ? __('general.actions.edit') : __('general.actions.save') }}</button>
                        @if (!isset($user))
                            <button type="submit" class="btn btn-sm btn-secondary" name="continue"
                                value="1">{{ __('general.actions.create_and_add_another') }}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
