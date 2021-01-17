@extends('layouts.app')

@section('content')

<div class="container" style="padding-bottom: 100px;">
	<div class="row">
		<div class="col-lg-12">
			<span class="form-title" style="margin-right: 20px;"><i class="fas fa-utensils"></i>Recipes</span>
            <div class="recipe-contents"  style="padding-top: 20px">
                @foreach($recipes as $recipe)
					<div class="recipe-content">
                        <a href="{{route('recipe.show', ['id' => $recipe])}}" class="recipe-select">
                            <div style="position: relative;">
                                @if($recipe->recipe_img)
                                    <img src="{{ asset('storage/'.$recipe->recipe_img)}}" class="recipe-image">
                                @else
                                    <img src="{{ asset('/img/logo.jpg') }}" class="recipe-image">
                                @endif
                                <span style="font-size:12px;margin-top: 5px" class="hidden-sp recipe-intro">
                                    {{$recipe->introduction}}
                                </span>
                            </div>
                                <span style="font-size: 18px;">
                                    <i class="fas fa-utensils font-md-sp" style="margin-top: 5px;">
                                        {{$recipe->title}}
                                    </i>
                                </span>
						</a>
							<span>
                                <a href="{{route('user.show', ['id' => $recipe->user_id])}}">
									<i class="fas fa-user" style="color: #F96167"></i>
									<span style="color: black">{{$recipe->user->name}}</span>
                                </a>
                                <span style="margin: 0 30px;">
                                    <i class="fas fa-comment" style="color: #F96167;"></i>
                                        <span style="color: black">{{count($recipe->comments)}}件</span>
                                </span>
                                <i class="fas fa-heart" style="color: #F96167"></i>
                                <span style="color:black">
                                    {{count($recipe->favorites)}}
                                </span>
							</span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection