@extends('layouts.app')
@push('stylesheets') 
<style type="text/css">
    
    .category-list{
        padding: 0;
        margin: 0;
        font-size: 16px;
        list-style: none;
    }
    .category-list ul{
        padding: 10px 0 0 20px;
        list-style: none;
        position: relative;
    }
    .category-list li{
        line-height: 20px;
        padding: 10px 0;
        margin-bottom: 10px;
    }
    .category-list li:last-child{
        margin-bottom: 0;
    }
    .category-list .category-item span{
        display: inline-block;
        margin-right: 20px;
    } 
    .category-list ul li{
        padding: 5px 0;
    }
    .category-list ul:before{
        content: '';
        left: 0;
        border-left: 1px solid #ccc;
        position: absolute; 
        height: 100%;
    }
    .category-list ul li:before{
        content: '--';
        position: absolute;
        left: 0;
        font-size: 14px;
        line-height: 25px;
        color: #ccc;
    }
    .category-list ul ul{
        padding-left: 20px;
        list-style: none;
    }
    .category-list ul ul li:before{
        content: '---';        
    }    
    .c_group{
        padding: 10px 0;
        margin-bottom: 0;
    }

</style> 
@endpush 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Categories</div> 
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif  
                    <div id="category-wrap"> 
                        <div class="category_list-wrap">
                            <ul class="category-list">
                                   <li class="category-item"><span>Total Categories <span class="badge badge-primary badge-pill"> {{ $categories->count() }}</span> </span>
                                         <button type="button" class="btn btn-sm btn-primary add-cat" data-cat="0">Add New Category</button> 
                                         <div id="cat-form-0" class="category-form" style="display:none">
                                              <form class="forms-sample" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data"> 
                                                  @csrf
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <input type="text" name="name" id="category-0" class="form-control category"/>
                                                    </div> 
                                                    <div class="col-sm-12 col-md-6">
                                                        <button type="submit" class="btn btn-sm btn-success category-add">Add </button>
                                                         <button type="button" class="btn btn-sm btn-success cancle"  data-cat="0">Cancle </button>
                                                    </div>    
                                                </div> 
                                            </form> 
                                         </div> 
                                    </li> 
                                @include('partials.category_list', ['categories' => $categories]) 
                            </ul>    
                        </div>    
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@include('modals.delete')
@endsection

@push('scripts')  
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script type="text/javascript">
         $(function() {

               $('.add-cat').click(function(){ 
                   
                    var catId = $(this).attr('data-cat');
                     var route =  $(this).attr('data-route');
                      $('#edit-block-'+catId).html('');  
                    $('#cat-form-'+catId).show();  

                    $('#category-form-'+catId).attr('action',route);
                }); 

                $('.edit-cat').click(function(){
                    $('#add-block').hide();
                    $('#edit-block').show();
                    var catId = $(this).attr('data-cat');
                    var catName = $(this).attr('data-catname');
                     var route =  $(this).attr('data-route');
                    var category =  $('#category-input-'+catId).val(catName);
                    $('#cat-form-'+catId).show();  
                    $('#category-form-'+catId).attr('action',route);
                     $('#edit-block-'+catId).html(' <input type="hidden" name="_method" value="PUT">');
                    alert(route);

                    
                });

                $('.cancle').click(function(){
                    var catId = $(this).attr('data-cat');
                    $('#cat-form-'+catId).hide(); 
                     $('#edit-block-'+catId).html('');                  
                });  

                  $('#confirmDelete').on('show.bs.modal', function (e) {
                        $message = $(e.relatedTarget).attr('data-message');
                        $(this).find('.modal-body p').text($message);
                        $title = $(e.relatedTarget).attr('data-title');
                        $(this).find('.modal-title').text($title);

                        // Pass form reference to modal for submission on yes/ok
                        var form = $(e.relatedTarget).closest('form');

                        //$(this).find('.modal-footer #confirm').data('form', form);
                        $(this).find('.modal-footer #confirm').data('form',form);
                  }); 

                  $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
                      $(this).data('form').submit();
                  }); 
            });
        
    </script> 
@endpush

