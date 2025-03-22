<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class CriteriaController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('adminOnly', only: ['create', 'store', 'edit',  'update', 'destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criterias = Criteria::orderByRaw('LENGTH(code), code')->paginate(10);

        return view('app.criteria.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.criteria.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            rules: [
                'code' => [
                    'required',
                    Rule::unique(Criteria::class),
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

        Criteria::create($validated);


        $request->session()->flash('success', __('general.notifications.created'));
        return $request->continue ?
            redirect()->route('criteria.create') :
            redirect()->route('criteria.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criteria)
    {
        $criteria->load('subcriterias');
        $subcriterias = $criteria->subcriterias()->paginate(10);

        return view('app.criteria.show', compact('criteria', 'subcriterias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria)
    {
        $criteria->load('subcriterias');
        $subcriterias = $criteria->subcriterias()->paginate(10);

        return view('app.criteria.form', compact('criteria', 'subcriterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criteria)
    {
        $validated = $request->validate(
            rules: [
                'code' => [
                    'required',
                    Rule::unique(Criteria::class)->ignore($criteria->code, 'code'),
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

        $criteria->update($validated);

        return redirect()->route('criteria.index')->with('success',  __('general.notifications.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();

        return redirect()->route('criteria.index')->with('success', __('general.notifications.deleted'));
    }
}
