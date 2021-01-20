@extends('layouts.app')

@section('content')

<div class="container" style="padding-bottom: 100px;">
	<div class="row">
		<div class="col-lg-12 col-xs-12 col-sm-12">
			<div class="top-images">
				<div class="top1">
					<div class="top-image-text">Welcome to Delitable</div>
				</div>
			</div>
			<div style="margin:30px auto ">
				@if(session('flash_notice'))
					<div class="good-flash"><i class="fas fa-check-circle"></i>{{session('flash_notice')}}</div>
				@endif
				<span class="form-title">
                    @if(Auth::check())
						Enjoy Delitable!
					@else
						Welcome to Delitable!
					@endif
				</span>
			</div>
			<p class="introduction-text">
			   当サイトは食材の配送サービスやレシピ投稿・閲覧をお楽しみいただけます<br>
				初めての方はまずは下記『About』にて、詳しい説明をご確認ください
			</p>
            <div style="padding-bottom: 30px;">
                @unless(Auth::check())
					<span class="hidden-tb hidden-sp">
						・ゲストログイン：ヘッダーの右上「ゲストログイン」よりできます<br>
						・管理者ログイン：フッター右下のロゴマークよりできます
					</span>
				@endunless
			</div>

			<div class="top-contents">
                <a href="">
					<div class="top-content top-vegetable">
						<div class="top-content-text">
								<span>[Delivary]<br>
								~野菜の配送サービス~</span>
						</div>
					</div>
                </a>
                <a href="/about">
					<div class="top-content top-about">
						<div class="top-content-text">
								<span>[About]<br>
								~Delitableの紹介~</span>
						</div>
					</div>
                </a>
                <a href="/recipe/index">
					<div class="top-content top-recipe">
						<div class="top-content-text">
								<span>[Recipe]<br>
								~レシピの共有~</span>
						</div>
					</div>
                </a>
			</div>
			<div class="hidden-tb hidden-sp">
				<div style="margin-bottom: 50px;">
					<span class="form-title" style="margin-right: 20px; font-size: 25px;">
						<i class="fas fa-utensils"></i> Recipes
					</span>
                    <div class="recipe-contents" style="justify-content: center;">
                        @foreach($recipes as $recipe)
                            <div class="recipe-content">
                                <a href="{{route('recipe.show', ['id'=>$recipe])}}" class="recipe-select">
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

                                <span class="hidden-sp hidden-tb">
                                    <a href="{{route('user.show', ['id'=>$recipe->user])}}">
                                        <i class="fas fa-user" style="color: #F96167"></i>
                                        <span style="color: black">{{$recipe->user->name}}</span>
                                    </a>
                                </span>
                            </div>
						@endforeach
					</div>
                    <span style="float: right;">
                        <a href="/recipe/index">more_Recipes > </a>
                    </span>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection