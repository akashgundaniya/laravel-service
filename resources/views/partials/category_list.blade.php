
 @foreach($categories as $cat)
    <li class="category-item"><span>{{ $cat->name }} <span class="badge badge-primary badge-pill">{{ count($cat->childs) }}</span> </span> 
        <button type="button" class="btn btn-sm btn-secondary add-cat" data-cat="{{ $cat->id }}" data-route="{{ route('category.store') }}" >Add</button>
        <button type="button"  class="btn btn-sm btn-success edit-cat" data-cat="{{ $cat->id }}"  data-catname="{{ $cat->name }}" data-route="{{ route('category.update',$cat->id) }}" >Edit</button>

        <form  action="{{ route('category.destroy',$cat->id) }}" method="post" id="delet-form-{{ $cat->id }}" style="display:inline-block; vertical-align: middle; margin: 0;" >
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete this categorie?" class="btn btn-sm btn-danger btn-rounded btn-fw">Delete</button>
        </form>
             <div id="cat-form-{{ $cat->id }}" style="display:none">
                <form class="forms" enctype="multipart/form-data" id="category-form-{{ $cat->id }}" method="post"> 
                    <div id="edit-block-{{ $cat->id }}">
                    </div> 
                      @csrf

                    <div class="form-group c_group">
                        <div class="input-group">
                            <input type="text" name="name" id="category-input-{{ $cat->id }}" class="form-control category"/>
                            <input type="hidden" name="parent_id" id="category-{{ $cat->id }}" class="form-control parent_id" value="{{ $cat->id }}" />
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-success category-add">Save </button>
                                <button type="button" class="btn btn-sm btn-danger cancle" data-cat="{{ $cat->id }}">Cancle </button>
                              </div>
                        </div>
                    </div>
                </form>  
                
             </div>
            @if(count($cat->childs))
             <ul> 
                    @include('partials.category_list', ['categories' => $cat->childs])
             </ul>
        @endif      
    </li>  
@endforeach
