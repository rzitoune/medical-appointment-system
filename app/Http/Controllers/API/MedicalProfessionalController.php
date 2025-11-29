<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfessionalResource;
use App\Models\MedicalProfessional;
use Illuminate\Http\Request;

class MedicalProfessionalController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalProfessional::with('user');

        if ($request->has('specialization') && $request->specialization != 'all') {
            $query->where('specialization', $request->specialization);
        }

        if ($request->has('teleconsultation')) {
            $query->where('is_teleconsultation_available', $request->boolean('teleconsultation'));
        }

        $professionals = $query->paginate(15);

        return ProfessionalResource::collection($professionals);
    }

    public function show($id)
    {
        $professional = MedicalProfessional::findOrFail($id);
        return new ProfessionalResource($professional);
    }

    public function bySpecialization($specialization)
    {
        $professionals = MedicalProfessional::where('specialization', $specialization)
                                            ->paginate(15);

        return ProfessionalResource::collection($professionals);
    }

    public function available()
    {
        $professionals = MedicalProfessional::where('is_teleconsultation_available', true)
                                            ->paginate(15);

        return ProfessionalResource::collection($professionals);
    }

    public function appointments($id, Request $request)
    {
        $professional = MedicalProfessional::findOrFail($id);
        $appointments = $professional->appointments()->paginate(15);

        return response()->json($appointments);
    }
}
