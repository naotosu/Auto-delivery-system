@extends('common')

@section('content')
@include('header')  
    <div class="main">
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
                        </div>
                        管理者画面（予定）
                    </div>
                </div>
            </div>
        </div>
        @include('footer')
    </div>
@endsection
