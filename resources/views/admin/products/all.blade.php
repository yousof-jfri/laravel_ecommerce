@component('admin.layouts.content')
    @slot('title', 'دسته بندی ها')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">محصولات </li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>محصولات</h4>
                    @can('add-product')
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">محصول جدید</a>
                    @endcan
                    
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>شماره</th>
                            <th>اسم محصول</th>
                            <th>قیمت</th>
                            <th>انبار</th>
                            <th>بازدید</th>
                            <th>عکس</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }} تومان</td>
                                <td>{{ $product->inventory }}</td>
                                <td>{{ $product->views }}</td>
                                <td><img src="{{ Storage::url($product->image) }}" alt="" style="height: 50px"></td>
                                <td>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" id="delete" method="post"> @csrf @method('DELETE') </form>
                                    @can('delete-product')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="deleteProduct('#delete')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endcan

                                    @can('edit-product')
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody></table>
                </div>
                <div class="card-footer">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    
    

    @slot('js')

        

        <script>
            function deleteProduct(id){
            Swal.fire({
                title : 'آیا میخواهید این محصول را پاک کنید؟',
                text: 'تمام اطلاعات محصول پاک میشود و قابل باز گشت نیست',
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