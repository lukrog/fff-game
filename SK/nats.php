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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(10, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

    <div id="TRESC">
    <?php    
       echo '<h3>'.zwroc_tekst(54, $jezyk).'</h3>';
       
       $sql = " SELECT Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Nat.skr 
                FROM Nat INNER JOIN z_z_tlumacz_nat ON Nat.id_nat = z_z_tlumacz_nat.id_nat
		ORDER BY z_z_tlumacz_nat.".$jezyk." 
	       ";
       //echo $sql.'<br/><br/>'; 
       $idzapytania = mysql_query($sql) or die(mysql_error());
          
	  
	  
	  
	  echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig2">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(18, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(19, $jezyk).'</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	   
	    
	    $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_nat = '$dane[0]' ";
	    $zapaa = mysql_query($sqlaa) or die(mysql_error());
	    $daneaa = mysql_fetch_row($zapaa);
	    
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[2].'" alt="'.$dane[1].'"/> <a href="nat.php?id_nat='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[3].'</td><td style="text-align: right;">'.$daneaa[0].'</td></tr>';
          }  
          echo '</table><br/><br/>'; 
           
    ?>	   
    </div>

<?php 

    koniec();

?>       

</body>
</html>
    
