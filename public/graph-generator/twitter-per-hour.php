<?php

$pdo = new PDO('mysql:host=plutoaurorareader.ce8nny2n0zc2.us-east-2.rds.amazonaws.com;port=3306;dbname=parser_db', 'plutousername', 'kidesign');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("select * from parser_db.twitter_messages" );
  $stmt->execute();
  
  $hour_t=[];
  $count_messages=[];
  $time=[];
  for($i=0;$i<=24;$i++){$count_messages[$i]=0;}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 

  {

    $time = explode(" ",$row['createdat']); 
    if (!isset($time[1])){$time[1]=NULL;}   
    $hour = substr($time[1], 0,2);
 
    switch ($hour) {
    case "00":
        $count_messages['0']=$count_messages['0']+1;
        break;
    case "01":
        $count_messages['1']=$count_messages['1']+1;
        break;
    case "02":
        $count_messages['2']=$count_messages['2']+1;
        break;
    case "03":
        $count_messages['3']=$count_messages['3']+1;
        break;
    case "04":
        $count_messages['4']=$count_messages['4']+1;
        break;
    case "05":
        $count_messages['5']=$count_messages['5']+1;
        break;
    case "06":
        $count_messages['6']=$count_messages['6']+1;
        break;
    case "07":
        $count_messages['7']=$count_messages['7']+1;
        break;
    case "08":
        $count_messages['8']=$count_messages['8']+1;
        break;
    case "09":
        $count_messages['9']=$count_messages['9']+1;
        break;
    case "10":
        $count_messages['10']=$count_messages['10']+1;
        break;
    case "11":
        $count_messages['11']=$count_messages['11']+1;
        break;
    case "12":
        $count_messages['12']=$count_messages['12']+1;
        break;
    case "13":
        $count_messages['13']=$count_messages['13']+1;
        break;
    case "14":
        $count_messages['14']=$count_messages['14']+1;
        break;
    case "15":
        $count_messages['15']=$count_messages['15']+1;
        break;
    case "16":
        $count_messages['16']=$count_messages['16']+1;
        break;
    case "17":
        $count_messages['17']=$count_messages['17']+1;
        break;
    case "18":
        $count_messages['18']=$count_messages['18']+1;
        break;
    case "19":
        $count_messages['19']=$count_messages['19']+1;
        break;
    case "20":
        $count_messages['20']=$count_messages['20']+1;
        break;
    case "21":
        $count_messages['21']=$count_messages['21']+1;
        break;
    case "22":
        $count_messages['22']=$count_messages['22']+1;
        break;
    case "23":
        $count_messages['23']=$count_messages['23']+1;
        break;




  }
}

$stmt = $pdo->prepare("select * from parser_db.twitter_tweets" );
  $stmt->execute();
  $hours=[];
  $count_tweets=[];
  for($i=0;$i<=24;$i++){$count_tweets[$i]=0;}

  while (  $row = $stmt->fetch(PDO::FETCH_ASSOC))
  {
    $time=explode(" ", $row['created_at']);
    $hour = substr($time[3], 0,2);

    switch ($hour) {
    case "00":
        $count_tweets['0']=$count_tweets['0']+1;
        break;
    case "01":
        $count_tweets['1']=$count_tweets['1']+1;
        break;
    case "02":
        $count_tweets['2']=$count_tweets['2']+1;
        break;
    case "03":
        $count_tweets['3']=$count_tweets['3']+1;
        break;
    case "04":
        $count_tweets['4']=$count_tweets['4']+1;
        break;
    case "05":
        $count_tweets['5']=$count_tweets['5']+1;
        break;
    case "06":
        $count_tweets['6']=$count_tweets['6']+1;
        break;
    case "07":
        $count_tweets['7']=$count_tweets['7']+1;
        break;
    case "08":
        $count_tweets['8']=$count_tweets['8']+1;
        break;
    case "09":
        $count_tweets['9']=$count_tweets['9']+1;
        break;
    case "10":
        $count_tweets['10']=$count_tweets['10']+1;
        break;
    case "11":
        $count_tweets['11']=$count_tweets['11']+1;
        break;
    case "12":
        $count_tweets['12']=$count_tweets['12']+1;
        break;
    case "13":
        $count_tweets['13']=$count_tweets['13']+1;
        break;
    case "14":
        $count_tweets['14']=$count_tweets['14']+1;
        break;
    case "15":
        $count_tweets['15']=$count_tweets['15']+1;
        break;
    case "16":
        $count_tweets['16']=$count_tweets['16']+1;
        break;
    case "17":
        $count_tweets['17']=$count_tweets['17']+1;
        break;
    case "18":
        $count_tweets['18']=$count_tweets['18']+1;
        break;
    case "19":
        $count_tweets['19']=$count_tweets['19']+1;
        break;
    case "20":
        $count_tweets['20']=$count_tweets['20']+1;
        break;
    case "21":
        $count_tweets['21']=$count_tweets['21']+1;
        break;
    case "22":
        $count_tweets['22']=$count_tweets['22']+1;
        break;
    case "23":
        $count_tweets['23']=$count_tweets['23']+1;
        break;




  }
}
?>

