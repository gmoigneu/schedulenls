@if(session('message'))
    <div class="alert alert-{{ session('message.type') }}">
        {{ session('message.text') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif