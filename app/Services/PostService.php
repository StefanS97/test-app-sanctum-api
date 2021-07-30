<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function getAllPosts()
    {
        return Post::orderBy('created_at')->get();
    }

    public function storePost($validatedData)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description']
        ]);

        return $post;
    }

    public function getPost($id)
    {
        return Post::find($id);
    }

    public function updatePost($validatedData, $id)
    {
        $post = Post::find($id);

        $post->title = $validatedData['title'];
        $post->description = $validatedData['description'];
        $post->save();

        return $post;
    }

    public function deletePost($id)
    {
        return Post::destroy($id);
    }

    public function searchPost($title)
    {
        return Post::where('title', 'like', "%$title%")->get();
    }
}