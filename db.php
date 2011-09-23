<?php
require_once('twitterphp.php');


class Tweet
{
	//attributes of a tweet
	public $key;
	public $created_at;
	public $id;
	public $text;
	public $source;
	public $truncated;
	public $in_reply_to_status_id;
	public $in_reply_to_user_id;
	public $in_reply_to_screen_name;
	public $favorited;
	public $isread;
	public $userid;
	public $username;
	public $userscreen_name;
	public $userprofile_image_url;
	public $accountid;
		
	private function __call($name, $arg){
        return call_user_func_array(array($this, $name), $arg);
    }
	function __construct(){
		$num = func_num_args();
		$args = func_get_args();
		switch($num){
		case 0:
            $this->__call('__construct0', $args);
            break;
        case 1:
            $this->__call('__construct1', $args);
            break;
        case 2:
            $this->__call('__construct2', $args);
            break;
        default:
            throw new Exception();
        }
	}
	//default empty
	function __construct0(){
	}
	//from xml
	function __construct1($statusxml){
		$this->key = $statusxml->key;
		$this->id = $statusxml->id;
		$this->created_at = $statusxml->created_at;
		$this->text = $statusxml->text;
		$this->source = $statusxml->source;
		$this->truncated = $statusxml->truncated;
		$this->in_reply_to_status_id = $statusxml->in_reply_to_status_id;
		$this->in_reply_to_user_id = $statusxml->in_reply_to_user_id;
		$this->in_reply_to_screen_name = $statusxml->in_reply_to_screen_name;
		$this->favorited = $statusxml->favorited;
		$this->isread = 0;
		$this->userid = $statusxml->user->id;
		$this->username = $statusxml->user->name;
		$this->userscreen_name = $statusxml->user->screen_name;
		$this->userprofile_image_url = $statusxml->user->profile_image_url;
		$this->accountid = $_SESSION['userLoggedInID'];
	}
	//from db row 
	function __construct2($row,$dummy){
		$this->key = $ros[0];
		$this->id = $row[1];
		$this->created_at = $row[2];
		$this->text = base64_decode($row[3]);
		$this->source = $row[4];
		$this->truncated = $row[5];
		$this->in_reply_to_status_id = $row[6];
		$this->in_reply_to_user_id = $row[7];
		$this->in_reply_to_screen_name = $row[8];
		$this->favorited = $row[9];
		$this->isread = $row[10];
		$this->userid = $row[11];
		$this->username = $row[12];
		$this->userscreen_name = $row[13];
		$this->userprofile_image_url = $row[14];
		$this->accountid = $_SESSION['userLoggedInID'];
	}
	function isEmpty(){
		if (($this->id == "")||($this->text == ""))
			{
			return true;
			}
			
		return false;
	}
	function display(){
		//$this->text = preg_replace('@(<a href="http://([\w-.]+)+(:\d+)?(/([\w/_.]*(\?\S+)?)?)?)@', 
        //         '$1', $this->text);
		//$this->text ='just saw @johndoe talking at #someforum about his product http://bit.ly/foo';
		//$regex = '/http([s]?):\/\/([^\ \)$]*)/';
		//$link_pattern = '<a href="http$1://$2" rel="nofollow" title="$2">http$1://$2</a>';
		//$this->text = preg_replace($regex,$link_pattern,$this->text);
		//$regex = '/@([a-zA-Z0-9_]*)/';
		//$link_pattern = '<a href="http://twitter.com/$1" title="$1 profile on Twitter" rel="nofollow">@$1</a>';
		//$this->text = preg_replace($regex,$link_pattern,$this->text);
		//$regex = '/\#([a-zA-Z0-9_]*)/';
		//$link_pattern = '<a href="http://search.twitter.com/search?q=%23$1" title="search for $1 on Twitter" rel="nofollow">\#$1</a>';
		//$this->text = preg_replace($regex,$link_pattern,$this->text);
		if ($this->isEmpty()) return false;
		
		$this->text = htmlspecialchars($this->text);
		print '<table><tr>';
		print '<td width="50px"><div class="tweeticon"><img src="'. $this->userprofile_image_url . '" width="48px"></div></td><td>';
		print '<table>';
		print '<tr><td><b>'. $this->userscreen_name .':</b></td></tr>';
		print '<tr><td>'. $this->text .'</td></tr>';
		print '<tr><td><div class="tweetdate">'. date("F j, Y, g:i a",strtotime($this->created_at)) .'</div></td></tr>';
		print '</table>';
		print '<td></tr></table>';

	}		
}

