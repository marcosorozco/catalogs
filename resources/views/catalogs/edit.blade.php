@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $catalog->title }}</div>

                    <div class="card-body">
                        <form action="{{route('catalogs.update', ['catalog_code' => $catalog->code, 'id'=> $data->id])}}"
                            method="POST"
                            class="form-">
                            @method('PUT')
                            @include('catalogs.partial.form_create_update')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
