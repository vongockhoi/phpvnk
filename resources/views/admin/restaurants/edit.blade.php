@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.restaurant.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.restaurants.update", [$restaurant->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.restaurant.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', $restaurant->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="avatar">{{ trans('cruds.restaurant.fields.avatar') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('avatar') ? 'is-invalid' : '' }}"
                         id="avatar-dropzone">
                    </div>
                    @if($errors->has('avatar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.avatar_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="province_id">{{ trans('cruds.restaurant.fields.province') }}</label>
                    <select class="form-control select2 {{ $errors->has('province') ? 'is-invalid' : '' }}"
                            name="province_id" id="province_id" required>
                        @foreach($provinces as $id => $entry)
                            <option value="{{ $id }}" {{ (old('province_id') ? old('province_id') : $restaurant->province->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('province'))
                        <div class="invalid-feedback">
                            {{ $errors->first('province') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.province_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="district_id">{{ trans('cruds.restaurant.fields.district') }}</label>
                    <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}"
                            name="district_id" id="district_id" required>
                        @foreach($districts as $id => $entry)
                            <option value="{{ $id }}" {{ (old('district_id') ? old('district_id') : $restaurant->district->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('district'))
                        <div class="invalid-feedback">
                            {{ $errors->first('district') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.district_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="address">{{ trans('cruds.restaurant.fields.address') }}</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                           name="address" id="address" value="{{ old('address', $restaurant->address) }}" required>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="status_id">{{ trans('cruds.restaurant.fields.status') }}</label>
                    <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status_id" id="status_id">
                        @foreach($statuses as $id => $entry)
                            <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $restaurant->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="latitude">{{ trans('cruds.restaurant.fields.latitude') }}</label>
                    <input class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" type="number"
                           name="latitude" id="latitude" value="{{ old('latitude', $restaurant->latitude) }}"
                           step="0.0000000001" required>
                    @if($errors->has('latitude'))
                        <div class="invalid-feedback">
                            {{ $errors->first('latitude') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.latitude_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="longitude">{{ trans('cruds.restaurant.fields.longitude') }}</label>
                    <input class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" type="number"
                           name="longitude" id="longitude" value="{{ old('longitude', $restaurant->longitude) }}"
                           step="0.0000000001" required>
                    @if($errors->has('longitude'))
                        <div class="invalid-feedback">
                            {{ $errors->first('longitude') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.longitude_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="featured_image">{{ trans('cruds.restaurant.fields.featured_image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('featured_image') ? 'is-invalid' : '' }}"
                         id="featured_image-dropzone">
                    </div>
                    @if($errors->has('featured_image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('featured_image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.featured_image_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.restaurant.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description">{!! old('description', $restaurant->description) !!}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="hotline">{{ trans('cruds.restaurant.fields.hotline') }}</label>
                    <input class="form-control {{ $errors->has('hotline') ? 'is-invalid' : '' }}" type="number" name="hotline" id="hotline" value="{{ old('hotline', $restaurant->hotline) }}" step="1">
                    @if($errors->has('hotline'))
                        <div class="invalid-feedback">
                            {{ $errors->first('hotline') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurant.fields.hotline_helper') }}</span>
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
        Dropzone.options.avatarDropzone = {
            url: '{{ route('admin.restaurants.storeMedia') }}',
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
                @if(isset($restaurant) && $restaurant->avatar)
                var file = {!! json_encode($restaurant->avatar) !!}
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
            url: '{{ route('admin.restaurants.storeMedia') }}',
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
                @if(isset($restaurant) && $restaurant->featured_image)
                var files =
                {!! json_encode($restaurant->featured_image) !!}
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
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return {
                        upload: function () {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function (resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '{{ route('admin.restaurants.storeCKEditorImages') }}', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${file.name}.`;
                                        xhr.addEventListener('error', function () {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function () {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function () {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({default: response.url});
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $restaurant->id ?? 0 }}');
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

    <script>
        $(function () {
            filterDistrictFromProvince();
        })

        $("#province_id").change(function () {
            filterDistrictFromProvince();
        });

        function filterDistrictFromProvince() {
            var province_id = $("#province_id").val();
            $.ajax({
                url: '{{ route("admin.districts.filterDistrictFromProvince") }}',
                data: {
                    province_id: province_id
                },
                type: "get",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    console.log(data)
                    $('#district_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Xin hãy lựa chọn</option>')

                    $.each(data, function (v, t) {
                        if (v == {{ $restaurant->district->id }}) {
                            $('#district_id').append($('<option>', {value: v, text: t}).attr('selected', 'selected'));
                        } else {
                            $('#district_id').append($('<option>', {value: v, text: t}));
                        }
                    });
                },
                error: function () {
                }
            });
        }

    </script>
@endsection
