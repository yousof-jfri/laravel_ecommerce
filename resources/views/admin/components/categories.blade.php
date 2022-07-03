@foreach ($categories as $category)
    <div class="px-3 py-1" style="border-right: 1px solid rgb(65, 65, 65);">
        <div class="d-flex">
            <span>{{ $category->id}} - {{$category->name }}</span>
            @if(count($category->childs) > 0)
                <i class="fa fa-angle-down mx-2"> </i>
            @endif

            @can('delete-category')
                <button onclick="deleteCategory('#delete{{ $category->id }}')" type="button" class="btn btn-danger btn-sm mx-1" style="color:white">
                    <i class="fa fa-trash" style="font-size: small"></i>
                </button>
            @endcan
            @can('edit-category')
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm mx-1" style="color:white">
                    <i class="fa fa-edit" style="font-size: small"></i>
                </a>
            @endcan
            @can('add-category')
                <a href="{{ route('admin.categories.addChild', $category->id) }}" class="btn btn-success btn-sm mx-1" style="color:white">
                    <i class="fa fa-plus" style="font-size: small"></i>
                </a>
            @endcan
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" id="delete{{$category->id}}">
                @csrf
                @method('DELETE')
            </form>
            
            
            
        </div>
        @include('admin.components.categories', ['categories' => $category->childs])
    </div>
@endforeach