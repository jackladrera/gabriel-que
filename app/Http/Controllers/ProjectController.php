<?php

namespace App\Http\Controllers;

use App\Project;
use App\Show;
use App\Song;
use App\ProjectSong;
use Illuminate\Http\Request;
use DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $startDate = date('Y-m-d', strtotime($request->input('startDate')));
		$endDate = date('Y-m-d', strtotime($request->input('endDate')));

		if ($request->ajax()) {
			$data = Project::where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->with('show')
                        ->with('songs','songs.song')
                        ->orderBy('created_at','desc')
                        ->get();

			return DataTables::of($data)
					->addIndexColumn()
					->addColumn('action', function($row){
						//    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        //     return $btn;
                        return '<a href="'.route('projects.edit', $row->id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <button class="delete-project btn btn-sm btn-danger" data-id="'.$row->id.'">Delete</button>';
                    })
					->rawColumns(['action'])
					->make(true);
		}

        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $shows = Show::get();
        $songs = Song::get();
        return view('projects.create', compact('shows','songs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $request->validate([
            'project_name'=>'required',
            'shows'=>'required',
            'songs'=>'required',
            'air_date'=>'required',
        ]);

        $project = new Project;
        $project->project_name = $request->get('project_name');
        $project->show_id = $request->get('shows');
        $project->air_date = date("Y-m-d",strtotime($request->get('air_date')));
        $project->save();
        $projectId = $project->id;

        foreach( $request->get('songs') as $songId ) {
            $song = new ProjectSong;
            $song->project_id = $projectId;
            $song->song_id = $songId;
            $song->save();
        }

        return redirect('/projects')->with('success', 'Project saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $project = Project::find($id);
        $songIDs = ProjectSong::where('project_id',$id)->get();
        $shows = Show::get();
        $songs = Song::get();
        // dd($project);
        return view('projects.edit', compact('project','shows','songs','songIDs'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'project_name'=>'required',
            'shows'=>'required',
            'songs'=>'required',
            'air_date'=>'required',
        ]);

        // dd(strtotime($request->get('air_date')));
        $project = Project::find($id);
        $project->project_name = $request->get('project_name');
        $project->show_id = $request->get('shows');
        $project->air_date = date("Y-m-d",strtotime($request->get('air_date')));
        $project->save();
        $projectId = $project->id;

        ProjectSong::where('project_id',$id)->delete();

        foreach( $request->get('songs') as $songId ) {
            $song = new ProjectSong;
            $song->project_id = $projectId;
            $song->song_id = $songId;
            $song->save();
        }

        return redirect('/projects')->with('success', 'Project updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $project = Project::find($id);
        $project->delete();

        return redirect('/projects')->with('success', 'Project deleted!');
    }
}
