@if(session('message'))
    <div class="alert alert-{{ session('message.type') }}">
        {{ session('message.text') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning</h3>
        <ul class="list-reset">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif