<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Comment;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function index()
    {
        return new CommentCollection(Comment::all());
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        return new CommentResource($comment);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'rate' => 'required|max:3',
                'comment' => 'required|max:255',
            ]);

            $comment = Comment::create($request->all());
    
            return response()->json([
                'id' => $comment->id,
                'created_at' => $comment->created_at,
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

        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        try {
            $request->validate([
                'rate' => 'required|max:3',
                'comment' => 'required|max:255',
            ]);
    
            $comment->update($request->all());
    
            return response()->json([
                'id' => $comment->id,
                'updated_at' => $comment->updated_at,
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
        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found'
            ], 404);
        }

        $comment->delete();

        return response()->json(null, 204);
    }
}
