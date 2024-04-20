<?php 
  //ł±czenie się z bazą php
  session_start();
  include_once('glowne.php');
?>
<?php 
$connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się połączyć z bazą dancych!</p>";
  mysql_query("SET NAMES 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - news</title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php 
	  
	  $jezyk = "PL";
	  
	  $sqljez = "Select '$jezyk' 
	          FROM z_z_tlumacz
		  WHERE id_trans = 2";
	  $idjez = mysql_query($sqljez) or die(mysql_error());
          $danejez = mysql_fetch_row($idjez);
         
	  
	  $i = $danejez[0];
	  
	  $sqljez = "Select '$jezyk' 
	          FROM z_z_tlumacz
		  WHERE id_trans = 2";
	  $idjez = mysql_query($sqljez) or die(mysql_error());
          $danejez = mysql_fetch_row($idjez);
	  
	  echo 'tu jest napisane w jakim języku to napisane: '.$danejez[0].'  <img src="http://fff.xon.pl/img/flagi/'.$i.'" /><br><br>';
	  
	  
	  
	  ?>
	   
	  
	   
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
