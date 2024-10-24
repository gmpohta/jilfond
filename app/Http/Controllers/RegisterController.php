<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Cart\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

final class RegisterController extends Controller
{
    private TransferService $transferCartService;

    public function __construct(
        TransferService $transferCartService
    ) {
        $this->transferCartService = $transferCartService;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        // Лучше переделать через события
        ($this->transferCartService)(auth()->id());

        return redirect()->route('products')->with('success');
    }
}
