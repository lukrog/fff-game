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
           $nr_st = 0;
           $data_dzis = "2019-08-03";
           
           //najpierw info o ekipie
           $sql_ek = "	SELECT `Ekipy`.`nazwa` , `Ekipy`.`id_kraj` , `Ekipy`.`skr`, `z_z_tlumacz_nat`.`SKR`
      			FROM `Ekipy`, `z_z_tlumacz_nat`
			WHERE `Ekipy`.`id_team` =".$id_ek." AND `Ekipy`.`id_kraj`=`z_z_tlumacz_nat`.`id_nat` ";
	   $idz_ek = mysql_query($sql_ek) or die(mysql_error());
           $dane_ek = mysql_fetch_row($idz_ek);
	    echo "<font size=20>Sprawdź datę startu wyścigu !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ".$data_dzis."</font><br/><br/>";
	   
	   echo '<pre>
{
  "team": {
    "id": "'.$dane_ek[2].'",
    "name": "'.$dane_ek[0].'",
    "flag": "'.$dane_ek[3].'",
    "color": "#8b8178",
    "tshirt": "http://tourdepologne.pl/wp-content/uploads/2017/ekipy/tshirt.jpg",
    "logo": "http://tourdepologne.pl/wp-content/uploads/2017/ekipy/logo.jpg",
    "photo": "http://tourdepologne.pl/wp-content/uploads/2017/ekipy/photo.jpg"
  },
  "profiles": [';
    
    $adres_png=$dane_ek[2].'-';
  //wyszukujemy kolarzy wg wpisów z listy
  $sql_ekipa = "SELECT `id_kol`, `nr_st` FROM `z_z_zTdP` WHERE `id_ekipy`= '$id_ek' LIMIT 0, 7";
	   
	  
	   
	   //echo $sql_ekipa.' <br/><br/>';
	   $idzapytania_ekipa = mysql_query($sql_ekipa) or die(mysql_error());
           while ($dane_ekipa = mysql_fetch_row($idzapytania_ekipa)) {
             $id_kol=$dane_ekipa[0];
      //kolarz
      //pierwszy
      $nr_st = $nr_st + 1;
      $sql = " 	SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.SKR
	       	FROM z_z_tlumacz_nat, Kolarze
 		WHERE Kolarze.id_kol = '$id_kol' AND Kolarze.id_nat = z_z_tlumacz_nat.id_nat
		     ";
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           //echo '<h1>'.$dane[0].' '.$dane[1].'</h1>';
           
           $zapdanedod = "SELECT zawodow
	                 FROM z_e_infokol 
			 WHERE id_kol = '$id_kol' ";
	   $idzdanedod = mysql_query($zapdanedod) or die('mysql_query');
           if (mysql_num_rows($idzdanedod) == 0) {
	       $danedod[0] = "";
           } else {
  	     $danedod = mysql_fetch_row($idzdanedod);
	   }
      
      	   $tescik5 = strtotime($dane[2]);	   
           $tescik = date("Y",$tescik5);	   
	   $tescik1 = strtotime(date("Y-m-d"));
           
	   //to tylko do TdP
	   $tescik6 = strtotime($data_dzis);
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
           
      $startowynr=$adres_png.str_replace(" ","_",strtoupper($dane[1])).'_'.str_replace(" ","_",$dane[0]);
      echo '
    {
      "id": '.$dane_ekipa[1].',
      "name": "'.$dane[0].' '.$dane[1].'",
      "birthDate": "'.$dane[2].'",
      "nationality": "'.$dane[3].'",
      "professionalSince": '.$danedod[0].',
      "age": '.$wiek.',
      "photo": "http://www.tourdepologne.pl/wp-content/uploads/2017/zawodnicy/'.$startowynr.'.png",
      "achievements": [
         {
           ';
      //tu osiągnięcia
      //najpierw po ang
      $jezykakt = 'EN';   
      
      //-===================================================================================================
      
      
          //--------------------------/
	  //         WYNIKI           /
	  //--------------------------/
	  // tu wklepujemy aktualny rok
          echo '   "2019":[';
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
 	   echo '"'.$dane[4];
 	   if ($jezykakt == "EN") {
	      if ($dane[4] == 1) {
	        echo '<sup>st</sup>';
	      } elseif ($dane[4] == 2) {
	        echo '<sup>nd</sup>';
	      } elseif ($dane[4] == 3) {
	        echo '<sup>rd</sup>';
	      } else {
	        echo '<sup>th</sup>';
	      } 
	   } elseif ($jezykakt = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezykakt).' ';
	   if ($dane[9] == 0) {
              echo zwroc_tekst(88, $jezykakt);
           } elseif ($dane[9] == 1){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(92, $jezykakt);
           } elseif ($dane[9] == 2){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(93, $jezykakt);
           } elseif ($dane[9] == 1000){
              echo zwroc_tekst(89, $jezykakt).' '.substr($dane[3], 1);
	      if ($jezykakt == "PL") {
	        echo 'u';
	      } elseif ($jezykakt == "EN") {
	        echo ' of';
              }
           } else {
              echo zwroc_tekst(89, $jezykakt).' '.zwroc_tekst(90, $jezykakt).' '.substr($dane[3], 5).'.';
           }
           
           //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane[6]%1000;
           //echo $reszta_z_dzielenia;
           
           $sqlxxx = " SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE `id_wys`=".$dane[6]." ";   
           $idzapytaniaxxx = mysql_query($sqlxxx) or die(mysql_error());          
           $danexxx = mysql_fetch_row($idzapytaniaxxx);
           
                
           if ($danexxx[0] == 1) {
             echo ' '.zwroc_tekst(1000, $jezykakt).'';
	   } elseif ($danexxx[0] == 2)  {
             echo ' '.zwroc_tekst(1001, $jezykakt).'';
	   }  elseif ($danexxx[0] == 3)  {
             echo ' '.zwroc_tekst(1002, $jezykakt).'';
	   }  elseif ($danexxx[0] == 4)  {
             echo ' '.zwroc_tekst(1003, $jezykakt).'';
	   } elseif ($danexxx[0] == 9)  {
             echo ' '.zwroc_tekst(1004, $jezykakt).'';
	   } elseif ($danexxx[0] == 5)  {
             echo ' '.zwroc_tekst(1005, $jezykakt).'';
	   } elseif ($danexxx[0] == 6)  {
             echo ' '.zwroc_tekst(1006, $jezykakt).'';
	   } elseif ($danexxx[0] == 24)  {
             echo ' '.zwroc_tekst(1007, $jezykakt).'';
	   } elseif ($danexxx[0] == 25)  {
             echo ' '.zwroc_tekst(1008, $jezykakt).'';
	   } elseif ($danexxx[0] == 20)  {
             echo ' '.zwroc_tekst(1009, $jezykakt).'';
	   } elseif ($danexxx[0] == 21)  {
             echo ' '.zwroc_tekst(1010, $jezykakt).'';
	   } elseif ($danexxx[0] == 22)  {
             echo ' '.zwroc_tekst(1012, $jezykakt).'';
	   } elseif ($danexxx[0] == 23)  {
             echo ' '.zwroc_tekst(1013, $jezykakt).'';
	   } else {
	    if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezykakt).' ';
	     //sprawdzam kraj
	     $sql_kraj = "SELECT `id_nat` FROM `Nat` WHERE `flaga`= '$dane[1]'";
	     $zap_kraj = mysql_query($sql_kraj) or die('mysql_query');
	     $dan_kraj = mysql_fetch_row($zap_kraj);
	   
	   //echo $dan_kraj[0].' <br/>';
	   
	   if ($jezykakt == "EN") {
	     echo zwroc_tekst_nat($dan_kraj[0], "EN"); 
	   } elseif ($jezykakt = "PL") {
	     echo zwroc_tekst_nat($dan_kraj[0], "PLdop");
	   }
	   $gg = strlen($dane[0]) - 2;
	   $gg1 = substr($dane[0],$gg,2);
	   echo ' '.$gg1;
	   
	   } else {
	     echo ' '.$dane[0];
	   }
	   }
	   
	  // if (($dane[10] < 35) AND ($dane[9] == 0))
	  // { echo '</b>';}
	   
	   //echo '';
           echo '",';
           
           
          }
         }
         
        }
           $sqlMAX =  " SELECT COUNT(Wyniki.punkty)  "
	            . " FROM Wyniki "
 		    . " WHERE (Wyniki.id_kol = '$id_kol') AND (Wyniki.id_co <> 10) ";
	   $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	   $danMAX = mysql_fetch_row($zapMAX);
	   $rokteraz1 = date("Y");
	   echo '';

          $sezonnowy = 1; 
          $rok_poprzedni = 0;
          //echo '<h2>'.zwroc_tekst(91, $jezykakt).'</h2>';
          //                   0             1           2             3           4                 5			6		7		8		9		10		11			     
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, WynikiP.miejsce, WynikiP.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), WynikiP.wynik, Co.id_co, waznosc_wyscigow.waznosc, YEAR(Wyscigi.dataP)
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiP
		   WHERE WynikiP.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiP.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiP.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI
		   ORDER BY YEAR(Wyscigi.dataP) DESC, WynikiP.miejsce, waznosc_wyscigow.waznosc, DATE(Wyscigi.dataP), Co.id_co ";     
	       
	       
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());          
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
                  //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezykakt).'</a> ('.$danMAX[0].')<br/>';
                  $sezonnowy = 0;
	      } else {$sezonnowy = 0;}
              echo '],
	      "'.$dane[11].'":[';
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
 	   echo '"'.$dane[4];
 	   if ($jezykakt == "EN") {
	      if ($dane[4] == 1) {
	        echo '<sup>st</sup>';
	      } elseif ($dane[4] == 2) {
	        echo '<sup>nd</sup>';
	      } elseif ($dane[4] == 3) {
	        echo '<sup>rd</sup>';
	      } else {
	        echo '<sup>th</sup>';
	      } 
	   } elseif ($jezykakt = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezykakt).' ';
	   if ($dane[9] == 0) {
              echo zwroc_tekst(88, $jezykakt);
           } elseif ($dane[9] == 1){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(92, $jezykakt);
           } elseif ($dane[9] == 2){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(93, $jezykakt);
           } elseif ($dane[9] == 1000){
              echo zwroc_tekst(89, $jezykakt).' '.substr($dane[3], 1);
	      if ($jezykakt == "PL") {
	        echo 'u';
	      } elseif ($jezykakt == "EN") {
	        echo ' of';
              }
           } else {
              echo zwroc_tekst(89, $jezykakt).' '.zwroc_tekst(90, $jezykakt).' '.substr($dane[3], 5).'.';
              
           }
           
	   //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane[6]%1000;
           //echo $reszta_z_dzielenia;
           
           $sqlxxx = " SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE `id_wys`=".$dane[6]." ";   
           $idzapytaniaxxx = mysql_query($sqlxxx) or die(mysql_error());          
           $danexxx = mysql_fetch_row($idzapytaniaxxx);
           
                
           if ($danexxx[0] == 1) {
             echo ' '.zwroc_tekst(1000, $jezykakt).'';
	   } elseif ($danexxx[0] == 2)  {
             echo ' '.zwroc_tekst(1001, $jezykakt).'';
	   }  elseif ($danexxx[0] == 3)  {
             echo ' '.zwroc_tekst(1002, $jezykakt).'';
	   }  elseif ($danexxx[0] == 4)  {
             echo ' '.zwroc_tekst(1003, $jezykakt).'';
	   } elseif ($danexxx[0] == 9)  {
             echo ' '.zwroc_tekst(1004, $jezykakt).'';
	   } elseif ($danexxx[0] == 5)  {
             echo ' '.zwroc_tekst(1005, $jezykakt).'';
	   } elseif ($danexxx[0] == 6)  {
             echo ' '.zwroc_tekst(1006, $jezykakt).'';
	   } elseif ($danexxx[0] == 24)  {
             echo ' '.zwroc_tekst(1007, $jezykakt).'';
	   } elseif ($danexxx[0] == 25)  {
             echo ' '.zwroc_tekst(1008, $jezykakt).'';
	   } elseif ($danexxx[0] == 20)  {
             echo ' '.zwroc_tekst(1009, $jezykakt).'';
	   } elseif ($danexxx[0] == 21)  {
             echo ' '.zwroc_tekst(1010, $jezykakt).'';
	   } elseif ($danexxx[0] == 22)  {
             echo ' '.zwroc_tekst(1012, $jezykakt).'';
	   } elseif ($danexxx[0] == 23)  {
             echo ' '.zwroc_tekst(1013, $jezykakt).'';
	   } else {
	    if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezykakt).' ';
	     //sprawdzam kraj
	     $sql_kraj = "SELECT `id_nat` FROM `Nat` WHERE `flaga`= '$dane[1]'";
	     $zap_kraj = mysql_query($sql_kraj) or die('mysql_query');
	     $dan_kraj = mysql_fetch_row($zap_kraj);
	   
	   //echo $dan_kraj[0].' <br/>';
	   
	   if ($jezykakt == "EN") {
	     echo zwroc_tekst_nat($dan_kraj[0], "EN"); 
	   } elseif ($jezykakt = "PL") {
	     echo zwroc_tekst_nat($dan_kraj[0], "PLdop");
	   }
	   $gg = strlen($dane[0]) - 2;
	   $gg1 = substr($dane[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane[0].'';
	   }
	   }
	   //if (($dane[11] < 35) AND ($dane[9] == 0))
	   //{ echo '</b>';}
	   
	   echo '",';
           
           
           
          }
         }
	          
	     $rok_poprzedni = $dane[11];
             
          }
                  $sqlMAX =  " SELECT COUNT(WynikiP.punkty)
		               FROM WynikiP INNER JOIN Wyscigi ON WynikiP.id_wys = Wyscigi.id_wys
			       WHERE (WynikiP.id_kol = '$id_kol') AND (WynikiP.id_co <> 10) AND (YEAR(Wyscigi.dataP) = '$rok_poprzedni') ";
		   
	          $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	          $danMAX = mysql_fetch_row($zapMAX);
                  //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezykakt).'</a> ('.$danMAX[0].')<br/>';

	  
	  
          echo '';
	  
	  
          
      
      
      
      
      
      
      
      //-======================================================================================================  
      echo ']
	 }, 
	 {
	   ';
      //potem po pol
      $jezykakt = 'PL';   
      
      //-===================================================================================================
      
      
          //--------------------------/
	  //         WYNIKI           /
	  //--------------------------/
	  // tu wklepujemy aktualny rok
          echo '   "2019":[';
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
 	   echo '"'.$dane[4];
 	   if ($jezykakt == "EN") {
	      if ($dane[4] == 1) {
	        echo '<sup>st</sup>';
	      } elseif ($dane[4] == 2) {
	        echo '<sup>nd</sup>';
	      } elseif ($dane[4] == 3) {
	        echo '<sup>rd</sup>';
	      } else {
	        echo '<sup>th</sup>';
	      } 
	   } elseif ($jezykakt = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezykakt).' ';
	   if ($dane[9] == 0) {
              echo zwroc_tekst(88, $jezykakt);
           } elseif ($dane[9] == 1){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(92, $jezykakt);
           } elseif ($dane[9] == 2){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(93, $jezykakt);
           } elseif ($dane[9] == 1000){
              echo zwroc_tekst(89, $jezykakt).' '.substr($dane[3], 1);
	      if ($jezykakt == "PL") {
	        echo 'u';
	      } elseif ($jezykakt == "EN") {
	        echo ' of';
              }
           } else {
              echo zwroc_tekst(89, $jezykakt).' '.zwroc_tekst(90, $jezykakt).' '.substr($dane[3], 5).'.';
           }
           
           //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane[6]%1000;
           //echo $reszta_z_dzielenia;
           
           $sqlxxx = " SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE `id_wys`=".$dane[6]." ";   
           $idzapytaniaxxx = mysql_query($sqlxxx) or die(mysql_error());          
           $danexxx = mysql_fetch_row($idzapytaniaxxx);
           
                
           if ($danexxx[0] == 1) {
             echo ' '.zwroc_tekst(1000, $jezykakt).'';
	   } elseif ($danexxx[0] == 2)  {
             echo ' '.zwroc_tekst(1001, $jezykakt).'';
	   }  elseif ($danexxx[0] == 3)  {
             echo ' '.zwroc_tekst(1002, $jezykakt).'';
	   }  elseif ($danexxx[0] == 4)  {
             echo ' '.zwroc_tekst(1003, $jezykakt).'';
	   } elseif ($danexxx[0] == 9)  {
             echo ' '.zwroc_tekst(1004, $jezykakt).'';
	   } elseif ($danexxx[0] == 5)  {
             echo ' '.zwroc_tekst(1005, $jezykakt).'';
	   } elseif ($danexxx[0] == 6)  {
             echo ' '.zwroc_tekst(1006, $jezykakt).'';
	   } elseif ($danexxx[0] == 24)  {
             echo ' '.zwroc_tekst(1007, $jezykakt).'';
	   } elseif ($danexxx[0] == 25)  {
             echo ' '.zwroc_tekst(1008, $jezykakt).'';
	   } elseif ($danexxx[0] == 20)  {
             echo ' '.zwroc_tekst(1009, $jezykakt).'';
	   } elseif ($danexxx[0] == 21)  {
             echo ' '.zwroc_tekst(1010, $jezykakt).'';
	   } elseif ($danexxx[0] == 22)  {
             echo ' '.zwroc_tekst(1012, $jezykakt).'';
	   } elseif ($danexxx[0] == 23)  {
             echo ' '.zwroc_tekst(1013, $jezykakt).'';
	   } else {
	    if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezykakt).' ';
	     //sprawdzam kraj
	     $sql_kraj = "SELECT `id_nat` FROM `Nat` WHERE `flaga`= '$dane[1]'";
	     $zap_kraj = mysql_query($sql_kraj) or die('mysql_query');
	     $dan_kraj = mysql_fetch_row($zap_kraj);
	   
	   //echo $dan_kraj[0].' <br/>';
	   
	   if ($jezykakt == "EN") {
	     echo zwroc_tekst_nat($dan_kraj[0], "EN"); 
	   } elseif ($jezykakt = "PL") {
	     echo zwroc_tekst_nat($dan_kraj[0], "PLdop");
	   }
	   $gg = strlen($dane[0]) - 2;
	   $gg1 = substr($dane[0],$gg,2);
	   echo ' '.$gg1;
	   
	   } else {
	     echo ' '.$dane[0];
	   }
	   }
	  // if (($dane[10] < 35) AND ($dane[9] == 0))
	  // { echo '</b>';}
	   
	   //echo '';
           echo '",';
           
           
          }
         }
         
        }
           $sqlMAX =  " SELECT COUNT(Wyniki.punkty)  "
	            . " FROM Wyniki "
 		    . " WHERE (Wyniki.id_kol = '$id_kol') AND (Wyniki.id_co <> 10) ";
	   $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	   $danMAX = mysql_fetch_row($zapMAX);
	   $rokteraz1 = date("Y");
	   echo '';

          $sezonnowy = 1; 
          $rok_poprzedni = 0;
          //echo '<h2>'.zwroc_tekst(91, $jezykakt).'</h2>';
          //                   0             1           2             3           4                 5			6		7		8		9		10		11			     
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, WynikiP.miejsce, WynikiP.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), WynikiP.wynik, Co.id_co, waznosc_wyscigow.waznosc, YEAR(Wyscigi.dataP)
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiP
		   WHERE WynikiP.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiP.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiP.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI
		   ORDER BY YEAR(Wyscigi.dataP) DESC, WynikiP.miejsce, waznosc_wyscigow.waznosc, DATE(Wyscigi.dataP), Co.id_co ";     
	       
	       
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());          
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
                  //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezykakt).'</a> ('.$danMAX[0].')<br/>';
                  $sezonnowy = 0;
	      } else {$sezonnowy = 0;}
              echo '],
	      "'.$dane[11].'":[';
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
 	   echo '"'.$dane[4];
 	   if ($jezykakt == "EN") {
	      if ($dane[4] == 1) {
	        echo '<sup>st</sup>';
	      } elseif ($dane[4] == 2) {
	        echo '<sup>nd</sup>';
	      } elseif ($dane[4] == 3) {
	        echo '<sup>rd</sup>';
	      } else {
	        echo '<sup>th</sup>';
	      } 
	   } elseif ($jezykakt = "PL") {
	     echo '.';
	   }
	    
	    
	   echo ' '.zwroc_tekst(87, $jezykakt).' ';
	   if ($dane[9] == 0) {
              echo zwroc_tekst(88, $jezykakt);
           } elseif ($dane[9] == 1){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(92, $jezykakt);
           } elseif ($dane[9] == 2){
              echo zwroc_tekst(88, $jezykakt).' '.zwroc_tekst(93, $jezykakt);
           } elseif ($dane[9] == 1000){
              echo zwroc_tekst(89, $jezykakt).' '.substr($dane[3], 1);
	      if ($jezykakt == "PL") {
	        echo 'u';
	      } elseif ($jezykakt == "EN") {
	        echo ' of';
              }
           } else {
              echo zwroc_tekst(89, $jezykakt).' '.zwroc_tekst(90, $jezykakt).' '.substr($dane[3], 5).'.';
              
           }
           
	   //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane[6]%1000;
           //echo $reszta_z_dzielenia;
           
           $sqlxxx = " SELECT `id_hiswys` FROM `z_a_historiawyscig` WHERE `id_wys`=".$dane[6]." ";   
           $idzapytaniaxxx = mysql_query($sqlxxx) or die(mysql_error());          
           $danexxx = mysql_fetch_row($idzapytaniaxxx);
           
                
           if ($danexxx[0] == 1) {
             echo ' '.zwroc_tekst(1000, $jezykakt).'';
	   } elseif ($danexxx[0] == 2)  {
             echo ' '.zwroc_tekst(1001, $jezykakt).'';
	   }  elseif ($danexxx[0] == 3)  {
             echo ' '.zwroc_tekst(1002, $jezykakt).'';
	   }  elseif ($danexxx[0] == 4)  {
             echo ' '.zwroc_tekst(1003, $jezykakt).'';
	   } elseif ($danexxx[0] == 9)  {
             echo ' '.zwroc_tekst(1004, $jezykakt).'';
	   } elseif ($danexxx[0] == 5)  {
             echo ' '.zwroc_tekst(1005, $jezykakt).'';
	   } elseif ($danexxx[0] == 6)  {
             echo ' '.zwroc_tekst(1006, $jezykakt).'';
	   } elseif ($danexxx[0] == 24)  {
             echo ' '.zwroc_tekst(1007, $jezykakt).'';
	   } elseif ($danexxx[0] == 25)  {
             echo ' '.zwroc_tekst(1008, $jezykakt).'';
	   } elseif ($danexxx[0] == 20)  {
             echo ' '.zwroc_tekst(1009, $jezykakt).'';
	   } elseif ($danexxx[0] == 21)  {
             echo ' '.zwroc_tekst(1010, $jezykakt).'';
	   } elseif ($danexxx[0] == 22)  {
             echo ' '.zwroc_tekst(1012, $jezykakt).'';
	   } elseif ($danexxx[0] == 23)  {
             echo ' '.zwroc_tekst(1013, $jezykakt).'';
	   } else {
	    if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, $jezykakt).'';
	     //sprawdzam kraj
	     $sql_kraj = "SELECT `id_nat` FROM `Nat` WHERE `flaga`= '$dane[1]'";
	     $zap_kraj = mysql_query($sql_kraj) or die('mysql_query');
	     $dan_kraj = mysql_fetch_row($zap_kraj);
	   
	   //echo $dan_kraj[0].' <br/>';
	   
	   if ($jezykakt == "EN") {
	     echo zwroc_tekst_nat($dan_kraj[0], "EN"); 
	   } elseif ($jezykakt = "PL") {
	     echo zwroc_tekst_nat($dan_kraj[0], "PLdop");
	   }
	   $gg = strlen($dane[0]) - 2;
	   $gg1 = substr($dane[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane[0].'';
	   }
	   }
	   //if (($dane[11] < 35) AND ($dane[9] == 0))
	   //{ echo '</b>';}
	   
	   echo '",';
           
           
           
          }
         }
	          
	     $rok_poprzedni = $dane[11];
             
          }
                  $sqlMAX =  " SELECT COUNT(WynikiP.punkty)
		               FROM WynikiP INNER JOIN Wyscigi ON WynikiP.id_wys = Wyscigi.id_wys
			       WHERE (WynikiP.id_kol = '$id_kol') AND (WynikiP.id_co <> 10) AND (YEAR(Wyscigi.dataP) = '$rok_poprzedni') ";
		   
	          $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	          $danMAX = mysql_fetch_row($zapMAX);
                  //echo '<a href="kolwyn.php?id_kol='.$id_kol.'&rok='.$rok_poprzedni.'">'.zwroc_tekst(95, $jezykakt).'</a> ('.$danMAX[0].')<br/>';

	  
	  
          echo ']
	  ';
	  
	  
          
      
      
      
      
      
      
      
      //-======================================================================================================
      
      
      
      
      
      
      
      echo '
	 }
    ';
      echo '  ]
    ';
    
    
    
    
    
    
    
    
      echo '}';
      if ($nr_st - $_GET['nr_st'] < 7) {
        echo ',';
      } else {
        echo '';
      }
     echo '
     '; 
    }
    
echo '
  ]
}   


	</pre>   ';
           
           
	   
	   
	  

	  
	  
	  ?>
	  
	  
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