class User
{
	public $userid = 0;
	public $username = '';
	public $userscreen_name = '';
	public $userpassword = '';
	public $userdefaultzoom = '';
	public $userlastlogon = '';
	public $userlocation = '';
	public $userdescription = '';
	public $userprofile_image_url = '';
	public $userurl = '';
	public $userprotected = '';
	public $useroauth_token = '';
	public $useroauth_token_secret = '';
	function display(){
		print '<table><tr><td valign="top"><img src="'. $this->userprofile_image_url .'"></td>';
		print '<td>ID: '. $this->userid;
		print '<br>Name: '. $this->username;
		print '<br>Screen Name: '. $this->userscreen_name;
		print '<br>Password: '. $this->userpassword;
		print '<br>Default Zoom: '. $this->userdefaultzoom;
		print '<br>Last Logon: '. $this->userlastlogon;
		print '<br>Location: '. $this->userlocation;
		print '<br>Description: '. $this->userdescription;
		print '<br><a href="'. $this->userurl .'">'. $this->userurl .'</a>';
		print '<br>Token: '. $this->useroauth_token;
		print '<br>Token Secret: '. $this->useroauth_token_secret;
		print '<br>Protected: '. (bool)$this->userprotected . '</td></tr></table>';
	}
	private function __call($name, $arg){
        return call_user_func_array(array($this, $name), $arg);
    }
	function __construct(){
		$num = func_num_args();
		$args = func_get_args();
		switch($num){
        case 0:
            $this->__call('__construct0', null);
            break;
        case 3:
            $this->__call('__construct3', $args);
            break;
        case 2:
            $this->__call('__construct2', $args);
            break;
        default:
            throw new Exception();
        }
	}
	function __construct0(){
	}
	function __construct3($res,$oauth_token,$oauth_token_secret){
		//print '|' . $res->id . '|<br>';
		$this->userid = $res->id;
		$this->username = $res->name;
		$this->userscreen_name = $res->screen_name;
		$this->userpassword = '';
		$this->userdefaultzoom = 2;
		$this->userlastlogon = date(DATE_RFC822);
		$this->userlocation = $res->location;
		$this->userdescription = $res->description;
		$this->userprofile_image_url = $res->profile_image_url;
		$this->userurl = $res->url;
		$this->userprotected = $res->user_protected;
		$this->useroauth_token = $oauth_token;
		$this->useroauth_token_secret = $oauth_token_secret;
		
	}
	function __construct2($userscreen_name, $userpassword){
		$t = new twitter();
		$t->username='nmeierpolys'; 
		$t->password='nathaniel1'; 
		//$t->verifyCredentials();
		//print_r($t->responseInfo);
		$res = $t->showUser($userscreen_name);
		if($res===false){ 
			echo "ERROR logging in<hr/>"; 
			echo "<pre>"; 
			print_r($t->responseInfo); 
			echo "</pre>"; 
		}else{ 
			$this->userid = $res->id;
			$this->username = $res->name;
			$this->userscreen_name = $userscreen_name;
			$this->userpassword = $userpassword;
			$this->userdefaultzoom = 2;
			$this->userlastlogon = date(DATE_RFC822);
			$this->userlocation = $res->location;
			$this->userdescription = $res->description;
			$this->userprofile_image_url = $res->profile_image_url;
			$this->userurl = $res->url;
			$this->userprotected = $res->user_protected;
		}
	}
}
class DB
{
	public $dbuser = 'twitteradmin2';
	public $dbpass = 'Erroneous9';
	public $dbdatabase = 'twitteradmin2';
	public $usertable = 'userinfo';
	public $tweettable = 'tweets';
	public $dbhost = '72.167.233.88';

