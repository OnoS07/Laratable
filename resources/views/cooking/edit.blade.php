@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 100px;">
	<span class="form-title">Edit Cooking</span>
	<div class="row" style="margin-top: 30px">
		<div class="col-lg-6">
            @if($recipe->recipe_img)
                <img src="{{asset('storage/'.$recipe->recipe_img)}}" class="recipe-image-show" style="margin:10px 0;">
            @else
                <img src="{{asset('/img/logo.jpg') }}" class="recipe-image-show" style="margin:10px 0;">
            @endif
		</div>
		<div class="col-lg-6 col-12">
			<p style="border-bottom: 1px solid silver; font-size: 20px" >レシピ
                <a href="{{route('recipe.edit', ['id'=>$recipe])}}" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
			</p>
			<div class="row">
				<div class="col-lg-3 col-3"><p>レシピ名</p></div>
				<div class="col-lg-9 col-9"><p>{{$recipe->title}}</p></div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-3"><p>紹介文</p></div>
				<div class="col-lg-9 col-9"><p>{{$recipe->introduction}}</p></div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-3"><p>分量(何人前)</p></div>
				<div class="col-lg-9 col-9"><p>{{$recipe->amount}}</p></div>
			</div>

            <p style="border-bottom: 1px solid silver; font-size: 20px" >材料
                <a href="{{route('ingredient.edit', ['id'=>$recipe])}}" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
            </p>
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
	<div class="row" style="padding-top: 30px">
		<div class="col-lg-12">
            <p style="border-bottom: 1px solid #F5F5F5; font-size: 20px" >作り方</p>
            @foreach($recipe->cookings as $cooking)
                <form action="{{route('cooking.update', ['id'=>$cooking])}}" method="post">
                    @csrf
                    <div class="row" style="margin-bottom: 10px">
                        <div id="move_<%= recipe.id %>" class="col-lg-1 col-2">
                        </div>
                        <div class="col-lg-9 col-10">
                            <textarea name="content" rows="2" style="width:100%">{{$cooking->content}}</textarea>
                        </div>
                        <div class="col-lg-2 col-12" style="text-align: right">
                            <input type="submit" value="変更" class="btn btn-warning btn-sm">
                                <form action="{{route('cooking.destroy', ['id'=>$cooking])}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$cooking->id}}">
                                    <input type="submit" value="削除" class="btn btn-danger btn-sm">
                                </form>
                        </div>
                    </div>
                </form>
            @endforeach
            <form action="{{route('cooking.store')}}" method="post">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
                <div class="row" style="padding-top: 30px;border-top: 1px solid #F5F5F5">
					<div class="col-lg-1"></div>
					<div class="col-lg-9 col-12">
                        <textarea name="content" rows="2" style="width:100%" placeholder="作り方を入力する", class="input-form">{{old('$cooking->content')}}</textarea>
					</div>
					<div class="col-lg-2 col-2">
                        <input type="submit" value="追加" class="btn btn-warning submit-btn-sm">
					</div>
				</div>
            </form>
 			
            <div style="text-align: center; margin-top: 50px">
                @if(empty($recipe->ingredients))
                    <a href="{{route('ingredient.edit', ['id'=>$recipe])}}" class="btn btn-warning">材料を入力する</a>
                @else
                    <a href="{{route('recipe.show', ['id'=>$recipe])}}" class="btn btn-warning">戻る</a>
                @endif
			</div>
		</div>
	</div>
</div>
@endsection