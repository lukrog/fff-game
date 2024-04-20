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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(11, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  <?php    
          
	  if ($_GET['rok'] == "") {
            $rokteraz = date("Y");
          } else {
            $rokteraz = $_GET['rok'];
          }
	  
	   
	  echo '<br/><br/>
	  
	  <form action="races.php" method="GET">
	  <select name="rok">';
	  
	  $sqla = " SELECT YEAR(dataP)  "
                . " FROM Wyscigi "
                . " GROUP BY YEAR(dataP)  "; 
          $dan = mysql_query($sqla) or die(mysql_error());
	  while ($dane = mysql_fetch_row($dan)) {
             
	     if ($dane[0] >= 2000) {
                echo '<option ';
                
                if ($dane[0] == $rokteraz) {
	           echo 'selected="selected"';
	        } 
                
                echo '>'.$dane[0].'</option>
	        ';
                }
             }
	     
	     
           
	  echo '
	
	  </select>

	  <input  class="form2" type=submit value="'.zwroc_tekst(61, $jezyk).'" />
	  
	  </form><br/><br/>';
	  
	     
             	  
	  
          
	  echo '<h3>'.zwroc_tekst(62, $jezyk).' '.$rokteraz.'</h3>';
	  $poczatek = 1000 * ($rokteraz - 2000);
	  $koniec = 1000 * ($rokteraz + 1 - 2000);	  
	  	  
	  	  
	  $sql = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, DATE(Wyscigi.dataP), Wyscigi.klaUCI, Wyscigi.dataP
	           FROM Nat, Wyscigi 
		   WHERE Wyscigi.id_wys >= '$poczatek' AND Wyscigi.id_wys < '$koniec' AND Nat.id_nat = Wyscigi.id_nat
		   ORDER BY DATE(Wyscigi.dataP), Wyscigi.id_wys ";
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(63, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(64, $jezyk).'';
	  
	  echo '</td></tr>';
	  
	  while ($dane = mysql_fetch_row($idzapytania)) {
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt="'.$dane[2].'"/> <a href="wyscig.php?id_wys='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[4].'</td><td>';
	    
	    $dzis=date("Y-m-d");
	    $dwadni_za = strtotime($dzis) + 2 * 24 * 3600;
            $dwadni_za = date('Y-m-d',$dwadni_za);
	    if (($dane[5] <= $dwadni_za) AND $dane[5] >= $dzis ) {
              echo '<b>'.$dane[5].'</b>';
            } else {
	      echo $dane[5]; 
	    }
	    
	      
            echo '</td></tr>';
          }  
          echo '</table><br/><br/>';
             
             
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
