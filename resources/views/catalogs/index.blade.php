@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $catalog->title }}</div>

                    <div class="card-body">
                        <a href="{{route('catalogs.create', ['catalog_code'=>$catalog->code])}}">[Create]</a><br>

                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Search Data
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="{{route('catalogs.index', ['catalog_code'=>$catalog->code])}}">
                                            @foreach($catalog->class::getFieldsForm() as $name=>$field)
                                                @if(!($field['hidden'] ?? false))
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ $field['name'] }}</label>

                                                        <div class="col-md-6">
                                                            @if(!is_array($field['type']))
                                                                <input id="{{$name}}_search"
                                                                       type="{{$field['type']}}"
                                                                       class="form-control @error($name.'_search') is-invalid @enderror"
                                                                       name="{{$name}}_search" value="{{ old($name.'_search', request($name.'_search')) }}"
                                                                       autocomplete="off"
                                                                       autofocus>
                                                            @else
                                                                @php
                                                                    if (isset($field['type']['collection'])) {
                                                                        $dataRowsSelect = $field['type']['collection'];
                                                                    } else {
                                                                        $dataRowsSelect = $field['type']['model']::get();
                                                                    }
                                                                @endphp
                                                                <select class="form-control @error($name.'_search') is-invalid @enderror" name="{{$name}}_search" id="{{$name}}_search">
                                                                    <option value="">seleccione</option>
                                                                    @foreach($dataRowsSelect as $dataRow)
                                                                        <option value="{{$dataRow->{$field['type']['key']} }}"
                                                                            {{old($name, request($name.'_search')) == $dataRow->{$field['type']['key']} ? 'selected' : ''}}>{{$dataRow->{$field['type']['value']} }}</option>
                                                                    @endforeach
                                                                </select>
                                                            @endif

                                                            @error($name.'_search')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="form-group row">
                                                <div class="col text-center">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach($catalog->class::getFields() as $field)
                                        @if(!($field['hidden'] ?? false))
                                            <th>{{$field['name']}}</th>
                                        @endif
                                    @endforeach
                                    @if(count($catalog->class::getActionsLink()))
                                        <th></th>
                                    @endif
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataRows as $data)
                                    <tr>
                                        @foreach($catalog->class::getFields() as $key=>$field)
                                            @if(!($field['hidden'] ?? false))
                                                @if($field['type'] == 'show')
                                                    <td>{{$field['value']($data) }}</td>
                                                @elseif(!($field['relation'] ?? false))
                                                    <td>{{$data->{$key} }}</td>
                                                @else
                                                    <td>{{$data->{$field['relation']}->{$field['relation_field']} ?? '' }}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if(count($catalog->class::getActionsLink()))
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button"
                                                            class="btn btn-outline-dark dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Options
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @foreach($catalog->class::getActionsLink() as $name => $link)
                                                            <a class="dropdown-item" href="{{$link}}">{{$name}}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary" href="{{route('catalogs.edit', ['catalog_code'=>$catalog->code, 'id'=>$data->id])}}">Edit</a>
                                        </td>
                                        <td>
                                            @if(is_null($data->deleted_at))
                                                <form action="{{route('catalogs.destroy',['catalog_code'=>$catalog->code, 'id'=>$data->id])}}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @else
                                                <form action="{!! route('catalogs.destroy',['catalog_code'=>$catalog->code, 'id'=>$data->id]) !!}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="submit" class="btn btn-success" value="Restaurar">
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
