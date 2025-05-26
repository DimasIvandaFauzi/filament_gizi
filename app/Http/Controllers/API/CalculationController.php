<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Calculation;
use Illuminate\Support\Facades\Validator;

class CalculationController extends Controller
{
    public function calculate(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'gender' => 'required|in:Laki-laki,Perempuan',
            'age' => 'required|integer|min:1|max:120',
            'weight' => 'required|numeric|min:20|max:200',
            'height' => 'required|numeric|min:100|max:220',
            'activity' => 'required|in:Rendah,Sedang,Tinggi',
            'goal' => 'required|in:Menurunkan Berat Badan,Menjaga Berat Badan,Meningkatkan Berat Badan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Hitung BMI
        $heightInMeters = $request->height / 100;
        $bmi = $request->weight / ($heightInMeters * $heightInMeters);
        $bmi = round($bmi, 1);

        // Tentukan status BMI
        $statusBmi = $this->getBmiStatus($bmi);

        // Hitung kebutuhan makronutrien (contoh sederhana)
        $macronutrientNeeds = $this->calculateMacronutrients($request->weight, $request->activity, $request->goal);

        // Simpan kalkulasi
        $calculation = Calculation::create([
            'user_id' => Auth::id(),
            'gender' => $request->gender,
            'age' => $request->age,
            'weight' => $request->weight,
            'height' => $request->height,
            'activity' => $request->activity,
            'goal' => $request->goal,
            'bmi' => $bmi,
            'status_bmi' => $statusBmi,
            'macronutrient_needs' => json_encode($macronutrientNeeds), // Simpan sebagai JSON
        ]);

        // Kembalikan respons
        return response()->json([
            'message' => 'Kalkulasi berhasil',
            'data' => [
                'id' => $calculation->id,
                'bmi' => $bmi,
                'status_bmi' => $statusBmi,
                'macronutrient_needs' => $macronutrientNeeds,
                'gender' => $request->gender,
                'age' => $request->age,
                'weight' => $request->weight,
                'height' => $request->height,
                'activity' => $request->activity,
                'goal' => $request->goal,
            ],
        ], 200);
    }

    public function history(Request $request)
    {
        $calculations = Calculation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Riwayat kalkulasi diambil',
            'data' => $calculations->map(function ($calculation) {
                return [
                    'id' => $calculation->id,
                    'gender' => $calculation->gender,
                    'age' => $calculation->age,
                    'weight' => $calculation->weight,
                    'height' => $calculation->height,
                    'activity' => $calculation->activity,
                    'goal' => $calculation->goal,
                    'bmi' => $calculation->bmi,
                    'status_bmi' => $calculation->status_bmi,
                    'macronutrient_needs' => json_decode($calculation->macronutrient_needs, true),
                    'created_at' => $calculation->created_at,
                ];
            }),
        ], 200);
    }

    private function getBmiStatus(float $bmi): string
    {
        if ($bmi < 18.5) {
            return 'Kekurangan Berat Badan';
        } elseif ($bmi < 25) {
            return 'Normal';
        } elseif ($bmi < 30) {
            return 'Kelebihan Berat Badan';
        } else {
            return 'Obesitas';
        }
    }

    private function calculateMacronutrients($weight, $activity, $goal)
    {
        // Logika sederhana untuk menghitung kebutuhan makronutrien
        $baseCalories = $weight * 24; // Contoh: 24 kcal per kg berat badan
        $activityFactor = $activity === 'Rendah' ? 1.2 : ($activity === 'Sedang' ? 1.5 : 1.9);
        $goalFactor = $goal === 'Menurunkan Berat Badan' ? 0.8 : ($goal === 'Meningkatkan Berat Badan' ? 1.2 : 1.0);
        $totalCalories = $baseCalories * $activityFactor * $goalFactor;

        $protein = $weight * 1.6; // 1.6g protein per kg berat badan
        $fat = $totalCalories * 0.25 / 9; // 25% dari kalori total, 9 kcal per gram lemak
        $carbs = ($totalCalories - ($protein * 4) - ($fat * 9)) / 4; // Sisa kalori untuk karbohidrat

        return [
            'protein' => round($protein),
            'carbs' => round($carbs),
            'fat' => round($fat),
        ];
    }
}