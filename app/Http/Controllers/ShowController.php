<?php

namespace App\Http\Controllers;

use App\Show;
use Illuminate\Http\Request;
use DataTables;

class ShowController extends Controller
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
			$data = Show::where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->orderBy('created_at','desc')
                        ->get();

			return DataTables::of($data)
					->addIndexColumn()
					->addColumn('action', function($row){
						//    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        //     return $btn;
                        return '<a href="'.route('shows.edit', $row->id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <button class="delete-show btn btn-sm btn-danger" data-id="'.$row->id.'">Delete</button>';
                    })
					->rawColumns(['action'])
					->make(true);
		}

        return view('shows.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('shows.create');
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
            'show_name'=>'required',
        ]);

        $show = new Show;
        $show->show_name = $request->get('show_name');
        $show->save();

        return redirect('/shows')->with('success', 'Show saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function show(Show $show)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $show = Show::find($id);
        return view('shows.edit', compact('show'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'show_name'=>'required',
        ]);

        $show = Show::find($id);
        $show->show_name = $request->get('show_name');
        $show->save();

        return redirect('/shows')->with('success', 'Show updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $show = Show::find($id);
        $show->delete();

        return redirect('/shows')->with('success', 'Show deleted!');
    }
}
