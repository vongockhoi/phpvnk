@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.address.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.addresses.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="customer_id">{{ trans('cruds.address.fields.customer') }}</label>
                    <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}"
                            name="customer_id" id="customer_id" required>
                        @foreach($customers as $id => $entry)
                            <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('customer'))
                        <div class="invalid-feedback">
                            {{ $errors->first('customer') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.customer_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">{{ trans('cruds.address.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', '') }}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="province_id">{{ trans('cruds.address.fields.province') }}</label>
                    <select class="form-control select2 {{ $errors->has('province') ? 'is-invalid' : '' }}"
                            name="province_id" id="province_id" required>
                        @foreach($provinces as $id => $entry)
                            <option value="{{ $id }}" {{ old('province_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('province'))
                        <div class="invalid-feedback">
                            {{ $errors->first('province') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.province_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="district_id">{{ trans('cruds.address.fields.district') }}</label>
                    <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}"
                            name="district_id" id="district_id">
                        @foreach($districts as $id => $entry)
                            <option value="{{ $id }}" {{ old('district_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('district'))
                        <div class="invalid-feedback">
                            {{ $errors->first('district') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.district_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="address">{{ trans('cruds.address.fields.address') }}</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                           name="address" id="address" value="{{ old('address', '') }}" required>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="note">{{ trans('cruds.address.fields.note') }}</label>
                    <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note"
                              id="note">{{ old('note') }}</textarea>
                    @if($errors->has('note'))
                        <div class="invalid-feedback">
                            {{ $errors->first('note') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.note_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('is_default') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="is_default" value="0">
                        <input class="form-check-input" type="checkbox" name="is_default" id="is_default"
                               value="1" {{ old('is_default', 0) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                               for="is_default">{{ trans('cruds.address.fields.is_default') }}</label>
                    </div>
                    @if($errors->has('is_default'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_default') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.address.fields.is_default_helper') }}</span>
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
                        $('#district_id').append($('<option>', {value: v, text: t}));
                    });
                },
                error: function () {
                }
            });
        }

    </script>
@endsection
