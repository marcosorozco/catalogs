@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $catalog->title }}</div>

                    <div class="card-body">
                        <form action="{{route('catalogs.store', ['catalog_code' => $catalog->code])}}"
                              method="POST"
                              class="form-">
                            @include('catalogs.partial.form_create_update')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
