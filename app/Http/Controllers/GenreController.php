<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;
use App\Models\Details\Movie_collections;
use App\Models\Details\Movie_genre;
use App\Models\Genre;


class GenreController extends Controller
{
    //

    public function get_movie(Request $request){

        $data =$request->validate([
            'genre'=>'required|string',
        ]);

        try{
            $genre = $data['genre'];
            $movies_genre = Movie_genre::whereHas('genres', function ($query) use ($genre){
                return $query->where('name',ucfirst($genre));
            })->get();

            $data =  collect($movies_genre)->map(function($movie){
                $res =  Movie_collections::find($movie->movie_collections_id)->info()->first();
                 return [
                    'Movie_ID'  => $res->id,
                    'Overall_rating' => $movie->movies()->first()->ratings()->avg('rating'),
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
