<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Http\Request;
use DataTables;

class ArtistController extends Controller
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
			$data = Artist::where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->orderBy('created_at','desc')
                        ->get();

			return DataTables::of($data)
					->addIndexColumn()
					->addColumn('action', function($row){
						//    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        //     return $btn;
                        return '<a href="'.route('artists.edit', $row->id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <button class="delete-artist btn btn-sm btn-danger" data-id="'.$row->id.'">Delete</button>';
                    })
					->rawColumns(['action'])
					->make(true);
		}

        return view('artists.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('artists.create');
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
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
        ]);

        $artist = new Artist;
        $artist->first_name = $request->get('first_name');
        $artist->last_name = $request->get('last_name');
        $artist->save();

        return redirect('/artists')->with('success', 'Artist saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $artist = Artist::find($id);
        return view('artists.edit', compact('artist'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
        ]);

        $artist = Artist::find($id);
        $artist->first_name = $request->get('first_name');
        $artist->last_name = $request->get('last_name');
        $artist->save();

        return redirect('/artists')->with('success', 'Artist updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $artist = Artist::find($id);
        $artist->delete();

        return redirect('/artists')->with('success', 'Artist deleted!');
    }
}
