@extends('layouts.app')

@section('title', __('profile.nav.label'))

@section('content')
    <x-profile-layout>
        <form action="{{ route('profile.update-profile') }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ __('profile.field.name') }}</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ auth()->user()->name }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('profile.field.email') }}</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">{{ __('profile.field.password') }}</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-sm btn-primary">{{ __('general.actions.edit') }}</button>
        </form>
    </x-profile-layout>
@endsection
