<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'income',
        'existing_debt',
        'monthly_expenses',
        'employment_status',
        'housing_status',
        'marital_status',
        'dependents',
        'bureau_score',
        'bureau_accounts',
        'bureau_delinquencies',
        'bureau_inquiries',
        'score',
        'risk_decision',
    ];

    protected $casts = [
        'income' => 'integer',
        'existing_debt' => 'integer',
        'monthly_expenses' => 'integer',
        'dependents' => 'integer',
        'bureau_score' => 'integer',
        'bureau_accounts' => 'integer',
        'bureau_delinquencies' => 'integer',
        'bureau_inquiries' => 'integer',
        'score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refreshScore(): self
    {
        $baseScore = $this->bureau_score ?: 600;
        $debtRatio = $this->income > 0 ? ($this->existing_debt + $this->monthly_expenses) / $this->income : 1;

        $points = 0;
        $points += match (true) {
            $this->income >= 15000 => 80,
            $this->income >= 8000 => 50,
            $this->income > 0 => 20,
            default => 0,
        };

        $points += match (true) {
            $debtRatio < 0.2 => 50,
            $debtRatio < 0.4 => 30,
            $debtRatio < 0.6 => 10,
            default => -20,
        };

        $points += match ($this->employment_status) {
            'full_time' => 40,
            'contract' => 20,
            'self_employed' => 15,
            'part_time' => 10,
            'unemployed' => -10,
            default => 0,
        };

        $points += match ($this->bureau_delinquencies) {
            0 => 40,
            1 => 10,
            2 => -10,
            default => -30,
        };

        $points += match ($this->bureau_inquiries) {
            0 => 20,
            1 => 10,
            2 => -5,
            default => -20,
        };

        $score = (int) min(850, max(300, $baseScore * 0.45 + $points * 1.2));
        $riskDecision = match (true) {
            $score >= 720 => 'low',
            $score >= 620 => 'medium',
            default => 'high',
        };

        $this->score = $score;
        $this->risk_decision = $riskDecision;
        $this->save();

        return $this;
    }
}
