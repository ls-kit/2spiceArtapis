@extends('frontend.layout.app')
@section('second_navbar')
    @include('frontend.partials.second_navbar')
@endsection
@section('main_section')

<section class="ls_py-40">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form action="{{route('sendmail')}}" method="POST" class="ls_contact-form">
                    @csrf
                    <h1>Get in touch!</h1>
                    @if(Session::has('message_sent'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{Session::get('message_sent')}}</strong>
                    </div>
                    @endif
                    <ul class="ls_p-0">
                    <li>
                        <div class="grid grid-2">
                            <input name="name" type="text" placeholder="Name" required>
                            <input name="email" type="email" placeholder="Email" required>
                        </div>
                    </li>
                    <li>
                        <div class="grid grid-2">
                            <input name="phone" type="tel" placeholder="Phone">
                            <input name="website" type="text" placeholder="Website">
                        </div>
                    </li>
                    <li>
                        <textarea name="message" placeholder="Message"></textarea>
                    </li>
                    <li>
                        <div class="grid grid-3">
                        <div class="required-msg">REQUIRED FIELDS</div>
                        <button class="btn-grid" type="submit">SUBMIT</button>
                        </div>
                    </li>
                    </ul>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>

@endsection
