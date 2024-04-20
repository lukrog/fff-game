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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(125, $jezyk); ?></title>
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
	  
	  <form action="champs.php" method="GET">
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
	  $poczatek = 1000 * ($rokteraz - 2000) + 780;
	  $koniec = 1000 * ($rokteraz + 1 - 2000);	  
	  	  
	  	  
	  $sql = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, DATE(Wyscigi.dataP), Wyscigi.klaUCI, Wyscigi.dataP "
	       . " FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat "
	       . " WHERE Wyscigi.id_wys >= '$poczatek' AND Wyscigi.id_wys < '$koniec' "
               . " ORDER BY Wyscigi.nazwa, Wyscigi.id_wys, DATE(Wyscigi.dataP) ";
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig15">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig9">'.zwroc_tekst(124, $jezyk).'</td></tr>';
	  
	  
	  //echo $rok_teraz.' MMMM '.date('Y');
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    if ($rokteraz == date('Y')) {        
              $zap_opi = " SELECT Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, Wyniki.miejsce, Nat.flaga, Nat.nazwa
                           FROM Nat INNER JOIN(Kolarze INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Kolarze.id_nat = Nat.id_nat
                           WHERE ((Wyniki.id_wys = '$dane[0]')) 
			   ORDER BY Wyniki.miejsce
                           LIMIT 0 , 1";  
	      //echo 'cos tam 1';   
            } else {
              $zap_opi = " SELECT Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, WynikiP.miejsce, Nat.flaga, Nat.nazwa
                           FROM Nat INNER JOIN(Kolarze INNER JOIN WynikiP ON Kolarze.id_kol = WynikiP.id_kol) ON Kolarze.id_nat = Nat.id_nat
                           WHERE ((WynikiP.id_wys = '$dane[0]')) 
			   ORDER BY WynikiP.miejsce
                           LIMIT 0 , 1";
                           //echo 'cos tam 21';
            }
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
    
	    if (mysql_num_rows($idz_opi) > 0) {
	      $dan_opi = mysql_fetch_row($idz_opi);
	      $zapiskolarza = '<img src="http://fff.xon.pl/img/flagi/'.$dan_opi[4].'" alt="'.$dan_opi[5].'" /> <a href="kol.php?id_kol='.$dan_opi[2].'">'.$dan_opi[0].' <b>'.$dan_opi[1].'</b></a>';
	    } else { 
	      $zapiskolarza = '-';
	    }
	    
	    
	    
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt="'.$dane[2].'"/> <a href="wyscigetap.php?id_wys='.$dane[0].'&id_co=0">'.$dane[1].'</a></td><td>
	    '.$zapiskolarza.'</td></tr>
	    ';
          }  
          echo '</table><br/><br/>';
             
             
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
