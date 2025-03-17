<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Criteria;
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
        $groupedCitizenByStage = Citizen::selectRaw('stage, COUNT(*) as total')
            ->groupBy('stage')
            ->get();
        $groupedCitizenByRT = Citizen::selectRaw("rt, COUNT(*) as total")
            ->groupBy('rt')
            ->get();
        $tenCitizens = Citizen::latest()->take(10)->get();

        return view('app.dashboard', compact('totalCitizen', 'totalCriteria', 'tenCitizens', 'groupedCitizenByStage', 'groupedCitizenByRT'));
    }
}
