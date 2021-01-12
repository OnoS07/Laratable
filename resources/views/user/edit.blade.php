@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 120px">
	<span class="form-title">
		<i class="fas fa-user"></i> Edit Profile
	</span>
    <span style="margin-left: 10px;font-size: 15px; padding-top: 20px;">
        <a href="{{route('user.show',['id' => Auth::user()->id ])}}">>back</a>
    </span>
    <form action='{{route('user.update')}}' method="post" enctype='multipart/form-data'>
        @csrf
        <input type="hidden" name="id" value="{{$user->id}}">
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-4 col-12" style="text-align: center;">
                @if($user->profile_img)
                    <img src="{{ asset('storage/'.$user->profile_img)}}" class="customer-image" id="img">
                @else
                    <img src="{{ asset('/img/logo.jpg') }}" class="customer-image" id="img">
                @endif
                <input type="file" name="profile_img" onchange="previewImage(this);"></input>
                <script>
                    function previewImage(obj)
                    {
                      var fileReader = new FileReader();
                      fileReader.onload = (function() {
                        document.getElementById('img').src = fileReader.result;
                      });
                      fileReader.readAsDataURL(obj.files[0]);
                    }
                  </script>
            </div>

            <div class="col-lg-8 col-12">
                <table class="table table-borderless">
                    <tr>
                        <td class="align-middle" style="width: 200px;">名前</td>
                        <td class="align-middle">
                            <input type="text" name="name" value="{{ $user->name }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle" style="width: 200px;">自己紹介</td>
                        <td class="align-middle">
                            <textarea type="text" name="introduction">{{ $user->introduction }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle">メールアドレス</td>
                        @if($user->email == 'test@test')
                            <td>ゲストアカウントのため、メールアドレスの変更はできません</td>
                        @else
                            <input type="text" name="email" value="{{ old('email') }}">
                        @endif
                    </tr>
                </table>
            </div>
	    </div>
        <div class="row" style="text-align: center;">
            <div class="col-lg-12">
                <input type="submit" value="編集する" class="btn-warning btn submit-btn">
            </div>
        </div>
    </form>
</div>

@endsection