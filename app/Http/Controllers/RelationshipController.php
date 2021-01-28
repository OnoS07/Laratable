<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Relationship;
use App\Models\User;

class RelationshipController extends Controller
{
    public function follow(Request $request){
        $follow = Relationship::create([
            'follow_id' => Auth::id(),
            'follower_id' => $request->user_id,
        ]);
        return redirect()->route('user.show', ['id'=>$request->user_id]);
    }

    public function unfollow(Request $request){
        $followed_user_id = $request->user_id;
        $follow = Relationship::where('follow_id', Auth::id())->where('follower_id', $followed_user_id)->first();
        $follow->delete();

        return redirect()->route('user.show', ['id'=>$followed_user_id]);
    }
}
