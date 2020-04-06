@extends('layouts.app')
@push('stylesheets') 
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css"> 
@endpush
@section('content')
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-title-box">
                          <h4 class="page-title float-left">Services</h4> 
                        <div class="clearfix"></div>
                         <a href="{{ route('services.create') }}" class="btn btn-success">Add New Service</a>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                      <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                              <p>@include('partials._flash')</p> 
                            </div>
                        </div> <!-- end row -->   
                        <form method="get" action="{{ route('services.index') }}">
                         
                          <div class="row">
                              <div class="col-sm-12 col-md-4">
                                  <div class="form-group">
                                    <label>Search By Text</label>
                                    <input type="text"  name="search" id="search" class="form-control search-field"/>
                                  </div>  
                              </div> 
                              <div class="col-sm-12 col-md-4">
                                 <div class="form-group">
                                    <label for="name">Category<span class="required">*</span></label>
                                    <select class="form-control search-field" name="category_id" id="mainCat">
                                       <option value="" disabled selected>Select Tutorial Category </option> 
                                        @foreach($categories as $key => $value)
                                          <option value="{{ $key }}"  {{ (isset($item) && $item->categories_id == $key) ? 'selected' : '' }}>{{ $value }} </option>
                                        @endforeach;
                                    </select> 
                                </div>
                              </div> 
                              <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">Category<span class="required">*</span></label>
                                    <select class="form-control search-field" name="sub_category_id" id="subCat">
                                       <option value="" disabled selected>Select Sub Category </option>  
                                       @foreach($subCategories as $key => $value)
                                          <option value="{{ $key }}"  {{ (isset($item) && $item->categories_id == $key) ? 'selected' : '' }}>{{ $value }} </option>
                                        @endforeach;
                                    </select> 
                                </div>  
                              </div> 
                              <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">Search by Date</label> 
                                    <input type="text" id="start_time" name="start_time" class="form-control search-field" autocomplete="off" />
                                </div>  
                              </div>
                              <div class="col-sm-12 col-md-4">
                                  <div class="form-group" style="margin-top:30px;">
                                     <button type="submit" class="btn btn-primary form-submit">Search</button>
                                  </div>  
                              </div> 
                          </div>
                        </form>  
                        <div class="row">
                          @if($services->count() > 0 )
                            @foreach($services as $service)
                              <div class="col-sm-12 col-md-3">
                                <div class="card">
                                  <div class="card-body">
                                    <h2>{{ $service->name }}</h2>
                                    <p><string>Category</string> : {{ $service->serviceCategory->name }}</p>  
                                    <p><string>Sub Category:</string> {{ $service->serviceSubCategory->name }}</p>
                                    <p><string>Start Date</string>: {{ $service->start_date }}</p>
                                    <p><string>End Date:</string> {{ $service->end_date }}</p>
                                    <p><string>Description:</string></p>
                                    <p> {{ $service->description }}</p>

                                  </div> 
                                </div>
                              </div>    
                            @endforeach
                          @else
                          <div class="col-sm-12">
                            <div class="alert alert-info" role="alert">
                              No service found.
                            </div> 
                          </div>  
                          @endif  
                        </div> <!-- end row --> 
                        <div style="margin-top:15px;">
                         {{ $services->onEachSide(1)->links() }} 
                        </div> 
                      </div>  
                    </div>
                </div><!-- end col-->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
</div>
<!-- End content-page -->
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
@include('modals.delete')
@endsection
@push('scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
 
  $(document).ready(function(){ 
              $('#start_time').datetimepicker({ format: 'YYYY-MM-DD',}); 
              $( "#mainCat" ).change(function(element) {
                var catId = $(this).val();  
                getSubCategoryByCategoryId(catId,'#subCat');
              });  
              $('.abc').click(function(){
                 $(this ).attr('data-page'); 
                 $(this).attr('href',newHref+'&cat='+catId); 
              })
            $("form").submit(function()
            {
               $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
                 
                return true; // ensure form still submits
            });
            /* $(".search-field").change(function(){  
              alert(this.value);
                    if(isNaN(this.value)) {
                        $('.form-submit').removeAttr('disabled');
                    }else{
                      $('.form-submit').prop("disabled", true);
                    } 
            });*/

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