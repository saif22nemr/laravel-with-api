@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! {{$user->name}}
                    <ul>
                        <li>User:</li>
                        <ul>
                    @foreach($user as $column => $value)
                            <li>{{$column}} : {{$value}}</li>
                    @endforeach
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
