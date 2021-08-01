<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\NotificationService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    protected $postService;
    protected $notificationService;

    public function __construct(PostService $postService, NotificationService $notificationService)
    {
        $this->postService = $postService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $allPosts = $this->postService->getAllPosts();
        return $this->sendResponse(PostResource::collection($allPosts), 'Posts retrieved successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|max:15',
            'description' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $post = $this->postService->storePost($input);

        $this->notificationService->sendNotificationByEmail(Auth::user(), $post);

        return $this->sendResponse(new PostResource($post), 'Post created successfully');
    }

    public function show(Post $post)
    {
        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully');
    }

    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'title' => 'required|max:15',
            'description' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $result = $this->postService->updatePost($input, $post);

        return $this->sendResponse(new PostResource($result), 'Post  updated successfully');
    }

    public function destroy(Post $post)
    {
        $this->postService->deletePost($post);

        return $this->sendResponse([], 'Post deleted successfully');
    }

    public function search($title)
    {
        $result = $this->postService->searchPost($title);

        return $this->sendResponse(PostResource::collection($result), 'Posts retrieved successfully');
    }
}
