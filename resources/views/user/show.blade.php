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
</div>

@endsection