@extends('layouts.app')

@section('content')
<div class="container">
	<span class="form-title">New Recipe</span>
	<div class="row" style="margin-top: 30px">
		<div class="col-lg-6">
            <form action="{{route('recipe.store')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="user_id" value="{{Auth::id()}}">
            <img src="{{asset('/img/logo.jpg') }}" class="recipe-image-show" id="preview-image">
            <input type="file" name="recipe_img" id="select-image" style="margin: 10px 0"><br>
		</div>
		<div class="col-lg-6">
			<p style="border-bottom: 1px solid #F5F5F5; font-size: 20px" >レシピ</p>
				<div class="row">
					<div class="col-lg-3">レシピ名</div>
					<div class="col-lg-9">
                        <p>
                            <input type="text" name="title" style="width:80%" value="{{old('title')}}" placeholder="レシピ名">
                        </p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">紹介文</div>
					<div class="col-lg-9">
                        <p>
                            <textarea type="text" name="introduction" rows="3" style="width:100%" placeholder="ポイント、特徴など">{{old('introduction')}}</textarea>
                        </p>
                    </div>
				</div>
				<div class="row">
					<div class="col-lg-3">分量</div>
					<div class="col-lg-9">
                        <p>
                            <input type="text" name="amount" style="width:80%" value="{{old('amount')}}" placeholder="何人前 何食分">
                        </p>
					</div>
				</div>
                <div style="text-align: center;margin: 20px 0">
                    <input type="submit" value="保存する" class="btn btn-warning submit-btn">
                </div>
            </form>
		</div>
	</div>
</div>
@endsection