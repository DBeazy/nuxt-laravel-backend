<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\TopicUpdateRequest;
use App\Http\Resources\Topic as TopicResource;
use App\Post;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [ 'index', 'show' ]]);
    }

    public function index()
    {
        $topics = Topic::latestFirst()->paginate(5);
        return TopicResource::collection($topics);
    }

    public function store(TopicCreateRequest $request)
    {
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return new TopicResource($topic);
    }

    public function show(Topic $topic)
    {
        return new TopicResource($topic);
    }

    public function update(TopicUpdateRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->title = $request->get('title', $topic->title);
        $topic->save();
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();
        return response(null, 204);
    }
}
