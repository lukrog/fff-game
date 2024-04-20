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
   <?php  // porównaj kolarzy
   ?>
   <title>SKARB KIBICA - <?php echo zwroc_tekst(118, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC"><br/>
	  <?php    
          $id_kol1 = $_GET['id_kol1'];
          $id_kol2 = $_GET['id_kol2'];
          if ($_GET['wszystko'] == "") {
	    $wszystko = "NIE";
	  } else {
	    $wszystko = $_GET['wszystko'];
	  }
	  
	  
	   
	   // pierwszy kolarz
	   
	   echo '<div style="float: left; width: 284px;">
	   
	   ';   
	   
	   $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , Kolarze.id_team, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_team, Kolarze.zdjecie
	            FROM z_z_tlumacz_nat, Ekipy, Nat, Kolarze
		    WHERE Kolarze.id_kol  = '$id_kol1' AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND Nat.id_nat = z_z_tlumacz_nat.id_nat
		    ";
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           echo '<b>'.$dane[0].' '.$dane[1].'</b>
	   
	   <table class="wyscig" rules="all">
	   <tr><td class="wyscig13"><i>'.zwroc_tekst(33, $jezyk).': </i></td><td class="wyscig8">'.$dane[2].'</td></tr>';
	   
	   $tescik = strtotime($dane[2]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
	   
	   echo '
	   <tr><td><i>'.zwroc_tekst(34, $jezyk).':</i></td><td>'.$tescik2.'
	   <tr><td><i>'.zwroc_tekst(79, $jezyk).': </i></td><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a></td></tr>
	   <tr><td></td><td><a href="kol.php?id_kol='.$id_kol1.'">'.zwroc_tekst(97, $jezyk).'</a></td></tr>
	   
	   </table>
	   
	   </div>';   
	    
	   // Drugi kolarz    
	       
	   echo '<div style="float: right; width: 284px;">
	   
	   ';   
	   
	   //$sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, User.id_user, Kolarze.zdjecie
	   //         FROM z_z_tlumacz_nat INNER JOIN (User INNER JOIN ( Ekipy INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) ON User.id_user = Kolarze.id_user) ON Nat.id_nat = z_z_tlumacz_nat.id_nat 
	   //         WHERE Kolarze.id_kol  = '$id_kol2' ";
		    
	   $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , Kolarze.id_team, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_team, Kolarze.zdjecie
	            FROM z_z_tlumacz_nat, Ekipy, Nat, Kolarze
		    WHERE Kolarze.id_kol  = '$id_kol2' AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND Nat.id_nat = z_z_tlumacz_nat.id_nat
		     ";	    
		    
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           echo '<b>'.$dane[0].' '.$dane[1].'</b>
	   
	   <table class="wyscig" rules="all">
	   <tr><td class="wyscig13"><i>'.zwroc_tekst(33, $jezyk).': </i></td><td class="wyscig8">'.$dane[2].'</td></tr>';
	   
	   $tescik = strtotime($dane[2]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
	   
	   echo '
	   <tr><td><i>'.zwroc_tekst(34, $jezyk).':</i></td><td>'.$tescik2.'
	   <tr><td><i>'.zwroc_tekst(79, $jezyk).': </i></td><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a></td></tr>
	   <tr><td></td><td><a href="kol.php?id_kol='.$id_kol2.'">'.zwroc_tekst(97, $jezyk).'</a></td></tr>
	   
	   </table>
	   
	   </div><div style="clear: both;"></div>
	   <br/><br/>';
	   
	   
	   if ($wszystko == "NIE") {
	      echo '<b><a href="http://fff.xon.pl/SK/porown.php?id_kol1='.$id_kol1.'&id_kol2='.$id_kol2.'&wszystko=tak">'.zwroc_tekst(135, $jezyk).'</a></b>
	   ';
	    } else {
	      echo '<b><a href="http://fff.xon.pl/SK/porown.php?id_kol1='.$id_kol1.'&id_kol2='.$id_kol2.'">'.zwroc_tekst(134, $jezyk).'</a></b>
	   ';
	    }
	   
	   
	   
	   echo '
	   ';
	   
	   echo '<h2>'.zwroc_tekst(136, $jezyk).'</h2>
	   
	   
	   <table class="wyscig" rules="all">
	   <tr><td class="wyscig1">Pos</td><td class="wyscig6">Wynik</td><td class="wyscig15">wyscig</td><td class="wyscig1">Pos;</td><td class="wyscig6">wynik</td></tr>
	   ';
	   
	   //$sqlpor = " SELECT Wyniki.id_wys , Wyniki.id_co
	   //            FROM Wyniki INNER JOIN Wyscigi ON Wyniki.id_wys = Wyscigi.id_wys
	//	       WHERE ((Wyniki.id_kol = '$id_kol1' OR Wyniki.id_kol = '$id_kol2') AND Wyniki.id_co <> 10 )
	//	       GROUP BY Wyniki.id_wys , Wyniki.id_co 
	//	       ORDER BY Wyscigi.dataP DESC, Wyniki.id_co";
	   
	   $sqlpor = " SELECT Wyniki.id_wys , Wyniki.id_co
	               FROM Wyniki, Wyscigi 
		       WHERE ((Wyniki.id_kol = '$id_kol1' OR Wyniki.id_kol = '$id_kol2') AND Wyniki.id_co <> 10 AND Wyniki.id_wys = Wyscigi.id_wys)
		       GROUP BY Wyniki.id_wys , Wyniki.id_co 
		       ORDER BY Wyscigi.dataP DESC, Wyniki.id_co";	       
		       
           $zappor = mysql_query($sqlpor) or die('mysql_query');
	   while ($danpor = mysql_fetch_row($zappor)) {
	     
	     if ($wszystko == "NIE") {
               $wynikkol1 = "NIE";
               $wynikkol2 = "NIE";
             } else {
	       $wynikkol1 = "TAK";
	       $wynikkol2 = "TAK";
	     }
             
	     $wiersztabeli = "";
	     
	     $sql1 = " SELECT miejsce, wynik
	               FROM Wyniki
		       WHERE id_wys='$danpor[0]' AND id_co='$danpor[1]' AND id_kol='$id_kol1' ";
	     $zap1 = mysql_query($sql1) or die('mysql_query');
	     $wiersztabeli = $wiersztabeli.'<tr><td>';
	     if (mysql_num_rows($zap1) == 0) {
	        $wiersztabeli = $wiersztabeli.'---</td><td>---</td><td>';
	     } else {
	       $dan1 = mysql_fetch_row($zap1);
	       
	       // czy wynik to s.t.
	       if ($dan1[1] == "s.t.") {
	          
	          $sql1aa = " SELECT wynik
	                      FROM Wyniki
		              WHERE (id_wys='$danpor[0]' AND id_co='$danpor[1]' AND wynik <> \"s.t.\" AND miejsce < '$dan1[0]' AND miejsce > 1) 
			      ORDER BY miejsce DESC";
                  //echo $sql1aa.'<br/>';
	          $zap1aa = mysql_query($sql1aa) or die('mysql_query');
	          if (mysql_num_rows($zap1aa) == 0) {
	            //brak innych wyników różnych od s.t.
	            $wynikkol1aa = "s.t."; 
	          } else {
	            // jest inny wynik to będzie $wynikkol1aa
	            $dan1aa = mysql_fetch_row($zap1aa);
	            $wynikkol1aa = $dan1aa[0];
	            
	           
	          }
		
	       } else {
	         // wynik od razu był inny od s.t.
	         $wynikkol1aa = $dan1[1];
	       }
	     
	       $wiersztabeli = $wiersztabeli.''.$dan1[0].'</td><td>'.$wynikkol1aa.'</td><td>';
	       $wynikkol1 = "TAK";    
	       
	     }
	     
	     
	     
	     
	     $sqlaaa = " SELECT Wyscigi.nazwa, Nat.flaga, Nat.nazwa
	                 FROM Wyscigi INNER JOIN Nat on Wyscigi.id_nat = Nat.id_nat
			 WHERE Wyscigi.id_wys = '$danpor[0]' ";
             $zapaaa = mysql_query($sqlaaa) or die('mysql_query');
             $danaaa = mysql_fetch_row($zapaaa);
	     
	     $ktoryetap = $danpor[1] + 10000;
	     
	     $sqlbbb = " SELECT z_Kategorie.jpg, z_EtapyKat.data
	                 FROM z_Kategorie INNER JOIN z_EtapyKat on z_EtapyKat.id_kat = z_Kategorie.id_kat
			 WHERE z_EtapyKat.id_co = '$danpor[1]' AND z_EtapyKat.id_wys = '$danpor[0]' ";
             $zapbbb = mysql_query($sqlbbb) or die('mysql_query');
             if (mysql_num_rows($zapbbb) == 0) {
                $jpg = "brak.jpg";
                $data = "";
             } else {
	       $danbbb = mysql_fetch_row($zapbbb);
	       $jpg = $danbbb[0];
	       $data = $danbbb[1];
	     }
             
             
	     
	     $wiersztabeli = $wiersztabeli.'<img src="http://fff.xon.pl/SK/graf/typetapu/'.$jpg.'" alt="kat." style="width: 18px; height: 18px;" /> <img src="http://fff.xon.pl/img/flagi/'.$danaaa[1].'" alt="'.$danaaa[2].'" /> <a href="wyscigetap.php?id_wys='.$danpor[0].'&id_co='.$danpor[1].'">'.$danaaa[0].' - '.zwroc_tekst($ktoryetap, $jezyk).'</a> ('.$data.')</td><td>';
	     
	     $sql2 = " SELECT miejsce, wynik
	               FROM Wyniki
		       WHERE id_wys='$danpor[0]' AND id_co='$danpor[1]' AND id_kol='$id_kol2' ";
	     $zap2 = mysql_query($sql2) or die('mysql_query');
	     if (mysql_num_rows($zap2) == 0) {
	       $wiersztabeli = $wiersztabeli.'---</td><td>---</td></tr>';
	     } else {
	       $dan2 = mysql_fetch_row($zap2);
	       
	       // czy wynik to s.t.
	       if ($dan2[1] == "s.t.") {
	          
	          $sql2aa = " SELECT wynik
	                      FROM Wyniki
		              WHERE (id_wys='$danpor[0]' AND id_co='$danpor[1]' AND wynik <> \"s.t.\" AND miejsce < '$dan2[0]' AND miejsce > 1) 
			      ORDER BY miejsce DESC";
                  //echo $sql2aa.'<br/>';
	          $zap2aa = mysql_query($sql2aa) or die('mysql_query');
	          if (mysql_num_rows($zap2aa) == 0) {
	            //brak innych wyników różnych od s.t.
	            $wynikkol2aa = "s.t."; 
	          } else {
	            // jest inny wynik to będzie $wynikkol1aa
	            $dan2aa = mysql_fetch_row($zap2aa);
	            $wynikkol2aa = $dan2aa[0];
	            
	           
	          }
		
	       } else {
	         // wynik od razu był inny od s.t.
	         $wynikkol2aa = $dan2[1];
	       }
	       
	       
	       
	       $wiersztabeli = $wiersztabeli.''.$dan2[0].'</td><td>'.$wynikkol2aa.'</td></tr>';
	       $wynikkol2 = "TAK";
	     }
	     	       
	     if ($wynikkol1 == "TAK" AND $wynikkol2 == "TAK") {
	       echo $wiersztabeli.'
	       ';
	     }
	     
	     
	     
	   }
	   
	   echo '</table><br/><br/>
	   
	   ';
	   
           if ($wszystko == "NIE") {
             
             echo '<h2>'.zwroc_tekst(137, $jezyk).'</h2>
	   
	   
	   <table class="wyscig" rules="all">
	   <tr><td class="wyscig1">Pos</td><td class="wyscig6">Wynik</td><td class="wyscig15">wyscig</td><td class="wyscig1">Pos;</td><td class="wyscig6">wynik</td></tr>
	   ';
	   
	   $sqlpor = " SELECT WynikiP.id_wys , WynikiP.id_co
	               FROM WynikiP INNER JOIN Wyscigi ON WynikiP.id_wys = Wyscigi.id_wys
		       WHERE WynikiP.id_kol = '$id_kol1' OR WynikiP.id_kol = '$id_kol2' 
		       GROUP BY WynikiP.id_wys , WynikiP.id_co 
		       ORDER BY Wyscigi.dataP DESC, WynikiP.id_co";
           $zappor = mysql_query($sqlpor) or die('mysql_query');
	   while ($danpor = mysql_fetch_row($zappor)) {
	     
	     if ($wszystko == "NIE") {
               $wynikkol1 = "NIE";
               $wynikkol2 = "NIE";
             } else {
	       $wynikkol1 = "TAK";
	       $wynikkol2 = "TAK";
	     }
             
	     $wiersztabeli = "";
	     
	     $sql1 = " SELECT miejsce, wynik
	               FROM WynikiP
		       WHERE id_wys='$danpor[0]' AND id_co='$danpor[1]' AND id_kol='$id_kol1' ";
	     $zap1 = mysql_query($sql1) or die('mysql_query');
	     $wiersztabeli = $wiersztabeli.'<tr><td>';
	     if (mysql_num_rows($zap1) == 0) {
	        $wiersztabeli = $wiersztabeli.'---</td><td>---</td><td>';
	     } else {
	       $dan1 = mysql_fetch_row($zap1);
	       $wiersztabeli = $wiersztabeli.''.$dan1[0].'</td><td>'.$dan1[1].'</td><td>';
	       $wynikkol1 = "TAK";
	     }
	     
	     $sqlaaa = " SELECT Wyscigi.nazwa, Nat.flaga, Nat.nazwa
	                 FROM Wyscigi INNER JOIN Nat on Wyscigi.id_nat = Nat.id_nat
			 WHERE Wyscigi.id_wys = '$danpor[0]' ";
             $zapaaa = mysql_query($sqlaaa) or die('mysql_query');
             $danaaa = mysql_fetch_row($zapaaa);
	     
	     $ktoryetap = $danpor[1] + 10000;
	     
	     $sqlbbb = " SELECT z_Kategorie.jpg, z_EtapyKat.data
	                 FROM z_Kategorie INNER JOIN z_EtapyKat on z_EtapyKat.id_kat = z_Kategorie.id_kat
			 WHERE z_EtapyKat.id_co = '$danpor[1]' AND z_EtapyKat.id_wys = '$danpor[0]' ";
             $zapbbb = mysql_query($sqlbbb) or die('mysql_query');
             if (mysql_num_rows($zapbbb) == 0) {
                $jpg = "brak.jpg";
                $data = "";
             } else {
	       $danbbb = mysql_fetch_row($zapbbb);
	       $jpg = $danbbb[0];
	       $data = $danbbb[1];
	     }
             
             
	     
	     $wiersztabeli = $wiersztabeli.'<img src="http://fff.xon.pl/SK/graf/typetapu/'.$jpg.'" alt="kat." style="width: 18px; height: 18px;" /> <img src="http://fff.xon.pl/img/flagi/'.$danaaa[1].'" alt="'.$danaaa[2].'" /> <a href="wyscigetap.php?id_wys='.$danpor[0].'&id_co='.$danpor[1].'">'.$danaaa[0].' - '.zwroc_tekst($ktoryetap, $jezyk).'</a> ('.$data.')</td><td>';
	     
	     $sql2 = " SELECT miejsce, wynik
	               FROM WynikiP
		       WHERE id_wys='$danpor[0]' AND id_co='$danpor[1]' AND id_kol='$id_kol2' ";
	     $zap2 = mysql_query($sql2) or die('mysql_query');
	     if (mysql_num_rows($zap2) == 0) {
	       $wiersztabeli = $wiersztabeli.'---</td><td>---</td></tr>';
	     } else {
	       $dan2 = mysql_fetch_row($zap2);
	       $wiersztabeli = $wiersztabeli.''.$dan2[0].'</td><td>'.$dan2[1].'</td></tr>';
	       $wynikkol2 = "TAK";
	     }
	     	       
	     if ($wynikkol1 == "TAK" AND $wynikkol2 == "TAK") {
	       echo $wiersztabeli.'
	       ';
	     }
	     
	     
	     
	   }
	   
	   echo '</table><br/><br/>
	   
	   ';
             
             
             
           }
           
           
	       
	  ?>
	   <br/> <br/>
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
