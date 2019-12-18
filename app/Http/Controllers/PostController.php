<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\Post as PostResource;
use App\Post;
use App\Topic;
// use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Create a new PostController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [ 'index', 'show' ]]);
    }

    public function store(PostCreateRequest $request, Topic $topic)
    {
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->posts()->save($post);
        return new PostResource($post);
    }

    public function show(Topic $topic, Post $post)
    {
        return new PostResource($post);
    }

    public function update(PostUpdateRequest $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);
        $post->body = $request->get('body', $post->body);
        $post->save();
        return new PostResource($post);
    }

    public function destroy(Topic $topic, Post $post)
    {
        $this->authorize('destroy', $post);
        $post->delete();
        return response(null, 204);
    }
}
