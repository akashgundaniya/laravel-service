
@if ($errors->any())
	<div class="alert alert-dismissable alert-danger  shake animated">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <strong>Error !</strong> 
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
	</div>
@endif
