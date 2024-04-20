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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(75, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php 
	  echo '<br/><br/>
	  
	  <b>'.zwroc_tekst(76, $jezyk).'</b> <br/>
          <font style="font-size: 7px; font-family: Courier, \'Courier New\', monospace; padding-right: 15px;">';
	  
	  
	  echo '<img src="graf/typetapu/MO.jpg" /> '.zwroc_tekst(101, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/MObr.jpg" /> '.zwroc_tekst(102, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/MOTT.jpg" /> '.zwroc_tekst(103, $jezyk).' <br/>';
	  
	  echo '<img src="graf/typetapu/HIL.jpg" /> '.zwroc_tekst(104, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/HILbr.jpg" /> '.zwroc_tekst(105, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/HILspr.jpg" /> '.zwroc_tekst(106, $jezyk).' <br/>';
	  
	  echo '<img src="graf/typetapu/FH.jpg" /> '.zwroc_tekst(107, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/FHbr.jpg" /> '.zwroc_tekst(108, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/FHspr.jpg" /> '.zwroc_tekst(109, $jezyk).' <br/>';
	  
	  echo '<img src="graf/typetapu/FL.jpg" /> '.zwroc_tekst(110, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/FLbr.jpg" /> '.zwroc_tekst(111, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/SPR.jpg" /> '.zwroc_tekst(112, $jezyk).' <br/>';
	  
	  echo '<img src="graf/typetapu/CB.jpg" /> '.zwroc_tekst(113, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/TT.jpg" /> '.zwroc_tekst(114, $jezyk).' <br/>';
	  echo '<img src="graf/typetapu/TTT.jpg" /> '.zwroc_tekst(115, $jezyk).' <br/>';  
	  
	  echo '<img src="graf/typetapu/unknown.jpg" /> '.zwroc_tekst(20, $jezyk).' <br/><br/>';
	  
	  
	   
	  
	  echo'
    
          '.zwroc_tekst(77, $jezyk).'
    
          </font>';
	  
	  
	  ?>
	   
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
