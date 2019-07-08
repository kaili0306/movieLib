<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieCollection;
use App\Movie;
use App\Comment;
use Illuminate\Validation\ValidationException;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->input('title');
        $duration = $request->input('duration');
        $genre = $request->input('genre');
    
        $movies = Movie::with(['raters'])
            ->when($title, function($query) use($title) {
                return $query->where('title', 'like', "%$title%");
            })
            ->when($duration, function($query) use($duration) {
                return $query->where('duration', '>', $duration);
            })
            ->when($genre, function($query) use($genre) {
                return $query->where('genre', 'like', "%$genre%");
            })
            ->get();
    
        return MovieResource::collection($movies);
    }

    public function show($id)
    {
        $movie = Movie::with('raters')->find($id);

        if(!$movie) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        return new MovieResource($movie);
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'title' => 'required',
                'duration' => 'required|max:3',
                'summary' => 'required|max:255',
                'datePublished' => 'required|date',
            ]);
    
            $movie = Movie::create($request->all());
            $movie->raters()->sync($request->raters);
    
            return response()->json([
                'id' => $movie->id,
                'created_at' => $movie->created_at,
            ], 201);
        }
        catch(ValidationException $ex) {
            return response()->json([
                'errors' => $ex->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {

        $movie = Movie::find($id);

        if(!$movie) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        try {
            $request->validate([
                'title' => 'required',
                'duration' => 'required|max:3',
                'summary' => 'required|max:255',
                'datePublished' => 'required|date',
            ]);
    
            $movie->update($request->all());
            $movie->raters()->sync($request->raters);
    
            return response()->json([
                'id' => $movie->id,
                'updated_at' => $movie->updated_at,
            ], 201);
        }
        catch(ValidationException $ex) {
            return response()->json([
                'errors' => $ex->errors(),
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        $movie = Movie::find($id);

        if(!$movie) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        $movie->delete();

        return response()->json(null, 204);
    }
}
