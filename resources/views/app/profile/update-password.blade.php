@extends('layouts.app')

@section('title', __('profile.nav.label'))

@section('content')
    <x-profile-layout>
        <form action="{{ route('profile.do-update-password') }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="old-password">{{ __('profile.field.old_password') }}</label>
                <input type="password" name="old_password" id="old-password"
                    class="form-control @error('old_password') is-invalid @enderror" required>
                @error('old_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="new-password">{{ __('profile.field.new_password') }}</label>
                <input type="password" name="new_password" id="new-password"
                    class="form-control @error('new_password') is-invalid @enderror" required>
                @error('new_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="confirmed-password">{{ __('profile.field.confirm_password') }}</label>
                <input type="password" name="confirm_password" id="confirmed-password"
                    class="form-control @error('confirm_password') is-invalid @enderror" required>
                @error('confirm_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-sm btn-primary">{{ __('general.actions.edit') }}</button>
        </form>
    </x-profile-layout>
@endsection
