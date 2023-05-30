<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::all();
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        $validated_data = $request->validated();
        $validated_data['slug'] = Technology::generateSlug($request->name);

        $checkTechnology = Technology::where('slug', $validated_data['slug'])->first();
        if ($checkTechnology) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare il Progetto col seguente titolo.']);
        }
        $newTechnology = Technology::create($validated_data);

        return redirect()->route('admin.technologies.show', ['technology' => $newTechnology->slug])->with('status', 'Tecnologia creata con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        return view('admin.technologies.show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        $validated_data = $request->validated();
        $validated_data['slug'] = Technology::generateSlug($request->name);

        $checkTechnology = Technology::where('slug', $validated_data['slug'])->where('id', '<>', $technology->id)->first();
        if ($checkTechnology) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile aggiornare la Tecnologia col seguente titolo.']);
        }
        $technology->update($validated_data);

        return redirect()->route('admin.technologies.show', ['technology' => $technology->slug])->with('status', 'Tecnologia modificata con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technologies.index');
    }
}
