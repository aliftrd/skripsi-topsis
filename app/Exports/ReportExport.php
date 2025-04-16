<?php

namespace App\Exports;

use App\Models\Citizen;
use App\Models\Criteria;
use App\Traits\CalculationTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    use CalculationTrait;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $citizens = Citizen::with('subCriterias')->orderByRaw('LENGTH(code), code')->get();
        $criterias = Criteria::orderByRaw('LENGTH(code), code')->get();

        $result = $this->processCalculation($citizens, $criterias);

        return view('export.calculation', array_merge(
            compact('citizens', 'criterias'),
            $result
        ));
    }
}
