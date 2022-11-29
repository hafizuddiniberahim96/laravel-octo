<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


use App\Models\Details\Movie_collections;
use App\Models\Theater;
use App\Models\Time_slot;


class TheaterController extends Controller
{
    //

    public function add(Request $request){
        $data =$request->validate([
            'name'=>'required|string',
        ]);

        try{

            $theater = Theater::firstOrCreate($request->only('name'));

            return response()->json([
                'message' => "Successfully added theater ".$theater->id,
                'success' => true
            ], 200);


        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on Adding Theater Name.',
                'success' => false
            ], 500);
        }
    }

    public function get_movie(Request $request){
        $data =$request->validate([
            'theater_name'=>'required|string',
            'd_date' => 'required|string',
        ]);
        try{
            $movies= Theater::where('name',$data['theater_name'])->first()
                            ->time_slots()->where('time_start','2020-04-04 00:00:00')
                            ->get();
            

        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on filter by Theater.',
                'success' => false
            ], 500);
        }

    }

    public function add_movie(Request $request){

        $data =$request->validate([
            'movie_title' => 'required|string',
            'theater_name'=>'required|string',
            'time_slot' => 'required|string',
        ]);

        try{


            $movie = Movie_collections::whereHas('movie', function ($query) use ($data){
                return $query->where('title',$data['movie_title']);
            })->first();

            if (!$movie) return response()->json([
                            'message' => "Movie Title not Found ",
                            'success' => true
                        ], 200);
            
            $theater = Theater::where('name',$data['theater_name'])->first();
            $movie_duration = $movie->movie()->first()->length;
            $movie_end = Carbon::parse($data['time_slot'])->addMinutes(98);
                
            $add_movie = Time_slot::firstOrCreate(
                [ 
                    'movie_collections_id' => $movie->movies_id,
                    'theater_id' => $theater->id,
                    'time_start' => $data['time_slot'], 
                ],
                [
                  
                    'time_end' => $movie_end,
                ]);
 

            return response()->json([
                'message' => "Successfully added timeslot to theater ".$theater->name.' on '. $add_movie->time_start,
                'success' => true
            ], 200);


        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on Add Movie Timeslot on Theater.',
                'success' => false
            ], 500);
        }

    }
}
