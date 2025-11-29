<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfessionalRequest;
use App\Models\User;
use App\Models\MedicalProfessional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfessionalAuthController extends Controller
{
    public function register(StoreProfessionalRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'user_type' => 'professional',
        ]);

        MedicalProfessional::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'rpps_number' => $request->rpps_number,
            'qualifications' => $request->qualifications,
            'work_address' => $request->work_address,
            'consultation_duration' => $request->consultation_duration ?? 30,
            'consultation_price' => $request->consultation_price,
            'is_teleconsultation_available' => $request->is_teleconsultation_available ?? false,
            'spoken_languages' => $request->spoken_languages,
            'accepted_insurance' => $request->accepted_insurance,
        ]);

        $token = $user->createToken('professional-token')->plainTextToken;

        return response()->json([
            'message' => 'Professional registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('user_type', 'professional')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('professional-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
