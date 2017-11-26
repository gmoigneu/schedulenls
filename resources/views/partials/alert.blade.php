@if(session('message'))
    <div class="alert alert-{{ session('message.type') }}">
        {{ session('message.text') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-lightest border-l-4 border-red text-red-dark p-2 my-4">
        <ul class="list-reset">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif