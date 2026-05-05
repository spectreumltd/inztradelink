<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function supplierRegister()
    {
        return view('supplier');
    }

    public function supplierRegisterStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['nullable', 'string', 'max:20'],
        ]);
        DB::beginTransaction();

        try {
            //code...   
            $user = User::create([
                'role_id' => User::SUPPLIER,
                'name' => trim($validated['first_name'].' '.$validated['last_name']),
                'email' => $validated['email'],
                'phone' => $validated['mobile'] ?? null,
                'password' => Hash::make($validated['password']),
            ]);
            // $user->sendEmailVerificationNotification();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
        DB::commit();
        return redirect()->route('verification.notice')
            ->with('status', 'Your account is created. Please verify your email.');
    }
}
