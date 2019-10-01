@extends('layouts.app')

@section('content')
<div class="container">
    <todo-list token="{{ Auth::user()->api_token }}"></todo-list>
</div>
@endsection
