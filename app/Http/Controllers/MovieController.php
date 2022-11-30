<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Movie;
use App\Models\Details\Movie_collections;
use App\Models\Details\Movie_genre;
use App\Models\Details\Movie_performer;
use Carbon\Carbon;




class MovieController extends Controller
{
    //

    public function add(Request $request){

        $data =$request->validate([
            'title'=>'required|string',
            'release'=>'required|string',
            'length'=>'required|string',
            'description'=>'required|string',
            'mpaa_rating'=>'required|string',
            'genre'=>'required|array',
            'director'=>'required|string',
            'performer'=>'required|array',
            'language'=>'required|string',
        ]);


        try{

            $genres_id= $this->add_to_object($data['genre'],'Genre');
            $performers_id = $this->add_to_object($data['performer'], 'Performer');
            $director_id = $this->add_to_object($data['director'], 'Director');
            $language_id = $this->add_to_object($data['language'], 'Language');
            $mpaa_rating_id = $this->add_to_object($data['mpaa_rating'], 'Mpaa_rating');

            //add to movie
            $movie = Movie::where('title', $data['title'])->firstOr(function () use ($request) {
                $movie = Movie::create($request->only('title','length','release','description'));
                return $movie;
            });
            // add to Movie_collections
            $Movie_collections = Movie_collections::firstOrCreate(
                [ 
                    'movies_id' => $movie->id,
                    'language_id' => $language_id[0],
                ],
                [
                    'rating_id' => $mpaa_rating_id[0], 
                    'director_id' => $director_id[0],
            ]);

            foreach ($genres_id as $id){ 
                Movie_genre::firstOrCreate(
                    [
                        'movie_collections_id' =>  $Movie_collections->id,
                        'genre_id' => $id,
                    ]
                );
               
            }  

            foreach ($performers_id as $id){ 
                Movie_performer::firstOrCreate(
                    [
                        'movie_collections_id' =>  $Movie_collections->id,
                        'performer_id' => $id,
                    ]
                );
            }
          
            return response()->json([
                'message' => "Successfully added movie ".$movie->title." with Movie_ID ".$movie->id,
                'success' => true
            ], 200);

        }catch(Exception $e){
            ## for developer debugging
            Log::error($e);
            return response()->json([
                'message' => 'Error on Adding Movie to Collection',
                'success' => false
              ], 500);

        }

      
    }

    public function new_movie(Request $request){

            $data =$request->validate([
                'r_date'=>'required|string',
            ]);

        try{

            $date = Carbon::parse($data['r_date']);
            $movies = Movie_collections::whereHas('info', function ($query) use ($date){
                return $query->where('release',$date);
            })->get();

            
            $data = collect($movies)->map(function($movie_collect){
                $movie = $movie_collect->info;
                return [
                    'Movie_ID'  => $movie->id,
                    'Overall_rating' => 10,
                    'Title' => $movie->title,
                    'Description' => $movie->description
                ];
            });

            return response()->json([
                'data' => $data
            ], 200);

        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'message' => 'Error on retrieving Movie to Collection',
                'success' => false
            ], 500);
        }
   }

    // apply to multiple model beware on changing this 
    private function add_to_object($objects,$name){
        $object_id = array();
        $model = 'App\Models\\'.$name;
        collect($objects)->each(function ($item)  use (&$object_id, $model){
            $object = $model::where('name', $item)->first();
            if(!$object) {
                $object = $model::Create([
                    'name' => ucfirst($item),
                ]);
            }
            array_push($object_id,$object->id);
        });

        return $object_id;

    }

   
}
