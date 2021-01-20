<ul>
    <div id="error_explanation">
        @foreach ($errors->all() as $error)
            <div class="bad-flash"><i class="fas fa-exclamation-circle"></i>{{$error}}
        @endforeach
    </div>
</ul>