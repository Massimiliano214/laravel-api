<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {      
        /*
        $form_data = $request->all();
        $newProject = new Project();
        $newProject->title = $form_data['title'];
        $newProject->content = $form_data['content'];
        $newProject->slug = Str::slug($newProject->title, '-');
        $newProject->save();
        */

        $validated_data = $request->validated();
        $validated_data['slug'] = Project::generateSlug($request->title);

        $checkProject = Project::where('slug', $validated_data['slug'])->first();
        if ($checkProject) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare il Progetto col seguente titolo.']);
        }

        if ($request->hasFile('cover_image')) {
            $path = Storage::put('cover', $request->cover_image);
            $validated_data['cover_image'] = $path;
        }

        $newProject = Project::create($validated_data);

        if ($request->has('technologies')) {
            $newProject->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.projects.show', ['project' => $newProject->slug])->with('status', 'Progetto creato con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {   
        //$project = Project::findOrFail($id);
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {   
        /*
        //$project = Project::findOrFail($id); 
        $form_data = $request->all();
        
        //$form_data = $request->validated();
        
        $project->update($form_data);
        */
    
        $validated_data = $request->validated();
        $validated_data['slug'] = Project::generateSlug($request->title);

        $checkProject = Project::where('slug', $validated_data['slug'])->where('id', '<>', $project->id)->first();
        if ($checkProject) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile aggiornare il Progetto col seguente titolo.']);
        }

        if ($request->hasFile('cover_image')) {

            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $path = Storage::put('cover', $request->cover_image);
            $validated_data['cover_image'] = $path;

        }

        $project->update($validated_data);

        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('status', 'Progetto modificato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {   
        //$project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('admin.projects.index');
    }
}
