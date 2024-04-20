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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(127, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  <?php    
	    
	    $nowe = $_GET['nowe'];
	    echo '<a href="trans.php?nowe=1">'.zwroc_tekst(140, $jezyk).'</a>';
	    
	    echo  '<h2>'.zwroc_tekst(127, $jezyk).'</h2><br/><br/><table class="wyscig" rules="all">
	          <tr><td class="wyscig=13"></td><td class="wyscig2">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig14">'.zwroc_tekst(128, $jezyk).'</td><td class="wyscig14">'.zwroc_tekst(129, $jezyk).'';
	  
	    echo '</td></tr>';
          
          
            if ($nowe == 1) {
	      //$sql = "SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy1.nazwa, Ekipy2.nazwa
              //      FROM Ekipy AS Ekipy2 INNER JOIN 
	//	    (Ekipy AS Ekipy1 
	//	    INNER JOIN (Nat 
	//	    INNER JOIN (z_a_historiakolprop 
	//	    INNER JOIN Kolarze ON z_a_historiakolprop.id_kol=Kolarze.id_kol) 
	//	    ON Kolarze.id_nat = Nat.id_nat) 
	//	    ON Ekipy1.id_team = z_a_historiakolprop.id_z)
	//	    ON Ekipy2.id_team = z_a_historiakolprop.id_do
	//	    
	//	    WHERE (z_a_historiakolprop.id_z <> z_a_historiakolprop.id_do)
	//	    ORDER BY z_a_historiakolprop.id_hk DESC, Kolarze.nazw, Kolarze.imie";
		    
              $sql = "SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy1.nazwa, Ekipy2.nazwa
                      FROM Ekipy AS Ekipy2, Ekipy AS Ekipy1, Nat, z_a_historiakolprop, Kolarze
		      WHERE z_a_historiakolprop.id_z <> z_a_historiakolprop.id_do AND Ekipy2.id_team = z_a_historiakolprop.id_do AND Ekipy1.id_team = z_a_historiakolprop.id_z AND z_a_historiakolprop.id_kol=Kolarze.id_kol AND Kolarze.id_nat = Nat.id_nat
		      ORDER BY z_a_historiakolprop.id_hk DESC, Kolarze.nazw, Kolarze.imie";
		    
		    
            } else {
	    //$sql = "SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy1.nazwa, Ekipy2.nazwa
            //        FROM Ekipy AS Ekipy2 INNER JOIN 
	//	    (Ekipy AS Ekipy1 
	//	    INNER JOIN (Nat 
	//	    INNER JOIN (z_a_historiakolprop 
	//	    INNER JOIN Kolarze ON z_a_historiakolprop.id_kol=Kolarze.id_kol) 
	//	    ON Kolarze.id_nat = Nat.id_nat) 
	//	    ON Ekipy1.id_team = z_a_historiakolprop.id_z)
	//	    ON Ekipy2.id_team = z_a_historiakolprop.id_do
	//	    
	//	    WHERE (z_a_historiakolprop.id_z <> z_a_historiakolprop.id_do)
	//	    ORDER BY z_a_historiakolprop.kiedy, Kolarze.nazw, Kolarze.imie";
	      
	      $sql = "SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy1.nazwa, Ekipy2.nazwa
                      FROM Ekipy AS Ekipy2, Ekipy AS Ekipy1, Nat, z_a_historiakolprop, Kolarze
		      WHERE z_a_historiakolprop.id_z <> z_a_historiakolprop.id_do AND Ekipy2.id_team = z_a_historiakolprop.id_do AND Ekipy1.id_team = z_a_historiakolprop.id_z AND z_a_historiakolprop.id_kol=Kolarze.id_kol AND Kolarze.id_nat = Nat.id_nat
		      ORDER BY z_a_historiakolprop.kiedy, Kolarze.nazw, Kolarze.imie";
	   }	    
		    
		//echo $sql;    
		    
	    $zap = mysql_query($sql) or die(mysql_error());
	    while ($dane = mysql_fetch_row($zap)) {
	      
	      $dzisiaj = date("Y");
	      $kiedys = strtotime($dane[3]);
	      $kiedys = date("Y", $kiedys);
	      
	      //echo $dane[3].'>>'.$dane[4].' <b>'.$dane[5].'</b> - '.$dane[1].'--'.$dane[2].'<br/>';
	      echo '<tr><td>'.$dane[3].'</td><td><img src="http://fff.xon.pl/img/flagi/'.$dane[6].'" /> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[4].' <b>'.$dane[5].'</b></a></td>
	            <td><a href="http://fff.xon.pl/SK/teamh.php?id_team='.$dane[1].'&rok='.$dzisiaj.'">'.$dane[7].'</a></td>
	            <td><a href="http://fff.xon.pl/SK/teamh.php?id_team='.$dane[2].'&rok='.$kiedys.'">'.$dane[8].'</td></tr>
	      ';
	      
	    }	    
	  
            echo '</table>';
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
