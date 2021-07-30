<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $allPosts = $this->postService->getAllPosts();
        return $allPosts;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:10',
            'description' => 'required|max:255'
        ]);

        $post = $this->postService->storePost($validatedData);

        if (!$post) {
            return response([
                'message' => 'Something went wrong'
            ], 500);
        }

        $response = [
            'post' => $post
        ];

        return response($response, 201);
    }

    public function show($id)
    {
        $post = $this->postService->getPost($id);

        if (!$post) {
            return [
                'message' => 'Something went wrong'
            ];
        }

        return $post;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:10',
            'description' => 'required|max:255'
        ]);

        $post = $this->postService->updatePost($validatedData, $id);

        if (!$post) {
            return [
                'message' => 'Something went wrong'
            ];
        }

        return $post;
    }

    public function destroy($id)
    {
        $result = $this->postService->deletePost($id);

        if (!$result) {
            return [
                'message' => 'Something went wrong'
            ];
        }

        return [
            'message' => 'Post deleted successfully'
        ];
    }

    public function search($title)
    {
        $result = $this->postService->searchPost($title);

        if (!$result) {
            return [
                'message' => 'Nothing found'
            ];
        }

        return $result;
    }
}
