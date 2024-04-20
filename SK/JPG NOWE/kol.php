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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(32, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	   <div id="TRESC">
	   <?php    
           $id_kol = $_GET['id_kol'];
	  
	   $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, User.id_user, Kolarze.zdjecie
	            FROM z_z_tlumacz_nat, User, Ekipy, Nat, Kolarze
		    WHERE Kolarze.id_kol = '$id_kol' AND Nat.id_nat = z_z_tlumacz_nat.id_nat AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user
		     ";
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           echo '<h1>'.$dane[0].' '.$dane[1].'</h1>';
           
           $zapdanedod = "SELECT id_kol, wzrost, waga, zdjecie, zawodow, www
	                 FROM z_e_infokol 
			 WHERE id_kol = '$id_kol' ";
	   $idzdanedod = mysql_query($zapdanedod) or die('mysql_query');
	  
	   if (mysql_num_rows($idzdanedod) == 0) {
             $i=1;
             while ($i <= 6) {
	       $danedod[$i] = "";
	       $i++;
	     }
           } else {
  	     $danedod = mysql_fetch_row($idzdanedod);
	   }
           
           
           
	   echo '<div><div style="float: right; width: 240px;">';
	   
	   
	   if ($danedod[3] == "") {
             echo '
	     <img src="'.$dane[10].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right style="padding-right: 20px;" /><br/>
	     ';
           } else {
             echo '
	     <img src="'.$danedod[3].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right style="padding-right: 20px;" /><br/>
	     ';
           }
	   
	   
	   echo '
	   </div><div style="float: left;">
	   ';
	   
	   echo '<table class="wyscig" rules="all">
	   <tr><td class="wyscig13"><i>'.zwroc_tekst(33, $jezyk).': </i></td><td class="wyscig9">'.$dane[2].'</td></tr>';
	   
	   //echo ' > '.$dane[2];
	   $tescik5 = strtotime($dane[2]);	   
           $tescik = date("Y",$tescik5);	   
	   $tescik1 = strtotime(date("Y-m-d"));
           
	   //to tylko do TdP
	   $dzis = date("Y-m-d");
	   $tescik6 = strtotime("2015-08-02");
	   $tescik6 = strtotime($dzis);
           $tescik1 = date("Y",$tescik6);
           
           $tescik2 = $tescik1 - $tescik;
           
          
	  $am =  date("m",$tescik5);
	  $ad =  date("d",$tescik5);
	  $bm =  date("m",$tescik6);
	  $bd =  date("d",$tescik6);
	  
	  //echo $am.' - '.$ad.' / '.$bm.' - '.$bd.' ';
	   
	   
	  if (($bm < $am) OR (($bd < $ad) AND ($bm == $am))) {
	    $wiek = $tescik2-1;
	    //echo 'odjąć';
	  } else {
	    $wiek = $tescik2;
	    //echo 'nie zmień';
	  }
           
	   
	   echo '
	   <tr><td><i>'.zwroc_tekst(34, $jezyk).':</i></td><td>'.$wiek.'
	   <tr><td><i>'.zwroc_tekst(79, $jezyk).': </i></td><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a></td></tr>
	   <tr><td><i>'.zwroc_tekst(56, $jezyk).': </i></td><td><a href="team.php?id_team='.$dane[7].'">';
	   
	   if ($dane[7] == 1000) {
              echo zwroc_tekst(22, $jezyk);
	   } elseif ($dane[7] == 1001) {
              echo zwroc_tekst(21, $jezyk);
	   } elseif ($dane[7] == 0) {
              echo zwroc_tekst(57, $jezyk);
           } else {
	      echo $dane[5];
	   }  
	   echo '</a></td></tr>
	   
	   ';
           
           if ($danedod[1] <> "") {
	   echo '<tr><td><i>'.zwroc_tekst(80, $jezyk).': </i></td><td>'.$danedod[1].'</td></tr>
           ';
	   }
           if ($danedod[2] <> "") {
	   echo '<tr><td><i>'.zwroc_tekst(81, $jezyk).': </i></td><td>'.$danedod[2].'</td></tr>
           ';
	   }
           if ($danedod[4] <> "") {
	   echo '<tr><td><i>'.zwroc_tekst(82, $jezyk).': </i></td><td>'.$danedod[4].'</td></tr>
           ';
	   }
	   if ($danedod[5] <> "") {
	   echo '<tr><td><i>'.zwroc_tekst(30, $jezyk).': </i></td><td><a href="'.$danedod[5].'">'.$danedod[5].'</a></td></tr>
           ';
	   }
           
           
           echo '
	   
	   </table>
	   </div><div style="clear: both;"> </div></div>
	     
	    <br/> ';
	  
	  
	  
	  
	  
          $roczek = date('Y');
	  $roczek1 = $roczek -1;
	  echo '<table class="szaretlo" rules="all"> ';
	  echo '<tr><td>'.zwroc_tekst(15, $jezyk).'</td><td class="wyscig3">  </td><td>'.zwroc_tekst(14, $jezyk).' </td></tr> ';
	  echo '<tr><td>';
          
	  $sqlMAX = " SELECT MAX(Cli), MAX(Hil), MAX(Fl), MAX(Spr), MAX(Cbl), MAX(TT) "
	           . " FROM z_ranking ";
	  $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	  $danMAX = mysql_fetch_row($zapMAX);
	  
	  $sql2007 = " SELECT id_kol, Cli, CliM, Hil, HilM, Fl, FlM, Spr, SprM, Cbl, CblM, TT, TTM "
	           . " FROM z_ranking "
	           . " WHERE id_kol = '$id_kol' ";
	  $zap2007 = mysql_query($sql2007) or die('mysql_query');
	  $dan2007 = mysql_fetch_row($zap2007);
	  
	  for ($j=0; $j<6; $j++) {
	    if ($danMAX[$j] == 0) {$danMAX[$j]=1;}
	  }
	  $clipr = $dan2007[1] / $danMAX[0] * 100;
	  $hilpr = $dan2007[3] / $danMAX[1] * 100;
	  $flpr = $dan2007[5] / $danMAX[2] * 100;
	  $sprpr = $dan2007[7] / $danMAX[3] * 100;
	  $cblpr = $dan2007[9] / $danMAX[4] * 100;
	  $TTpr = $dan2007[11] / $danMAX[5] * 100;

	  echo '<table> ';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingikro.php?sort=1&limit1='.($dan2007[2]-5).'&limit2='.($dan2007[2]+5).'&zazn='.$dan2007[2].'>Cli</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/cliT.jpg"><img src="http://fff.xon.pl/img/ranking/cli.jpg" style="width: '.round(2*$clipr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingikro.php?sort=2&limit1='.($dan2007[4]-5).'&limit2='.($dan2007[4]+5).'&zazn='.$dan2007[4].'>Hil</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/hilT.jpg"><img src="http://fff.xon.pl/img/ranking/hil.jpg" style="width: '.round(2*$hilpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingikro.php?sort=3&limit1='.($dan2007[6]-5).'&limit2='.($dan2007[6]+5).'&zazn='.$dan2007[6].'>Fl</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/flT.jpg"><img src="http://fff.xon.pl/img/ranking/fl.jpg" style="width: '.round(2*$flpr).'px; height: 14px;"/></td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingikro.php?sort=4&limit1='.($dan2007[8]-5).'&limit2='.($dan2007[8]+5).'&zazn='.$dan2007[8].'>Spr</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/sprT.jpg"><img src="http://fff.xon.pl/img/ranking/spr.jpg" style="width: '.round(2*$sprpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingikro.php?sort=5&limit1='.($dan2007[10]-5).'&limit2='.($dan2007[10]+5).'&zazn='.$dan2007[10].'>Cbl</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/cblT.jpg"><img src="http://fff.xon.pl/img/ranking/cbl.jpg" style="width: '.round(2*$cblpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingikro.php?sort=6&limit1='.($dan2007[12]-5).'&limit2='.($dan2007[12]+5).'&zazn='.$dan2007[12].'>TT</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/ttT.jpg"><img src="http://fff.xon.pl/img/ranking/tt.jpg" style="width: '.round(2*$TTpr).'px; height: 14px;"/> </td></tr>';
	  echo '</table> ';


          echo '</td><td>  </td><td>';
          
          
          $sqlMAX = " SELECT MAX(Cli), MAX(Hil), MAX(Fl), MAX(Spr), MAX(Cbl), MAX(TT) "
	           . " FROM z_ranking2 ";
	  $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	  $danMAX = mysql_fetch_row($zapMAX);
	  
	  $sql2007 = " SELECT id_kol, Cli, CliM, Hil, HilM, Fl, FlM, Spr, SprM, Cbl, CblM, TT, TTM "
	           . " FROM z_ranking2 "
	           . " WHERE id_kol = '$id_kol' ";
	  $zap2007 = mysql_query($sql2007) or die('mysql_query');
	  $dan2007 = mysql_fetch_row($zap2007);
	  
	  for ($j=0; $j<6; $j++) {
	    if ($danMAX[$j] == 0) {$danMAX[$j]=1;}
	  }
	  $clipr = $dan2007[1] / $danMAX[0] * 100;
	  $hilpr = $dan2007[3] / $danMAX[1] * 100;
	  $flpr = $dan2007[5] / $danMAX[2] * 100;
	  $sprpr = $dan2007[7] / $danMAX[3] * 100;
	  $cblpr = $dan2007[9] / $danMAX[4] * 100;
	  $TTpr = $dan2007[11] / $danMAX[5] * 100;
	  
	  
	  
	  echo '<table> ';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingib.php?sort=1&limit1='.($dan2007[2]-5).'&limit2='.($dan2007[2]+5).'&zazn='.$dan2007[2].'>Cli</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/cliT.jpg"><img src="http://fff.xon.pl/img/ranking/cli.jpg" style="width: '.round(2*$clipr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingib.php?sort=2&limit1='.($dan2007[4]-5).'&limit2='.($dan2007[4]+5).'&zazn='.$dan2007[4].'>Hil</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/hilT.jpg"><img src="http://fff.xon.pl/img/ranking/hil.jpg" style="width: '.round(2*$hilpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingib.php?sort=3&limit1='.($dan2007[6]-5).'&limit2='.($dan2007[6]+5).'&zazn='.$dan2007[6].'>Fl</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/flT.jpg"><img src="http://fff.xon.pl/img/ranking/fl.jpg" style="width: '.round(2*$flpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingib.php?sort=4&limit1='.($dan2007[8]-5).'&limit2='.($dan2007[8]+5).'&zazn='.$dan2007[8].'>Spr</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/sprT.jpg"><img src="http://fff.xon.pl/img/ranking/spr.jpg" style="width: '.round(2*$sprpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingib.php?sort=5&limit1='.($dan2007[10]-5).'&limit2='.($dan2007[10]+5).'&zazn='.$dan2007[10].'>Cbl</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/cblT.jpg"><img src="http://fff.xon.pl/img/ranking/cbl.jpg" style="width: '.round(2*$cblpr).'px; height: 14px;"/> </td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingib.php?sort=6&limit1='.($dan2007[12]-5).'&limit2='.($dan2007[12]+5).'&zazn='.$dan2007[12].'>TT</a></td><td class="rankingd" background="http://fff.xon.pl/img/ranking/ttT.jpg"><img src="http://fff.xon.pl/img/ranking/tt.jpg" style="width: '.round(2*$TTpr).'px; height: 14px;"/> </td></tr>';
	  echo '</table> ';




          echo '</td></tr>';
          echo '</table>';


	  echo '<a href="#skr"><font style="font-size: 10px;">* - '.zwroc_tekst(75, $jezyk).'</font></a>
	        <br/><br/>
	       ';
	  
          
          
          
          
          
          
          
          
          
          
          //---------------------------------------
          //    Najlepsze wyniki kolarza
          //---------------------------------------
          $ile_zwycięstw = 0;
          $ile_osiagniec = 0;
          // chcemy mieć wszystkie wyniki zwycięstwa.
          // i max 15??? z 2 i dalej miejscami.
          
          echo '<h2>'.zwroc_tekst(1020, $jezyk).'</h2>';
          
          //Osiągnięcia kolarza.
	  //
	  //Najpierw wyrzucamy zwycięstwa (generalka)
	  
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), Wyscigi.id_wys, Wyscigi.id_nat
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig
		   WHERE WynikiALL.id_kol='$id_kol' 
		      AND Wyscigi.id_wys = WynikiALL.id_wys 
		      AND Nat.id_nat = Wyscigi.id_nat 
		      AND Co.id_co = WynikiALL.id_co 
		      AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI 
		      AND WynikiALL.miejsce = 1 AND WynikiALL.id_co = 0 
		      AND Wyscigi.id_wys = z_a_historiawyscig.id_wys
	           ORDER BY z_a_historiawyscig.id_hiswys, waznosc_wyscigow.waznosc, WynikiALL.id_co, Wyscigi.dataP DESC";
	  //echo $sql_osiagniecia.' <- test1 <br/>';	   
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    
	    //$dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	    //na razie wypisz wszystko
	    
	    //Sprawdzamy czy w historii były takie przypadki:
	    $sql_hiswys = "SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE id_wys = '$dane_osiagniecia[3]' ";
	    //echo $sql_hiswys;
	    $idzapytania_hiswys = mysql_query($sql_hiswys) or die(mysql_error());
	    $dane_hiswys = mysql_fetch_row($idzapytania_hiswys);
	    
	    $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' AND z_a_historiawyscig.id_hiswys='$dane_hiswys[0]' AND WynikiALL.id_co=0 AND WynikiALL.miejsce=1 AND z_a_historiawyscig.id_wys = WynikiALL.id_wys";
	   //echo '<br/>'.$sql_czy_byly;
	    $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
            $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	    
	    //echo ' ---0--- '.$dane_czy_byly[0].'kkkkkkkkkkkkkk<br/>';
	    
	    if ($dane_czy_byly[0] > 1) {
	      echo $dane_czy_byly[0].'x ';
	      $ile_zwycięstw = $ile_zwycięstw + $dane_czy_byly[0];
	      // wypisujemy tylko raz ale daty wklepujemy czyli	      
	    } else {
	      $ile_zwycięstw = $ile_zwycięstw + 1;
	    }
	    
	       
 	  
	   echo zwroc_tekst(1021, $jezyk).' '.zwroc_tekst(88, $jezyk);
	    
	    //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane_osiagniecia[3]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($reszta_z_dzielenia == 780) {
             echo ' '.zwroc_tekst(1000, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 781)  {
             echo ' '.zwroc_tekst(1001, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 782)  {
             echo ' '.zwroc_tekst(1002, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 783)  {
             echo ' '.zwroc_tekst(1003, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 784)  {
             echo ' '.zwroc_tekst(1004, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 788)  {
             echo ' '.zwroc_tekst(1005, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 789)  {
             echo ' '.zwroc_tekst(1006, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 790)  {
             echo ' '.zwroc_tekst(1007, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 791)  {
             echo ' '.zwroc_tekst(1008, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 794)  {
             echo ' '.zwroc_tekst(1009, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 795)  {
             echo ' '.zwroc_tekst(1010, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezyk).'
	     ';
	     //sprawdzam kraj
	     
	     if ($jezyk == "PL") {
	       echo zwroc_tekst_nat($dane_osiagniecia[4], "PLdop");
	     } else {
	       echo zwroc_tekst_nat($dane_osiagniecia[4], $jezyk);
	     }
	     
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
	    
	    
	    if ($dane_czy_byly[0] > 1) {
	      
	      echo ' ('.$dane_osiagniecia[2].'';
	        
	        
	      for ($il1=1; $il1<$dane_czy_byly[0]; $il1++) {
	        //teraz robimy myk bo dodajemy różne daty:
	        
	        
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        echo ', '.$dane_osiagniecia[2].'';
	      }
	      echo ')<br/>';
	      
	      
	    }  else {
	      //echo '1st place in ';
	      echo ' ('.$dane_osiagniecia[2].')<br/>';
	    }
	    

	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	   

	  
	  
	  $ile_zwycięstw_etap = 0; 
	  
	  
	  //-----------------------------------------
	  //teraz wyrzucamy zwycięstwa (etapy)
	  //-----------------------------------------
	  
	  
	  //                                    0          1        2                 3                     4                             5    
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), WynikiALL.id_wys, z_a_historiawyscig.id_hiswys, Wyscigi.klaUCI
	  
	                       FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig 
			       WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys
			          AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co 
				  AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI 
				  AND WynikiALL.miejsce = 1 AND WynikiALL.id_co > 100
				  AND Wyscigi.id_wys = z_a_historiawyscig.id_wys
				  
			       ORDER BY z_a_historiawyscig.id_hiswys, waznosc_wyscigow.waznosc, Wyscigi.dataP DESC, WynikiALL.id_co";
			       
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    
	    //sprawdzamy czy na tym wyścigu było więcej wyników takich:
	    $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' AND z_a_historiawyscig.id_hiswys='$dane_osiagniecia[4]' 
			       AND WynikiALL.id_co>100 AND WynikiALL.miejsce=1 
			       AND z_a_historiawyscig.id_wys = WynikiALL.id_wys
			     ";
	    $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
            $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	    
	    echo zwroc_tekst(1021, $jezyk).' '.zwroc_tekst(89, $jezyk).' ';
	    
	    if ($dane_czy_byly[0] > 1) {
	      //kilka wygranych etapów                                                        ['.$dane_osiagniecia[5].']
	      echo $dane_czy_byly[0].' '.zwroc_tekst(1022, $jezyk).' '.$dane_osiagniecia[0].' ';
	      
	      $ile_zwycięstw_etap = $ile_zwycięstw_etap + $dane_czy_byly[0];
	      
	      echo ' ('.$dane_osiagniecia[2].'';
	      //teraz trzeba przeskoczyć tyle ile etapów wygrał
	      
	      
	      
	      for ($ile=1;$ile<$dane_czy_byly[0];$ile++){
	        $data_wpisana_juz_roku = $dane_osiagniecia[2];
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        
	        if ($data_wpisana_juz_roku == $dane_osiagniecia[2]) {
	          echo '';
		} else {
		  echo ', '.$dane_osiagniecia[2];
		}
		
	        
	      }
	      echo ') ';
	    } else {
	      echo zwroc_tekst(90, $jezyk).' '.$dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')';
	      $ile_zwycięstw_etap = $ile_zwycięstw_etap + 1;
	    }
	    echo '<br/>';
	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	  
	  //---------------------------------------------
	  //Wrzucamy zwycięstwa (klasyfikacje)
	  //---------------------------------------------
	  
	  
          $ile_zwycięstw_kla = 0;   
	  
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), Wyscigi.id_wys, Wyscigi.id_nat
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL
		   WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI AND WynikiALL.miejsce = 1 AND (WynikiALL.id_co > 0 AND WynikiALL.id_co < 10)
	           ORDER BY waznosc_wyscigow.waznosc, Wyscigi.dataP DESC ";
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
            //$dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	    //na razie wypisz wszystko
	    
	    //Sprawdzamy czy w historii były takie przypadki:
	    $sql_hiswys = "SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE id_wys = '$dane_osiagniecia[3]' ";
	    //echo $sql_hiswys;
	    $idzapytania_hiswys = mysql_query($sql_hiswys) or die(mysql_error());
	    $dane_hiswys = mysql_fetch_row($idzapytania_hiswys);
	    
	    $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' AND z_a_historiawyscig.id_hiswys='$dane_hiswys[0]' AND WynikiALL.id_co='$dane_osiagniecia[1]' AND WynikiALL.miejsce=1 AND z_a_historiawyscig.id_wys = WynikiALL.id_wys";
	   //echo '<br/>'.$sql_czy_byly;
	    $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
            $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	    
	    //echo ' ---0--- '.$dane_czy_byly[0].'kkkkkkkkkkkkkk<br/>';
	    
	    if ($dane_czy_byly[0] > 1) {
	      echo $dane_czy_byly[0].'x ';
	      $ile_zwycięstw_kla = $ile_zwycięstw_kla + $dane_czy_byly[0];
	    } else {
	      $ile_zwycięstw_kla = $ile_zwycięstw_kla + 1;
	    }
	    
	    
	    echo zwroc_tekst(1021, $jezyk).' '.zwroc_tekst(88, $jezyk);
	   





	    //echo '1. miejsce w klasyfikacji ';
	    
	    if ($dane_osiagniecia[1] == 1) {
	      echo ' '.zwroc_tekst(92, $jezyk).' ';
	    } else {
	      echo ' '.zwroc_tekst(93, $jezyk).' ';
	    }
	    
	    echo $dane_osiagniecia[0];
	    
	     if ($dane_czy_byly[0] > 1) {
	      
	      echo ' (';
	      
	      echo $dane_osiagniecia[2].'';
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        
	      for ($il1=1; $il1<$dane_czy_byly[0]; $il1++) {
	        //teraz robimy myk bo dodajemy różne daty:
	        
	        echo ' '.$dane_osiagniecia[2].'';
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        
	      }
	      echo ')<br/>';
	      
	      
	    } else {
	      //echo '1st place in ';
	      echo ' ('.$dane_osiagniecia[2].')<br/>';
	    }
	    
	    
	    
	    //echo $dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')<br/>';
	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	 	   
	  //echo 'osiągnięć: '.$ile_osiagniec.'<br/>';
	   
	  
	  
	  //------------------------------------------------------------------------------------------------
	  //A teraz dorzucamy jeśli potrzeba wyniki z 2 i dalej miejsc wg punktów :D w generalce 
	  //------------------------------------------------------------------------------------------------
	  
	  
	  $ile_jeszcze = 15 - $ile_osiagniec;
	  if ($ile_jeszcze <= 0) {$ile_jeszcze = 0;}
	  
	  
	  //                                0           1              2                    3               4                5                    6
	  $sql_osiagniecia = "SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), WynikiALL.miejsce, Wyscigi.id_wys, Wyscigi.id_nat, z_a_historiawyscig.id_hiswys
	                      FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig
			      WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys 
			         AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co 
				 AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI AND WynikiALL.miejsce > 1 
				 AND ((WynikiALL.id_co > 100 AND WynikiALL.miejsce <= 3) OR (WynikiALL.id_co = 0 AND WynikiALL.miejsce <= 10)) 
				 AND Wyscigi.id_wys = z_a_historiawyscig.id_wys      
			      ORDER BY WynikiALL.miejsce, waznosc_wyscigow.waznosc, z_a_historiawyscig.id_hiswys, Wyscigi.dataP DESC, WynikiALL.id_co  
		   ";
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 15 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    //na razie wypisz wszystko
	    
	    
	    
	    
	    
	    //sprawdzamy czy to etap czy co
	    if ($dane_osiagniecia[1] > 100) {
	      echo $dane_osiagniecia[3].'';
	      
	      
	      if ($jezyk == "EN") {
	          if ($dane_osiagniecia[3] == 2) {
	          echo 'nd';
	        } elseif ($dane_osiagniecia[3] == 3) {
	          echo 'rd';
	        } else {
	          echo 'th';
	        } 
	    
	        echo ' ';
	      } elseif ($jezyk == "PL") {
	        echo '. ';
	      }
	      
	      echo zwroc_tekst(1024, $jezyk).' ';
	      
	      
	      
	      
	      $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' 
			       AND z_a_historiawyscig.id_hiswys='$dane_osiagniecia[6]' 
			       AND WynikiALL.id_co>100 AND WynikiALL.miejsce='$dane_osiagniecia[3]' 
			       AND WynikiALL.id_wys = z_a_historiawyscig.id_wys";
	      $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
              $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	   
	      if ($dane_czy_byly[0] > 1) {
	      //kilka wygranych etapów
	      echo $dane_czy_byly[0].' '.zwroc_tekst(1022, $jezyk).' '.$dane_osiagniecia[0];
	      
	      
	      echo ' ('.$dane_osiagniecia[2].'';
	      //teraz trzeba przeskoczyć tyle ile etapów wygrał
	      
	      $data_wpisana_juz_roku = $dane_osiagniecia[2];
	      
	      for ($ile=1;$ile<$dane_czy_byly[0];$ile++){
	        $data_wpisana_juz_roku = $dane_osiagniecia[2];
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        
	        if ($data_wpisana_juz_roku <> $dane_osiagniecia[2]) {
	          echo ', '.$dane_osiagniecia[2];
		}
		
	        
	      }
	      echo ') <br/>';
	    } else {
	        echo zwroc_tekst(90, $jezyk).' '.$dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')<br/>';
	      }
	      

	    } else {
	      
              
	      
	      $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' 
			       AND z_a_historiawyscig.id_hiswys='$dane_osiagniecia[6]' 
			       AND WynikiALL.id_co=0 AND WynikiALL.miejsce='$dane_osiagniecia[3]' 
			       AND WynikiALL.id_wys = z_a_historiawyscig.id_wys";
	      $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
              $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	      
	      if ($dane_czy_byly[0] > 1) {
	        echo $dane_czy_byly[0].'x ';
	      }
	      
	      echo $dane_osiagniecia[3];
	      
	    
	      if ($jezyk == "EN") {
	          if ($dane_osiagniecia[3] == 2) {
	          echo 'nd';
	        } elseif ($dane_osiagniecia[3] == 3) {
	          echo 'rd';
	        } else {
	          echo 'th';
	        } 
	    
	        echo ' ';
	      } elseif ($jezyk == "PL") {
	        echo '. ';
	      }
	      
	      echo zwroc_tekst(1023, $jezyk).' ';
	      
	      
	      //echo '. miejsce w ';
	      
	    //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane_osiagniecia[4]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($reszta_z_dzielenia == 780) {
             echo ' '.zwroc_tekst(1000, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 781)  {
             echo ' '.zwroc_tekst(1001, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 782)  {
             echo ' '.zwroc_tekst(1002, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 783)  {
             echo ' '.zwroc_tekst(1003, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 784)  {
             echo ' '.zwroc_tekst(1004, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 788)  {
             echo ' '.zwroc_tekst(1005, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 789)  {
             echo ' '.zwroc_tekst(1006, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 790)  {
             echo ' '.zwroc_tekst(1007, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 791)  {
             echo ' '.zwroc_tekst(1008, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 794)  {
             echo ' '.zwroc_tekst(1009, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 795)  {
             echo ' '.zwroc_tekst(1010, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezyk).'
	     ';
	     //sprawdzam kraj
	     
	     if ($jezyk == "PL") {
	       echo zwroc_tekst_nat($dane_osiagniecia[5], "PLdop");
	     } elseif ($jezyk == "EN" ) {
	       echo zwroc_tekst_nat($dane_osiagniecia[5], "EN");
	     }
	     
	     
	   
	   
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
	    
	    if ($dane_czy_byly[0] > 1) {
	      
	      echo ' ('.$dane_osiagniecia[2].'';
	        
	        
	      for ($il1=1; $il1<$dane_czy_byly[0]; $il1++) {
	        //teraz robimy myk bo dodajemy różne daty:
	        
	        
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        echo ', '.$dane_osiagniecia[2].'';
	      }
	      echo ') <br/>';
	      
	      
	    }  else {

	      echo ' ('.$dane_osiagniecia[2].') <br/>';
	    }
	    
	  }
	    $ile_osiagniec = $ile_osiagniec + 1;
	  } 
	  if  ($ile_osiagniec < 6) {
	    //trzeba dobić do 6 osiągnięć
	    $max=6 - $ile_osiagniec;
	    
	    //echo $max.' <- max ';
	    
	    for ($il=0;$il<$max;$il++) {
	      echo ' <br/>';
	    }
	  } 
          
          
          
          
          
          $ile_zwyciestw_suma = $ile_zwycięstw + $ile_zwycięstw_etap + $ile_zwycięstw_kla;
          echo '<br/><br/>
	  
	  '.zwroc_tekst(1030, $jezyk).':
          <br/>
          
	  <b>'.$ile_zwyciestw_suma.'</b> = '.$ile_zwycięstw.' <i>('.zwroc_tekst(1031, $jezyk).')</i> + '.$ile_zwycięstw_etap.' <i>('.zwroc_tekst(1032, $jezyk).')</i> + '.$ile_zwycięstw_kla.' <i>('.zwroc_tekst(1033, $jezyk).')</i><br/><br/>';
          
          
          
          
          
          //----------------------/
	  //  przyszłość kolarza  /
	  //----------------------/
	  
	  $sqlhis = " SELECT id_kol, id_z, id_do, kiedy, YEAR(kiedy), MONTH(kiedy), DAY(kiedy) "
                  . " FROM z_a_historiakolprop "
	          . " WHERE id_kol = '$id_kol' "
		  . " ORDER BY kiedy DESC ";
	  $zaphis = mysql_query($sqlhis) or die('mysql_query');
	  
          
	  if (mysql_num_rows($zaphis) > 0) {
	    
	  echo '<h2>'.zwroc_tekst(83, $jezyk).':</h2>';
	  echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig6">'.zwroc_tekst(84, $jezyk).'</td><td class="wyscig7">'.zwroc_tekst(56, $jezyk).'</td></tr>';
          
	  while ($danhis = mysql_fetch_row($zaphis))
	  {
	    if ($danhis[4] > date("Y")) {
               $rokteraz = date("Y");
            } else {
               $rokteraz = $danhis[4]; 
            }	    
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga "
                     . " FROM z_a_historiaekip, Nat "
	             . " WHERE z_a_historiaekip.id_ek = '$danhis[2]' AND z_a_historiaekip.rok = '$rokteraz' AND z_a_historiaekip.id_nat = Nat.id_nat ";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
	    $danhise = mysql_fetch_row($zaphise);
	    
	    
	    if (($danhis[5] > 1) OR ($danhis[6] > 1)) {
	      echo '<tr><td>'.$danhis[3];
	    } else {
              echo '<tr><td>'.$danhis[4];
            }  
	    echo '</td><td><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" alt="flaga" /> <a href=teamh.php?id_team='.$danhis[2].'&rok=';
	    
	    
	    if ($danhis[2] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	    } elseif ($danhis[2] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	    } elseif ($danhis[2] == 0) {
                     echo zwroc_tekst(57, $jezyk);
            } else {
	             echo $danhis[4];
	    }  
	    
	    echo '>'.$danhise[0],'</a> ('.$danhise[2].') - '.$danhise[3].'</td><td>';
	    
	    
          }
	  echo '
                </table>';
                
          }
          
          //--------------------/
	  //  historia kolarza  /
	  //--------------------/
	  echo '<h2>'.zwroc_tekst(85, $jezyk).'</h2>';
	  echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig6">'.zwroc_tekst(84, $jezyk).'</td><td class="wyscig7">'.zwroc_tekst(56, $jezyk).'</td></tr>';
          
	  $sqlhis = " SELECT id_kol, id_z, id_do, kiedy, YEAR(kiedy), MONTH(kiedy), DAY(kiedy) "
                  . " FROM z_a_historiakol "
	          . " WHERE id_kol = '$id_kol' "
		  . " ORDER BY kiedy DESC ";
	  $zaphis = mysql_query($sqlhis) or die('mysql_query');
	  while ($danhis = mysql_fetch_row($zaphis))
	  {
	    	    
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga "
                     . " FROM z_a_historiaekip, Nat "
	             . " WHERE z_a_historiaekip.id_ek = '$danhis[2]' AND z_a_historiaekip.rok = '$danhis[4]' AND z_a_historiaekip.id_nat = Nat.id_nat ";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
	    $danhise = mysql_fetch_row($zaphise);
	    
	    
	    if (($danhis[5] > 1) OR ($danhis[6] > 1)) {
	      echo '<tr><td>'.$danhis[3];
	    } else {
              echo '<tr><td>'.$danhis[4];
            }  
	    echo '</td><td><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" alt="flaga" /> <a href=teamh.php?id_team='.$danhis[2].'&rok='.$danhis[4].'>';
	    
	    if ($danhis[2] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	    } elseif ($danhis[2] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	    } elseif ($danhis[2] == 0) {
                     echo zwroc_tekst(57, $jezyk);
            } else {
	             echo $danhise[0];
	    }  
	    
	    echo '</a> ('.$danhise[2].') - '.$danhise[3];
	    
	    //jeżeli transfer 1 sierpnia to stażysta
	    if (($danhis[5] == 8) and ($danhis[6] == 1)) {
	      echo " (".zwroc_tekst(1034, $jezyk).")";
	    }
	    
	    echo '</td><td>
	    ';
	    
	    
          }
	  echo '
                </table>';
          if ($_SESSION['boss'] >= 1) { 
             
            echo '<a href=\'http://fff.xon.pl/kol_edyt.php?id_kol='.$id_kol.'\'>DODAJ TRANSFER</a>
      
            '; 
	  }
	  
	  //--------------------------/
	  //         WYNIKI           /
	  //--------------------------/
          echo '<h2>'.zwroc_tekst(86, $jezyk).'</h2>';
          //                    0              1          2            3            4              5                6                 7                 8            9                10                                 
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, Wyniki.miejsce, Wyniki.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), Wyniki.wynik, Co.id_co, waznosc_wyscigow.waznosc
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, Wyniki
		   WHERE Wyniki.id_kol='$id_kol' AND Wyscigi.id_wys = Wyniki.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = Wyniki.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI
	           ORDER BY Wyniki.miejsce, waznosc_wyscigow.waznosc, Co.id_co, DATE(Wyscigi.dataP) DESC ";
	       
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          while ($dane = mysql_fetch_row($idzapytania))
          {
           
            if (($dane[9] == 10)) {
              
           } else {
             
           // Jeżeli | generalka	       jeśli ważnosć 10 [IO MŚ] to piersza 25                                            jeśli waż=30 [Tour Vuelta Giro]           ważność = 35 [Mistz. Kraj]         ważność 40 [Młodzieżowe mistrz]       ważność 80 [to Pro Tuoury monumenty]        waż 90 [HC] czyli piątka                waż 100 [x.1] pierwsza 3                waż 110 [x.2] [pierwsza 3]             waż 120 [wyścigi młodzieżowe]            wszystkie pozostałe dajemy
	   //                                                                   Jeśli waż=20 [MŚ TTT] to 3 miejsce                to pierwsza 30                         to pierwsza 25                      dajemy pierwszą 20                     leci 10 albo 7                                                                                                                                                      dajemy 10                               tylko zwyciężcę
	     if ((($dane[9] == 0) AND ((($dane[10]==10) AND ($dane[4]<=25)) OR (($dane[10]==20) AND ($dane[4]<=3)) OR (($dane[10]==30) AND ($dane[4]<=30)) OR (($dane[10]==35) AND ($dane[4]<=5)) OR (($dane[10]==40) AND ($dane[4]<=20)) OR (($dane[10]==80) AND ($dane[4]<=20)) OR (($dane[10]==90) AND ($dane[4]<=15)) OR (($dane[10]==100) AND ($dane[4]<=10)) OR (($dane[10]==110) AND ($dane[4]<=5)) OR (($dane[10]==120) AND ($dane[4]<=15))  OR (($dane[10]>120) AND ($dane[4]<=3)) )) 
	  
	   // Jeżeli zaś etap                 Waż 30 [toury] pierwsza 5              waż = 80 [PT] to podium                  waż 90 [x.HC]  zwycięzca               waż 100 [x.1] zwycięzca                ważność 110 x.2  zwyciężca          waż 120 [młodzież]  zwycięzca           w pozostałych nie podajemy
                OR (($dane[9] > 0) AND (($dane[10]==30) AND ($dane[4]<=15)) OR (($dane[10]==80) AND ($dane[4]<=10)) OR (($dane[10]==90) AND ($dane[4]<=5)) OR (($dane[10]==100) AND ($dane[4]<=3)) OR (($dane[10]==110) AND ($dane[4]<=3)) OR (($dane[10]==120) AND ($dane[4]<=3)) OR (($dane[10]>120) AND ($dane[4]<=1))   )) {
	     
           //if ((($dane[9] < 8) AND ($dane[4] <= 20)) OR (($dane[9] > 100) AND ($dane[4] <= 10)) ) {
	   
	   if (($dane[10] < 35) AND ($dane[9] == 0))
	   { echo '<b>';} 
	   //echo $dane[10].' - '.$dane[9].' -> ';
	   //miejsce
 	   echo $dane[4];
 	   if ($jezyk == "EN") {
	      if ($dane[4] == 1) {
	        echo 'st';
	      } elseif ($dane[4] == 2) {
	        echo 'nd';
	      } elseif ($dane[4] == 1) {
	        echo 'rd';
	      } else {
	        echo 'th';
	      } 
	   } elseif ($jezyk = "PL") {
	     echo '.';
	   }
	    
	   
	    
	   echo ' '.zwroc_tekst(87, $jezyk).' ';
	   
	   //tu testowo obrazek jaki to był etap.
           $sqliop = " SELECT z_Kategorie.skrot, z_Kategorie.jpg
	               FROM z_Kategorie, z_EtapyKat 
		       WHERE id_wys = '$dane[6]' AND id_co = '$dane[9]' AND z_Kategorie.id_kat=z_EtapyKat.id_kat ";
	   $zapiop = mysql_query($sqliop) or die(mysql_error());
	   if (mysql_num_rows($zapiop)== 0) {
	     $typetapu = "brak.jpg";
	   } else {
	     $daniop = mysql_fetch_row($zapiop);        
	     $typetapu = $daniop[1];
	   } 
           
           echo '<img src="graf/typetapu/'.$typetapu.'" alt="" style="width: 10px; height: 10px;" /> '; 
	   
	   
	   if ($dane[9] == 0) {
              echo zwroc_tekst(88, $jezyk);
           } elseif ($dane[9] == 1){
              echo zwroc_tekst(88, $jezyk).' '.zwroc_tekst(92, $jezyk);
           } elseif ($dane[9] == 2){
              echo zwroc_tekst(88, $jezyk).' '.zwroc_tekst(93, $jezyk);
           } elseif ($dane[9] == 1000){
              echo zwroc_tekst(89, $jezyk).' '.substr($dane[3], 1);
	      if ($jezyk == "PL") {
	        echo 'u';
	      } elseif ($jezyk == "EN") {
	        echo ' of';
              }
           } else {
              echo zwroc_tekst(89, $jezyk).' '.zwroc_tekst(90, $jezyk).' '.substr($dane[3], 5).'.';
           }
           
           
           
           
           
           
           
           //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane[6]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($reszta_z_dzielenia == 780) {
             echo ' '.zwroc_tekst(1000, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 781)  {
             echo ' '.zwroc_tekst(1001, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 782)  {
             echo ' '.zwroc_tekst(1002, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 783)  {
             echo ' '.zwroc_tekst(1003, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 784)  {
             echo ' '.zwroc_tekst(1004, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 788)  {
             echo ' '.zwroc_tekst(1005, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 789)  {
             echo ' '.zwroc_tekst(1006, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 790)  {
             echo ' '.zwroc_tekst(1007, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 791)  {
             echo ' '.zwroc_tekst(1008, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 794)  {
             echo ' '.zwroc_tekst(1009, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 795)  {
             echo ' '.zwroc_tekst(1010, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezyk).'
	     ';
	     //sprawdzam kraj
	     $sql_kraj = "SELECT `id_nat` FROM `Nat` WHERE `flaga`= '$dane[1]'";
	     $zap_kraj = mysql_query($sql_kraj) or die('mysql_query');
	     $dan_kraj = mysql_fetch_row($zap_kraj);
	   
	   //echo $dan_kraj[0].' <br/>';
	   
	   if ($jezyk == "EN") {
	     echo zwroc_tekst_nat($dan_kraj[0], "EN"); 
	   } elseif ($jezyk = "PL") {
	     echo zwroc_tekst_nat($dan_kraj[0], "PLdop");
	   }
	   $gg = strlen($dane[0]) - 2;
	   $gg1 = substr($dane[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane[0].'
	     ';
	   }
	   
	   if (($dane[10] < 35) AND ($dane[9] == 0))
	   { echo '</b>';}
	   
	   echo ' ('.$dane[2].') 
	   <br/>';
           
           
           
          }
         }
        }
           $sqlMAX =  " SELECT COUNT(Wyniki.punkty)  "
	            . " FROM Wyniki "
 		    . " WHERE (Wyniki.id_kol = '$id_kol') AND (Wyniki.id_co <> 10) ";
	   $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	   $danMAX = mysql_fetch_row($zapMAX);
	   $rokteraz1 = date("Y");
	   echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rokteraz1.'">'.zwroc_tekst(95, $jezyk).'</a> ('.$danMAX[0].'.)<br/>';


          $sezonnowy = 1; 
          $rok_poprzedni = 0;
          echo '<h2>'.zwroc_tekst(91, $jezyk).'</h2>';
          //                 0			1	2		3	4			5		6		7		8		9		10			11    
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, WynikiP.miejsce, WynikiP.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), WynikiP.wynik, Co.id_co, waznosc_wyscigow.waznosc, YEAR(Wyscigi.dataP)
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiP
		   WHERE WynikiP.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiP.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiP.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI
		   ORDER BY YEAR(Wyscigi.dataP) DESC, WynikiP.miejsce, waznosc_wyscigow.waznosc, Co.id_co ";     
	       
	       
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          //echo '<table class="wyscig" rules="all">';
          //echo '<tr><td class="wyscig7">Nazwa</td><td class="wyscig6">w czym</td><td class="wyscig6">miejsce</td><td class="wyscig6">punkty</td></tr>';
          while ($dane = mysql_fetch_row($idzapytania))
          {
           //echo  $rok_poprzedni.'--------------->'.$dane[11];
           if ($rok_poprzedni <> $dane[11]) {
              if ($sezonnowy == 0) {
                  $sqlMAX =  " SELECT COUNT(WynikiP.punkty)
		               FROM WynikiP INNER JOIN Wyscigi ON WynikiP.id_wys = Wyscigi.id_wys
			       WHERE (WynikiP.id_kol = '$id_kol') AND (WynikiP.id_co <> 10) AND (YEAR(Wyscigi.dataP) = '$rok_poprzedni') ";
		   
	          $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	          $danMAX = mysql_fetch_row($zapMAX);
                  echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezyk).'</a> ('.$danMAX[0].')<br/>';
                  $sezonnowy = 0;
	      } else {$sezonnowy = 0;}
              echo '<h3>'.zwroc_tekst(94, $jezyk).' '.$dane[11].' </h3>';
           }

	   if (($dane[9] == 10)) {
              
           } else {
             
           // Jeżeli | generalka	       jeśli ważnosć 10 [IO MŚ] to piersza 25                                            jeśli waż=30 [Tour Vuelta Giro]           ważność = 35 [Mistz. Kraj]         ważność 40 [Młodzieżowe mistrz]       ważność 80 [to Pro Tuoury monumenty]        waż 90 [HC] czyli piątka                waż 100 [x.1] pierwsza 3                waż 110 [x.2] [pierwsza 3]             waż 120 [wyścigi młodzieżowe]            wszystkie pozostałe dajemy
	   //                                                                   Jeśli waż=20 [MŚ TTT] to 3 miejsce                to pierwsza 30                         to pierwsza 25                      dajemy pierwszą 20                     leci 10 albo 7                                                                                                                                                      dajemy 10                               tylko zwyciężcę
	     if ((($dane[9] == 0) AND ((($dane[10]==10) AND ($dane[4]<=25)) OR (($dane[10]==20) AND ($dane[4]<=3)) OR (($dane[10]==30) AND ($dane[4]<=30)) OR (($dane[10]==35) AND ($dane[4]<=5)) OR (($dane[10]==40) AND ($dane[4]<=20)) OR (($dane[10]==80) AND ($dane[4]<=20)) OR (($dane[10]==90) AND ($dane[4]<=15)) OR (($dane[10]==100) AND ($dane[4]<=10)) OR (($dane[10]==110) AND ($dane[4]<=5)) OR (($dane[10]==120) AND ($dane[4]<=15))  OR (($dane[10]>120) AND ($dane[4]<=3)) )) 
	  
	   // Jeżeli zaś etap                 Waż 30 [toury] pierwsza 5              waż = 80 [PT] to podium                  waż 90 [x.HC]  zwycięzca               waż 100 [x.1] zwycięzca                ważność 110 x.2  zwyciężca          waż 120 [młodzież]  zwycięzca           w pozostałych nie podajemy
                OR (($dane[9] > 0) AND (($dane[10]==30) AND ($dane[4]<=15)) OR (($dane[10]==80) AND ($dane[4]<=10)) OR (($dane[10]==90) AND ($dane[4]<=5)) OR (($dane[10]==100) AND ($dane[4]<=3)) OR (($dane[10]==110) AND ($dane[4]<=3)) OR (($dane[10]==120) AND ($dane[4]<=3)) OR (($dane[10]>120) AND ($dane[4]<=1))   )) {
	     
           //if ((($dane[9] < 8) AND ($dane[4] <= 20)) OR (($dane[9] > 100) AND ($dane[4] <= 10)) ) {
	     

	   
	   if (($dane[11] < 35) AND ($dane[9] == 0))
	   { echo '<b>';} 
	   
	  
 	   echo $dane[4];
 	   if ($jezyk == "EN") {
	      if ($dane[4] == 1) {
	        echo 'st';
	      } elseif ($dane[4] == 2) {
	        echo 'nd';
	      } elseif ($dane[4] == 1) {
	        echo 'rd';
	      } else {
	        echo 'th';
	      } 
	   } elseif ($jezyk = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezyk).' ';
	   
	   
	   //tu testowo obrazek jaki to był etap.
           $sqliop = " SELECT z_Kategorie.skrot, z_Kategorie.jpg
	               FROM z_Kategorie, z_EtapyKat 
		       WHERE id_wys = '$dane[6]' AND id_co = '$dane[9]' AND z_Kategorie.id_kat=z_EtapyKat.id_kat ";
	   $zapiop = mysql_query($sqliop) or die(mysql_error());
	   if (mysql_num_rows($zapiop)== 0) {
	     $typetapu = "brak.jpg";
	   } else {
	     $daniop = mysql_fetch_row($zapiop);        
	     $typetapu = $daniop[1];
	   } 
           
           echo '<img src="graf/typetapu/'.$typetapu.'" alt="" style="width: 10px; height: 10px;" /> '; 
	   
	   
	   if ($dane[9] == 0) {
              echo zwroc_tekst(88, $jezyk);
           } elseif ($dane[9] == 1){
              echo zwroc_tekst(88, $jezyk).' '.zwroc_tekst(92, $jezyk);
           } elseif ($dane[9] == 2){
              echo zwroc_tekst(88, $jezyk).' '.zwroc_tekst(93, $jezyk);
           } elseif ($dane[9] == 1000){
              echo zwroc_tekst(89, $jezyk).' '.substr($dane[3], 1);
	      if ($jezyk == "PL") {
	        echo 'u';
	      } elseif ($jezyk == "EN") {
	        echo ' of';
              }
           } else {
              echo zwroc_tekst(89, $jezyk).' '.zwroc_tekst(90, $jezyk).' '.substr($dane[3], 5).'.';
           }
           //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane[6]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($reszta_z_dzielenia == 780) {
             echo ' '.zwroc_tekst(1000, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 781)  {
             echo ' '.zwroc_tekst(1001, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 782)  {
             echo ' '.zwroc_tekst(1002, $jezyk).'
	     ';
	   }  elseif ($reszta_z_dzielenia == 783)  {
             echo ' '.zwroc_tekst(1003, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 784)  {
             echo ' '.zwroc_tekst(1004, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 788)  {
             echo ' '.zwroc_tekst(1005, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 789)  {
             echo ' '.zwroc_tekst(1006, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 790)  {
             echo ' '.zwroc_tekst(1007, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 791)  {
             echo ' '.zwroc_tekst(1008, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 794)  {
             echo ' '.zwroc_tekst(1009, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia == 795)  {
             echo ' '.zwroc_tekst(1010, $jezyk).'
	     ';
	   } elseif ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezyk).'
	     ';
	     //sprawdzam kraj
	     $sql_kraj = "SELECT `id_nat` FROM `Nat` WHERE `flaga`= '$dane[1]'";
	     $zap_kraj = mysql_query($sql_kraj) or die('mysql_query');
	     $dan_kraj = mysql_fetch_row($zap_kraj);
	   
	   //echo $dan_kraj[0].' <br/>';
	   
	   if ($jezyk == "EN") {
	     echo zwroc_tekst_nat($dan_kraj[0], "EN"); 
	   } elseif ($jezyk = "PL") {
	     echo zwroc_tekst_nat($dan_kraj[0], "PLdop");
	   }
	   $gg = strlen($dane[0]) - 2;
	   $gg1 = substr($dane[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane[0].'
	     ';
	   }
	   
	   if (($dane[11] < 35) AND ($dane[9] == 0))
	   { echo '</b>';}
	   
	   echo ' ('.$dane[2].') 
	   <br/>';
           
           
           
          }
         }
	          
	     $rok_poprzedni = $dane[11];
             
          }
                  $sqlMAX =  " SELECT COUNT(WynikiP.punkty)
		               FROM WynikiP INNER JOIN Wyscigi ON WynikiP.id_wys = Wyscigi.id_wys
			       WHERE (WynikiP.id_kol = '$id_kol') AND (WynikiP.id_co <> 10) AND (YEAR(Wyscigi.dataP) = '$rok_poprzedni') ";
		   
	          $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	          $danMAX = mysql_fetch_row($zapMAX);
                  echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezyk).'</a> ('.$danMAX[0].')<br/>';
          echo '
	  <br/>';
	  
	  
          echo '</table>
    
          <br/><br/>
    
          <a  name="skr"> </a>
          
          <b>'.zwroc_tekst(76, $jezyk).'</b> <br/>
          <font style="font-size: 7px; font-family: Courier, \'Courier New\', monospace; padding-right: 15px;">
    
          '.zwroc_tekst(77, $jezyk).'
    
          </font>';
	  
	  
          
	  
	  
	  ?>
	  
	  
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