	//GENERAL DB OPERATIONS
	function open(){
		//open db connection
		mysql_connect($this->dbhost,$this->dbuser,$this->dbpass);
		
		//select db
		@mysql_select_db($this->dbdatabase) or die( "Unable to select database");
	}
	function close(){
		//close db connection
		mysql_close();
	}
	function query($querystr = ''){
	//user query
	if($querystr != '')
		{
			return mysql_query($querystr);
		}else{
			return "error: no query";
		}
	}
	
	//USER OPERATIONS
	function getAllUsers(){
		$query = "SELECT * FROM ". $this->usertable . " WHERE 1";
		$sqlresult = mysql_query($query);

		//display results
		$resultsize = mysql_num_rows($sqlresult);
		$i=0;

		while($i<$resultsize){
			$userid = mysql_result($sqlresult,$i,"userid");
			$username = mysql_result($sqlresult,$i,"userid");
			$user = $this->getUserByID(intval($userid));
			echo $i . ': <a href="./index.php?act=showlocaluser&id='. $userid .'">'.$username.'</a>';
			$user->display();
			echo '<hr>';
			$i++;
		}
	}
	function getUserLoggedIn($username,$password){
		$query = "SELECT * FROM ". $this->usertable . " WHERE userscreen_name='". $username ."' AND userpassword='". $password ."'";
		$sqlresult = mysql_query($query);
		if(mysql_num_rows($sqlresult) != 0) // true if >0 results
		{
			return true;
		}else{
			return false;
		}
	}
	function getUserByID($id){
		$query = "SELECT * FROM ". $this->usertable . " WHERE userid='". $id ."'";
		$sqlresult = mysql_query($query);
		if(mysql_num_rows($sqlresult) == 0){
			return new User();
		}
		
		$user = new User();
		
		$user->userid = mysql_result($sqlresult,0,"userid");
		$user->username = mysql_result($sqlresult,0,"username");
		$user->userscreen_name = mysql_result($sqlresult,0,"userscreen_name");
		$user->userpassword = mysql_result($sqlresult,0,"userpassword");
		$user->userdefaultzoom = mysql_result($sqlresult,0,"userdefaultzoom");
		$user->userlastlogon = mysql_result($sqlresult,0,"userlastlogon");
		$user->userlocation = mysql_result($sqlresult,0,"userlocation");
		$user->userdescription = mysql_result($sqlresult,0,"userdescription");
		$user->userprofile_image_url = mysql_result($sqlresult,0,"userprofile_image_url");
		$user->userurl = mysql_result($sqlresult,0,"userurl");
		$user->userprotected = mysql_result($sqlresult,0,"userprotected");
		$user->useroauth_token = mysql_result($sqlresult,0,"oauth_token");
		$user->useroauth_token_secret = mysql_result($sqlresult,0,"oauth_token_secret");
		
		
		return $user;
	}
	function getUserByScreenName($screen_name){
		$query = "SELECT * FROM ". $this->usertable . " WHERE userscreen_name='". $screen_name ."'";
		$sqlresult = mysql_query($query);
		if(mysql_num_rows($sqlresult) == 0){
			return new User();
		}
		
		$user = new User();
		
		$user->userid = mysql_result($sqlresult,0,"userid");
		$user->username = mysql_result($sqlresult,0,"username");
		$user->userscreen_name = mysql_result($sqlresult,0,"userscreen_name");
		$user->userpassword = mysql_result($sqlresult,0,"userpassword");
		$user->userdefaultzoom = mysql_result($sqlresult,0,"userdefaultzoom");
		$user->userlastlogon = mysql_result($sqlresult,0,"userlastlogon");
		$user->userlocation = mysql_result($sqlresult,0,"userlocation");
		$user->userdescription = mysql_result($sqlresult,0,"userdescription");
		$user->userprofile_image_url = mysql_result($sqlresult,0,"userprofile_image_url");
		$user->userurl = mysql_result($sqlresult,0,"userurl");
		$user->userprotected = mysql_result($sqlresult,0,"userprotected");
		$user->useroauth_token = mysql_result($sqlresult,0,"oauth_token");
		$user->useroauth_token_secret = mysql_result($sqlresult,0,"oauth_token_secret");
		
		return $user;
	}
	function insertUser($user){
		$query = "INSERT INTO ". $this->usertable . 
			" VALUES ('".
			$user->userid ."','".
			$user->userscreen_name ."','".
			$user->userpassword ."','".
			$user->username ."','".
			$user->userdefaultzoom ."','".
			date( 'Y-m-d H:i:s', strtotime($user->userlastlogon)) ."','".
			$user->userlocation ."','".
			$user->userdescription ."','".
			$user->userprofile_image_url ."','".
			$user->userurl ."','".
			$user->userprotected ."','".
			$user->useroauth_token ."','".
			$user->useroauth_token_secret ."')";
		mysql_query($query);
	}
	function deleteAllUsers(){
		$query = "DELETE FROM ". $this->usertable ." WHERE 1";
		mysql_query($query);
	}
	function deleteUserByID($id){
		$query = "DELETE FROM ". $this->usertable ." WHERE userid='". $id ."'";
		mysql_query($query);
	}
	function deleteUserByScreenName($userscreen_name){
		$query = "DELETE FROM ". $this->usertable ." WHERE userscreen_name='". $userscreen_name ."'";
		mysql_query($query);
	}

