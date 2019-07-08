<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RaterResource;
use App\Http\Resources\RaterCollection;
use App\Rater;

class RaterController extends Controller
{
    public function index()
    {
        return new RaterCollection(Rater::all());
    }

    public function show($id)
    {
        $rater = Rater::with('movies')->find($id);

        if(!$rater) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        return new RaterResource($rater);

    }

    public function store(Request $request)
    {
        $rater = Rater::create($request->all());

        return response()->json([
            'id' => $rater->id,
            'created_at' => $rater->created_at,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $rater = Rater::find($id);

        if(!$rater) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        $rater->update($request->all());

        return response()->json(null, 204);
    }

    public function destroy(Request $request, $id)
    {
        $rater = Rater::find($id);

        if(!$rater) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        $rater->delete();

        return response()->json(null, 204);
    }
}
