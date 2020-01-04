<html>
<head>
</head>
<body>
<?php
	if(isset($_GET['MovieName'])&&$_GET['MovieName']!="")
	{
		$find=$_GET['MovieName'];
		$search=explode(" ",$find);
		$year=$_GET['Year'];
		$url="https://www.googleapis.com/books/v1/volumes?q=".$search[0]."";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$curl_result = curl_exec($curl);
		curl_close($curl);
		$json_object = json_decode($curl_result);
		foreach($json_object->items as $value){
			echo $value->volumeInfo->title;
			echo "<br/>";
		}
	}	
?>
</body>
</html>