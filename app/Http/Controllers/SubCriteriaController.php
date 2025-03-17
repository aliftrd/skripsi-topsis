<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Criteria $criteria)
    {
        return view('app.sub-criteria.form', compact('criteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Criteria $criteria)
    {
        $validated = $request->validate(
            rules: [
                'code' => [
                    'required',
                    Rule::unique(SubCriteria::class),
                ],
                'name' => 'required',
                'weight' => 'required|numeric|min:1|max:5',
            ],
            attributes: [
                'code' => __('criteria.field.code'),
                'name' => __('criteria.field.name'),
                'weight' => __('criteria.field.weight'),
            ]
        );

        SubCriteria::create([
            'criteria_code' => $criteria->code,
            ...$validated
        ]);

        $request->session()->flash('success', __('general.notifications.created'));
        return $request->continue ?
            redirect()->route('criteria.sub-criteria.create', $criteria->code) :
            redirect()->route('criteria.edit', $criteria->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCriteria $subcriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria, SubCriteria $subcriteria)
    {
        return view('app.sub-criteria.form', compact('criteria', 'subcriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criteria, SubCriteria $subcriteria)
    {
        $validated = $request->validate(
            rules: [
                'code' => [
                    'required',
                    Rule::unique(SubCriteria::class)->ignore($subcriteria->code, 'code'),
                ],
                'name' => 'required',
                'weight' => 'required|numeric|min:1|max:5',
            ],
            attributes: [
                'code' => __('criteria.field.code'),
                'name' => __('criteria.field.name'),
                'weight' => __('criteria.field.weight'),
            ]
        );

        $subcriteria->update($validated);

        $request->session()->flash('success', __('general.notifications.updated'));
        return redirect()->route('criteria.edit', $criteria->code);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria, SubCriteria $subcriteria)
    {
        $subcriteria->delete();

        return back()->with('success', __('general.notifications.deleted'));
    }
}
