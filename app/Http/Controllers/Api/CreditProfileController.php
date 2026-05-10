<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreditProfileController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $profiles = CreditProfile::latest()->limit(50)->get();

        return response()->json(['data' => $profiles]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'income' => ['required', 'numeric', 'min:0'],
            'existing_debt' => ['required', 'numeric', 'min:0'],
            'monthly_expenses' => ['required', 'numeric', 'min:0'],
            'employment_status' => ['required', Rule::in(['full_time', 'part_time', 'contract', 'self_employed', 'unemployed'])],
            'housing_status' => ['nullable', 'string', 'max:100'],
            'marital_status' => ['nullable', 'string', 'max:100'],
            'dependents' => ['nullable', 'integer', 'min:0'],
        ]);

        $profile = CreditProfile::create($data);
        $profile->refreshScore();

        return response()->json(['message' => 'Credit profile created', 'data' => $profile], 201);
    }

    public function show(CreditProfile $creditProfile): JsonResponse
    {
        return response()->json(['data' => $creditProfile]);
    }

    public function updateBureau(Request $request, CreditProfile $creditProfile): JsonResponse
    {
        $data = $request->validate([
            'bureau_score' => ['required', 'integer', 'min:300', 'max:850'],
            'bureau_accounts' => ['nullable', 'integer', 'min:0'],
            'bureau_delinquencies' => ['nullable', 'integer', 'min:0'],
            'bureau_inquiries' => ['nullable', 'integer', 'min:0'],
        ]);

        $creditProfile->update($data);
        $creditProfile->refreshScore();

        return response()->json(['message' => 'Bureau data attached and score updated', 'data' => $creditProfile]);
    }

    public function score(CreditProfile $creditProfile): JsonResponse
    {
        return response()->json([
            'data' => [
                'score' => $creditProfile->score,
                'risk_decision' => $creditProfile->risk_decision,
                'profile' => $creditProfile,
            ],
        ]);
    }
}
