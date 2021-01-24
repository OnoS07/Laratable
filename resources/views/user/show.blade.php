@extends('layouts.app')

@section('content')

<div class="container" style="padding-bottom: 100px;">
	<span class="form-title">
        <i class="fas fa-user"></i>
        @if($user == Auth::user())
			My Page
		@else
			User Page
		@endif
	</span>
	<div class="row" style="margin-top: 30px;">
        <div class="col-lg-4 col-12" style="text-align: center;">
            @if($user->profile_img)
                <img src="{{ asset('storage/'.$user->profile_img)}}" class="customer-image">
            @else
                <img src="{{ asset('/img/logo.jpg') }}" class="customer-image">
            @endif
		</div>
		<div class="col-lg-8 col-12">
			@if(session('flash_update'))
				<div class="good-flash"><i class="fas fa-check-circle"></i>{{session('flash_update')}}</div> 
			@endif
			<table class="table table-bordered">
				<tr>
					<td class="align-middle" style="width: 25%;">名前</td>
					<td class="align-middle">{{$user->name}}</td>
				</tr>
				<tr>
					<td class="align-middle" style="width: 200px;">自己紹介</td>
					<td class="align-middle">{{$user->introduction}}</td>
				</tr>
				@if($user == Auth::user())
				<tr>
					<td class="table-active align-middle">メールアドレス</td>
					<td class="align-middle">{{$user->email}}</td>
				</tr>
				@endif
			</table>
			<div>
                @if($user == Auth::user())
                    <a href="{{route('user.edit',['id' => $user->id ])}}" class="btn btn-warning">プロフィール編集</a>
                @endif
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 30px">
		<div class="col-lg-12">
			<span class="form-title" style="font-size: 20px;">
				<i class="fas fa-utensils"></i>
				@if($user == Auth::user())
					My Recipes
				@else
					<span id="open-recipe" style="cursor: pointer;">User Recipes
					<i class="fas fa-angle-double-down" style="margin-left: 10px;"></i></span>
				@endif
			</span>
			@if($user == Auth::user())
				<p id="close-recipe" style="cursor: pointer;">
					●非公開<i class="fas fa-angle-double-down" style="margin-left: 10px;"></i>
				</p>
				<div class="recipe-contents close-recipe-contents" style="padding: 20px 0; border-bottom: 1px silver solid; display: none;">
					@foreach($close_recipes as $recipe)
						<div class="recipe-content">
							<a href="{{route('recipe.show', ['id' => $recipe])}}">
									@if($recipe->recipe_img)
										<img src="{{ asset('storage/'.$recipe->recipe_img)}}" class="recipe-image">
									@else
										<img src="{{ asset('/img/logo.jpg') }}" class="recipe-image">
									@endif
									<span style="font-size: 18px">
										<i class="fas fa-utensils font-md-sp" style="margin-top: 5px;"> {{$recipe->title}}</i><br>
									</span>
							</a>
						</div>
					@endforeach
				</div>
			@endif
			@if($user == Auth::user())
				<p id="open-recipe" style="cursor: pointer;">
					●公開中<i class="fas fa-angle-double-down" style="margin-left: 10px;"></i>
				</p>
			@endif
			<div class="recipe-contents open-recipe-contents"  style="padding-top: 20px;display: none; ">
				@foreach($open_recipes as $recipe)
					<div class="recipe-content">
						<a href="{{route('recipe.show', ['id' => $recipe])}}">
							@if($recipe->recipe_img)
								<img src="{{ asset('storage/'.$recipe->recipe_img)}}" class="recipe-image">
							@else
								<img src="{{ asset('/img/logo.jpg') }}" class="recipe-image">
							@endif
							<span style="font-size: 18px">
								<i class="fas fa-utensils font-md-sp" style="margin-top: 5px;"> {{$recipe->title}}</i><br>
							</span>
						</a>
						<span class="hidden-sp hidden-tb">
							<span>
								<i class="fas fa-comment" style="color: #F96167;"></i>
									<span style="color: black">{{count($recipe->comments)}}件</span>
							</span>
							<i class="fas fa-heart" style="color: #F96167;margin-left: 20px;"></i>
							<span style="color:black">
								{{count($recipe->favorites)}}
							</span>
							<i class="fas fa-paw", style="color: #F96167; margin-left: 20px;"></i>
								{{$recipe->view_count}}
							<span><i class="fas fa-calendar-alt" style="color: #F96167;margin-left: 20px;"></i>
								{{$recipe->created_at->format('Y/m/d')}}
							</span>
						</span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection