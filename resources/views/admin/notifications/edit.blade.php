@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.notification.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.notifications.update", [$notification->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('cruds.notification.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $notification->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sub_title">{{ trans('cruds.notification.fields.sub_title') }}</label>
                <input class="form-control {{ $errors->has('sub_title') ? 'is-invalid' : '' }}" type="text" name="sub_title" id="sub_title" value="{{ old('sub_title', $notification->sub_title) }}">
                @if($errors->has('sub_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sub_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.sub_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="content">{{ trans('cruds.notification.fields.content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $notification->content) !!}</textarea>
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.content_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.notification.fields.target_type') }}</label>
                <select class="form-control {{ $errors->has('target_type') ? 'is-invalid' : '' }}" name="target_type" id="target_type" required>
                    <option value disabled {{ old('target_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Notification::TARGET_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('target_type', $notification->target_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('target_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('target_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.target_type_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="target_id">{{ trans('cruds.notification.fields.target') }}</label>--}}
{{--                <select class="form-control select2 {{ $errors->has('target') ? 'is-invalid' : '' }}" name="target_id" id="target_id">--}}
{{--                    @foreach($targets as $id => $entry)--}}
{{--                        <option value="{{ $id }}" {{ (old('target_id') ? old('target_id') : $notification->target->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @if($errors->has('target'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('target') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.notification.fields.target_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="schedule_time">{{ trans('cruds.notification.fields.schedule_time') }}</label>
                <input class="form-control datetime {{ $errors->has('schedule_time') ? 'is-invalid' : '' }}" type="text" name="schedule_time" id="schedule_time" value="{{ old('schedule_time', $notification->schedule_time) }}">
                @if($errors->has('schedule_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('schedule_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.schedule_time_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="icon">{{ trans('cruds.notification.fields.icon') }}</label>--}}
{{--                <div class="needsclick dropzone {{ $errors->has('icon') ? 'is-invalid' : '' }}" id="icon-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('icon'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('icon') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.notification.fields.icon_helper') }}</span>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label>{{ trans('cruds.notification.fields.status') }}</label>--}}
{{--                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">--}}
{{--                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>--}}
{{--                    @foreach(App\Models\Notification::STATUS_SELECT as $key => $label)--}}
{{--                        <option value="{{ $key }}" {{ old('status', $notification->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @if($errors->has('status'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('status') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.notification.fields.status_helper') }}</span>--}}
{{--            </div>--}}
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
                xhr.open('POST', '{{ route('admin.notifications.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $notification->id ?? 0 }}');
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
    Dropzone.options.iconDropzone = {
    url: '{{ route('admin.notifications.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="icon"]').remove()
      $('form').append('<input type="hidden" name="icon" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="icon"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($notification) && $notification->icon)
      var file = {!! json_encode($notification->icon) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="icon" value="' + file.file_name + '">')
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
@endsection