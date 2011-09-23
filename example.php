<?php	


require_once('my_twitter.php5');



$twitter =  new MyTwitter('nmeierpolys', 'nathaniel1');



$status = $twitter->userTimeLine();


$total = count($status);

	
for ( $i=0; $i < $total ; $i++ )

		{ 
		
		
		echo "<p>". $status[$i]['text'] ."</p>";

		
}
		
?>













