@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 100px;">
	<span class="form-title">Edit Ingredient</span>
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

            <p style="border-bottom: 1px solid silver; font-size: 20px" >材料</p>
            @foreach($recipe->ingredients as $ingredient)
                <form action="{{route('ingredient.update')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$ingredient->id}}">
                    <div class="row" style="padding-top: 10px">
                        <div class="col-lg-2 col-2"></div>
                        <div class="col-lg-4 col-4">
                            <input type="text" name="content" placeholder="具材" value="{{$ingredient->content}}">
                        </div>
                        <div class="col-lg-2 col-2">
                            <input type="text" name="amount" placeholder="分量" value="{{$ingredient->amount}}" size="8">
                        </div>
                        <div class="col-lg-2 col-2">
                            <input type="submit" value="変更" class="btn btn-warning btn-sm">
                        </div>
                </form>
                        <div class="col-lg-2 col-2">
                        <form action="{{route('ingredient.destroy')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$ingredient->id}}">
                            <input type="hidden" name="recipe_id" value="{{$ingredient->recipe_id}}">
                            <input type="submit" value="削除" class="btn btn-danger btn-sm">
                        </form>
                        </div>
                    </div>
            @endforeach
            <form action="{{route('ingredient.store')}}" method="post">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
				<div class="row justify-content-end" style="padding-top: 30px;">
					<div class="col-lg-4 col-4">
                        <input type="text" name="content" value="{{old('content')}}" class="new_form" placeholder="追加する具材">
					</div>
					<div class="col-lg-2 col-2">
                        <input type="text" name="amount" value="{{old('amount')}}" placeholder="分量", class="new_form" size="8">
					</div>
					<div class="col-lg-4 col-4">
                        <input type="submit" value="追加" class="btn btn-warning submit-btn-sm">
					</div>
				</div>
            </form>

			<div style="text-align: center; margin-top: 30px;">
                @if($recipe->cookings->isEmpty())
                    <a href="{{route('cooking.edit', ['id'=>$recipe])}}" class="btn btn-warning">保存する</a>
                @elseif($recipe->recipe_status == 'open' || $recipe->recipe_status == 'empty' || $recipe->recipe_status == 'close')
                    <a href="{{route('recipe.show', ['id'=>$recipe])}}" class="btn btn-warning">戻る</a>
                @else
                    <form action="{{route('recipe.update', ['id'=>$recipe])}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$recipe->id}}">
                        <input type="hidden" name="recipe_status" value="open">
                        <input type="submit" value="レシピを投稿する" class="btn btn-warning" style="padding: 5px 30px">
                    </form>
                @endif
			</div>

		</div>
	</div>
	<div class="row" style="margin-top:30px;">
		<div class="col-lg-12 col-12">
		<p style="border-bottom: 1px solid silver; font-size: 20px" >作り方
			<a href="{{route('cooking.edit', ['id'=>$recipe])}}" class="btn btn-warning btn-sm" style="margin-bottom:5px">編集</a>
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