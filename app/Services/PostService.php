<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function getAllPosts()
    {
        return Post::all();
    }

    public function storePost($input)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $input['title'],
            'description' => $input['description']
        ]);

        return $post;
    }

    public function getPost($id)
    {
        return Post::find($id);
    }

    public function updatePost($input, $id)
    {
        $post = Post::find($id);

        if(!$post) {
            return null;
        }

        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();

        return $post;
    }

    public function deletePost($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return null;
        }

        return $post->delete();
    }

    public function searchPost($title)
    {
        return Post::where('title', 'like', "%$title%")->get();
    }
}