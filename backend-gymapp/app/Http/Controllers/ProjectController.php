<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = auth()->user();
        if (($user->rol) == "admin"){
            return Project::all();
        }
        return Project::where('user_id', $user->id)->get();
        }catch (\Exception $e){
            return $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $token = JWTAuth::getToken();
        $admin = JWTAuth::parseToken()->toUser($token);

        $data = $request->only('title', 'content', 'category');

        $category = Category::where('name', $data['category'])->first();

        if($admin->can('create', Project::class)){
            $project = new Project();
            $project->title = $data['title'];
            $project->content = $data['content'];
            $project->user_id = $admin->id;
            $project->category_id = $category->id;

            $project->save();
        }else{
            abort(403);
        }
        return ([
            'data' => [
                'project_data' => $project,
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
