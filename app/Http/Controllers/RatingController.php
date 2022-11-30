<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\Details\Movie_collections;
use App\Models\Rating;

class RatingController extends Controller
{
    //

    public function add(Request $request){
        
        try{
            
            $data =$request->validate([
                'movie_title'=>'required|string',
                'rating' => 'required|int',
                'r_description' => 'required|string'
            ]);

            $movie = Movie_collections::whereHas('info', function ($query) use ($data){
                return $query->where('title',$data['movie_title']);
            })->first();

            if(!$movie)  return response()->json([
                'message' => "Movie Title not Found ",
                'success' => true
            ], 200);

            Rating::firstOrCreate(
                [ 
                    'user_id' => $request->user()->id,
                    'movie_collections_id' => $movie->id,
                ],
                [
                    'rating' => $data['rating'],
                    'r_description' => $data['r_description'],
                ]
            );

            return response()->json([
                'message' => 'Success on adding Rating to Movies.',
                'success' => true
            ], 200);

        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on adding Rating to Movies.',
                'success' => false
            ], 500);
        }

    }
}
