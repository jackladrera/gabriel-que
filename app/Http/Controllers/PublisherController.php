<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;
use DataTables;

class PublisherController extends Controller
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
			$data = Publisher::where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->orderBy('created_at','desc')
                        ->get();

			return DataTables::of($data)
					->addIndexColumn()
					->addColumn('action', function($row){
						//    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        //     return $btn;
                        return '<a href="'.route('publishers.edit', $row->id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <button class="delete-publisher btn btn-sm btn-danger" data-id="'.$row->id.'">Delete</button>';
                    })
					->rawColumns(['action'])
					->make(true);
		}

        return view('publishers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('publishers.create');
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
            'publisher_name'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip'=>'required',
            'phone'=>'required'
        ]);

        $publisher = new Publisher;
        $publisher->publisher_name = $request->get('publisher_name');
        $publisher->address = $request->get('address');
        $publisher->city = $request->get('city');
        $publisher->state = $request->get('state');
        $publisher->zip = $request->get('zip');
        $publisher->phone = $request->get('phone');
        $publisher->save();

        return redirect('/publishers')->with('success', 'Publisher saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $publisher = Publisher::find($id);
        return view('publishers.edit', compact('publisher'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'publisher_name'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip'=>'required',
            'phone'=>'required'
        ]);

        $publisher = Publisher::find($id);
        $publisher->publisher_name = $request->get('publisher_name');
        $publisher->address = $request->get('address');
        $publisher->city = $request->get('city');
        $publisher->state = $request->get('state');
        $publisher->zip = $request->get('zip');
        $publisher->phone = $request->get('phone');
        $publisher->save();

        return redirect('/publishers')->with('success', 'Publisher updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $publisher = Publisher::find($id);
        $publisher->delete();

        return redirect('/publishers')->with('success', 'Publisher deleted!');
    }
}