	//TWEET OPERATIONS
	function getTweetByID($id){
		$query = "SELECT * FROM ". $this->tweettable . " WHERE id='". $id ."'";
		$sqlresult = mysql_query($query);
		if(mysql_num_rows($sqlresult) == 0){
			return -1;
		}
		
		$tweet = new Tweet();
		
		$tweet->id = mysql_result($sqlresult,0,"id");
		$tweet->created_at = mysql_result($sqlresult,0,"created_at");
		$tweet->text = base64_decode(mysql_result($sqlresult,0,"text"));
		$tweet->source = mysql_result($sqlresult,0,"source");
		$tweet->truncated = mysql_result($sqlresult,0,"truncated");
		$tweet->in_reply_to_status_id = mysql_result($sqlresult,0,"in_reply_to_status_id");
		$tweet->in_reply_to_user_id = mysql_result($sqlresult,0,"in_reply_to_user_id");
		$tweet->in_reply_to_screen_name = mysql_result($sqlresult,0,"in_reply_to_screen_name");
		$tweet->favorited = mysql_result($sqlresult,0,"favorited");
		$tweet->isread = mysql_result($sqlresult,0,"isread");
		$tweet->userid = mysql_result($sqlresult,0,"userid");
		$tweet->username = mysql_result($sqlresult,0,"username");
		$tweet->userscreen_name = mysql_result($sqlresult,0,"userscreen_name");
		$tweet->userprofile_image_url = mysql_result($sqlresult,0,"userprofile_image_url");
		return $tweet;
	}
	function getAllUnreadTweets(){
		$sort = "DESC"; //switch DESC to ASC
		$query = "SELECT * FROM ". $this->tweettable . " WHERE isread=0 AND accountid=" . $_SESSION['userLoggedInID'] . " ORDER BY created_at ". $sort;
		$sqlresult = mysql_query($query);

		//display results as Tweet objects
		$resultsize = mysql_num_rows($sqlresult);
		if($resultsize == 0){
			print '<b> 0 Tweets Found <b><br>';
			exit;
		}
		$arr = array();
		//read results into array
		for($i = 0;$i<$resultsize;$i++){
			$row = mysql_fetch_array($sqlresult, MYSQL_NUM);
			$arr[$i] = new Tweet($row,5);
		}
		
		$this->displayTweets($arr);
	}
	function getXUnreadTweets($count = 10,$start = 0){
		$sort = "DESC"; //switch DESC to ASC
		$query = "SELECT * FROM ". $this->tweettable . " WHERE isread=0 AND accountid=" . $_SESSION['userLoggedInID'] . " ORDER BY created_at ". $sort . " LIMIT " . $start . ", " . $count;
		$sqlresult = mysql_query($query);

		//display results as Tweet objects
		$resultsize = mysql_num_rows($sqlresult);
		if($resultsize == 0){
			print '<b> 0 Tweets Found <b><br>';
			exit;
		}
		$arr = array();
		//read results into array
		for($i = 0;$i<$resultsize;$i++){
			$row = mysql_fetch_array($sqlresult, MYSQL_NUM);
			$arr[$i] = new Tweet($row,5);
		}
		
		$this->displayTweets($arr);
	}
	function getAllReadTweets(){
		$sort = "DESC"; //switch DESC to ASC
		$query = "SELECT * FROM ". $this->tweettable . " WHERE isread=1 AND accountid=" . $_SESSION['userLoggedInID'] . " ORDER BY created_at ". $sort;
		$sqlresult = mysql_query($query);
		
		//display results as Tweet objects
		$resultsize = mysql_num_rows($sqlresult);
		if($resultsize == 0){
			print '<b> 0 Tweets Found <b><br>';
			exit;
		}
		$arr = array();
		//read results into array
		for($i = 0;$i<$resultsize;$i++){
			$row = mysql_fetch_array($sqlresult, MYSQL_NUM);
			$arr[$i] = new Tweet($row,5);
		}
		
		$this->displayTweets($arr);
	}
	function getAllTweets(){
		if($_SESSION['userLoggedInID'] == "") {
			print "Must be logged in to view tweets"; 
			return -1;
		}
		$sort = "DESC"; //switch DESC to ASC
		print 'For User: ' . $_SESSION['userLoggedInName'] . ' ';
		$query = "SELECT * FROM ". $this->tweettable . " WHERE accountid='". $_SESSION['userLoggedInID'] . "' ORDER BY created_at ". $sort;
		$sqlresult = mysql_query($query);

		//display results as Tweet objects
		$resultsize = mysql_num_rows($sqlresult);
		if($resultsize == 0){
			print '<b> 0 Tweets Found <b><br>';
			return -1;
		}
		$arr = array();
		//read results into array
		for($i = 0;$i<$resultsize;$i++){
			$row = mysql_fetch_array($sqlresult, MYSQL_NUM);
			$arr[$i] = new Tweet($row,5);
		}
		
		$this->displayTweets($arr);
	}
	function getAllTweetsUserBlind(){
		$sort = "DESC"; //switch DESC to ASC
		print 'For User: ' . $_SESSION['userLoggedInID'];
		$query = "SELECT * FROM ". $this->tweettable . " ORDER BY created_at ". $sort;
		$sqlresult = mysql_query($query);

		//display results as Tweet objects
		$resultsize = mysql_num_rows($sqlresult);
		if($resultsize == 0){
			print '<b> 0 Tweets Found <b><br>';
			return -1;
		}
		$arr = array();
		//read results into array
		for($i = 0;$i<$resultsize;$i++){
			$row = mysql_fetch_array($sqlresult, MYSQL_NUM);
			$arr[$i] = new Tweet($row,5);
		}
		
		$this->displayTweets($arr);
	}
	function displayTweets($tweetarray){
		if($tweetarray == null){
			print 'displayTweets error: no items in array';
			break;
		}
		$count = count($tweetarray)-1;
		print '<span id="tweettotalcount">'. $count .'</span> tweets:<br>';
		print '<table>';
		
		for($i = 0; $i <= $count;$i++){
			if($tweetarray[$i] != null){
				if(!$tweetarray[$i]->isEmpty())
					{
					print '<table><tr><tr onclick="highlight(this);"><td class="tweet" id="'. $tweetarray[$i]->id .'">';
					$tweetarray[$i]->display();
					print '</td></tr></table>';
					}
			}
		}
		print '</table>';
	}
	function getZoomedTweets($zoom = 0, $includeread = 0){
		$sort = "DESC"; //switch DESC to ASC
		if($_SESSION['userLoggedInID'] == NULL){
			print 'Must be logged in to do that<br>';
			return -1;
		}
		$query = "SELECT * FROM ". $this->tweettable . " WHERE isread=" . $includeread ." AND accountid=". $_SESSION['userLoggedInID'] ." ORDER BY created_at ". $sort;
		$sqlresult = mysql_query($query);
		
		//display results as Tweet objects
		$resultsize = mysql_num_rows($sqlresult);
		if($resultsize == 0){
			print '<b> 0 Tweets Found <b><br>';
			return -1;
		}
		//read results into array
		for($i = 0;$i<=$resultsize;$i++){
			$row = mysql_fetch_array($sqlresult, MYSQL_NUM);
			$results[$i] = $row;
		}
		
		if($zoom == 0){
			$zoom = 1;
		}
		
		//$numdesired = ($resultsize - ($resultsize % $zoom)) / $zoom;
		$numdesired = round(($resultsize * $zoom) / 50);
		$interval = $resultsize / $numdesired;
		//print '<b> '. $numdesired .' Tweets Selected</b> ('. $resultsize .' total)<br>';
		
		$arr = array();
		
		//init all $arr[] slots to -1
		for($i = 0; $i <= $numdesired; $i++){
			$arr[$i] = null;
		}
		$selected = 0;
		for($i = 0; $i <= $numdesired;$i++){
			if($i == $numdesired){
				//$selected = rand ( $numdesired * $zoom, $numdesired * $zoom + ($resultsize % $zoom) - 1); 
				$selected = rand ( ($i-1) * $interval, $i * $interval);
			} else {
				//$selected = rand ( $i * $zoom, $i * $zoom + ($zoom - 1)); //get range of width $zoom, starting at $zoom*$i
				$selected = rand ( ($i-1) * $interval, $i * $interval);
			}
			$tweet = new Tweet($results[$selected],5);
			//$arr[$i] = $tweet;
			if (!$tweet->isEmpty()) $arr[++$arrIndex] = $tweet;
		}
		$this->displayTweets($arr);
	}
	function insertUpdateTweet($tweet){
		$querydelete = "DELETE FROM ". $this->tweettable .
					" WHERE id='". $tweet->id ."' AND accountid='". $_SESSION['userLoggedInID'] ."'";
					
		$queryinsert = "INSERT INTO ". $this->tweettable .
					 "(id,created_at,
					text,
					source,
					truncated,
					in_reply_to_status_id,
					in_reply_to_user_id,
					in_reply_to_screen_name,
					favorited,
					isread,
					userid,
					username,
					userscreen_name,
					userprofile_image_url,
					accountid
					) VALUES ('".
					$tweet->id ."','".
					date( 'Y-m-d H:i:s', strtotime($tweet->created_at)) ."','".
					base64_encode($tweet->text) ."','".
					$tweet->source ."','".
					$tweet->truncated ."','".
					$tweet->in_reply_to_status_id ."','".
					$tweet->in_reply_to_user_id ."','".
					$tweet->in_reply_to_screen_name ."','".
					$tweet->favorited ."','".
					$tweet->isread ."','".
					$tweet->userid ."','".
					$tweet->username ."','".
					$tweet->userscreen_name ."','".
					$tweet->userprofile_image_url ."','".
					$tweet->accountid ."')";
		mysql_query($querydelete);
		mysql_query($queryinsert);
	}
	function insertTweet($tweet){
	
		$query = "INSERT INTO ". $this->tweettable . 
				 "(id,created_at,
					text,
					source,
					truncated,
					in_reply_to_status_id,
					in_reply_to_user_id,
					in_reply_to_screen_name,
					favorited,
					isread,
					userid,
					username,
					userscreen_name,
					userprofile_image_url,
					accountid
					) VALUES ('".
					$tweet->id ."','".
					date( 'Y-m-d H:i:s', strtotime($tweet->created_at)) ."','".
					base64_encode($tweet->text) ."','".
					$tweet->source ."','".
					$tweet->truncated ."','".
					$tweet->in_reply_to_status_id ."','".
					$tweet->in_reply_to_user_id ."','".
					$tweet->in_reply_to_screen_name ."','".
					$tweet->favorited ."','".
					$tweet->isread ."','".
					$tweet->userid ."','".
					$tweet->username ."','".
					$tweet->userscreen_name ."','".
					$tweet->userprofile_image_url ."','".
					$tweet->accountid ."')";
		//print '<br>'.$query.'<br>';
		mysql_query($query);
	}
	function deleteUserTweets(){
		if($_SESSION['userLoggedInID'] == NULL){
			print 'Must be logged in to do that<br>';
			return -1;
		} else {
			$query = "DELETE FROM ". $this->tweettable ." WHERE accountid=". $_SESSION['userLoggedInID'];
			mysql_query($query);
		}
		print $query;
	}
	function deleteTweetByID($id){
		$query = "DELETE FROM ". $this->tweettable ." WHERE id='". $id ."'";
		mysql_query($query);
	}
	function readTweetByID($id,$userid = NULL){
		
		if($userid == NULL){
		$query = "UPDATE ". $this->tweettable ." SET isread=1 WHERE id='". $id ."'";
		} else {
		$query = "UPDATE ". $this->tweettable ." SET isread=1 WHERE id='". $id ."' AND userid='". $userid ."'";
		}
		mysql_query($query);
	}
	function deleteAllTweets(){
		$query = "DELETE FROM ". $this->tweettable ."WHERE 1";
		print $query;
		mysql_query($query);
	}
	function deleteTweetsByUserScreenName($userscreen_name){
		$query = "DELETE FROM ". $this->tweettable ." WHERE userscreen_name='". $userscreen_name ."'";
		mysql_query($query);
	}
	
}







