<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\lib\twitteroauth\TwitterOAuth;
use Session;
use DB;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphNodeFactory;
use PDO;
class HistoricalController extends Controller
{

    public function historical(){
    		$index = new HomeController;
    		$fbLoginUrl=$index->index();
          //  $row = DB::table('parser_db.twitter_messages')->select('*')->get();
                    return view('historical',['fbLoginUrl'=>$fbLoginUrl ]);
    }


    static function getHistoricalData()
    {
    	$pdo = new PDO('mysql:host=plutoaurorareader.ce8nny2n0zc2.us-east-2.rds.amazonaws.com;port=3306;dbname=parser_db', 'plutousername', 'kidesign');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare("select * from twitter_messages where id_owner= :owner_id" );
		$id= Session::get('user')->userId;
		$owner = DB::table('parser_db.upload_index')->select('data_owner_id')->where('logged_user', '=' ,$id)->where('t_or_f','=','Twitter')->max('data_owner_id');

		$stmt->execute([':owner_id' => $owner ]);  
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
		$stmt = $pdo->prepare("select * from twitter_tweets where id_owner= :owner_id" );
		$stmt->execute([':owner_id' => $owner ]);  
		$hours=[];
		$count_tweets=[];
		for($i=0;$i<=24;$i++){$count_tweets[$i]=0;}
		while (  $row = $stmt->fetch(PDO::FETCH_ASSOC))
		  {
		    $time=explode(" ", $row['created_at']);

		    if($row['created_at'] != NULL)
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
		echo  json_encode(['count_messages'=>$count_messages,'count_tweets'=>$count_tweets]);
    }//func

public function getHistoricalData_FB()
{
	$pdo = new PDO('mysql:host=plutoaurorareader.ce8nny2n0zc2.us-east-2.rds.amazonaws.com;port=3306;dbname=parser_db', 'plutousername', 'kidesign');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("select * from parser_db.facebook_comments where id_owner= :owner_id" );
		$id= Session::get('user')->userId;
		$owner = DB::table('parser_db.upload_index')->select('data_owner_id')->where('logged_user', '=' ,$id)->where('t_or_f','=','Facebook')->max('data_owner_id');

$stmt->execute([':owner_id' => $owner ]);  
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
	

  


	$stmt = $pdo->prepare("select * from parser_db.facebook_posts where id_owner= :owner_id" );
	$stmt->execute([':owner_id' => $owner ]);  
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
			echo  json_encode(['count_comments'=>$count,'count_posts'=>$count_posts]);
	    
		}

static function uploaded_history()
		{


	$pdo = new PDO('mysql:host=plutoaurorareader.ce8nny2n0zc2.us-east-2.rds.amazonaws.com;port=3306;dbname=parser_db', 'plutousername', 'kidesign');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->prepare("select * from parser_db.upload_index where logged_user = :id " );
  $id= Session::get('user')->userId;

  $stmt->execute( [':id' => $id ] );
  $logged_user=[];
  $data_owner=[];
  $data_owner_id=[];
  $timestamp=[];
  $t_or_f=[];
  $archive_id=[];
  $for_table=["ID","Data Owner","Facebook/Twitter","Timestamp"," "];
  while (  $rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
  			
			array_push($logged_user,$rows['logged_user']);
			array_push($data_owner,$rows['data_owner']);
			array_push($data_owner_id,$rows['data_owner_id']);
			array_push($timestamp,$rows['timestamp']);
			array_push($t_or_f,$rows['t_or_f']);
			array_push($archive_id,$rows['id']);

		}
			for($i=0;$i<sizeof($data_owner);$i++){
				array_push($for_table,$archive_id[$i]);
				array_push($for_table,$data_owner[$i]);
				array_push($for_table,$t_or_f[$i]);
				array_push($for_table,$timestamp[$i]);
				array_push($for_table,'<button id="button_'.$archive_id[$i]. '" style="width: 100%" class="btn btn-warning" type="button" name="delete" onclick="History.delete_row('.$archive_id[$i].')">Delete</button>');
			}
			echo json_encode($for_table);
    }

static function delete_row() {

	DB::table('parser_db.upload_index')->where('id', '=', $_POST['id'])->delete();
	return "Row ".$_POST['id']." deleted successfully";

}

}


?>
