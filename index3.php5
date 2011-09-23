<?php

require_once( './my_twitter.php5' );

$username = 'nmeierpolys';

$password = 'nathaniel1';

echo 'Connecting...';
$twitter =  new MyTwitter($username, $password);
echo '<br>Posting status outcome: '. $twitter->updateStatus('It Worked Again!');
echo '<br>Limit: ';
print_r($twitter->userRateLimit());
echo '<br> User Timeline: <br>';
print_r($twitter->userTimeLine());	
echo '<br> Public Timeline: <br>';
print_r($twitter->publicTimeLine());

?>