<?php // подключение к базе данных

$dblocation = "localhost";
$dbname = 'my-shop_univ';
$dbuser = 'bohdan0516';
$dbpasswd = '0516';

    $link = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname)
        or die("Error!: " . mysqli_error($link));
   
   		if(!mysqli_set_charset($link, "utf8")){
        	printf("Error!: " . mysql_error($link)); 
    	}

	if (! $link) {
    	echo "feiLLLLL";
    }
   	if ($link) {
   		echo "ok";
   	}