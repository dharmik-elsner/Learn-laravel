@extends('layouts.myapp')

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
                    {{ __('Seller logged in!') }}
                    <p>Welcome to your dashboard, {{ Auth::user()->name }}!</p>
                </div>
                <div class="card-body" style="border-top: 2px solid #eee;">
                    <a class="btn btn-primary" href="{{ route('form.add.website') }}">Add Website</a>
                    <br>
                    <p>click the button to add website!!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
