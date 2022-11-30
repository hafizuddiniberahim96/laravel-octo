<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


use App\Models\Details\Movie_collections;
use App\Models\Theater;
use App\Models\Time_slot;

class TimeslotController extends Controller
{
    //

    public function get_movie(Request $request){

        $data =$request->validate([
            'theater_name'=>'required|string',
            'time_slot' => 'required|string',
            'time_end' => 'required|string'
        ]);
        
        try{

            $movie_start =Carbon::parse($data['time_slot'])->format('Y-m-d H:i:s');
            $movie_end = Carbon::parse($data['time_end'])->format('Y-m-d H:i:s');
            
            $timeslots= Time_slot::whereHas('theaters', function ($query) use ($data){
                                    return $query->where('name',$data['theater_name']);})
                                ->where([ ['time_start','>=',$movie_start],
                                            ['time_end','<=',$movie_end]
                                        ])
                                ->get();
            $data = collect($timeslots)->map(function($time){
                return [
                    'Movie_ID'  => $time->movie_collections_id,
                    'Title' => $time->movies->info->title,
                    'Theater_name' => $time->theaters->name,
                    'Start_time' => $time->time_start->format('Y-m-d H:i:s'),
                    'End_time' => $time->time_end->format('Y-m-d H:i:s'),
                    'Description' => $time->movies->info->description,
                    'Theater_room_no' => $time->room->name 
                ];
            });
            

            return response()->json([
                'data' => $data
            ], 200);         

        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on retreiving movies filter by Time slot.',
                'success' => false
            ], 500);
        }
    }
}
