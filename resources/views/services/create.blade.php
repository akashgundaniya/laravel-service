@extends('layouts.app')
@push('stylesheets') 
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">     
@endpush
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<section class="content container">
  <p>@include('partials._errors')</p>
  <form id="UserForm" name="services-form" action="@yield('editId',route('services.index'))" method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
    {{csrf_field()}}
    @section('editMethod')
    @show
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header with-border">
                <h3 class="card-title">Service</h3>
              </div> 
              <div class="card-body">
                <div class="form-group">
                    <label for="name">Category<span class="required">*</span></label>
                    <select class="form-control" name="category_id" id="mainCat">
                       <option value="" disabled selected>Select Tutorial Category </option> 
                        @foreach($categories as $key => $value)
                          <option value="{{ $key }}"  {{ (isset($item) && $item->categories_id == $key) ? 'selected' : '' }}>{{ $value }} </option>
                        @endforeach;
                    </select> 
                </div>
                <div class="form-group">
                    <label for="name">Category<span class="required">*</span></label>
                    <select class="form-control" name="sub_category_id" id="subCat">
                       <option value="" disabled selected>Select Sub Category </option>  
                    </select> 
                </div> 
                <div class="form-group">
                    <label for="name">Name<span class="required">*</span></label>
                    <input type="text" id="name" name="name" required="required" class="form-control" value="{{ empty($item) ? old('name') : $item->name }}">
                </div>  
                <div class="form-group">
                    <label for="name">Start Date</label> 
                    <input type="text" id="start_date" name="start_date" class="form-control search-field" autocomplete="off" />
                </div>   
                <div class="form-group">
                    <label for="name">End Date</label> 
                    <input type="text" id="end_date" name="end_date" class="form-control search-field" autocomplete="off" />
                </div> 
                <div class="form-group">
                    <label for="name">Description</label> 
                    <textarea id="description" name="description" class="form-control search-field"></textarea> 
                </div>  
              </div> 
            </div>
        </div> 
    </div>
    <!-- end row -->
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button class="btn btn-warning" type="reset">Reset</button>
        <button class="btn btn-danger" type="button"  onclick="window.location.href='{{ route('services.index') }}'">Cancel</button> 
      </div> 
  </form>
</section>
<!-- End content-page -->
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
@endsection
@push('scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){ 
      $( "#mainCat" ).change(function(element) {
        var catId = $(this).val();  
        getSubCategoryByCategoryId(catId,'#subCat');
      });
      $('#start_date,#end_date').datetimepicker({ format: 'YYYY-MM-DD',}); 


  });
  
  function getSubCategoryByCategoryId(catId,responseTarget){
     
      $.ajax({
        type: 'GET', 
        url: "{{ route('category.getSubCategoryByCategoryId')}}",
        data: {
            //'_token': '{{ csrf_token() }}',
            'id': catId 
        },
        success: function(response) {
               var options = ' <option value="" disabled selected>Sekect Sub Category </option> '; 
              if(response.length != 0){
                   console.log(response);  
                  $.each(response, function( index, value ) { 
                    options += "<option value='"+index+"'>"+value+"</option>";
                   //$(responseTarget).append('<option value="foo" selected="selected">Foo</option>');
                  });
                  $(responseTarget).html(options); 
              }else{
                $(responseTarget).html(options)
              }
        },
      });  
    }
  
</script>
@endpush