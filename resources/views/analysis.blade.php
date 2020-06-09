@extends('layouts.admin')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('/css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('/css/highcharts.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- chart --}}
    <script src="{{asset('/js/vendors.js')}}"></script>
    <script src="{{asset('/js/jquery-ui.js')}}"></script>
    <script src="{{asset('/js/chart.js')}}"></script>
    <script src="{{asset('/js/jquery.js')}}"></script>
    <style>
        .tops {
            /*background: red;*/
            border-radius: 2.5px;
            display: flex;
            align-items: center;
            padding: 0px 30px;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }
        footer{
            margin-top: 200px;
        }
		ul{list-style-type:none;}
    </style>
</head>
<body>
   <div class="">
        <div class="left">
        @section('items')
  
            <ul class="show-items">

                    <li class="base-item" data-type="toggle">
                        <span><i class="fa fa-twitter"></i>&nbsp;&nbsp;Twitter</span>
                        <ul class="secondary-items" data-toggle>
                            <li class="secondary-item" data-type="tw-secondary" name="messages">
                                <span>Messages</span>
                            </li>
                            <li class="secondary-item" data-type="tw-secondary" name="posts">
                                <span>Posts</span>
                            </li>
                        </ul>
                    </li>

                    </li>
                    <li class="base-item" data-type="toggle">
                        <span><i class="fa fa-facebook-official"></i>&nbsp;&nbsp;Facebook</span> 
                    </li>
                    <li class="base-item upload-form" data-type="toggle">
                        <span><i class="fa fa-archive"></i>&nbsp;&nbsp;Archive</span>
                    </li>

             <a style="text-decoration: none;color: #5f5f5f" href="{{ asset('https://publisher.ki.social/?view=tw_upload') }}">
                                        <li class="base-item" data-type="toggle">
    <i class="fa fa-twitter"></i><span class="menu-title" data-i18n="">&nbsp;&nbsp;Twitter Upload</span></a> </li>
                        @if(isset(Session::get('user')->facebook))
                            <ul class="secondary-items" data-toggle>
                                @if (!empty(Session::get('user')->facebook['accounts']))
                                    @foreach (Session::get('user')->facebook['accounts'] as $account)
                                        <li class="secondary-item page-analytics fb-page-name" data-type="fb-secondary" data-id = "{{ $account['id'] }}">
                                            <span >{{ $account['pageName'] }}</span>
                                        </li>
                                        <li>
                                            <ul style="display: none;" style="" class="secondary-items third-items" data-toggle>
                                                <li class="secondary-item facebook-data" data-type="fb-secondary" name="messages"  data-id = "{{ $account['id'] }}">
                                                    <span data-id = "{{ $account['id'] }}">Messages</span>
                                                </li>
                                                <li class="secondary-item facebook-data" data-type="fb-secondary" name="posts" data-id = "{{ $account['id'] }}">
                                                    <span>Posts</span>
                                                </li>
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @else
                            <div data-toggle class="secondary-items">
                                <button class="login-facebook" onclick="window.location.assign({{ '"'.$fbLoginUrl.'"' }})"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Login</button>
                                {{-- <button class="login-facebook" onclick="window.location.assign('{{ route('fbRedirect') }}')"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Login</button> --}}
                                {{-- <button class="login-facebook" onclick="window.location.assign({{ $fbLoginUrl }})"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Login</button> --}}
                                {{-- <button class="login-facebook" onclick="window.location.assign( {{ route('fbRedirect') }} )"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Login</button> --}}
                            </div>
                        @endif
                    </li>
                    <li class="base-item" onclick="window.location.assign('{{ route('logout') }}')">
                        <span><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</span>
                    </li>
                </ul>
                <ul class="base-item" style="font-size: 16px; padding: 5px 15px;">
       
                </ul>
            </div>
                {{-- </div> --}}
                @endsection


	</div>
        <div class="body">
            <div class="graphics">
                    <div class="graph-container" style="padding:20px 20px 20px 20px;">
						<div class="row">
						  <div class="col-md-4">
						    <ul class="diseases">
							  <li> <a href="">diseases</a></li>
							</ul>
						  </div>
						  <div class="col-md-4">
						  <ul class="sub_diseases">
							  <li><input type="checkbox"> 2019-nCoV  2019 Novel Coronavirus  OR </li>
							  <li><input type="checkbox"> Acinetobacter baumannii	Acinetobacter infections </li>
							  <li><input type="checkbox"> Actinomyces israelii, Actinomyces gerencseriae and Propionibacterium propionicus	Actinomycosis</li>
							  <li><input type="checkbox"> Acute Flaccid Myelitis  AFM  OR </li>
							  <li><input type="checkbox"> Alphavirus	Chikungunya</li>
							</ul>
						  </div>
						  <div class="col-md-4">Graph</div>
						</div>

                    </div>
            </div>
        </div>
    </div>
</body>
{{-- <script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="{{asset('js/chart.js')}}"></script>
<script src="{{asset('js/vendor.js')}}"></script>
 --}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
<script src="{{asset('/js/home.js')}}"></script>
<script src="{{asset('/js/historical.js')}}"></script>
<script defer src="{{asset('/js/menu.js')}}"></script>
</html>

