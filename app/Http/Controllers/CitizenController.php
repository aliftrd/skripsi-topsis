<?php

namespace App\Http\Controllers;

use App\Imports\CitizensImport;
use App\Models\Citizen;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CitizenController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('adminOnly', only: ['create', 'store', 'import', 'edit',  'update', 'destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citizens = Citizen::orderByRaw('LENGTH(code), code')->paginate(10);

        return view('app.citizen.index', compact('citizens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterias = Criteria::with('subcriterias')->orderByRaw('LENGTH(code), code')->get();

        return view('app.citizen.form', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $criterias = Criteria::get();

        $attributes = [
            'code' => __('citizen.field.code'),
            'nik' => __('citizen.field.nik'),
            'name' => __('citizen.field.name'),
            'province' => __('citizen.field.province'),
            'district' => __('citizen.field.district'),
            'subdistrict' => __('citizen.field.subdistrict'),
            'village' => __('citizen.field.village'),
            'rt' => __('citizen.field.rt'),
            'rw' => __('citizen.field.rw'),
            'address' => __('citizen.field.address'),
            'criteria' => __('criteria.nav.label'),
        ];

        foreach ($criterias as $criteria) {
            $attributes["criteria.$criteria->code"] = __('criteria.nav.label') . " {$criteria->name}";
        }

        $validated = $request->validate(
            rules: [
                'code' => 'required|string',
                'nik' => 'required|numeric',
                'name' => 'required|string',
                'province' => 'required|string',
                'district' => 'required|string',
                'subdistrict' => 'required|string',
                'village' => 'required|string',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric',
                'address' => 'required|string',
                'criteria' => 'required|array',
                'criteria.*' => 'required|string|exists:sub_criterias,code',
            ],
            attributes: $attributes
        );

        DB::transaction(function () use ($validated) {
            $citizenData = Arr::except($validated, ['criteria']);
            $citizen = Citizen::create($citizenData);

            $criteriaData = collect($validated['criteria'])
                ->mapWithKeys(fn($subCriteriaCode, $criteriaCode) => [
                    $criteriaCode => ['sub_criteria_code' => $subCriteriaCode]
                ])
                ->toArray();

            $citizen->subCriterias()->attach($criteriaData);
        });

        $request->session()->flash('success', __('general.notifications.created'));
        return $request->continue ?
            redirect()->route('citizen.create') :
            redirect()->route('citizen.index');
    }

    /**
     * Import a newly record in storage.
     */
    public function import(Request $request)
    {
        $validated = $request->validate([
            'importFile' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        Excel::import(new CitizensImport, $validated['importFile']);

        return redirect()->route('citizen.index')->with('success',  __('general.notifications.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Citizen $citizen)
    {
        $citizen->load('subCriterias.criteria');
        $selectedCriteria = $citizen->subCriterias->mapWithKeys(function ($subCriteria) {
            return [$subCriteria->criteria->code => $subCriteria->code];
        })->toArray();
        $criterias = Criteria::orderByRaw('LENGTH(code), code')->get();

        return view('app.citizen.show', compact('citizen', 'criterias', 'selectedCriteria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Citizen $citizen)
    {
        $citizen->load('subCriterias.criteria');
        $selectedCriteria = $citizen->subCriterias->mapWithKeys(function ($subCriteria) {
            return [$subCriteria->criteria->code => $subCriteria->code];
        })->toArray();
        $criterias = Criteria::orderByRaw('LENGTH(code), code')->get();

        return view('app.citizen.form', compact('citizen', 'criterias', 'selectedCriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Citizen $citizen)
    {
        $criterias = Criteria::get();

        $attributes = [
            'code' => __('citizen.field.code'),
            'nik' => __('citizen.field.nik'),
            'name' => __('citizen.field.name'),
            'province' => __('citizen.field.province'),
            'district' => __('citizen.field.district'),
            'subdistrict' => __('citizen.field.subdistrict'),
            'village' => __('citizen.field.village'),
            'rt' => __('citizen.field.rt'),
            'rw' => __('citizen.field.rw'),
            'address' => __('citizen.field.address'),
            'criteria' => __('criteria.nav.label'),
        ];

        foreach ($criterias as $criteria) {
            $attributes["criteria.$criteria->code"] = __('criteria.nav.label') . " {$criteria->name}";
        }

        $validated = $request->validate(
            rules: [
                'code' => 'required|string',
                'nik' => 'required|numeric',
                'name' => 'required|string',
                'province' => 'required|string',
                'district' => 'required|string',
                'subdistrict' => 'required|string',
                'village' => 'required|string',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric',
                'address' => 'required|string',
                'criteria' => 'required|array',
                'criteria.*' => 'required|string|exists:sub_criterias,code',
            ],
            attributes: $attributes
        );

        DB::transaction(function () use ($validated, $citizen) {
            $citizen->update(Arr::except($validated, ['criteria']));

            $criteriaData = collect($validated['criteria'])
                ->mapWithKeys(fn($subCriteriaCode, $criteriaCode) => [
                    $criteriaCode => ['sub_criteria_code' => $subCriteriaCode]
                ])
                ->toArray();

            $citizen->subCriterias()->sync($criteriaData);
        });

        return redirect()->route('citizen.index')->with('success',  __('general.notifications.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Citizen $citizen)
    {
        $citizen->delete();

        return redirect()->route('citizen.index')->with('success', __('general.notifications.deleted'));
    }
}
