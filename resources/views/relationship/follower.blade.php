@extends('layouts.app')
@section('content')
<div class="container" style="padding-bottom: 100px;">
	<div class="row">
		<div class="col-lg-12">
			<span class="form-title">Follower</span>
            <span style="margin-left: 10px;font-size: 15px;">
                <a href="{{route('user.show', ['id'=>$user])}}">>back</a>
            </span>

            @foreach($followers as $follower)
				<div class="row" style="margin-top: 20px;padding-bottom: 20px; border-bottom: 1px solid #F96167">
                    <div class="col-lg-2 col-2" style="text-align: center;">
                        <a href="{{route('user.show', ['id'=>$follower->id])}}">
                            @if($follower->profile_img)
                                <img src="{{ asset('storage/'.$follower->profile_img)}}" class="follow-image">
                            @else
                                <img src="{{ asset('/img/logo.jpg') }}" class="follow-image">
                            @endif
                        </a>
					</div>
					<div class="col-lg-7 col-10 font-md-sp">
						<table class="table table-bordered">
							<tr>
								<td class="align-middle">
                                    <a href="{{route('user.show', ['id'=>$follower->id])}}">
                                        {{$follower->name}}
                                    </a>
								</td>
							</tr>
							<tr>
								<td class="align-middle">{{$follower->introduction}}</td>
							</tr>
						</table>
					</div>
					<div class="col-lg-3 col-1 font-md-sp" style="text-align: center;">
                        @if(Auth::check())
                            @if(Auth::id() != $follower->id)
                                @if($follower->followed_by())
                                    <form action="{{route('unfollow')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$follower->id}}">
                                        <input type="submit" value="フォローをやめる" class="btn btn-secondary submit-btn" style="border: none;">
                                    </form>
                                @else
                                    <form action="{{route('follow')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$follower->id}}">
                                        <input type="submit" value="フォローをする" class="btn btn-warning submit-btn" style="border: none;">
                                    </form>
                                @endif
                            @endif
                        @endif
					</div>
				</div>
            @endforeach
            
		</div>
	</div>
</div>
@endsection