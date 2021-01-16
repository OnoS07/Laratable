@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 100px;">
	<span class="form-title"><i class="fas fa-utensils"></i> Recipe</span>
    <span style="margin-left: 10px;font-size: 15px;">
        <a href="{{route('recipe.index')}}">>back</a>
    </span>
	<div class="row" style="margin-top: 30px">
		<div class="col-lg-6 col-12">
            @if(Auth::check())
                @if($recipe->user == Auth::user())
                    <span style="float: right">
                        <form action="{{route('recipe.destroy')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$recipe->id}}">
                            <input type="submit" value="レシピを削除する" class="btn btn-danger btn-submit-sm">
                        </form>
                    </span>
				@endif
            @endif
            @if($recipe->recipe_img)
                <img src="{{asset('storage/'.$recipe->recipe_img)}}" class="recipe-image-show" style="margin:10px 0;">
            @else
                <img src="{{asset('/img/logo.jpg') }}" class="recipe-image-show" style="margin:10px 0;">
            @endif
			<div style="margin-top: 20px;">
				<span class="font-md">
                    <a href="{{route('user.show', ['id'=>$recipe->user])}}">
						<i class="fas fa-user" style="color: #F96167"></i>
                        <span style="color: black">
                            {{$recipe->user->name}}
                        </span>
                    </a>
				</span>
			</div>
		</div>

		<div class="col-lg-6 col-12">
            <p style="border-bottom: 1px solid #F96167; font-size: 20px; font-weight: bold">{{$recipe->title}}
                @if(Auth::check())
                    @if($recipe->user == Auth::user())
                        <a href="{{route('recipe.edit', ['id'=>$recipe->user])}}" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
                    @endif
                @endif
			</p>
			<div class="row">
				<div class="col-lg-12 col-12">
                    <p>{{$recipe->introduction}}</p>
                </div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-3"><p>分量(何人前)</p></div>
				<div class="col-lg-9 col-9"><p>{{$recipe->amount}}</p></div>
			</div>

            <p style="border-bottom: 1px solid #F96167; font-size: 20px;margin-top:20px" >材料
                @if(Auth::check())
                    @if($recipe->user == Auth::user())
                        <a href="{{route('ingredient.edit', ['id'=>$recipe])}}" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
                    @endif
                @endif
            </p>
            @foreach($recipe->ingredients as $ingredient)
				<div class="row" style="margin-bottom: 10px">
					<div class="col-lg-5 col-5 font-md-sp">
                        {{$ingredient->content}}
					</div>
					<div class="col-lg-7 col-7 font-md-sp">
						{{$ingredient->amount}}
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<div class="row" style="margin-top:30px;">
		<div class="col-lg-12 col-12">
            <p style="border-bottom: 1px solid #F96167; font-size: 20px" >作り方
                @if(Auth::check())
                    @if($recipe->user == Auth::user())
                        <a href="{{route('cooking.edit', ['id'=>$recipe])}}" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
                    @endif
                @endif
            </p>
            @foreach($recipe->cookings as $cooking)
				<div class="row" style="margin-bottom: 10px">
					<div class="col-lg-1 col-1 font-md-sp" style="text-align: right"  >
						{{$loop->iteration}}
					</div>
					<div class="col-lg-11 col-11 font-md-sp">
						{{$cooking->content}}
					</div>
				</div>
			@endforeach
		</div>
    </div>
    
    <div style="margin-top:30px;" id="comments">
        <span class="form-title" >Comments</span>
            @foreach($recipe->comments as $comment)
                <div style="margin: 10px 0">
                    <div class="row">
                        <div class="col-lg-4 col-4" style="text-align: center">
                            @if($comment->user->profile_img)
                                <a href="{{route('user.show', ['id'=>$comment->user->id])}}">
                                    <img src="{{asset('storage/'.$comment->user->profile_img)}}" class="comment-image">
                                </a>
                            @else
                                <a href="{{route('user.show'), ['id'=>$comment->user->id]}}">
                                    <img src="{{asset('/img/logo.jpg') }}" class="comment-image">
                                </a>
                            @endif
                        </div>
                        <div class="col-lg-6 col-8 font-md-sp" style="margin: auto 0;">
                            {{$comment->content}}
                        </div>
                        <div class="col-lg-2 col-2"></div>
                    </div>
                    <div class="row" style="border-bottom: 1px silver solid; margin: 0 10px">
                        <div class="col-lg-12 col-12">
                            <span style="float: right" class="font-md-sp">
                                <a href="{{route('user.show', ['id'=>$comment->user->id])}}">
                                    <i class="fas fa-user" style="color: #F96167"></i>{{$comment->user->name}}
                                </a>
                                <span style="margin:0 10px"><i class="fas fa-calendar-alt", style="color: #F96167"></i>
                                    {{$comment->created_at->format('Y/m/d')}}
                                </span>
                                @if($comment->user == Auth::user())
                                    <form action="{{route('comment.destroy')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$comment->id}}">
                                        <input type="hidden" name="recipe_id" value="{{$comment->recipe_id}}">
                                        <input type="submit" value="削除" class="btn btn-danger btn-sm" style="float: right;">
                                    </form>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(Auth::check())
				<div class="row" style="margin-top: 30px">
					<div class="col-lg-12 col-12">
                        <span class="form-title" style="font-size: 20px">New Comment</span>
                        <form action="{{route('comment.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                            <textarea name="content" rows="2" style="width:80%;" class="font-md-sp">{{old('content')}}</textarea><br>
                            <input type="submit" value="コメント" class="btn btn-warning submit-btn">
                        </form>
					</div>
				</div>
			@endif
    </div>

</div>
@endsection