<!DOCTYPE html>
<html class="loaded" data-textdirection="ltr" style="height: 100%;" lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Twitter per hour</title>
    <link rel="apple-touch-icon" href="https://pluto.kisocial.io/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://pluto.kisocial.io/favicon.png">
    <!--<link href="KiDesign_files/css.css" rel="stylesheet">-->
    <script src="js/vendors.js"></script></head>
  <body class="fixed-navbar vertical-layout vertical-compact-menu 2-columns  menu-open pace-done" data-open="click" data-menu="vertical-compact-menu" data-col="2-columns" style="position: relative; min-height: 100%; top: 40px;">


    <div class="app-content content basic-info">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <script src="js/jquery-ui.js"></script>
            <!-- Bar Stacked Chart -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="bar-stacked" class="exported-canvas chartjs-render-monitor" height="500" style="display: block; height: 400px; width: 1314px;" width="1642"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



<script>
    $(window).on("load",function(){
        var ctx=$("#bar-stacked");
        var chartOptions={responsive:true,maintainAspectRatio:false,legend:{position:'bottom',},hover:{mode:'label'},scales:{xAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Time during the day'},ticks:{padding:15}}],yAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Number'},ticks:{padding:15}}]},title:{display:true,text:'Twitter messages and tweets during the day'}};
        var colors_array=['#00A5A8','#FF7D4D','#0ea09b','#058241','#99ffb7','#edc4a3','#ed5562'];
        var chartData={
            labels:["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"],
            datasets:[{label:"Messages",
            data:<?php echo json_encode($count_messages); ?>,fill:false,borderColor:"#9C27B0",pointBorderColor:"#9C27B0",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,},{label:"Tweets",
            data:<?php echo json_encode($count_tweets); ?>,fill:false,borderColor:"#00A5A8",pointBorderColor:"#00A5A8",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,}]};
        var config={type:'line',options:chartOptions,data:chartData};
        var lineChart=new Chart(ctx,config);


    });
    </script>   


        </div>
      </div>
    </div> 
    

    <!-- BEGIN PAGE VENDOR JS-->
    <script src="js/chart.js"></script>
    <script src="js/jquery.js"></script>
    
    

<div class="goog-te-spinner-pos"><div class="goog-te-spinner-animation"><svg xmlns="http://www.w3.org/2000/svg" class="goog-te-spinner" width="96px" height="96px" viewBox="0 0 66 66"><circle class="goog-te-spinner-path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div></div><iframe class="goog-te-menu-frame skiptranslate" title="Меню мов віджета &quot;Перекладач&quot;" style="visibility: visible; box-sizing: content-box; width: 1164px; height: 274px; display: none;" frameborder="0"></iframe><iframe class="goog-te-menu-frame skiptranslate" title="Меню мов віджета &quot;Перекладач&quot;" style="visibility: visible; box-sizing: content-box; width: 1164px; height: 274px; display: none;" frameborder="0"></iframe><iframe class="goog-te-menu-frame skiptranslate" title="Меню мов віджета &quot;Перекладач&quot;" style="visibility: visible; box-sizing: content-box; width: 241px; height: 71px; display: none;" frameborder="0"></iframe></body></html>