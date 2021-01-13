@extends('layouts.app')

@section('content')
<div class="container">
	<span class="form-title">Edit Recipe</span>
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-6 col-12">
            <form action="{{route('recipe.update', ['id'=>$recipe])}}" method="post" enctype='multipart/form-data'>
                @csrf
                <input type="hidden" name="id" value="{{$recipe->id}}">
            @if($recipe->recipe_img)
                <img src="{{asset('storage/' . $recipe->recipe_img)}}" class="recipe-image-show" id="preview-image" style="margin:10px 0;">
            @else
                <img src="{{asset('/img/logo.jpg') }}" class="recipe-image-show" id="preview-image" style="margin:10px 0;">
            @endif
            <input type="file" name="recipe_img" id="select-image" style="margin: 10px 0">
        </div>
        <div class="col-lg-6 col-12">
            <p style="border-bottom: 1px solid #F5F5F5; font-size: 20px" >レシピ</p>
                <div class="row">
                    <div class="col-lg-3">レシピ名</div>
                    <div class="col-lg-9">
                        <p>
                            <input type="text" name="title" style="width:80%" value="{{$recipe->title}}" placeholder="レシピ名">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">紹介文</div>
                    <div class="col-lg-9">
                        <p>
                            <textarea type="text" name="introduction" rows="3" style="width:100%" placeholder="ポイント、特徴など">{{$recipe->introduction}}</textarea>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">分量</div>
                    <div class="col-lg-9">
                        <input type="text" name="amount" style="width:80%" value="{{$recipe->amount}}" placeholder="何人前 何食分">
                    </div>
                </div>
                <div style="text-align: center;margin: 20px 0">
                    <input type="submit" value="保存する" class="btn btn-warning submit-btn">
                </div>
            <p style="border-bottom: 1px solid silver; font-size: 20px" >材料</p>
            @foreach($recipe->ingredients as $ingredient)
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-lg-8 col-8 font-md-sp">
                        {{$ingredient->content}}
                    </div>
                    <div class="col-lg-4 col-4 font-md-sp">
                        {{$ingredient->amount}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

	<div class="row" style="margin-top:30px; padding-bottom: 100px;">
		<div class="col-lg-12">
			<p style="border-bottom: 1px solid silver; font-size: 20px" >作り方</p>
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