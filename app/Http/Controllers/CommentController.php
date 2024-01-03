<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric',
            'user_id' =>  'required|numeric',
            'product_id' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        $comment = Comment::create([
            'rating' => $request->input('rating'),
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'comment' => $request->input('comment'),
            
        ]);
        
        return $comment;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
