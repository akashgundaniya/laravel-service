@if(session()->has('success'))
	 <div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ session()->get('success') }}
  </div>
@endif

@if(session()->has('error'))
 <div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ session()->get('error') }}
  </div>
@endif

@if(session()->has('info'))
 <div class="alert alert-info alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ session()->get('info') }}
  </div>
@endif
@if ($errors->any())
	<div class="alert alert-dismissable alert-danger  shake animated">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <strong>Error !</strong> 
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
	</div>
@endif

