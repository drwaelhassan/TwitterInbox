<?php


$pdo = new PDO('mysql:host=plutoaurorareader.ce8nny2n0zc2.us-east-2.rds.amazonaws.com;port=3306;dbname=parser_db', 'plutousername', 'kidesign');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $stmt = $pdo->prepare("select * from parser_db.facebook_comments" );
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $hours=[];
  $count=[];
  for($i=0;$i<=24;$i++){$count[$i]=0;}

  while (  $row = $stmt->fetch(PDO::FETCH_ASSOC))
  {

  	$timestamp = gmdate("Y-m-d\TH:i:s\Z", $row['timestamp']);  
	$hour = substr($timestamp, strpos($timestamp, "T") + 1,2);    

	switch ($hour) {
    case "00":
		$count['0']=$count['0']+1;
	    break;
    case "01":
		$count['1']=$count['1']+1;
	    break;
    case "02":
		$count['2']=$count['2']+1;
	    break;
    case "03":
		$count['3']=$count['3']+1;
	    break;
    case "04":
		$count['4']=$count['4']+1;
	    break;
    case "05":
		$count['5']=$count['5']+1;
	    break;
    case "06":
		$count['6']=$count['6']+1;
	    break;
    case "07":
		$count['7']=$count['7']+1;
	    break;
    case "08":
		$count['8']=$count['8']+1;
	    break;
    case "09":
		$count['9']=$count['9']+1;
	    break;
    case "10":
		$count['10']=$count['10']+1;
	    break;
    case "11":
		$count['11']=$count['11']+1;
	    break;
    case "12":
		$count['12']=$count['12']+1;
	    break;
    case "13":
		$count['13']=$count['13']+1;
	    break;
    case "14":
		$count['14']=$count['14']+1;
	    break;
    case "15":
		$count['15']=$count['15']+1;
	    break;
    case "16":
		$count['16']=$count['16']+1;
	    break;
    case "17":
		$count['17']=$count['17']+1;
	    break;
    case "18":
		$count['18']=$count['18']+1;
	    break;
    case "19":
		$count['19']=$count['19']+1;
	    break;
    case "20":
		$count['20']=$count['20']+1;
	    break;
    case "21":
		$count['21']=$count['21']+1;
	    break;
    case "22":
		$count['22']=$count['22']+1;
	    break;
    case "23":
		$count['23']=$count['23']+1;
	    break;




  }
}

$stmt = $pdo->prepare("select * from parser_db.facebook_posts" );
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $hours=[];
  $count_posts=[];
  for($i=0;$i<=24;$i++){$count_posts[$i]=0;}

  while (  $row = $stmt->fetch(PDO::FETCH_ASSOC))
  {

  	$timestamp = gmdate("Y-m-d\TH:i:s\Z", $row['timestamp']);  
	$hour = substr($timestamp, strpos($timestamp, "T") + 1,2);    

	switch ($hour) {
    case "00":
		$count_posts['0']=$count_posts['0']+1;
	    break;
    case "01":
		$count_posts['1']=$count_posts['1']+1;
	    break;
    case "02":
		$count_posts['2']=$count_posts['2']+1;
	    break;
    case "03":
		$count_posts['3']=$count_posts['3']+1;
	    break;
    case "04":
		$count_posts['4']=$count_posts['4']+1;
	    break;
    case "05":
		$count_posts['5']=$count_posts['5']+1;
	    break;
    case "06":
		$count_posts['6']=$count_posts['6']+1;
	    break;
    case "07":
		$count_posts['7']=$count_posts['7']+1;
	    break;
    case "08":
		$count_posts['8']=$count_posts['8']+1;
	    break;
    case "09":
		$count_posts['9']=$count_posts['9']+1;
	    break;
    case "10":
		$count_posts['10']=$count_posts['10']+1;
	    break;
    case "11":
		$count_posts['11']=$count_posts['11']+1;
	    break;
    case "12":
		$count_posts['12']=$count_posts['12']+1;
	    break;
    case "13":
		$count_posts['13']=$count_posts['13']+1;
	    break;
    case "14":
		$count_posts['14']=$count_posts['14']+1;
	    break;
    case "15":
		$count_posts['15']=$count_posts['15']+1;
	    break;
    case "16":
		$count_posts['16']=$count_posts['16']+1;
	    break;
    case "17":
		$count_posts['17']=$count_posts['17']+1;
	    break;
    case "18":
		$count_posts['18']=$count_posts['18']+1;
	    break;
    case "19":
		$count_posts['19']=$count_posts['19']+1;
	    break;
    case "20":
		$count_posts['20']=$count_posts['20']+1;
	    break;
    case "21":
		$count_posts['21']=$count_posts['21']+1;
	    break;
    case "22":
		$count_posts['22']=$count_posts['22']+1;
	    break;
    case "23":
		$count_posts['23']=$count_posts['23']+1;
	    break;




  }
}












 
?>
<!DOCTYPE html>
<html class="loaded" data-textdirection="ltr" style="height: 100%;" lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>KiDesign</title>
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
        var chartOptions={responsive:true,maintainAspectRatio:false,legend:{position:'bottom',},hover:{mode:'label'},scales:{xAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Time during the day'},ticks:{padding:15}}],yAxes:[{display:true,gridLines:{color:"#f3f3f3",drawTicks:false,},scaleLabel:{display:true,labelString:'Number'},ticks:{padding:15}}]},title:{display:true,text:'Facebook comments and posts during the day'}};
        var colors_array=['#00A5A8','#FF7D4D','#0ea09b','#058241','#99ffb7','#edc4a3','#ed5562'];
        var chartData={
        	labels:["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"],
        	datasets:[{label:"Comments",
        	data:<?php echo json_encode($count); ?>,fill:false,borderColor:"#9C27B0",pointBorderColor:"#9C27B0",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,},{label:"Posts",
        	data:<?php echo json_encode($count_posts); ?>,fill:false,borderColor:"#00A5A8",pointBorderColor:"#00A5A8",pointBackgroundColor:"#FFF",pointBorderWidth:1,pointHoverBorderWidth:1,pointRadius:3,}]};
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