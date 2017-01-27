<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Image;

class PostsController extends Controller
{
    protected $posts;

    function __construct(Post $posts)
    {
        $this->posts = $posts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->posts->all();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('posts.form', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;

        $image = $request->file('image');
        $filename = time().'-'.$image->getClientOriginalName();
        Image::make($image->getRealPath())->save(public_path('uploads/posts/'.$filename));

        $post->image = $filename;

        $post->save();

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->posts->findOrFail($id);
        return view('posts.form', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = $this->posts->findOrFail($id);

        $post->title = $request->title;
        $post->body = $request->body;

        if ($request->hasFile('image')) {
            $old_image = $post->image;
            if ($old_image!=null) {
                unlink(public_path('uploads/posts/'.$old_image));
            }
            $image = $request->file('image');
            $filename = time().'-'.$image->getClientOriginalName();
            Image::make($image->getRealPath())->save(public_path('uploads/posts/'.$filename));

            $post->image = $filename;   
        }

        $post->save();

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
