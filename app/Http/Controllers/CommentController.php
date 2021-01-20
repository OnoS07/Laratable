<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Recipe;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, Comment::$rules, [], ['content'=>'コメント本文']);
        $comment = new Comment;
        $comment->recipe_id = $request->recipe_id;
        $comment->user_id = $request->user_id;
        $comment->content = $request->content;
        if($comment->save()){
            session()->flash('flash_comment', 'NEW COMMENT CREATE !');
        }
        $recipe = Recipe::find($request->recipe_id);
        return redirect()->route('recipe.show', ['id'=>$recipe]);
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $comment = Comment::find($request->id)->delete();
        return redirect()->route('recipe.show', ['id'=>$recipe]);
    }   
}
