<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Details\Movie_collections;
use App\Models\Details\Movie_performer;
use App\Models\Performer;

class PerformerController extends Controller
{
    //

    public function get_movie(Request $request){
        $data =$request->validate([
            'performer_name'=>'required|string',
        ]);

        try{

            $performer = $data['performer_name'];

            $performers = Movie_performer::whereHas('performers',function ($query) use ($performer){
                return $query->where('name',$performer);
            })->get();

            $data =  collect($performers)->map(function($performer){
                $res =  Movie_collections::find($performer->movie_collections_id)->movie()->first();
                 return [
                    'Movie_ID'  => $res->id,
                    'Overall_rating' => 10,
                    'Title' => $res->title,
                    'Description' => $res->description
                ];
            });

            return response()->json([
                'data' => $data
            ], 200);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on Retrieving Movie by Genres',
                'success' => false
            ], 500);

        }

    }
}
