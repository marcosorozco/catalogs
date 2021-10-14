<a href="{{route('catalogs.index', ['catalog_code'=>$catalog->code])}}">[Regresar]</a>
@csrf
@foreach($catalog->class::getFieldsForm() as $name=>$field)
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ $field['name'] }}</label>

        <div class="col-md-6">
            @if(!is_array($field['type']))
                <input id="{{$name}}"
                       type="{{$field['type']}}"
                       class="form-control @error($name) is-invalid @enderror"
                       name="{{$name}}" value="{{ old($name, (!isset($field['value']) || $field['value'] != false ? ($data->$name ?? null) : null) ) }}"
                       required
                       autocomplete="off"
                       autofocus>
            @else
                @php
                    if (isset($field['type']['collection'])) {
                        $dataRows = $field['type']['collection'];
                    } else {
                        $dataRows = $field['type']['model']::get();
                    }
                @endphp
                <select class="form-control @error($name) is-invalid @enderror" name="{{$name}}" id="{{$name}}" required>
                    <option value="">seleccione</option>
                    @foreach($dataRows as $dataRow)
                        <option value="{{$dataRow->{$field['type']['key']} }}"
                            {{old($name, $data->$name ?? null) == $dataRow->{$field['type']['key']} ? 'selected' : ''}}>{{$dataRow->{$field['type']['value']} }}</option>
                    @endforeach
                </select>
            @endif

            @error($name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
@endforeach
<div class="form-group row">
    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>
