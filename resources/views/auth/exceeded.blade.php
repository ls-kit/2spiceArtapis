@extends('frontend.layout.app')
@push('custom_css')
    <style>
        .login-wraper .login-window {
            top: 25%;
            left: 30%;
            margin-top: 0px;
        }

        @media screen and (max-width:767px) {
            .login-wraper .login-window {
                left: 0%;
            }
        }
    </style>
@endpush
@section('main_section')
    <div class="row">
        <div class="login-wraper text-center">
            <div class="hidden-xs">
                <img src="{{ asset('assets/frontend/images/login.jpg') }}" alt="">
            </div>
            <div class="login-window">
                <div class="l-head">
                    {!! trans('titles.exceeded') !!}
                </div>
                <div class="l-form">
                    <form>
                        <div class="form-group">
                            {!! trans('auth.tooManyEmails', ['email' => $email, 'hours' => $hours]) !!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
