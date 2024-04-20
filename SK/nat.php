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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(23, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  <?php    
           
          $id_nat = $_GET['id_nat'];
    
	  $zap = "SELECT z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Nat.skr 
	          FROM Nat, z_z_tlumacz_nat 
	          WHERE Nat.id_nat = '$id_nat' AND Nat.id_nat = z_z_tlumacz_nat.id_nat";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
	  
          echo '<h1>'.$dane[0].'</h1>';
          echo '<img src="http://fff.xon.pl/img/flagi/'.$dane[1].'" alt="flaga - '.$dane[0].'"/> ('.$dane[2].')<br/>
	  
	  <a href="natkk.php?id_nat='.$id_nat.'">'.zwroc_tekst(55, $jezyk).'</a>
	  <br/><br/><br/>';
          
             
          $poczatek = 1000 * (date("Y")-2000);
	  $koniec = 1000 * (date("Y")+1-2000);
	     
          
          echo '<table class="wyscig" rules="all"';
          echo '<tr><td class="wyscig4">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig8">'.zwroc_tekst(56, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(33, $jezyk).'</td></tr>';
          //$zap = "SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.dataU, Ekipy.nazwa, Ekipy.id_team 
	  //        FROM Nat INNER JOIN (Kolarze INNER JOIN Ekipy ON Ekipy.id_team = Kolarze.id_team) ON Nat.id_nat = Ekipy.id_kraj 
	  //        WHERE (((Kolarze.id_nat)= '$id_nat' ) AND ((Kolarze.id_team <> 1000) )) 
	  //        ORDER BY Kolarze.nazw " ;
	          
	  $zap = "SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.dataU, Ekipy.nazwa, Ekipy.id_team 
	          FROM Nat, Kolarze, Ekipy  
	          WHERE Kolarze.id_nat= '$id_nat' AND Kolarze.id_team <> 1000 AND  Nat.id_nat = Ekipy.id_kraj AND Ekipy.id_team = Kolarze.id_team
	          ORDER BY Kolarze.nazw " ;        
	          
	  $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    
  	    
            echo '<tr><td> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a></td>
	    <td>';
	    
	    if ($dane[7]==0) {
               echo ''.zwroc_tekst(57, $jezyk).'';
            } elseif ($dane[7] == 1001) {
               echo ''.zwroc_tekst(21, $jezyk).''; 
            }  else {
	       echo '<img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" /> <a href="team.php?id_team='.$dane[7].'">'.$dane[6].'</a>';
	    }
	    
	    echo '</td>
	    <td>'.$dane[4].'</td></tr>';
          }
          echo '</table>';
          
	  
	  
	  
	   
           
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
