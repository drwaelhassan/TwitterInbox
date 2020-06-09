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
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- chart --}}
    <script src="{{asset('/js/vendors.js')}}"></script>
    <script src="{{asset('/js/jquery-ui.js')}}"></script>
    <script src="{{asset('/js/chart.js')}}"></script>
    <script src="{{asset('/js/jquery.js')}}"></script>
    <style>
        .main-menu.menu-shadow{
            width: 0% !important
        }
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
        
        footer {
            margin-top: 200px;
        }
    </style>
</head>

<body>
    @section('historical')
        <div>
            <div class="show-items" style="cursor: pointer;padding:10px">
                <a style="font-size: 16px; padding-left: 15px;color:#6a6e80!important" class="dashboard-item" href="/home"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">&nbsp;&nbsp;Home</span></a>
            </div>
            <div class="show-items" style="cursor: pointer;padding:10px">
                <a style="font-size: 16px; padding-left: 15px;color:#6a6e80!important" class="dashboard-item" href="/historical"><span class="menu-title" data-i18n="nav.dash.main">&nbsp;&nbsp;Historical</span></a>
            </div>
            <div class="show-items" style="cursor: pointer;padding:10px;" onclick="window.location.assign('https://inbox.ki.social/logout')">
                <a style="font-size: 16px; padding-left: 15px;color:#6a6e80!important" class="dashboard-item" href="/logout" ><i class="fa fa-sign-out menu-title"></i></i><span class="menu-title" data-i18n="nav.dash.main">&nbsp;&nbsp;Logout</span></a>
            </div>
        </div> 
    @endsection
    <div class="body">
            <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;flex-direction: column;justify-content: center;height: 250px;" class="form" >
 

                <h1 style="text-align: center;color: #1e9ff2">Upload File</h1>
                <form class="form-group" action="parser/parser_php/upload-manager.php" method="post" enctype="multipart/form-data">
                    <div style="display: flex;justify-content: space-around;margin-top: 20px;">

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
            <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;flex-direction: column;justify-content: center;height: auto;" class="graph" >
                <h1>Test Data Per Hour</h1>
                <canvas id="bar-stacked" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; height: 400px; width: 1314px;" width="1642"></canvas>
            </div>
            <div style="box-shadow: 0px 0px 20px #a09797;background: #fff;margin-top: 77px; padding: 25px;flex-direction: column;justify-content: center;height: auto;" class="graph" >
                <h1>Facebook Data Per Hour</h1>
                <canvas id="bar-stacked-FB" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; height: 400px; width: 1314px;" width="1642"></canvas>
            </div>
        </div>
<script src="{{asset('/js/home.js')}}"></script>
<script src="{{asset('/js/historical.js')}}"></script>

<script defer src="{{asset('/js/menu.js')}}"></script>

</html>