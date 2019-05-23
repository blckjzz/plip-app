@if(session('sucess'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <ul>{!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}</ul>
@endif