<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Posts=Post::all();
        return view('index', compact("Posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   if ($request->hasFile("image")) {
        $image = $request->file("image");
        $imname = $image->getClientOriginalName() . "-" . time() . "." . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imname);


    }
        Post::create([
            "title"=>$request->title,
            'description'=>$request->description,
            'image'=>$imname,
        ]);
        return redirect()->route("Posts.index");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Post $post)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $Post)
    {
        return view("edit", compact("Post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $Post)
{
    if ($request->hasFile("image")) {
        $image = $request->file("image");
        $imname = $image->getClientOriginalName() . "-" . time() . "." . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imname);
    } else {
        $imname = $Post->image;
    }

    $Post->update([
        "title" => $request->title,
        "description" => $request->description,
        "image" => $imname,
    ]);
    return redirect()->route("Posts.index");
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $Post)
    {
        $Post->delete();
        return redirect()->route("Posts.index");
    }
}
