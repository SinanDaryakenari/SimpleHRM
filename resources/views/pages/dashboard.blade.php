@extends('layouts.master')

@section('additional-css')
@endsection

@section('additional-js')
@endsection

@section('page-content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        You are logged in!
    </div>
@endsection



