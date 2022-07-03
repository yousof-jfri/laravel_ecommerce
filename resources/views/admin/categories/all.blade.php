@component('admin.layouts.content')
    @slot('title', 'دسته بندی ها')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">دسته بندی ها </li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>دسته بندی ها</h4>
                    @can('add-category')
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">دسته بندی جدید</a>
                    @endcan
                </div>
                <div class="card-body">
                    @include('admin.components.categories', ['categories' => $categories])
                </div>
                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    
    

    @slot('js')

        

        <script>
            function deleteCategory(id){
            Swal.fire({
                title : 'آیا میخواهید این دسته بندی را پاک کنید؟',
                text: 'تمام دسته بندی های زیر دسته هم پاک میشوند و قابل باز گشت نیستند',
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