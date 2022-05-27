@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.products.update", [$product->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="avatar">{{ trans('cruds.product.fields.avatar') }}</label>
                <div class="needsclick dropzone {{ $errors->has('avatar') ? 'is-invalid' : '' }} dz_image_overwrite" id="avatar-dropzone">
                </div>
                @if($errors->has('avatar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avatar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.avatar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="brief_description">{{ trans('cruds.product.fields.brief_description') }}</label>
                <input class="form-control {{ $errors->has('brief_description') ? 'is-invalid' : '' }}" type="text" name="brief_description" id="brief_description" value="{{ old('brief_description', $product->brief_description) }}">
                @if($errors->has('brief_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('brief_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.brief_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hash_tags">{{ trans('cruds.product.fields.hash_tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('hash_tags') ? 'is-invalid' : '' }}" name="hash_tags[]" id="hash_tags" multiple>
                    @foreach($hash_tags as $id => $hash_tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('hash_tags', [])) || $product->hash_tags->contains($id)) ? 'selected' : '' }}>{{ $hash_tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('hash_tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hash_tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.hash_tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="restaurants">{{ trans('cruds.product.fields.restaurant') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('restaurants') ? 'is-invalid' : '' }}" name="restaurants[]" id="restaurants" multiple>
                    @foreach($restaurants as $id => $restaurant)
                        <option value="{{ $id }}" {{ (in_array($id, old('restaurants', [])) || $product->restaurants->contains($id)) ? 'selected' : '' }}>{{ $restaurant }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurants'))
                    <div class="invalid-feedback">
                        {{ $errors->first('restaurants') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="featured_image">{{ trans('cruds.product.fields.featured_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('featured_image') ? 'is-invalid' : '' }}" id="featured_image-dropzone">
                </div>
                @if($errors->has('featured_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.featured_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.product.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $product->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.product.fields.category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (in_array($id, old('restaurants', [])) || $product->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurants'))
                    <div class="invalid-feedback">
                        {{ $errors->first('restaurants') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.category_helper') }}</span>

            </div>
            <div class="form-group">
                <label for="preparation_time_hour">{{ trans('cruds.product.fields.preparation_time') }} (h:m)</label>
                <div style="display: flex;">
                    <input class="form-control {{ $errors->has('preparation_time_hour') ? 'is-invalid' : '' }}" style="width: 60px;" type="number" name="preparation_time_hour" id="preparation_time_hour" value="{{ old('preparation_time_hour', floor($product->preparation_time/60)) }}" step="1">
                    <span style="line-height: 30px;">:</span>
                    <input class="form-control {{ $errors->has('preparation_time_minute') ? 'is-invalid' : '' }}" style="width: 100px;" type="number" name="preparation_time_minute" id="preparation_time_minute" value="{{ old('preparation_time', $product->preparation_time%60) }}" step="1">
                </div>
                @if($errors->has('preparation_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('preparation_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.preparation_time_helper') }}</span>
            </div>
            <div class="form-group form-currency">
                <label class="required" for="price">{{ trans('cruds.product.fields.price') }}</label>
                <input class="form-control currency_price {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', currency_format2($product->price)) }}" step="0.01" required>
                <span class="currency">đ</span>

                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.price_helper') }}</span>
            </div>
            <div class="form-group form-currency">
                <label for="price_discount">{{ trans('cruds.product.fields.price_discount') }}</label>
                <input class="form-control currency_price_discount {{ $errors->has('price_discount') ? 'is-invalid' : '' }}" type="text" name="price_discount" id="price_discount" value="{{ old('price_discount', currency_format2($product->price_discount)) }}" step="0.01">
                <span class="currency">đ</span>

                @if($errors->has('price_discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price_discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.price_discount_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_price_change') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_price_change" value="0">
                    <input class="form-check-input" type="checkbox" name="is_price_change" id="is_price_change" value="1" {{ $product->is_price_change || old('is_price_change', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_price_change">{{ trans('cruds.product.fields.is_price_change') }}</label>
                </div>
                @if($errors->has('is_price_change'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_price_change') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.is_price_change_helper') }}</span>
            </div>
            <div class="form-group">
{{--                <label for="type" class="required">{{ trans('cruds.product.fields.type') }}</label>--}}
{{--                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">--}}
{{--                    <option value="1" {{ (in_array(1, old('type', [])) || $product->type == 1) ? 'selected' : '' }}>Bán theo phần</option>--}}
{{--                    <option value="2" {{ (in_array(2, old('type', [])) || $product->type == 2) ? 'selected' : '' }}>Bán theo con</option>--}}
{{--                    <option value="3" {{ (in_array(3, old('type', [])) || $product->type == 3) ? 'selected' : '' }}>Bán theo kg</option>--}}
{{--                </select>--}}

{{--                @if($errors->has('type'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('type') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.product.fields.type_helper') }}</span>--}}
                <label for="product_unit_id" class="required">{{ trans('cruds.product.fields.product_unit_id') }}</label>
                <select class="form-control select2 {{ $errors->has('product_unit_id') ? 'is-invalid' : '' }}" name="product_unit_id" id="product_unit_id">
                    @foreach($product_units as $id => $entry)
                        <option value="{{ $id }}" {{ (old('product_unit_id') ? old('product_unit_id') : $product->product_unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product_unit_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_unit_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.product_unit_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.product.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" step="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.product.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $product->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.status_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    const currency = [2000,1000,500, 200, 100, 50, 20, 10, 5, 2, 1];
    const valueRef = document.querySelector(".currency_price");
    function getCurrency(value) {
        console.clear();
        var map = new Map();
        let i = 0;
        //loop unitll value 0
        while (value) {
            //if divide in non-zero add in map
            if (Math.floor(value / currency[i])  != 0) {
                map.set(currency[i],Math.floor( value / currency[i]));
                //update value using mod
                value = value % currency[i];
            }
            i++;
        }

        for (var [key, value] of map) {
            console.log(key + ' = ' + value);
        }
    }
    function getChange() {
        // 48 - 57 (0-9)
        var str1 = valueRef.value;
        if (
            str1[str1.length - 1].charCodeAt() < 48 ||
            str1[str1.length - 1].charCodeAt() > 57
        ) {
            valueRef.value = str1.substring(0, str1.length - 1);
            return;
        }

        // t.replace(/,/g,'')
        let str = valueRef.value.replace(/,/g, "");

        let value = +str;
        getCurrency(value)
        valueRef.value = value.toLocaleString();
    }
    valueRef.addEventListener("keyup", getChange);

    const currency2 = [2000,1000,500, 200, 100, 50, 20, 10, 5, 2, 1];
    const valueRef2 = document.querySelector(".currency_price_discount");
    function getCurrency2(value) {
        console.clear();
        var map = new Map();
        let i = 0;
        //loop unitll value 0
        while (value) {
            //if divide in non-zero add in map
            if (Math.floor(value / currency2[i])  != 0) {
                map.set(currency2[i],Math.floor( value / currency2[i]));
                //update value using mod
                value = value % currency2[i];
            }
            i++;
        }

        for (var [key, value] of map) {
            console.log(key + ' = ' + value);
        }
    }
    function getChange2() {
        // 48 - 57 (0-9)
        var str1 = valueRef2.value;
        if (
            str1[str1.length - 1].charCodeAt() < 48 ||
            str1[str1.length - 1].charCodeAt() > 57
        ) {
            valueRef2.value = str1.substring(0, str1.length - 1);
            return;
        }

        // t.replace(/,/g,'')
        let str = valueRef2.value.replace(/,/g, "");

        let value = +str;
        getCurrency2(value)
        valueRef2.value = value.toLocaleString();
    }
    valueRef2.addEventListener("keyup", getChange2);
</script>
<script>
    Dropzone.options.avatarDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="avatar"]').remove()
      $('form').append('<input type="hidden" name="avatar" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="avatar"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($product) && $product->avatar)
      var file = {!! json_encode($product->avatar) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="avatar" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
<script>
    var uploadedFeaturedImageMap = {}
Dropzone.options.featuredImageDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="featured_image[]" value="' + response.name + '">')
      uploadedFeaturedImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFeaturedImageMap[file.name]
      }
      $('form').find('input[name="featured_image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($product) && $product->featured_image)
      var files = {!! json_encode($product->featured_image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="featured_image[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>

<script>
    $(document).ready(function () {
        function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                return {
                    upload: function() {
                        return loader.file
                            .then(function (file) {
                                return new Promise(function(resolve, reject) {
                                    // Init request
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', '{{ route('admin.products.storeCKEditorImages') }}', true);
                                    xhr.setRequestHeader('x-csrf-token', window._token);
                                    xhr.setRequestHeader('Accept', 'application/json');
                                    xhr.responseType = 'json';

                                    // Init listeners
                                    var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                    xhr.addEventListener('error', function() { reject(genericErrorText) });
                                    xhr.addEventListener('abort', function() { reject() });
                                    xhr.addEventListener('load', function() {
                                        var response = xhr.response;

                                        if (!response || xhr.status !== 201) {
                                            return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                        }

                                        $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                        resolve({ default: response.url });
                                    });

                                    if (xhr.upload) {
                                        xhr.upload.addEventListener('progress', function(e) {
                                            if (e.lengthComputable) {
                                                loader.uploadTotal = e.total;
                                                loader.uploaded = e.loaded;
                                            }
                                        });
                                    }

                                    // Send request
                                    var data = new FormData();
                                    data.append('upload', file);
                                    data.append('crud_id', '{{ $product->id ?? 0 }}');
                                    xhr.send(data);
                                });
                            })
                    }
                };
            }
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
                allEditors[i], {
                    extraPlugins: [SimpleUploadAdapter]
                }
            );
        }
    });
</script>
@endsection
