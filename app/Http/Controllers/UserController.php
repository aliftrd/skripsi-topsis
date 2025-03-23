<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnums;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'adminOnly'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('app.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.user.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            rules: [
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique(User::class),
                ],
                'role' => [
                    'required',
                    Rule::enum(UserRoleEnums::class),
                ],
                'password' => [
                    'required',
                    Password::default(),
                ],
            ],
            attributes: [
                'name' => __('user.field.name'),
                'email' => __('user.field.email'),
                'role' => __('user.field.role'),
                'password' => __('user.field.password'),
            ]
        );

        User::create($validated);

        $request->session()->flash('success', __('general.notifications.created'));
        return $request->continue ?
            redirect()->route('user.create') :
            redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('app.user.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            rules: [
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique(User::class)->ignore($user->id),
                ],
                'role' => [
                    'required',
                    Rule::enum(UserRoleEnums::class),
                ],
                'password' => [
                    'nullable',
                    Password::default(),
                ],
            ],
            attributes: [
                'name' => __('user.field.name'),
                'email' => __('user.field.email'),
                'role' => __('user.field.role'),
                'password' => __('user.field.password'),
            ]
        );

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        $request->session()->flash('success', __('general.notifications.updated'));
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (User::where('role', 1)->count() <= 1) return redirect()->route('user.index')->with('error', __('general.notifications.error'));

        $user->delete();

        return redirect()->route('user.index')->with('success', __('general.notifications.deleted'));
    }
}
