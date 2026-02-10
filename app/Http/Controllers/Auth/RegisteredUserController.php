<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', ['isManagerCreate' => false]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'NIK' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'NIK' => $request->NIK,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'is_manager' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the registration view for manager creating a customer.
     */
    public function createCustomer(): View
    {
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        return view('auth.register', ['isManagerCreate' => true]);
    }

    /**
     * Handle manager creating a customer account.
     */
    public function storeCustomer(Request $request): RedirectResponse
    {
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'NIK' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'NIK' => $request->NIK,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'is_manager' => false,
        ]);

        return redirect()->back()->with('success', 'Customer created successfully.');
    }
}
