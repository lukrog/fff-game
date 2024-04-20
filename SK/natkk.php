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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(23, $jezyk); ?> - <?php echo zwroc_tekst(22, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php    
           
          $id_nat = $_GET['id_nat'];
    
	  $zap = "SELECT z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Nat.skr 
	  FROM Nat INNER JOIN z_z_tlumacz_nat ON Nat.id_nat = z_z_tlumacz_nat.id_nat
	  WHERE (((Nat.id_nat)= '$id_nat' ))";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
	  
          echo '<h1>'.$dane[0].'</h1>
	  '.zwroc_tekst(22, $jezyk).'<br/>';
          echo '<img src="http://fff.xon.pl/img/flagi/'.$dane[1].'" alt="flaga - '.$dane[0].'"/> ('.$dane[2].') <br/>
	  <a href="nat.php?id_nat='.$id_nat.'">'.zwroc_tekst(58, $jezyk).'</a>
	  
	  <br/><br/>';
          
             
          $poczatek = 1000 * (date("Y")-2000);
	  $koniec = 1000 * (date("Y")+1-2000);
	     
          
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig4">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig4">'.zwroc_tekst(59, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(33, $jezyk).'</td></tr>';
          $zap = "SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.dataU, Ekipy.nazwa, Ekipy.id_team 
	  FROM Nat INNER JOIN (Kolarze INNER JOIN Ekipy ON Ekipy.id_team = Kolarze.id_team) ON Nat.id_nat = Kolarze.id_nat 
	  WHERE (((Kolarze.id_nat)= '$id_nat' ) AND ((Kolarze.id_team = 1000) )) 
	  ORDER BY Kolarze.nazw " ;
	  $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    
  	    
            echo '<tr><td><a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a></td>
	    <td>';
	    $sqlhis = " SELECT id_kol, id_z, id_do, kiedy, YEAR(kiedy), MONTH(kiedy), DAY(kiedy) "
                   . " FROM z_a_historiakol "
	           . " WHERE id_kol = '$dane[0]' "
		   . " ORDER BY kiedy DESC ";
	    $zaphis = mysql_query($sqlhis) or die('mysql_query');
	    
	    //echo mysql_num_rows($zaphis);
	    
	    if (mysql_num_rows($zaphis) == 0) {
               echo zwroc_tekst(60, $jezyk);
            } else {
               $zaphis = mysql_query($sqlhis) or die('mysql_query');
               $danhis = mysql_fetch_row($zaphis);
               //$koniec_kariery_rok = $danhis[3];
	       
               $danhis = mysql_fetch_row($zaphis);
               $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga "
                     . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	             . " WHERE (z_a_historiaekip.id_ek = '$danhis[2]') AND (z_a_historiaekip.rok = '$danhis[4]') ";
	       $zaphise = mysql_query($sqlhise) or die('mysql_query');
	       $danhise = mysql_fetch_row($zaphise);
	       echo '<img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" alt="flaga" /> '.$danhise[0].' - '.$danhis[4].' ('.$danhise[2].') - '.$danhise[3].' <br/>';
            }
	    
	    
	    echo '</td>
	    <td>'.$dane[4].'</td></tr>';
          }
          echo '</table>
	  
	  <br/>';
          
	  
	  
	  
	   
           
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