/* OLD Testing
$t= new twitter(); 
$t->username='nmeierpolys'; 
$t->password='nathaniel1'; 
//1
$status = $t->showSingleUpdate('1472669360');
$tweet1 = new Tweet($status);
$tweet1->display();
//2
$status = $t->showSingleUpdate('2241944628');
$tweet2 = new Tweet($status);
$tweet2->display();

//$t->showZoomedTweets($skipevery,200);
//$t->showZoomedTweets(2,100);

$user = new User('nmeierpolys','nathaniel1');
//var_dump($tweet);
//$user->show();
$user2 = new User('sirpython','sirpythonpass');
//$user2->show();

//Show rate limits
$t1= new twitter();
$res = $t1->rateLimit();
print '<b>IP limit: ';
var_dump($res);
print '</b><br>';
$t1= new twitter();
$t1->username='nmeierpolys'; 
$t1->password='nathaniel1'; 
$res = $t1->rateLimit();
print '<b>User limit: ';
var_dump($res);
print '</b><br>';

$db = new DB();
$db->open();
//$db->getAllUsers();
$db->deleteAllTweets();
$db->insertTweet($tweet1);
$db->insertTweet($tweet2);
$db->getAllTweets();

$db->deleteAllUsers();
$db->insertUser($user);
$db->insertUser($user2);
$db->getAllUsers();
//print $db->getLoggedIn('nmeierpolysnmeierpolys','nathaniel1');
$db->close();
*/
?>