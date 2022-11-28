<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Details\Movie_collections;
use App\Models\Details\Movie_genre;
use App\Models\Genre;


class GenreController extends Controller
{
    //

    public function get_movie(Request $request){
        $genre = 'comedy';
        try{
            $movies = Movie_genre::whereHas('genres', function ($query) use ($genre){
                return $query->where('name',ucfirst($genre));
            })->get();
    
            $data =  collect($movies)->map(function($movie){
                $res =  Movie_collections::find($movie->id)->movie()->first();
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
