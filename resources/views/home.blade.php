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
                @if (!empty(Session::get('user')->facebook['accounts']))
                    <div class="graph-container">

                        {{-- @section('tab1') --}}
                        <div class="tabs">
                            <span class="graph-type" id="activeGraphFb" type='hour' social='fb'>Hour</span>
                            <span class="graph-type" type='week' social='fb'>Week</span>
                            <span class="graph-type" type='month' social='fb'>Month</span>
                        </div>

                        {{-- @endsection --}}
                        <div id="fbContainer"></div>
                        {{-- <div class="tabs">
                            <span class="graph-post-type" id="activeGraphFbPost" type='hour' social='fb'>Hour</span>
                            <span class="graph-post-type" type='week' social='fb'>Week</span>
                            <span class="graph-post-type" type='month' social='fb'>Month</span>
                        </div> --}}
                        {{-- <div id="fbPostContainer"></div> --}}
                    </div>
                @endif
                <div style="margin-top:60px;" class="graph-container">
                    <div class="tabs">
                        <span class="graph-type" id="activeGraphTw" type='hour' social='tw'>Hour</span>
                        <span class="graph-type" type='week' social='tw'>Week</span>
                        <span class="graph-type" type='month' social='tw'>Month</span>
                    </div>
                    <div class="statistic" data-type = "graph-type" style="display: none; justify-content: space-around; margin-top: 15px;">
                          <div class="tops" style="background: #1e9ef2;flex-direction: column;">Max post of an hour<p class="message-type-hour"></p></div>
                          <div class="tops" style="background: #1e9ef2;flex-direction: column;">Max post of the week day<p class="message-type-day"></div>
                          <div class="tops" style="background: #1e9ef2;flex-direction: column;">Max post of the month<p class="message-type-month"></div>
                    </div>
                    <canvas id="twContainer" width="100%" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; width: auto; max-height: 400px;"></canvas>
                    {{-- <div ></div> --}}
                    <div class="tabs">
                        <span class="graph-post-type" id="activeGraphTwPost" type='hour' social='tw'>Hour</span>
                        <span class="graph-post-type" type='week' social='tw'>Week</span>
                        <span class="graph-post-type" type='month' social='tw'>Month</span>
                    </div>
                    <div class="statistic" data-type="graph-post-type" style="display: none; justify-content: space-around; margin-top: 15px;">
                          <div class="tops" style="background: #1e9ef2;flex-direction: column;">Max post of an hour <p class="post-type-hour"></p> </div>
                          <div class="tops" style="background: #1e9ef2;flex-direction: column;">Max post of the week day <p class="post-type-day"></p></div>
                          <div class="tops" style="background: #1e9ef2;flex-direction: column;">Max post of the month <p class="post-type-month"></p></div>
                    </div>
                    <canvas id="twPostContainer" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; max-height: 400px; width: 1314px;" width="1642"></canvas>
                </div>
            </div>
            <div class="form" style="display: none;flex-direction: column;justify-content: center;">
                    <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;height: 250px;" >
                        <h1 style="text-align: center;color: #1e9ff2">Upload File</h1>
                    <!--                    @php print_r (session()->all()); 
                                        @endphp -->
<!--                                         {{ \App\Http\Controllers\HistoricalController::getHistoricalData() }}
 -->                        <form class="form-group" action="parser/parser_php/upload-manager.php?id={{ Session::get('user')->userId }}" method="post" enctype="multipart/form-data">
                            <div style="display: flex;justify-content: space-around;margin-top: 20px;">
                               {{-- <label for="fileSelect">Filename:</label> --}}
                                {{-- Archive type: --}}
                                <select style="width: 30%" class="form-control" name='type'>
                                    <option value='facebook'>Facebook</option>
                                    <option value='twitter'>Twitter</option>
                                </select>
                                <p style="width: 30%">
                                    <input style="display: none;" type="file" name="zip_file" id="zip-file">
                                    <button type="button" style="width: 100%" class="btn btn-warning open-file">Select Zip File</button>
                                </p>
                                <div style="width: 30%">
                                    <input style="width: 100%" class="btn btn-success" type="submit" name="submit" value="Upload">
                                    <p><strong>Note:</strong> Only .zip allowed.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                <div>
                    <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;flex-direction: column;justify-content: center;height: auto;" class="uploaded-history" >
                        <h1>Uploaded Data History</h1>
<!--                     <h1>{{ \App\Http\Controllers\HistoricalController::uploaded_history() }}</h1>
 -->
                     <div id="table" class="table">
                         
                     </div>

                    </div>
                    <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;flex-direction: column;justify-content: center;height: auto;" class="graph" >
                        <h1>Twitter Data Per Hour</h1>
                        <canvas id="bar-stacked" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; height: 400px; width: 1314px;" width="1642"></canvas>
                    </div>
                    <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;flex-direction: column;justify-content: center;height: auto;" class="graph" >
                        <h1>Facebook Data Per Hour</h1>
                        <canvas id="bar-stacked-FB" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; height: 400px; width: 1314px;" width="1642"></canvas>
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

