@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}


                    <form enctype="multipart/form-data" method="POST" action="{{ Route('import') }}">
                        @csrf
                        <input type="file" name="file">

                        <button>Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
