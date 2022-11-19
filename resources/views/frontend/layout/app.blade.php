<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <link rel="icon" href="{{$settings->favicon}}">

    <title>{{($settings->app_name)? $settings->app_name : config('app.name')}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/frontend/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- player -->
    {{-- <link rel="stylesheet" href="{{asset('assets/frontend/js/vendor/player/johndyer-mediaelement-89793bc/build/mediaelementplayer.min.css')}}" /> --}}

    <!-- Theme CSS -->
    <link href="{{asset('assets/frontend/css/custom-style.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/frontend/css/font-awesome.min.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('assets/frontend/css/font-circle-video.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/font-circle-video.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/font-circle-video.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/slick.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/ls-custom-style.css')}}" rel="stylesheet">
    @stack('custom_css')

    <!-- font-family: 'Hind', sans-serif; -->
    <link href='https://fonts.googleapis.com/css?family=Hind:400,300,500,600,700|Hind+Guntur:300,400,500,700' rel='stylesheet' type='text/css'>
</head>

<body class="@yield('class') light">
    <!-- logo, menu, search, avatar -->
    @include('frontend.partials.navbar')

    @include('frontend.partials.mobile_menu')
    <!-- /logo -->

    <!-- goto -->
    {{-- @yield('second_navbar') --}}
    <!-- /goto -->

    @yield('main_section')

    <!-- footer -->
    @include('frontend.partials.footer')
    <!-- /footer -->



    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{asset('assets/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/frontend/bootstrap/js/bootstrap.min.js')}}"></script>
    {{-- <script src="{{asset('assets/frontend/js/vendor/player/johndyer-mediaelement-89793bc/build/mediaelement-and-player.min.js')}}"></script> --}}
    <script src="{{asset('assets/frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/custom.js')}}"></script>
    @stack('custom_script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('keyup', 'input[name="keyword"]', function() {
                    let keyword = $(this).val();
                    search(keyword);
            });

            function search(keyword) {
                // let keyword = $('input[name="keyword"]').val();
                console.log(keyword)
                if (keyword.length > 0) {
                    $('#searchResultDiv').css({'display':'block'})
                    $.ajax({
                        url: `/ajax/search/${keyword}`
                        , type: 'GET'
                        // , beforeSend: function() {
                        //     console.log('beforesend')
                        //     )
                        // }
                        , success: function(data) {
                            console.log(data)
                            $('#searchResultDiv').empty()
                            $('#searchResultDiv').append(data)
                        }
                        , error: function(error) {
                            console.log(error)
                        }
                    })
                } else {
                    $('#searchResultDiv').css({'display':'none'})
                }
            };

        });

    </script>

<script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('keyup', 'input[name="keyword"]', function() {
                    let keyword = $(this).val();
                    search(keyword);
            });

            function search(keyword) {
                // let keyword = $('input[name="keyword"]').val();
                console.log(keyword)
                if (keyword.length > 0) {
                    $('#searchResultDiv2').css({'display':'block'})
                    $.ajax({
                        url: `/ajax/search/${keyword}`
                        , type: 'GET'
                        // , beforeSend: function() {
                        //     console.log('beforesend')
                        //     )
                        // }
                        , success: function(data) {
                            console.log(data)
                            $('#searchResultDiv2').empty()
                            $('#searchResultDiv2').append(data)
                        }
                        , error: function(error) {
                            console.log(error)
                        }
                    })
                } else {
                    $('#searchResultDiv2').css({'display':'none'})
                }
            };

        });

    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6345a8f554f06e12d8999f98/1gf41o000';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
