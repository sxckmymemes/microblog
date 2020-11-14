<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'microblog';
$db_link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
?>
<meta charset="utf-8">
<body>
	<div>
		<form>
			<input type="button" value="Логин" onClick='location.href="http://localhost/pshe_07-main/login.php"'>
			<input type="button" value="Зарегестрироваться" onClick='location.href="http://localhost/pshe_07-main/register.php"'>
		</form>
	</div>
</body>
<style type="text/css">
	body {
		display: flex;
		flex-direction: column;lumn;
		align-items: center;
		font-family: Arial, Helvetica, sans-serif;
	}

	.post {
		width: 800px;
		margin: 20px;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0 0 5px rgba(0,0,0,0.5);
	}
	.post .title {
		font-weight: bold;
		font-size: 30px;
		margin: 10px 0px;
		border-bottom: solid 1px grey;
	}
	.post .up {
		text-align: right;
		margin-top: 12px;
	}

</style>
<?php
	require "db_link.php";

	$sql = "SELECT * FROM `posts`";
	$result = mysqli_query($db_link, $sql);

	while ( $row = mysqli_fetch_assoc($result) ) {
		$id    = $row["post_id"];
		$title = $row["title"];
		$text  = $row["text"];
		$date  = $row["date"];
		$status = $row["status"];

			
			echo "<div class='post'>
				<div class='title'>$title</div>
				<div class='text'>$text</div>
				<div class='footer'>$date</div>
				<div class='up'>$status</div>
			</div>";


	}
?>
<?php

	mysqli_free_result($result);
?>
