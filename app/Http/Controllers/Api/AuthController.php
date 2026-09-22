<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $coach = \App\Models\User::first();
        $coachId = $coach ? $coach->id : 1;
        $code = (string) random_int(100000, 999999);

        $member = Member::create([
            'coach_id' => $coachId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'join_date' => now()->toDateString(),
            'status' => 'inactive',
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null,
            'verification_code' => $code,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::raw("Welcome to The Money Circle!\n\nYour 6-digit verification code is: {$code}\n\nEnter this code in the app to activate your account.", function ($msg) use ($member) {
                $msg->to($member->email)->subject('The Money Circle - Verify Your Email');
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Verification email delivery failed: ' . $e->getMessage());
        }

        return response()->json([
            'token' => $member->createToken('flutter-app')->plainTextToken,
            'member' => $member,
            'requires_verification' => true,
            'message' => 'Registration successful. A 6-digit verification code has been sent to your email.',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (! $member || ! Hash::check($request->password, $member->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $requiresVerification = ! $member->isEmailVerified();

        return response()->json([
            'token' => $member->createToken('flutter-app')->plainTextToken,
            'member' => $member,
            'requires_verification' => $requiresVerification,
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $member = $request->user();

        if ($member->isEmailVerified()) {
            return response()->json([
                'message' => 'Email is already verified.',
                'member' => $member,
            ]);
        }

        if (trim($request->code) !== (string) $member->verification_code) {
            throw ValidationException::withMessages([
                'code' => ['The verification code is incorrect. Please check your email and try again.'],
            ]);
        }

        $member->update([
            'email_verified_at' => now(),
            'verification_code' => null,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Account activated successfully!',
            'member' => $member->fresh(),
        ]);
    }

    public function resendVerificationCode(Request $request)
    {
        $member = $request->user();

        if ($member->isEmailVerified()) {
            return response()->json([
                'message' => 'Email is already verified.',
            ]);
        }

        $code = (string) random_int(100000, 999999);
        $member->update(['verification_code' => $code]);

        try {
            \Illuminate\Support\Facades\Mail::raw("Your new 6-digit verification code is: {$code}\n\nEnter this code in the app to activate your account.", function ($msg) use ($member) {
                $msg->to($member->email)->subject('The Money Circle - New Verification Code');
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Resend verification email failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'A new 6-digit verification code has been sent to your email.',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $member = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $member->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'member' => $member->fresh(),
        ]);
    }

    public function changePassword(Request $request)
    {
        $member = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($request->current_password, $member->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        $member->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'message' => 'Password changed successfully',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}