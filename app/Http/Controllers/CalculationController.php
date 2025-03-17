<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $citizens = Citizen::with('subCriterias')->orderByRaw('LENGTH(code), code')->get();
        $criterias = Criteria::orderByRaw('LENGTH(code), code')->get();

        if ($citizens->isEmpty()) {
            return redirect()->route('citizen.index')->with('error',  __('citizen.notifications.empty'));
        }

        $normalizeMatrix = $this->normalizeMatrix($citizens, $criterias);
        $matrixRij = $this->matrixRij($citizens, $criterias, $normalizeMatrix);
        $normalizeMatrixWeight = $this->normalizeMatrixWeight($citizens, $criterias, $matrixRij);
        $minMax = $this->minMax($normalizeMatrixWeight);
        $idealMinMaxDistance = $this->idealMinMaxDistance($normalizeMatrixWeight, $minMax);
        $preferenceValue = $this->preferenceValue($idealMinMaxDistance);

        $citizenRanks = $citizens->sortByDesc(
            fn($citizen) => $preferenceValue[$citizen->code] ?? PHP_INT_MIN
        )->values();

        return view('app.calculation', compact('citizens', 'criterias', 'normalizeMatrix', 'matrixRij', 'normalizeMatrixWeight', 'minMax', 'idealMinMaxDistance', 'preferenceValue', 'citizenRanks'));
    }

    /**
     * Normalize the matrix.
     */
    private function normalizeMatrix($citizens, $criterias)
    {
        $matrix = [];
        $sumPerCriteria = [];
        $sqrtPerCriteria = [];

        // Step 1: Compute squared values
        foreach ($citizens as $citizen) {
            $matrix[$citizen->code] = [];

            foreach ($criterias as $criteria) {
                // Ambil sub-kriteria yang memiliki kriteria tertentu
                $subCriteria = $citizen->subCriterias->firstWhere('criteria.code', $criteria->code);

                // Pastikan sub-kriteria ditemukan dan memiliki pivot
                $value = $subCriteria->weight ?? 0;

                // Hitung nilai kuadrat
                $matrix[$citizen->code][$criteria->code] = pow($value, 2);
                $sumPerCriteria[$criteria->code] = ($sumPerCriteria[$criteria->code] ?? 0) + $matrix[$citizen->code][$criteria->code];
            }
        }

        // Step 2: Compute square root of total
        foreach ($criterias as $criteria) {
            $sqrtPerCriteria[$criteria->code] = round(sqrt($sumPerCriteria[$criteria->code] ?? 0), 3);
        }

        $matrix['total'] = $sumPerCriteria;
        $matrix['sqrt'] = $sqrtPerCriteria;

        return $matrix;
    }


    /**
     * Compute the Rij matrix.
     */
    private function matrixRij($citizens, $criterias, $normalizeMatrix)
    {
        $matrix = [];

        foreach ($citizens as $citizen) {
            $matrix[$citizen->code] = [];

            foreach ($criterias as $criteria) {
                $subCriteria = $citizen->subCriterias->firstWhere('criteria.code', $criteria->code);
                $value = $subCriteria->weight ?? 0;
                $matrix[$citizen->code][$criteria->code] = round($value / $normalizeMatrix['sqrt'][$criteria->code], 3);
            }
        }

        return $matrix;
    }

    /**
     * Normalize the matrix weight.
     */
    private function normalizeMatrixWeight($citizens, $criterias, $matrixRij)
    {
        $matrix = [];

        foreach ($citizens as $citizen) {
            $matrix[$citizen->code] = [];

            foreach ($criterias as $criteria) {
                $value = $citizen->subCriterias->firstWhere('criteria.code', $criteria->code)->weight;
                $matrix[$citizen->code][$criteria->code] = round($matrixRij[$citizen->code][$criteria->code] * $value, 3);
            }
        }

        return $matrix;
    }

    /**
     * Compute the min-max matrix.
     */

    private function minMax(array $normalizeMatrixWeight): array
    {
        $matrix = [
            'plus' => [],
            'minus' => [],
        ];

        // Initialize min and max values with the first row of the matrix
        $firstRow = reset($normalizeMatrixWeight);
        foreach ($firstRow as $criteria => $value) {
            $matrix['plus'][$criteria] = $value;  // Max (A+)
            $matrix['minus'][$criteria] = $value; // Min (A-)
        }

        // Iterate through the matrix to update min and max values
        foreach ($normalizeMatrixWeight as $row) {
            foreach ($row as $criteria => $value) {
                $matrix['plus'][$criteria] = max($matrix['plus'][$criteria], $value);
                $matrix['minus'][$criteria] = min($matrix['minus'][$criteria], $value);
            }
        }

        return $matrix;
    }

    /**
     * Compute the ideal-min-max distance per citizen.
     */
    private function idealMinMaxDistance(array $normalizeMatrixWeight, array $minMax): array
    {
        $matrix = [
            'plus' => [],
            'minus' => [],
        ];

        foreach ($normalizeMatrixWeight as $citizenCode => $criteriaValues) {
            $sumPlus = 0;
            $sumMinus = 0;

            foreach ($criteriaValues as $criteria => $value) {
                $sumPlus += pow($value - $minMax['plus'][$criteria], 2);
                $sumMinus += pow($value - $minMax['minus'][$criteria], 2);
            }

            $matrix['plus'][$citizenCode] = round(sqrt($sumPlus), 3); // A+
            $matrix['minus'][$citizenCode] = round(sqrt($sumMinus), 3); // A-
        }

        return $matrix;
    }

    /**
     * Compute the preference value.
     */
    private function preferenceValue(array $idealMinMaxDistance): array
    {
        $matrix = [];

        foreach ($idealMinMaxDistance['plus'] as $citizenCode => $value) {
            $matrix[$citizenCode] = round(($idealMinMaxDistance['minus'][$citizenCode] / ($idealMinMaxDistance['plus'][$citizenCode]) + $idealMinMaxDistance['minus'][$citizenCode]), 3);
        }

        return $matrix;
    }
}
