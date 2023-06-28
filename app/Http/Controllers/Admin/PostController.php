<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Http\Request;
use App\Models\Admin\Type;
use App\Models\Admin\Technology;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.posts.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title' => 'required|max:255',
                'description' => 'required|min:10',
                'slug' => 'required',
                'type' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id',
                
            ],
            [
                'title.required' => 'è richiesto di compilare il campo title',
                'title.max' => 'il titolo deve contenere al massimo 255 caratteri',
                'title.unique' => 'Il titolo è gia stato utilizzato',
                'description.required' => 'è richiesto di compilare il campo title',
                'description.min' => 'il testo troppo corto per essere inserito',

            ],
        );

        $form_data = $request->all();

        //inserimento img
        if( $request ->hasFile('image')){
            //public folder esiste ,post_image,cartella che creo 
            $path = Storage::disk('public')->put('post_images', $request->image);
            $form_data['image'] = $path;
        }

        $newPost = new Post();
        $newPost->fill($form_data);

        $newPost->save();

        if ($request->has('technologies')) {
            $newPost->technologies()->attach($request->technologies);
        }

        return redirect()->route( 'admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $singoloPost = Post::find($id);
        return view('admin.posts.show', compact('singoloPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.edit', compact('post', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $request->validate(
            [
                'title' => 'required|max:255',
                'description' => 'required|min:10',
                'technologies' => 'nullable|exists:technologies,id',
                
            ],
            [
                'title.required' => 'è richiesto di compilare il campo title',
                'title.max' => 'il titolo deve contenere al massimo 255 caratteri',
                'title.unique' => 'Il titolo è gia stato utilizzato',
                'description.required' => 'è richiesto di compilare il campo title',
                'description.min' => 'il testo troppo corto per essere inserito',

            ],
        );

        $form_data = $request->all();

        if( $request ->hasFile('image')){
            
            if( $post->image) {
                Storage::delete( $post->image);
                 }
            //public folder esiste ,post_image,cartella che creo 
            $path = Storage::disk('public')->put('post_images', $request->image);
            $form_data['image'] = $path;
        };

        $post->update($form_data);

        if($request->has('technologies')){
            $post->technologies()->sync($request->technologies);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if( $post->image) {
            Storage::delete($post->image);
             }

        $post->technologies()->sync([]);
        $post->delete();
        
        return redirect()->route('admin.posts.index');
    }
}
