<?php

namespace App\Http\Controllers;

use App\Song;
use App\Artist;
use App\Publisher;
use App\SongArtist;
use App\SongPublisher;
use Illuminate\Http\Request;
use DataTables;

class SongController extends Controller
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
			$data = Song::where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->with('artists','artists.artist')
                        ->with('publishers','publishers.publisher')
                        ->orderBy('created_at','desc')
                        ->get();

			return DataTables::of($data)
					->addIndexColumn()
					->addColumn('action', function($row){
						//    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        //     return $btn;
                        return '<a href="'.route('songs.edit', $row->id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <button class="delete-song btn btn-sm btn-danger" data-id="'.$row->id.'">Delete</button>';
                    })
					->rawColumns(['action'])
					->make(true);
		}

        return view('songs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $artists = Artist::get();
        $publishers = Publisher::get();
        return view('songs.create', compact('artists','publishers'));
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
            'song_name'=>'required',
            'artists'=>'required',
            'publishers'=>'required',
        ]);

        $song = new Song;
        $song->song_name = $request->get('song_name');
        $song->save();
        $songId = $song->id;

        foreach( $request->get('artists') as $artistID ) {
            $artist = new SongArtist;
            $artist->song_id = $song->id;
            $artist->artist_id = $artistID;
            $artist->save();
        }

        foreach( $request->get('publishers') as $publisherID ) {
            $publisher = new SongPublisher;
            $publisher->song_id = $song->id;
            $publisher->publisher_id = $publisherID;
            $publisher->save();
        }

        return redirect('/songs')->with('success', 'Song saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $song = Song::find($id);
        $artistIDs = SongArtist::where('song_id',$id)->get();
        $publisherIDs = SongPublisher::where('song_id',$id)->get();
        $artists = Artist::get();
        $publishers = Publisher::get();
        // dd($artistIDs);
        return view('songs.edit', compact('song','artists','publishers','artistIDs','publisherIDs'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'song_name'=>'required',
            'artists'=>'required',
            'publishers'=>'required',
        ]);

        // dd($request);
        $song = Song::find($id);
        $song->song_name = $request->get('song_name');
        $song->save();

        SongArtist::where('song_id',$id)->delete();
        SongPublisher::where('song_id',$id)->delete();

        foreach( $request->get('artists') as $artistID ) {
            $artist = new SongArtist;
            $artist->song_id = $song->id;
            $artist->artist_id = $artistID;
            $artist->save();
        }

        foreach( $request->get('publishers') as $publisherID ) {
            $publisher = new SongPublisher;
            $publisher->song_id = $song->id;
            $publisher->publisher_id = $publisherID;
            $publisher->save();
        }

        return redirect('/songs')->with('success', 'Song updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $song = Song::find($id);
        $song->delete();

        return redirect('/songs')->with('success', 'Song deleted!');
    }
}
