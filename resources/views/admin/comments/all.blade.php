@component('admin.layouts.content')
    @slot('title', 'نظرات')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">نظرات</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>نظرات</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>نظر</th>
                                <th>نظر پدر</th>
                                <th>وضعیت</th>
                                <th>توسط</th>
                                <th>محصول</th>
                                <th>اقدامات</th>
                            </tr>

                            @foreach ($comments as $comment)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $comment->comment }}</td>
                                
                                <td>{{ $comment->parent_id != 0 ? $comment->parent_id : 'ندارد' }}</td>
                                <td> @if( $comment->approved) <span class="badge badge-success">تایید شده</span> @else <span class="badge badge-danger">تایید نشده</span> @endif</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ $comment->product->name }}</td>
                                <td>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" id="delete{{$comment->id}}">@csrf @method('DELETE')</form>
                                    <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST" id="approve{{$comment->id}}">@csrf @method('PATCH')</form>
                                    @can('delete-comment')
                                        <button type="button" onclick="deleteCategory('#delete{{$comment->id}}')" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endcan
                                    @can('approve-comment')
                                        @if($comment->approved != 1)
                                        <button onclick="document.querySelector('#approve{{$comment->id}}').submit()" class="btn btn-sm btn-primary">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        @endif
                                    @endcan
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    

    @slot('js')

        

        <script>
            function deleteCategory(id){
            Swal.fire({
                title : 'آیا میخواهید این نظر را پاک کنید؟',
                showCancelButton: true,
                confirmButtonText: 'بله ، پاکش کن',
                cancelButtonText: 'خیر',
                cancelButtonColor: 'tomato'
            }).then((result) => {
                if(result.isConfirmed){
                    document.querySelector(id).submit()
                }
            })
            }
        </script>
        
    @endslot
@endcomponent