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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(56, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	   <div id="TRESC">
	   
	  <?php 
	  $id_team = $_GET['id_team'];
	  //$zap = "SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Ekipy.liga, Nat.id_nat 
	  //        FROM z_z_tlumacz_nat INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Nat.id_nat = z_z_tlumacz_nat.id_nat
   	  //        WHERE Ekipy.id_team= '$id_team'
	  //	  ";
	  
	  $zap = "SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Ekipy.liga, Nat.id_nat 
	          FROM z_z_tlumacz_nat, Nat, Ekipy 
	          WHERE Ekipy.id_team= '$id_team' AND Nat.id_nat = Ekipy.id_kraj AND Nat.id_nat = z_z_tlumacz_nat.id_nat
		  ";
	  
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  echo '<br/>
	    
	    <h1>'.$dane[1].' ('.$dane[2].')</h1>
	    
	    ';
	    
	  $zapdanedod = "SELECT id_team, koszulka, adres, email, www, sponsor, zdjecie_ek, opis, manager, dyrSpo, asys, lek, mas, mech
	                 FROM z_e_infoekipy 
			 WHERE id_team = '$id_team' ";
	  $idzdanedod = mysql_query($zapdanedod) or die('mysql_query');
	  
	  if (mysql_num_rows($idzdanedod) == 0) {
             $i=1;
             while ($i <= 14) {
	       $danedod[$i] = "";
	       $i++;
	     }
          } else {
  	     $danedod = mysql_fetch_row($idzdanedod);
	  }
	  echo '<div><div style="float: right; width: 250px;">
	   
	   
	   ';
	   if ($danedod[1] <> "") {
	      echo '<img src="'.$danedod[1].'" alt="koszulka" align=right style="padding-right: 20px;" />
	   ';
	   }
	   
	   echo '
	   
	   </div><div style="float: left;">
	   ';  
	  $ekipa = $dane[1];  
	  echo '<table class="wyscig" rules="all"> 
	    
	    <tr><td class="wyscig13"><i>'.zwroc_tekst(17, $jezyk).'</i></td><td class="wyscig9">'.$dane[1].' </td></tr>
	    <tr><td><i>'.zwroc_tekst(18, $jezyk).'</i></td><td>'.$dane[2].'</td></tr>
	    <tr><td></td></tr>
	    <tr><td><i>'.zwroc_tekst(23, $jezyk).'</i></td><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="nat.php?id_nat='.$dane[6].'">'.$dane[3].'</a> </td></tr>
	    <tr><td><i>'.zwroc_tekst(24, $jezyk).'</i></td><td>'.$dane[5].'</td></tr>
          ';
          $roczek = date('Y');
          echo '<tr><td><i>'.zwroc_tekst(25, $jezyk).'</i></td><td><a href="teamh.php?id_team='.$id_team.'&rok='.$roczek.'">'.zwroc_tekst(26, $jezyk).'</a></td></tr>
	  ';
          $roczek = $roczek + 1;
          echo '<tr><td><i>'.zwroc_tekst(25, $jezyk).'</i></td><td><a href="teamh.php?id_team='.$id_team.'&rok='.$roczek.'">'.zwroc_tekst(27, $jezyk).'</a></td></tr>
          ';
	  if ($danedod[2] <> "") {
	  echo '<tr><td><i>'.zwroc_tekst(28, $jezyk).'</i></td><td>'.$danedod[2].'</td></tr>
          ';
	  }
	  if ($danedod[3] <> "") {
	  echo '<tr><td><i>'.zwroc_tekst(29, $jezyk).'</i></td><td>'.$danedod[3].'</td></tr>
          ';
	  }
	  if ($danedod[4] <> "") {
	  echo '<tr><td><i>'.zwroc_tekst(30, $jezyk).'</i></td><td><a href="'.$danedod[4].'" >'.$danedod[4].'</a></td></tr>
          ';
	  }
	  if ($danedod[5] <> "") {
	  echo '<tr><td><i>'.zwroc_tekst(31, $jezyk).'</i></td><td>'.$danedod[5].'</td></tr>
	  ';
	  }
          echo '
	  </table>
	  </div><div style="clear: both;"> </div></div>
	  
	  <br/><br/>
	  ';
          
          
	  echo '<table class="wyscig" rules="all">
	  <tr><td class="wyscig2">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(33, $jezyk).'</td><td class="wyscig1">'.zwroc_tekst(34, $jezyk).'
	  </td></tr>
	    ';
         
          
          $pocz = 1000 * (date("Y")-2000);
	  $kon = 1000 * (date("Y")+1-2000);
          
          


          //$zap = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, Sum(Wyniki.punkty)
          //         FROM Wyniki RIGHT JOIN (Nat INNER JOIN (Kolarze INNER JOIN User ON Kolarze.id_user = User.id_user ) On Nat.id_nat = Kolarze.id_nat) ON Wyniki.id_kol = Kolarze.id_kol 
	//	   WHERE Kolarze.id_team= '$id_team'
	//	   GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, User.login, User.id_user
	//	   ORDER BY Kolarze.nazw ";   
               
          $zap = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, Kolarze.punkty
                   FROM Nat, Kolarze 
		   WHERE Kolarze.id_team= '$id_team' AND Nat.id_nat = Kolarze.id_nat
		   ORDER BY Kolarze.nazw, Kolarze.imie ";        
               
               
	  $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {

  	    $tescik = strtotime($dane[4]);
            $tescik = date("Y",$tescik);
            $tescik1 = strtotime(date("Y-m-d"));
            $tescik1 = date("Y",$tescik1);
            $tescik2 = $tescik1 - $tescik;
  	    
            echo '<tr><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt="flaga"/> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a></td>
	    <td>'.$dane[4].'</td><td>'.$tescik2.'</td>
	    </tr>';
            
	  
	  }
	  echo '
	  
	  
	  
	  ';
	  
	  //if ($danedod[7] <> "") {
	  //echo '
	  //<tr><td><b>'.zwroc_tekst(35, $jezyk).'</b></td><td></td></tr>
	  //<tr><td>'.$danedod[7].'</td><td></td></tr>
	  //';
	  //}
	  
	  if ($danedod[8] <> "") {
	  echo '
	  <tr><td><b>'.zwroc_tekst(35, $jezyk).'</b></td><td></td></tr>
	  <tr><td>'.$danedod[8].'</td><td></td></tr>
	  ';
	  }
	  if ($danedod[9] <> "") {
	  echo '
	  <tr><td><b>'.zwroc_tekst(36, $jezyk).'</b></td><td></td></tr>
	  <tr><td>'.$danedod[9].'</td><td></td></tr>
	  ';
	  }
	  if ($danedod[10] <> "") {
	  echo '
	  <tr><td><b>'.zwroc_tekst(38, $jezyk).'</b></td><td></td></tr>
	  <tr><td>'.$danedod[10].'</td><td></td></tr>
	  ';
	  }
	  if ($danedod[11] <> "") {
	  echo '
	  <tr><td><b>'.zwroc_tekst(39, $jezyk).'</b></td><td></td></tr>
	  <tr><td>'.$danedod[11].'</td><td></td></tr>
	  ';
	  }
	  if ($danedod[12] <> "") {
	  echo '
	  <tr><td><b>'.zwroc_tekst(40, $jezyk).'</b></td><td></td></tr>
	  <tr><td>'.$danedod[12].'</td><td></td></tr>
	  ';
	  }
	  if ($danedod[13] <> "") {
	  echo '
	    <tr><td><b>'.zwroc_tekst(41, $jezyk).'</b></td><td></td></tr>
	    <tr><td>'.$danedod[13].'</td><td></td></tr>
	    ';
	  }
 
 
	  echo '
	  
	  ';
	  
	  
          echo '</table><br/>
	    <div style="float: center; padding-right: 20px; text-align: justify;">
	    ';
	    
	  if ($jezyk == "PL") {
	  if ($danedod[7] <> "") {
	  echo '
	    '.$danedod[7].'
	    
	    ';
	  }
          }
	    
	  
	  
	  if ($danedod[6] <> "") {
	    echo '
	    <img src="'.$danedod[6].'" alt="ekipa" style="width: 550px;" />
	    ';
	  }
	  
	  //-------------------------------------------
	  //              Wyniki kolarzy
	  //-------------------------------------------
	  echo '<h2>'.zwroc_tekst(153, $jezyk).'</h2>';
	  
	  $zmianamiejsca = 0;
	  $zapytko = " SELECT Wyniki.miejsce, Wyniki.id_co, Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Wyscigi.id_wys, Wyscigi.nazwa, Co.nazwa, waznosc_wyscigow.waznosc
                       FROM Wyniki, Kolarze, waznosc_wyscigow, Wyscigi, Co
                       WHERE Kolarze.id_team = '$id_team' AND Kolarze.id_kol=Wyniki.id_kol AND Wyniki.miejsce < 21 AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI AND Wyscigi.id_wys = Wyniki.id_wys AND Wyniki.id_co = Co.id_co
		       ORDER BY miejsce, waznosc_wyscigow.waznosc, Wyniki.id_co, DATE(Wyscigi.dataP) DESC ";
	  $idzapytko = mysql_query($zapytko) or die(mysql_error());          
          while ($danzap = mysql_fetch_row($idzapytko)) {
	    if ($danzap[0] <> $zmianamiejsca) {
              if ($danzap[0] == 1) {
	        echo '<h3>'.zwroc_tekst(150, $jezyk).'</h3>'; 
		$zmianamiejsca=1;
	      }
              elseif ($danzap[0] == 2) {
	        echo '<h3>'.zwroc_tekst(151, $jezyk).'</h3>'; 
		$zmianamiejsca=2;
	      }
              elseif ($danzap[0] == 3) {
		if ($zmianamiejsca == 1) {echo '<h3>'.zwroc_tekst(151, $jezyk).'</h3>';}
		$zmianamiejsca=3;
	      }
              elseif ($danzap[0] >= 4) {
	        if (($zmianamiejsca < 4) AND ($zmianamiejsca > 0)) {
		  echo '<h3>'.zwroc_tekst(152, $jezyk).'</h3>'; 
		}
		$zmianamiejsca=5;
	      } else {
	        
	      }
	    }
	    
	    
	    
	    if ((($danzap[1] > 100) AND ($danzap[0] <= 10)) OR (($danzap[1] < 8) AND ($danzap[0] <= 20)) ) {
	      //----------------------------------------------------
	      //            Gdy na etapie to do 10 miejsca
	      //             W generalce to do 20 miejsca
	      //----------------------------------------------------
	      
	      if (($danzap[8] < 35) AND ($danzap[1] == 0)) {
	        echo '<b>';
	      } 
	      
	      echo $danzap[0]; //miesce
	      if ($jezyk == "EN") {
	        if ($danzap[0] == 1) {
	          echo 'st';
	        } elseif ($danzap[0] == 2) {
	          echo 'nd';
	        } elseif ($danzap[0] == 1) {
	          echo 'rd';
	        } else {
	          echo 'th';
	        } 
	     } elseif ($jezyk = "PL") {
	       echo '.';
	     }
	     echo ' '.zwroc_tekst(87, $jezyk).' '; 
	      
	     if ($danzap[1] == 0) {
                echo zwroc_tekst(88, $jezyk);
             } elseif ($danzap[1] == 1){
                echo zwroc_tekst(88, $jezyk).' '.zwroc_tekst(92, $jezyk);
             } elseif ($danzap[1] == 2){
                echo zwroc_tekst(88, $jezyk).' '.zwroc_tekst(93, $jezyk);
             } elseif ($danzap[1] == 1000){
                echo zwroc_tekst(89, $jezyk).' '.zwroc_tekst(11000, $jezyk);
	        if ($jezyk == "PL") {
	           echo 'u';
	        } elseif ($jezyk == "EN") {
	           echo ' of';
                }
             } else {
                echo zwroc_tekst(89, $jezyk).' '.zwroc_tekst(90, $jezyk).' '.substr($danzap[7], 5).'.';
             } 
	     echo ' '.$danzap[6].' ('.$danzap[3].' '.$danzap[4].')';
	     if (($danzap[8] < 35) AND ($danzap[1] == 0)) {
	         echo '</b>';
	     } 
	     echo '<br/>';
	    
	    }
	    
	    
	  }
	  
	  
	  
	  echo'<br/></div>
	    <div style="clear: both;"> </div>
	    <div style="float: center; text-align: center;">
	    ';
	    
          echo '
	  <br/>
	  
	  </div>
	  <div style="clear: both;"> </div>
	  <br/>All photos: '.$ekipa.'<br/>
	  ';
	  ?>   
	      
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
