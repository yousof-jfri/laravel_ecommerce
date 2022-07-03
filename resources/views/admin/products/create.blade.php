@component('admin.layouts.content')
    @slot('title', 'دسته بندی جدید')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.products.index') }}">محصولات</a>
        </li>
        <li class="breadcrumb-item active">محصول جدید</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">محصول جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.products.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم محصول</label>
                            <input type="text" class="form-control @error('name') invalide @enderror" id="name" name="name" placeholder="اسم محصول را وارد کنید">
                            @error('name')
                                <div class="alert alert-danger mt-3">
                                    <span>نام دسته بندی مناسب نیست</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">توضیحات محصول</label>
                            
                            
                            <div class="mb-3">
                                <textarea id="description" name="description" style="width: 100%" rows="10" placeholder="لطفا متن مورد نظر خودتان را وارد کنید"></textarea>
                              </div>

                            @error('description')
                                <div class="alert alert-danger mt-3">
                                    <span>توضیحات محصول مناسب نیست</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">قیمت محصول</label>
                            <input type="number" class="form-control @error('price') invalide @enderror" id="price" name="price" placeholder="قیمت محصول را وارد کنید">
                            @error('price')
                                <div class="alert alert-danger mt-3">
                                    <span>قیمت محصول مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inventory">موجودی محصول</label>
                            <input type="number" class="form-control @error('inventory') invalide @enderror" id="inventory" name="inventory" placeholder="موجودی محصول را وارد کنید">
                            @error('inventory')
                                <div class="alert alert-danger mt-3">
                                    <span>موجودی محصول مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">عکس محصول</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">انتخاب فایل</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category">دسته بندی محصول</label>
                            <select name="categories[]" multiple class="form-control select2" id="category">
                                @foreach (App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="alert alert-danger mt-3">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div id="attributeDiv"></div>
                            <button type="button" class="btn btn-primary" onclick="newAttribute({{ App\Models\Attribute::all() }})">افزودن ویژه گی</button>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ثبت محصول</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @slot('js')
    
        <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('plugins/select2/select2.full.js') }}"></script>
        
        <script src="{{ asset('dist/js/custom.js') }}"></script>

        <script>
            
            $(function () {
              // Replace the <textarea id="editor1"> with a CKEditor
              // instance, using default configuration.
              
              $('select').select2()
              ClassicEditor
                .create(document.querySelector('#description'))
                    .then(function (editor) {
                    // The editor instance
                    })
                    .catch(function (error) {
                    console.error(error)
                    })
          
              // bootstrap WYSIHTML5 - text editor
          
                $('.textarea').wysihtml5({
                    toolbar: { fa: true }
                })
            })
        </script>
    @endslot

@endcomponent