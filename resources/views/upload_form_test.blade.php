<!DOCTYPE html>
@extends('layouts.admin')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Form</title>
    <link rel="stylesheet" href="{{asset('/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('/css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('/css/highcharts.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>
   <div class="container">
        <div class="left">
        @section('items')
                <ul style="display: block;" class="base-items">

                    <li class="base-item" onclick="window.location.assign('{{ route('home') }}')">
                        <span>
                            <i class="la la-home"></i>
                            Dashborad
                        </span>
                        {{-- <span><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</span> --}}
                    </li>
                    <li class="base-item" onclick="window.location.assign('{{ route('logout') }}')">
                        <span><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</span>
                    </li>
                </ul>
                @endsection  
  </div>
        <div class="body">
        @if (!empty(Session::get('user')->facebook['accounts']))
            <div class="graph-container">
        @endif
        <div class="graph-container" style="padding:25px;>
        <form action="upload-manager.php" method="post" enctype="multipart/form-data">
            <h2>Upload File</h2>
        <label for="fileSelect">Filename:</label>
        Archive type: <select name='type'>
        <option value='facebook'>Facebook</option>
        <option value='twitter'>Twitter</option>
        </select>
        <p><input type="file" name="zip_file" id="zip-file"></p>
        <input type="submit" name="submit" value="Upload">
        <p><strong>Note:</strong> Only .zip allowed.</p>
        </form>
        <div id="twContainer"></div>
        <div id="twPostContainer"></div>
        </div>
        </div>
        </div>
</body>

<script src="{{asset('/js/home.js')}}"></script>
<script src="{{asset('/js/menu.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</html>

