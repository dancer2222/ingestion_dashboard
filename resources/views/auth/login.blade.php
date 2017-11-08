@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-12 text-center mt-5">

            <h4 class="text-muted mt-5">Login with Google</h4>

            <div>
                <a class="btn btn-info" href="{{ action('Auth\\LoginGoogleController@login', ['google']) }}" role="button">
                    Google
                </a>
            </div>

        </div>

        <div class="col-xs-10 offset-xs-1 col-md-4 offset-md-4 mt-5">

            {{-- Block has been temporarily commented --}}

            {{--<form method="POST" action="{{ route('login') }}">--}}
                {{--{{ csrf_field() }}--}}

                {{--<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">--}}
                    {{--<label for="formGroupExampleInput">Email</label>--}}
                    {{--<input type="email" class="form-control" id="input-email" name="email" value="{{ old('email') }}" required autofocus>--}}
                    {{--@if ($errors->has('email'))--}}
                        {{--<div class="form-control-feedback">{{ $errors->first('email') }}</div>--}}
                    {{--@endif--}}
                {{--</div>--}}

                {{--<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">--}}
                    {{--<label for="input-password">Password</label>--}}
                    {{--<input type="password" class="form-control" id="input-password" name="password" required>--}}
                    {{--@if ($errors->has('email'))--}}
                        {{--<div class="form-control-feedback">{{ $errors->first('password') }}</div>--}}
                    {{--@endif--}}
                {{--</div>--}}

                {{--<div class="form-check">--}}
                    {{--<label class="form-check-label">--}}
                        {{--<input type="checkbox" class="form-check-input" id=""--}}
                               {{--name="remember" {{ old('remember') ? 'checked' : '' }}>--}}
                        {{--Remember me--}}
                    {{--</label>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<button type="submit" class="btn btn-primary">Sign in</button>--}}
                {{--</div>--}}
            {{--</form>--}}

            {{--<hr class="mt-5">--}}

            {{--<h4 class="text-muted mt-5">Login with Google</h4>--}}

            {{--<a class="btn btn-info" href="{{ action('Auth\\LoginSocialController@login', ['google']) }}" role="button">--}}
                {{--Google--}}
            {{--</a>--}}

        </div>
    </div>
</div>
@endsection
