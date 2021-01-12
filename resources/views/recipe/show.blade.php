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
                    <a href="/" class="btn btn-danger btn-sm">レシピを削除する</a>
				@endif
            @endif
            @if($recipe->recipe_img)
                <img src="{{asset('strage/' . $recipe->recipe_img)}}" class="recipe-image-show" style="margin:10px 0;">
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
            <p style="border-bottom: 1px solid #F96167; font-size: 20px; font-weight: bold">
                {{$recipe->title}}
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
                        <a href="/" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
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
                        <a href="/" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
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

</div>

@endsection