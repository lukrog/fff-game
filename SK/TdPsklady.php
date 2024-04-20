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
           $id_ek = $_GET['id_ek'];
	   $sql_ekipa = "SELECT `id_kol` FROM `z_z_zTdP` WHERE `id_ekipy`= '$id_ek' ";
	   echo "<font size=20>Sprawdź datę startu wyścigu !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</font><br/><br/>";
	   
	   echo $sql_ekipa.' <br/><br/>';
	   $idzapytania_ekipa = mysql_query($sql_ekipa) or die(mysql_error());
           while ($dane_ekipa = mysql_fetch_row($idzapytania_ekipa)) {
	   
	   
	   
	   // $id_kol = $_GET['id_kol'];
	   $id_kol = $dane_ekipa[0];
	  
	  
	   $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, User.id_user, Kolarze.zdjecie
	            FROM z_z_tlumacz_nat, User, Ekipy, Nat, Kolarze
		    WHERE Kolarze.id_kol = '$id_kol' AND Nat.id_nat = z_z_tlumacz_nat.id_nat AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user
		     ";
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           //echo '<h1>'.$dane[0].' '.$dane[1].'</h1>';
           
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
           
           
           
	   //echo '<div><div style="float: right; width: 210px;">';
	   
	   
	   //if ($danedod[3] == "") {
            // echo '<br/>
	    // <img src="'.$dane[10].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right style="padding-right: 10px;" />
	    // ';
           //} else {
             //echo '
	     //<img src="'.$danedod[3].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right style="padding-right: 20px;" /><br/>
	     //';
          // }
	   
	   
	   //echo '	   </div>';
	   echo '<div style="float: left; width: 550px;">
	   ';
	   
	   
	   //echo ' > '.$dane[2];
	   $tescik5 = strtotime($dane[2]);	   
           $tescik = date("Y",$tescik5);	   
	   $tescik1 = strtotime(date("Y-m-d"));
           
	   //to tylko do TdP
	   $tescik6 = strtotime("2016-07-12");
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
	         
	         <h1>'.$dane[0].' '.$dane[1].'</h1>
	         <!--
	         <img src="'.$dane[10].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right style="padding-right: 10px;" />
	         -->
	         <i>'.zwroc_tekst(33, $jezyk).': </i> '.$dane[2].'<br/><br/>
	         <i>'.zwroc_tekst(34, $jezyk).':</i> '.$wiek.'<br/><br/>
		 '.zwroc_tekst(79, $jezyk).': </i> <img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> '.$dane[3].'<br/><br/>
		 ';
	   echo '<i>'.zwroc_tekst(56, $jezyk).': </i> ';
	   
	   if ($dane[7] == 1000) {
              echo zwroc_tekst(22, $jezyk);
	   } elseif ($dane[7] == 1001) {
              echo zwroc_tekst(21, $jezyk);
	   } elseif ($dane[7] == 0) {
              echo zwroc_tekst(57, $jezyk);
           } else {
	      echo $dane[5];
	   }  
	   echo '<br/><br/>
   	   <i>'.zwroc_tekst(80, $jezyk).': </i>'.$danedod[1].' <i>'.zwroc_tekst(81, $jezyk).': </i>'.$danedod[2].'<br/><br/>
	   <i>'.zwroc_tekst(82, $jezyk).': </i>'.$danedod[4].'<br/><br/><br/>';
	   
	   
	   echo '<h3>'.zwroc_tekst(85, $jezyk).'</h3>';
	   echo '<table class="wyscig">';
           //echo '<tr><td class="wyscig6">'.zwroc_tekst(84, $jezyk).'</td><td class="wyscig9">'.zwroc_tekst(56, $jezyk).'</td></tr>';
	  $sqlhis = " SELECT id_kol, id_z, id_do, kiedy, YEAR(kiedy), MONTH(kiedy), DAY(kiedy) "
                  . " FROM z_a_historiakol "
	          . " WHERE id_kol = '$id_kol' AND id_do <> 0 "
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
	      echo '<tr><td class="wyscig6">'.$danhis[3];
	    } else {
              echo '<tr><td class="wyscig6">'.$danhis[4];
            }  
	    echo '</td><td class="wyscig7">   ';
	    
	    if ($danhis[2] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	    } elseif ($danhis[2] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	    } elseif ($danhis[2] == 0) {
                     echo zwroc_tekst(57, $jezyk);
            } else {
	             echo $danhise[0];
	    }  
	    
	    //jeżeli transfer 1 sierpnia to stażysta
	    if (($danhis[5] == 8) and ($danhis[6] == 1)) {
	      echo " (".zwroc_tekst(1034, $jezyk).")";
	    }
	    
	    echo ' </td></tr>
	    ';
	    
	    
          }
	  echo '
                </table>';
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   echo '<br/><br/>';
	   
	  
	  //--------------------------/
	  //         WYNIKI           /
	  //--------------------------/
          echo '<h3>'.zwroc_tekst(158, $jezyk).'</h3>';
	  //                  0              1             2           3            4               5               6                 7                    8        9             10                        
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, Wyniki.miejsce, Wyniki.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), Wyniki.wynik, Co.id_co, waznosc_wyscigow.waznosc
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, Wyniki
		   WHERE Wyniki.id_kol='$id_kol' AND Wyscigi.id_wys = Wyniki.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = Wyniki.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI
	           ORDER BY Wyniki.miejsce, waznosc_wyscigow.waznosc, DATE(Wyscigi.dataP), Co.id_co ";
	  

	      
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          while ($dane = mysql_fetch_row($idzapytania))
          {
           
            if (($dane[9] == 10)) {
              
           } else {
           
	  // było:     if ((($dane[9] < 8) AND ($dane[4] <= 20)) OR (($dane[9] > 100) AND ($dane[4] <= 10)) )    
	  //  a musimy uzależnić wszystko od: $dane[9]<8 - generalka $dane[9]>100 etapy
	  //  $dane[4] to miejsca, a $dane[10] to ważność wyścigów która ustawi nam wszystko w odpowiedniej hierarhii
	  //  
	  // Jeżeli | generalka	       jeśli ważnosć 10 [IO MŚ] to piersza 10                                            jeśli waż=30 [Tour Vuelta Giro]           ważność = 35 [Mistz. Kraj]         ważność 40 [Młodzieżowe mistrz]        ważność 80 [to Pro Tuoury monumenty]        waż 90 [HC] czyli piątka                waż 100 [x.1] pierwsza 3                waż 110 [x.2] [pierwsza 3]             waż 120 [wyścigi młodzieżowe]            wszystkie pozostałe dajemy
	  //                                                                   Jeśli waż=20 [MŚ TTT] to 1 miejsce                to pierwsza 10                         to pierwsza 5                       dajemy pierwszą 10                      leci 10 albo 7                                                                                                                                                      dajemy 10                               tylko zwyciężcę
	     if ((($dane[9] == 0) AND ((($dane[10]==10) AND ($dane[4]<=10)) OR (($dane[10]==20) AND ($dane[4]<=1)) OR (($dane[10]==30) AND ($dane[4]<=10)) OR (($dane[10]==35) AND ($dane[4]<=3)) OR (($dane[10]==40) AND ($dane[4]<=3)) OR (($dane[10]==80) AND ($dane[4]<=10)) OR (($dane[10]==90) AND ($dane[4]<=3)) OR (($dane[10]==100) AND ($dane[4]<=1)) OR (($dane[10]==110) AND ($dane[4]<=0)) OR (($dane[10]==120) AND ($dane[4]<=1))  OR (($dane[10]>120) AND ($dane[4]<=0)) )) 
	  
	  // Jeżeli zaś etap                 Waż 30 [toury] pierwsza 5              waż = 80 [PT] to podium                  waż 90 [x.HC]  zwycięzca               waż 100 [x.1] zwycięzca                ważność 110 x.2  zwyciężca          waż 120 [młodzież]  zwycięzca           w pozostałych nie podajemy
                OR (($dane[9] > 0) AND (($dane[10]==30) AND ($dane[4]<=3)) OR (($dane[10]==80) AND ($dane[4]<=1)) OR (($dane[10]==90) AND ($dane[4]<=0)) OR (($dane[10]==100) AND ($dane[4]<=0)) OR (($dane[10]==110) AND ($dane[4]<=0)) OR (($dane[10]==120) AND ($dane[4]<=0)) OR (($dane[10]>120) AND ($dane[4]<=0))   )) {
	     
           //if ((($dane[9] < 8) AND ($dane[4] <= 20)) OR (($dane[9] > 100) AND ($dane[4] <= 10)) ) {
	   
	  // if (($dane[10] < 35) AND ($dane[9] == 0))
	  // { echo '<b>';} 
	   //echo $dane[10].' - '.$dane[9].' -> ';
	   //miejsce
 	   echo $dane[4];
 	   if ($jezyk == "EN") {
	      if ($dane[4] == 1) {
	        echo '<sup>st</sup>';
	      } elseif ($dane[4] == 2) {
	        echo '<sup>nd</sup>';
	      } elseif ($dane[4] == 3) {
	        echo '<sup>rd</sup>';
	      } else {
	        echo '<sup>th</sup>';
	      } 
	   } elseif ($jezyk = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezyk).' ';
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
           $reszta_z_dzielenia = $dane_osiagniecia[3]%1000;
           //echo $reszta_z_dzielenia;
           
           $sqlxxx = " SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE `id_wys`=".$dane_osiagniecia[3]." ";   
           $idzapytaniaxxx = mysql_query($sqlxxx) or die(mysql_error());          
           $danexxx = mysql_fetch_row($idzapytaniaxxx);
           
           if ($danexxx[0] == 1) {
             //MŚ TT
	     echo ' '.zwroc_tekst(1000, "EN").'
	     ';
	   } elseif ($danexxx[0] == 2)  {
             //MŚ
	     echo ' '.zwroc_tekst(1001, "EN").'
	     ';
	   }  elseif ($danexxx[0] == 3)  {
             // MŚ TT U23
	     echo ' '.zwroc_tekst(1002, "EN").'
	     ';
	   }  elseif ($danexxx[0] == 4)  {
             //MŚ U23
	     echo ' '.zwroc_tekst(1003, "EN").'
	     ';
	   } elseif ($danexxx[0] == 9)  {
             //Mistrzostwach Świata - jazda drużynowa na czas
	     echo ' '.zwroc_tekst(1004, "EN").'
	     ';
	   } elseif ($danexxx[0] == 5)  {
             //Igrzyskach Olipmpijskich
	     echo ' '.zwroc_tekst(1005, "EN").'
	     ';
	   } elseif ($danexxx[0] == 6)  {
             //Igrzyskach Olipmpijskich - jazda na czas
	     echo ' '.zwroc_tekst(1006, "EN").'
	     ';
	   } elseif ($danexxx[0] == 24)  {
             //Mistrzostwach Europy U23 - jazda na czas
	     echo ' '.zwroc_tekst(1007, "EN").'
	     ';
	   } elseif ($danexxx[0] == 25)  {
             //Mistrzostwach Europy U23
	     echo ' '.zwroc_tekst(1008, "EN").'
	     ';
	   } elseif ($danexxx[0] == 20)  {
             //Igrzyskach Europejskich - jazda na czas
	     echo ' '.zwroc_tekst(1009, "EN").'
	     ';
	   } elseif ($danexxx[0] == 21)  {
             //	Igrzyskach Europejskich
	     echo ' '.zwroc_tekst(1010, "EN").'
	     ';
	   } elseif ($danexxx[0] == 22)  {
             //Mistrzostwach Europy
	     echo ' '.zwroc_tekst(1012, "EN").'
	     ';
	   } elseif ($danexxx[0] == 23)  {
             //Mistrzostwach Europy TT
	     echo ' '.zwroc_tekst(1013, "EN").'
	     ';} else {
	      if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, "EN").'
	     ';
	     //sprawdzam kraj
	     
	     if ("EN" == "PL") {
	       echo zwroc_tekst_nat($dane_osiagniecia[4], "PLdop");
	     } else {
	       echo zwroc_tekst_nat($dane_osiagniecia[4], "EN");
	     }
	     
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
	    }
	   
	  // if (($dane[10] < 35) AND ($dane[9] == 0))
	  // { echo '</b>';}
	   
	   echo '
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
	   //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rokteraz1.'">'.zwroc_tekst(95, $jezyk).'</a> ('.$danMAX[0].'.)<br/>';


          $sezonnowy = 1; 
          $rok_poprzedni = 0;
          //echo '<h2>'.zwroc_tekst(91, $jezyk).'</h2>';
          //                   0             1           2             3           4                 5			6		7		8		9		10		11			     
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, WynikiP.miejsce, WynikiP.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), WynikiP.wynik, Co.id_co, waznosc_wyscigow.waznosc, YEAR(Wyscigi.dataP)
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiP
		   WHERE WynikiP.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiP.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiP.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI
		   ORDER BY YEAR(Wyscigi.dataP) DESC, WynikiP.miejsce, waznosc_wyscigow.waznosc, DATE(Wyscigi.dataP), Co.id_co ";     
	       
	       
	       
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
                  //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezyk).'</a> ('.$danMAX[0].')<br/>';
                  $sezonnowy = 0;
	      } else {$sezonnowy = 0;}
              echo '<h3>'.zwroc_tekst(94, $jezyk).' '.$dane[11].' </h3>';
           }

	   if (($dane[9] == 10)) {
              
           } else {
           
	   
	  // Jeżeli | generalka	       jeśli ważnosć 10 [IO MŚ] to piersza 10                                            jeśli waż=30 [Tour Vuelta Giro]           ważność = 35 [Mistz. Kraj]         ważność 40 [Młodzieżowe mistrz]        ważność 80 [to Pro Tuoury monumenty]        waż 90 [HC] czyli piątka                waż 100 [x.1] pierwsza 3                waż 110 [x.2] [pierwsza 3]             waż 120 [wyścigi młodzieżowe]            wszystkie pozostałe dajemy
	  //                                                                   Jeśli waż=20 [MŚ TTT] to 1 miejsce                to pierwsza 10                         to pierwsza 5                       dajemy pierwszą 10                      leci 10 albo 7                                                                                                                                                      dajemy 10                               tylko zwyciężcę
	     if ((($dane[9] == 0) AND ((($dane[10]==10) AND ($dane[4]<=10)) OR (($dane[10]==20) AND ($dane[4]<=1)) OR (($dane[10]==30) AND ($dane[4]<=10)) OR (($dane[10]==35) AND ($dane[4]<=3)) OR (($dane[10]==40) AND ($dane[4]<=3)) OR (($dane[10]==80) AND ($dane[4]<=10)) OR (($dane[10]==90) AND ($dane[4]<=3)) OR (($dane[10]==100) AND ($dane[4]<=1)) OR (($dane[10]==110) AND ($dane[4]<=0)) OR (($dane[10]==120) AND ($dane[4]<=1))  OR (($dane[10]>120) AND ($dane[4]<=0)) )) 
	  
	  // Jeżeli zaś etap                 Waż 30 [toury] pierwsza 5              waż = 80 [PT] to podium                  waż 90 [x.HC]  zwycięzca               waż 100 [x.1] zwycięzca                ważność 110 x.2  zwyciężca          waż 120 [młodzież]  zwycięzca           w pozostałych nie podajemy
                OR (($dane[9] > 0) AND (($dane[10]==30) AND ($dane[4]<=3)) OR (($dane[10]==80) AND ($dane[4]<=1)) OR (($dane[10]==90) AND ($dane[4]<=0)) OR (($dane[10]==100) AND ($dane[4]<=0)) OR (($dane[10]==110) AND ($dane[4]<=0)) OR (($dane[10]==120) AND ($dane[4]<=0)) OR (($dane[10]>120) AND ($dane[4]<=0))   )) {
	     
           //if ((($dane[9] < 8) AND ($dane[4] <= 20)) OR (($dane[9] > 100) AND ($dane[4] <= 10)) ) {
	   
	  

	   
	   //if (($dane[10] < 35) AND ($dane[9] == 0))
	   //{ echo '<b>';} 
	   
	   //echo $dane[10].' - '.$dane[9].' -> ';
 	   //miejsce
 	   echo $dane[4];
 	   if ($jezyk == "EN") {
	      if ($dane[4] == 1) {
	        echo '<sup>st</sup>';
	      } elseif ($dane[4] == 2) {
	        echo '<sup>nd</sup>';
	      } elseif ($dane[4] == 3) {
	        echo '<sup>rd</sup>';
	      } else {
	        echo '<sup>th</sup>';
	      } 
	   } elseif ($jezyk = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezyk).' ';
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
	   //if (($dane[11] < 35) AND ($dane[9] == 0))
	   //{ echo '</b>';}
	   
	   echo '
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
                  //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezyk).'</a> ('.$danMAX[0].')<br/>';
          echo '
	  <br/>';
	  
	  
          echo '</table>
    
          ';
	  
	  
          }
	  echo '<br/><br/><br/>data wyścigu to:'.date("Y-m-d",$tescik6);
	  
	  ?>
	  
	  
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
