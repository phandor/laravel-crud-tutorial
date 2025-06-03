<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{   
    public function deletePost(Post $post){
        if (auth()->guard()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    } 

    public function actuallyUpdatePost(Post $post, Request $request){
        if (auth()->guard()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Post $post){
        if (auth()->guard()->user()->id !== $post['user_id']) {
            return redirect('/');
        }
        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->guard()->id();
        Post::create($incomingFields);
        return redirect('/');
    }
}
