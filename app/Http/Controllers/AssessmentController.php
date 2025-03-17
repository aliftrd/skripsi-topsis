<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $criterias = Criteria::orderByRaw('LENGTH(code), code')->get();
        $citizens = Citizen::with('subCriterias.criteria')
            ->orderByRaw('LENGTH(code), code')
            ->paginate(10);

        return view('app.assessment', compact('criterias', 'citizens'));
    }
}
