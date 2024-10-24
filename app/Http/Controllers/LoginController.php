<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Cart\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class LoginController extends Controller
{
    private TransferService $transferCartService;

    public function __construct(
        TransferService $transferCartService
    ) {
        $this->transferCartService = $transferCartService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Лучше переделать через события
            ($this->transferCartService)(auth()->id());

            return redirect()->intended('/')->with('success');
        }

        return back()->withInput()->with('error', 'Неверный адрес электронной почты или пароль.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('products')->with('success');
    }
}
