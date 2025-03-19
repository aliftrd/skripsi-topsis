<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\CitizenStage;
use App\Models\Criteria;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $totalCitizen = Citizen::count();
        $totalCriteria = Criteria::count();
        $availableYears = $this->getAvailableYear();
        $year = $request->input('year', max($availableYears));

        $groupedCitizenByStage = CitizenStage::where('year', $year)
            ->selectRaw('stage, COUNT(*) as total')
            ->groupBy('stage')
            ->get();
        $groupedCitizenByRT = Citizen::selectRaw("rt, COUNT(*) as total")
            ->groupBy('rt')
            ->get();
        $tenCitizens = Citizen::latest()->take(10)->get();

        return view('app.dashboard', compact('totalCitizen', 'totalCriteria', 'tenCitizens', 'groupedCitizenByStage', 'groupedCitizenByRT', 'availableYears'));
    }

    private function getAvailableYear()
    {
        $availableYears = CitizenStage::distinct()
            ->pluck('year')
            ->toArray();

        if (empty($availableYears)) return [now()->year];

        $maxYear = !empty($availableYears) ? max($availableYears) : now()->year;

        $targetYears = range($maxYear, $maxYear + 2);

        $availableYears = array_unique(array_merge($availableYears, $targetYears));

        sort($availableYears);

        return $availableYears;
    }
}
