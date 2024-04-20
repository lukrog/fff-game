<?php 
  //ł±czenie się z bazą php
  session_start();
  

  $connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się połączyć z bazą dancych!</p>";
  mysql_query("SET NAMES 'utf8'");
  include_once('glowne.php');
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - <?php echo zwroc_tekst(6, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php 
	  
	     $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	     echo $lang.' <br/>';
	     
	     $pos = strpos($lang, 'pl');
	     echo $pos.' <- miejsce<br/>';
	     if ($pos === false) {
	       echo 'nie znaleziono języka polskiego<br/>';
	     } else {
	       echo 'znaleziono język polski<br/>';
	     }
	     $pos = strpos($lang, 'en');
	     echo $pos.' <- miejsce<br/>';
	     if ($pos === false) {
	       echo 'nie znaleziono języka angielskiego<br/>';
	     } else {
	       echo 'znaleziono język angielski na miejscu <br/>';
	     }
	     $pos = strpos($lang, 'fr');
	     echo $pos.' <- miejsce<br/>';
	     if ($pos === false) {
	       echo 'nie znaleziono języka francuskiego<br/>';
	     } else {
	       echo 'znaleziono język francuski na miejscu<br/>';
	     }
	     
	     
	  ?>
	  
	  <br/> <br/>
	   
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
