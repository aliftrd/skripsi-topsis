<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Citizen;
use App\Models\Criteria;
use App\Traits\CalculationTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CalculationController extends Controller
{
    use CalculationTrait;

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

        $result = $this->processCalculation($citizens, $criterias);

        return view('app.calculation', array_merge(
            compact('citizens', 'criterias'),
            $result
        ));
    }

    public function export()
    {
        return Excel::download(new ReportExport, 'calculation.xlsx');
    }
}
