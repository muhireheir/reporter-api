@extends('layouts.app')


@section('content')
<div class="container">

<form method="POST" action="{{ route('shops.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Shop name</label>
        <input required type="text" class="form-control"  name="name" placeholder="Shop name">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Shop email</label>
        <input required type="email" name="email" class="form-control"  placeholder="shop email">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

@endsection
