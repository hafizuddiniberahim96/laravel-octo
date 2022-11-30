<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


use App\Models\Details\Movie_collections;
use App\Models\Theater;
use App\Models\Theater_room;

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

    public function add_rooms(Request $request){
        $data =$request->validate([
            'theater_name'=>'required|string',
            'room_name' => 'required|array',
        ]);
        try{
            collect($data['room_name'])->each(function($room) use ($data){
                $theater = Theater::where('name',$data['theater_name'])->firstOrFail();
                Theater_room::firstorCreate(
                    [   'theater_id' =>  $theater->id,
                        'name' => $room
                    ],
                    [
                        'available' => 1
                    ]
                );
            });

            return response()->json([
                'message' => 'Success on adding rooms to Theater.',
                'success' => true
            ], 200);

        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on adding rooms to Theater.',
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
            $movie_start =Carbon::parse($data['d_date'])->format('Y-m-d H:i:s');
            $movie_end = Carbon::parse($data['d_date'])->format('Y-m-d').' 23:59:59';
            
            $theaters= Theater::where('name',$data['theater_name'])->first()
                            ->time_slots()->where([
                                ['time_start','>=',$movie_start],
                                ['time_end','<=',$movie_end]
                                ])
                            ->get();
            $data = collect($theaters)->map(function($theater){
                return [
                    'Movie_ID'  => $theater->movie_collections_id,
                    'Title' => $theater->movies->info->title,
                    'Theater_name' => $theater->theaters->name,
                    'Start_time' => $theater->time_start->format('Y-m-d H:i:s'),
                    'End_time' => $theater->time_end->format('Y-m-d H:i:s'),
                    'Description' => $theater->movies->info->description,
                    'Theater_room_no' => $theater->room->name 
                ];
            });

            return response()->json([
                'data' => $data
            ], 200);
            

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
            'room_name' => 'required|string',
        ]);

        try{


            $movie = Movie_collections::whereHas('info', function ($query) use ($data){
                return $query->where('title',$data['movie_title']);
            })->first();

            if (!$movie) return response()->json([
                            'message' => "Movie Title not Found ",
                            'success' => true
                        ], 200);
            
            $theater = Theater::where('name',$data['theater_name'])->firstOrFail();
            $room = $theater->rooms()->where('name',$data['room_name'])->firstOrFail();
            $movie_duration = $movie->info()->first()->length;
            $movie_end = Carbon::parse($data['time_slot'])->addMinutes(98);
                
            $add_movie = Time_slot::firstOrCreate(
                [ 
                    'movie_collections_id' => $movie->movies_id,
                    'theater_id' => $theater->id,
                    'time_start' => $data['time_slot'], 
                ],
                [
                    'room_id' => $room->id,
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
