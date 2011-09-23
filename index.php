<?php
session_start(); 
?>

<?php

require_once('twitterphp.php');
// require twitterOAuth lib
require_once('twitterOAuth.php');

//Set vars
/* Sessions are used to keep track of tokens while user authenticates with twitter */
session_start();
/* Consumer key from twitter */
$consumer_key = 'GZp1I6FWnuU3RdE0Y7iRBg';
$_SESSION['consumer_key'] = $consumer_key;
/* Consumer Secret from twitter */
$consumer_secret = 'dfLKV4jTPNRqJ5PVUxejSKrg93DBg1c5pNuVN3abqjU';
$_SESSION['consumer_secret'] = $consumer_secret;
/* Set up placeholder */
$content = NULL;
/* Set state if previous session */
$state = $_SESSION['oauth_state'];
/* Checks if oauth_token is set from returning from twitter */
$session_token = $_SESSION['oauth_request_token'];
/* Checks if oauth_token is set from returning from twitter */
$oauth_token = $_REQUEST['oauth_token'];
/* Set section var */
$section = $_REQUEST['section'];

//Identify iPhone safari browser
$browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
if ($browser == true) {
	$_SESSION['iPhone'] = true;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
	<title>TweetSampler</title>
	
	<?php if ($_SESSION['iPhone']) {
		Print '<link rel="stylesheet" href="iphone.css" type="text/css">';
	} else {
		Print '<link rel="stylesheet" href="main.css" type="text/css">';
	} ?>
		
	<script type="text/javascript" src="addanevent.js"></script>
    <script type="text/javascript" src="slider.js"></script>
    <script type="text/javascript" src="slider-setup.js"></script>
	<script type="text/javascript">
	var selectedID = 0;
	
	document.getElementsByClassName = function(cl) {
		var retnode = [];
		var myclass = new RegExp('\\b'+cl+'\\b');
		var elem = this.getElementsByTagName('*');
		for (var i = 0; i < elem.length; i++) {
			var classes = elem[i].className;
			if (myclass.test(classes)) retnode.push(elem[i]);
		}
		return retnode;
	};
		
	function highlight(obj) {
		var mycl = 'select';
		
		var myclass = new RegExp('\\b'+mycl+'\\b');
		var elem = document.getElementsByClassName('select');
		for (var i = 0; i < elem.length; i++) {
			var classes = elem[i].className;
			elem[i].parentNode.parentNode.parentNode.parentNode.removeChild(elem[i].parentNode.parentNode.parentNode);
			//elem[i].className = "tweet";
		}
		console.debug(obj.cells[0].id);
		obj.cells[0].className = "select";
		markTweetRead(obj.cells[0].id);
		document.getElementById("tweettotalcount").innerHTML=document.getElementById("tweettotalcount").innerHTML - 1 
	};

	function lengthchange(obj)
	{
		var newremaining = 140 - obj.value.length;
		document.getElementById("remaining").innerHTML=newremaining;
		
	};
	function removeElementById(obj) 
	{
		tweetid = document.getElementById(obj.cells[0].id).parentNode;
		if (tweetid.parentNode && tweetid.parentNode.removeChild(tweetid)) 
		{
			tweetid.parentNode.removeChild(tweetid);
		}
	};
	
	function encodeMyHtml() {
   	 encodedHtml = escape(encodeHtml.htmlToEncode.value);
    	 encodedHtml = encodedHtml.replace(/\//g,"%2F");
    	 encodedHtml = encodedHtml.replace(/\?/g,"%3F");
    	 encodedHtml = encodedHtml.replace(/=/g,"%3D");
    	 encodedHtml = encodedHtml.replace(/&/g,"%26");
    	 encodedHtml = encodedHtml.replace(/@/g,"%40");
    	 encodeHtml.htmlEncoded.value = encodedHtml;
  	};
	
	function submitPost(userscreen_name)
	{
	var xmlhttp;
	if (window.XMLHttpRequest)
		{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
	else if (window.ActiveXObject)
		{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	else
		{
		alert("Your browser does not support XMLHTTP!");
		}
	tweettext = escape(document.getElementById("tweettext").value);
	var url="index.php?act=ajaxupdatestatus";
	url=url+"&text="+tweettext;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	console.log("AJAX (url): ", url);
	console.log("AJAX (screenname): ", userscreen_name);
	document.getElementById("tweettext").value = "";
	document.getElementById("remaining").innerHTML = "140";
	document.getElementById("aftersubmit").innerHTML = unescape(tweettext) + "<br><a href='http://twitter.com/" + userscreen_name + "'>Feed</a><br><br>";
	};
	
	function markTweetRead(tweetid)
	{
	var xmlhttp;
	if (window.XMLHttpRequest)
		{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
	else if (window.ActiveXObject)
		{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	else
		{
		alert("Your browser does not support XMLHTTP!");
		}
		
	var url="index.php?act=readtweet";
	url=url+"&id="+tweetid;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	console.log("AJAX (url): ", url);
	};
	
	</script>
</head>

<body>
<?php
function logInUser($userobj){

if($userobj == NULL){
	print 'Error! Null Object<br>';
	break;
}

session_start();
$_SESSION['userLoggedInID'] =(string)$userobj->userid;
$_SESSION['userLoggedInName'] = (string)$userobj->username;
$_SESSION['oauth_access_token'] = (string)$userobj->oauth_token;
$_SESSION['oauth_access_token_secret'] = (string)$userobj->oauth_token_secret;
}
function showIntro(){

	if($_SESSION['iPhone'] == 'iPhone')
		{
		Print 'Hello iPhone user!<br>';
	}
		
	print '<h2>Welcome to TweetSampler!</h2> 
			This is still a work in progress and things are still way rough around the edges.  
			Nevertheless, take it for a spin.  
			Log in in the upper right corner, get updates and try zooming in and out on your tweets.';
}

function displayItem($action = ''){
//print 'ACTION: '.$action.'<br>';
switch ($action) {
	case "intro":
		showIntro();
	break;
	case "clearsession":
		session_destroy();
	break;
	case "logout":
		session_destroy();
	break;
	case "authenticates":
	
		if(0){
		/* If oauth_token is missing get it */
		if ($_REQUEST['oauth_token'] != NULL && $_SESSION['oauth_state'] === 'start') {
		$_SESSION['oauth_state'] = $state = 'returned';
		}
		
		
		
		print "State: " . $state . "<br>";
		switch ($state) {
		default:
			/* Create TwitterOAuth object with app key/secret */
			$to = new TwitterOAuth($consumer_key, $consumer_secret);
			/* Request tokens from twitter */
			$tok = $to->getRequestToken();

			/* Save tokens for later */
			$_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
			$_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
			$_SESSION['oauth_state'] = "start";
			
			/* Build the authorization URL */
			$request_link = $to->getAuthorizeURL($token);

			/* Build link that gets user to twitter to authorize the app */
			$content = 'Click on the link to go to twitter to authorize your account.';
			$content .= '<a href="'.$request_link.'">'.$request_link.'</a>';
		break;
		case 'returned':
			/* If the access tokens are already set skip to the API call */
			if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
			  /* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
			  $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
			  /* Request access tokens from twitter */
			  $tok = $to->getAccessToken();

			  /* Save the access tokens. Normally these would be saved in a database for future use. */
			  $_SESSION['oauth_access_token'] = $tok['oauth_token'];
			  $_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
		} 

			/* Random copy */
			$content = 'your account should now be registered with twitter. Check here:<br />';
			$content .= '<a href="https://twitter.com/account/connections">https://twitter.com/account/connections</a>';

			/* Create TwitterOAuth with app key/secret and user access key/secret */
			$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
			/* Run request on twitter API as user. */
			
			//Nathaniel's Additions
			$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
			$xml = new SimpleXMLElement($to->OAuthRequest('https://twitter.com/account/verify_credentials.xml',array(), 'GET')); 
			print_r($to->OAuthRequest('https://twitter.com/account/verify_credentials.xml',array(), 'GET'));
			//print "|" . $_SESSION['oauth_access_token'] . " -- " . $_SESSION['oauth_access_token_secret'] . "|<br>";
			$userobj = new User($xml,$_SESSION['oauth_access_token'],$_SESSION['oauth_access_token_secret']);
			//print "|" . $_SESSION['oauth_access_token'] . " -- " . $_SESSION['oauth_access_token_secret'] . "|<br>";
			//session_start();
			$_SESSION['userLoggedInID'] =(string)$userobj->userid;
			$userobj->display();
			$db = new DB();
			$db->open();
			$db->insertUser($userobj);
			$db->close();
		break;
		}
		print 'User ID: '. $_SESSION['userLoggedInID'] .'<br>';
		print_r($content);}
	break;
	case "loginas":
		if(!$_GET["id"]) //missing info, say so
		{
			print 'Missing login id';
		}
		$db = new DB();
		$db->open();
		$thisuser = $db->getUserByID($_GET["id"]);
		$db->close();
		logInUser($thisuser);
		$thisuser->display();
	 
		print 'Welcome '. $_SESSION['userLoggedInName'] .'  <a href="./index.php?act=logout">Log Out</a><br>';
	 
	break;
	case "login":
		print '
			<form name="login" action="index.php" method="get">
			Username:
			<input type="text" name="user" /><br>
			Password:
			<input type="password" name="pass"/><br>
			<input type="hidden" name="act" value="handlelogin"/>
			<input type="submit" value="Submit" />
			</form>
		';
		$text = $_GET["text"];
	break;
	case "handlelogin":
		if(!$_GET["user"] || !$_GET["pass"]) //missing login info, try again
		{
			print '<b> Log in to TweetSampler: </b><br>';
			print '
			<form name="login" action="index.php" method="get">
			Username:
			<input type="text" name="user" /><br>
			Password:
			<input type="password" name="pass"/><br>
			<input type="hidden" name="act" value="handlelogin"/>
			<input type="submit" value="Submit" />
			</form>
			';
		} else {
			$db = new DB();	
			$db->open();
			if($db->getUserLoggedIn($_GET["user"],$_GET["pass"]))
			{
				print 'Success';
			} else {
				print 'Failure';
			}
			$db->close();
		}
	break;
	case "updatestatus":
		print '<form name="input" action="" method="post">
		Tweet Content:<br>
		<textarea onkeyup="lengthchange(this);" id="tweettext" cols="50" rows="3"></textarea><br>
		Remaining: <span id="remaining">140</span> characters 
		<input type="button" value="Post" onClick="javascript:submitPost(\''. $_SESSION["userLoggedInScreenName"] . '\');"/>
		</form>
		<span id="aftersubmit"></span>';
	break;
	case "oldupdatestatus":
		$t= new twitter(); 
		$text = $_GET["text"];
		echo "<b>Update Status: <b><br>";
		echo $text;
		$tweet = $t->update($text);
		if($tweet != NULL)
		{
			$tweet->display();
		} else {
			print 'Error - Status update not posted.';
		}
	break;
	case "ajaxupdatestatus":
		$t= new twitter();
		$text = $_GET["text"];
		echo "<b>Update Status: <b><br>";
		echo $text;
		$t->update($text);
	break;
	case "updatetweets":
		$t= new twitter();
		echo "<b>Update Tweets: <b><br>";
		$t->showZoomedTweets(0,300);
	break;
	case "deletetweets":
		$db = new DB();
		$db->open();
		echo "<b>Delete Tweets: <b><br>";
		$db->deleteAllTweets();
		$db->close();
	break;
	case "deleteusertweets":
		$db = new DB();
		$db->open();
		echo "<b>Delete User Tweets: <b><br>";
		$db->deleteUserTweets();
		$db->close();
	break;
	case "readtweet":
		$db = new DB();
		$db->open();
		$id = $_GET["id"];
		$db->readTweetByID($id);
		$db->close();
        break;
	case "showallusers":
		$db = new DB();
		$db->open();
		echo "<b>Show All Users: <b><br>";
		$db->getAllUsers();
		$db->close();
	break;
	case "showzoomedtweets":
		print '<div class="slider" id="slider01">
			<div class="left"></div>
			<div class="right"></div>
			<img src="img/knob.png" width="31" height="15" />
		</div>
		<div id="results">Results</div>';
		
		//Show zoomedTweets
		//for($i=1;$i<=20;$i++){
		//	print "<a href='./index.php?act=showzoomedtweets&zoom=". $i ."'> ". $i ." </a>";
		//	if($i != 20){
		//		print "|";
		//	} else {
		//		print "<br>";
		//	}
		//}
		//$db = new DB();
		//$db->open();
		//echo "<b>Show Zoomed Tweets: <b><br>";
		//$zoom = $_GET["zoom"];
		//$db->getZoomedTweets($zoom);
		//$db->close();
	break;
	case "showalltweets":
		$db = new DB();
		$db->open();
		echo "<b>Show All Tweets: </b><br>";
		$db->getAllTweetsUserBlind();
		$db->close();
	break;
	case "showallmytweets":
		$db = new DB();
		$db->open();
		echo "<b>Show All Tweets: </b><br>";
		$db->getAllTweets();
		$db->close();
	break;
	case "showunreadtweets":
		$db = new DB();
		$db->open();
		echo "<b>Show Unread Tweets: </b><br>";
		$db->getAllUnreadTweets();
		//$db->getXUnreadTweets();
		$db->close();
        break;
	case "showreadtweets":
		$db = new DB();
		$db->open();
		echo "<b>Show read Tweets: </b><br>";
		$db->getAllReadTweets();
		$db->close();
        break;
	case "showlocaltweet":
		$db = new DB();
		$db->open();
		echo "<b>Show Tweet by ID: </b><br>";
		$tweetid = $_GET["id"];
		if($tweetid == NULL) //check for post arg id
		{	
			print "No tweetid entered.  Please try again";
			break;
		}
		$tweet = $db->getTweetByID($tweetid,$_SESSION['userLoggedInID']);
		if($tweet == -1){
			print 'Ooops - Tweet not found locally<br>';
		} else {
			$tweet->display();
		}
		$db->close();
        break;
	case "showlocaluser":
		print ' showlocaluser';
		$db = new DB();
		$db->open();
		echo "<b>Show User by ID: </b><br>";
		$userid = $_GET["id"];
		$user = $db->getUserByID($userid);
		$user->display();
		$db->close();
        break;
	default:
		showIntro();
}
}
?>
<div id="header">
<?php
//Logged in User ID?
if($_SESSION['userLoggedInID'] == NULL)
{
	/* If oauth_token is missing get it */
	if ($_REQUEST['oauth_token'] != NULL && $_SESSION['oauth_state'] === 'start') {/*{{{*/
	  $_SESSION['oauth_state'] = $state = 'returned';
	}
	 
	switch ($state) {/*{{{*/
		default:
			//no request
			/* Create TwitterOAuth object with app key/secret */
			$to = new TwitterOAuth($consumer_key, $consumer_secret);
			/* Request tokens from twitter */
			$tok = $to->getRequestToken();
			
			/* Save tokens for later */
			$_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
			$_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
			$_SESSION['oauth_state'] = "start";
			
			/* Build the authorization URL */
			$request_link = $to->getAuthorizeURL($token);
			
			/* Build link that gets user to twitter to authorize the app */
			$content = '<p align="right"><a href="'.$request_link.'">
						<img border="0" src="http://twuffer.com/templates/twuffer_v2/_img/sign-in-with-twitter-d.png" /></a></p>';
			break;
		case 'returned':
			//response from request
			/* If the access tokens are already set skip to the API call */
			if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
				/* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
				$to = new TwitterOAuth($consumer_key, $consumer_secret, 
									   $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
				/* Request access tokens from twitter */
				$tok = $to->getAccessToken();
				
				/* Save the access tokens. Normally these would be saved in a database for future use. */
				$_SESSION['oauth_access_token'] = $tok['oauth_token'];
				$_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
			}
		
			/* Create TwitterOAuth with app key/secret and user access key/secret */
			$to = new TwitterOAuth($consumer_key, $consumer_secret,
								   $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
			$tempresponse = $to->OAuthRequest('https://twitter.com/account/verify_credentials.xml',array(), 'GET');
			$xml = new SimpleXMLElement($tempresponse); 
			$userobj = new User($xml,$_SESSION['oauth_access_token'],$_SESSION['oauth_access_token_secret']);
			if($userobj->userid == NULL){
				print 'Problem logging.  Most likely you\'ve reached the 15 attempts/hour cap.  Wait an hour and try again<br>';
				return -1;
			}
				
			$_SESSION['userLoggedInID'] =(string)$userobj->userid;
			$_SESSION['userLoggedInName'] =(string)$userobj->username;
			$_SESSION['userLoggedInScreenName'] =(string)$userobj->userscreen_name;
			
			$db = new DB();
			$db->open();
			$db->insertUser($userobj);
			$db->close();
			$content = '<p align="right">Welcome '. $_SESSION['userLoggedInName'] 
					.'  <a href="./index.php?act=logout">Log Out</a></p>';
			
			break;
	}
} else {
	//Has user -> show user welcome
	print '<p align="right">Welcome ' . $_SESSION['userLoggedInName'] .' (<a href="./index.php?act=logout">Log Out</a>)</p>';
}
	
print_r($content);
?>
</div>
<div id="wrap">
<div class="topcurve"></div>
<div id="nav">
<ul>
	<li><a href="index.php">Home</a></li>
	<li><a href='./index.php?act=updatestatus'>Update Status</a></li>
	<li><a href='./index.php?act=updatetweets'>Get Updates</a></li>
	<li><a href='./index.php?act=showallmytweets'>All Tweets</a></li>
	<li><a href='./index.php?act=showzoomedtweets&zoom=2'>Zoomed Tweets</a></li>
	<li><a href="./index.php?act=showreadtweets">Show Read</a></li>
	<li><a href="./index.php?act=showunreadtweets">Show Unread</a></li>
    <li></li>
</ul>
</div>
<?php
	if (!$_SESSION['iPhone']) {
		Print '<div id="sidebar">
				<div id="links">
				<b>Options: </b><br>
					<a href="./index.php">Home</a><br>	
					<!---
					<a href="./index.php?act=loginas&id=18812084">login as nmeierpolys</a><br>	
					<a href="./index.php?act=loginas&id=48063718">login as SirPython</a><br>	
					<a href="./index.php?act=loginas&id=60699448">login as SirPython2</a><br>
					<a href="./index.php?act=clearsession">clearsession</a><br>	
					<a href="./index.php?act=authenticate">OAuth Authenticate</a><br>	
					<a href="./index.php?act=updatestatus">updatestatus</a><br>
					<a href="./index.php?act=updatetweets">updatetweets</a><br>	--->	
					<a href="./index.php?act=deleteusertweets">deleteusertweets</a><br>
					<a href="./index.php?act=showalltweets">showalltweets</a><br>
					<a href="./index.php?act=showallmytweets">showallmytweets</a><br>
					<a href="./index.php?act=showzoomedtweets&zoom=2">showzoomedtweets</a><br>
					<a href="./index.php?act=showreadtweets">showreadtweets</a><br>
					<a href="./index.php?act=showunreadtweets">showunreadtweets</a><br>
					showlocaluser: <br>
					<a href="./index.php?act=showlocaluser&id=18812084">Nathaniel Meierpolys</a><br>
					or <a href="./index.php?act=showlocaluser&id=48063718">SirPython</a><br>

				</div>
				</div>';
		}
?>
<div id="main">

<div id="content">
</div>
<?php //displayItem
if(isset($_GET["act"]));
{
	displayItem($_GET["act"]);
}
?>

</div>
<div id="footer"><center>TweetSampler - Copyright <a href="mailto:nmeierpolys@gmail.com">Nathaniel Meierpolys</a></center></div>
<div class="bottomcurve">&nbsp;</div>
</body>
</html>