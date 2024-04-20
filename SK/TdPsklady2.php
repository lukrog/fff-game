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
	  
	   //                  0		1		2		3			4		5		6		7		8		9	19		11
	   $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, User.id_user, Kolarze.zdjecie, Nat.skr
	            FROM z_z_tlumacz_nat, User, Ekipy, Nat, Kolarze
		    WHERE Kolarze.id_kol = '$id_kol' AND Nat.id_nat = z_z_tlumacz_nat.id_nat AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user
		     ";
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           //echo '<h1>'.$dane[0].' '.$dane[1].'</h1>';
           
           //                     0        1      2       3        4      5
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
           
           $dzien_urodz = date("d",$tescik5);
           $mies_urodz = date("m",$tescik5);
           $rok_urodz = date("Y",$tescik5);
           
	   //to tylko do TdP
	   $tescik6 = strtotime("2017-07-29");
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
           
           //$string = "Królikowski";
           //echo $string.' ';
           //$string = strtoupper($string);
           //echo $string.' <br/>';
           
           $wzrost = substr($danedod[1], 0, 3);
           $waga = substr($danedod[2], 0, 2);
           
           
           
           
	   echo 'NAME;'.strtoupper($dane[1]).' '.$dane[0].'<br/>
	         BIRTH;'.$dzien_urodz.'.'.$mies_urodz.'.'.$rok_urodz.'<br/>
	         AGE;'.$wiek.'<br/>
	         NATIONALITY;'.$dane[11].'<br/>
	         HEIGHT;'.$wzrost.'<br/>
		 WEIGHT;'.$waga.'<br/>
	         TEAM;'.$dane[5].'<br/>
	         PRO FROM;'.$danedod[4].'<br/>
	         
	         
	         
	         ACHIEVEMENTS ENG';
	$ile_osiagniec =0;
	
	
	//--------------------------------------------------------------
	//   OSIĄGNIĘCIA KOLARZA - ANG                      
	//--------------------------------------------------------------
	
	
		 
	  //Osiągnięcia kolarza. - ANG
	  //
	  //Najpierw wyrzucamy zwycięstwa (generalka)
	  
	  $sql_osiagniecia = "SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), Wyscigi.id_wys, Wyscigi.id_nat, z_a_historiawyscig.id_hiswys
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig
		   WHERE WynikiALL.id_kol='$id_kol' 
		      AND Wyscigi.id_wys = WynikiALL.id_wys 
		      AND Nat.id_nat = Wyscigi.id_nat 
		      AND Co.id_co = WynikiALL.id_co 
		      AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI 
		      AND WynikiALL.miejsce = 1 AND WynikiALL.id_co = 0 
		      AND Wyscigi.id_wys = z_a_historiawyscig.id_wys
	           ORDER BY waznosc_wyscigow.waznosc, z_a_historiawyscig.id_hiswys, Wyscigi.dataP DESC";
	  //echo $sql_osiagniecia.' <- test1 <br/>';	   
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    echo ";";
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
	      
	      // wypisujemy tylko raz ale daty wklepujemy czyli
	      

	      
	      
	    } else {
	      echo '';
	    }
	    
	    echo '1st place in ';
	    
	   //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane_osiagniecia[3]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($dane_osiagniecia[5] == 1) {
             //MŚ TT
	     echo ' '.zwroc_tekst(1000, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 2)  {
             //MŚ
	     echo ' '.zwroc_tekst(1001, "EN").'
	     ';
	   }  elseif ($dane_osiagniecia[5] == 3)  {
             // MŚ TT U23
	     echo ' '.zwroc_tekst(1002, "EN").'
	     ';
	   }  elseif ($dane_osiagniecia[5] == 4)  {
             //MŚ U23
	     echo ' '.zwroc_tekst(1003, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 9)  {
             //Mistrzostwach Świata - jazda drużynowa na czas
	     echo ' '.zwroc_tekst(1004, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 5)  {
             //Igrzyskach Olipmpijskich
	     echo ' '.zwroc_tekst(1005, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 6)  {
             //Igrzyskach Olipmpijskich - jazda na czas
	     echo ' '.zwroc_tekst(1006, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 24)  {
             //Mistrzostwach Europy U23 - jazda na czas
	     echo ' '.zwroc_tekst(1007, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 25)  {
             //Mistrzostwach Europy U23
	     echo ' '.zwroc_tekst(1008, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 20)  {
             //Igrzyskach Europejskich - jazda na czas
	     echo ' '.zwroc_tekst(1009, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 21)  {
             //	Igrzyskach Europejskich
	     echo ' '.zwroc_tekst(1010, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 22)  {
             //Mistrzostwach Europy
	     echo ' '.zwroc_tekst(1012, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 23)  {
             //Mistrzostwach Europy TT
	     echo ' '.zwroc_tekst(1013, "EN").'
	     ';
	     } else {
	     if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, "EN").'
	     ';
	     //sprawdzam kraj
	     
	     echo zwroc_tekst_nat($dane_osiagniecia[4], "EN");
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
	   }
	   if ($dane_czy_byly[0] > 1) {
	      
	      echo ' ('.$dane_osiagniecia[2].'';
	        
	        
	      for ($il1=1; $il1<$dane_czy_byly[0]; $il1++) {
	        //teraz robimy myk bo dodajemy różne daty:
	        
	        
	        $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	        echo ', '.$dane_osiagniecia[2].'';
	      }
	      echo ')<br/>';
	      
	      
	    } else {
	      //echo '1st place in ';
	      echo ' ('.$dane_osiagniecia[2].')<br/>';
	    }
	    
	    
	    
	    
	    
	    //echo $dane_osiagniecia[0].' ('.$dane_osiagniecia[2].') <br/>';
	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	   
	  $ile_jeszcze = 6 - $ile_osiagniec;
	  if ($ile_jeszcze <= 0) {$ile_jeszcze = 0;}
	  
	  //-----------------------------------------------------
	  //   ZWYCIĘSTWA ETAPY
	  //-----------------------------------------------------	  
	  
	  //teraz wyrzucamy zwycięstwa (etapy)
	  //                                    0          1        2                 3                     4                                 
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), WynikiALL.id_wys, z_a_historiawyscig.id_hiswys
	  
	                       FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig 
			       WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys
			          AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co 
				  AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI 
				  AND WynikiALL.miejsce = 1 AND WynikiALL.id_co > 100
				  AND Wyscigi.id_wys = z_a_historiawyscig.id_wys
				  
			       ORDER BY waznosc_wyscigow.waznosc, z_a_historiawyscig.id_hiswys, Wyscigi.dataP DESC";
			       
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    echo ";";
	    //sprawdzamy czy na tym wyścigu było więcej wyników takich:
	    $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' AND z_a_historiawyscig.id_hiswys='$dane_osiagniecia[4]' 
			       AND WynikiALL.id_co>100 AND WynikiALL.miejsce=1 
			       AND z_a_historiawyscig.id_wys = WynikiALL.id_wys
			     ";
	    $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
            $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	    
	    echo '1st place on ';
	    
	    if ($dane_czy_byly[0] > 1) {
	      //kilka wygranych etapów
	      echo $dane_czy_byly[0].' stages of '.$dane_osiagniecia[0];
	      
	      
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
	      echo ') ';
	    } else {
	      echo 'stage of '.$dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')';
	    }
	    echo '<br/>';
	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	  
	  //Najpierw wyrzucamy zwycięstwa (klasyfikacje)
	  $ile_jeszcze = 6 - $ile_osiagniec;
	  if ($ile_jeszcze <= 0) {$ile_jeszcze = 0;}
	  
	  
	  
	  
	  
	  
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), Wyscigi.id_wys, Wyscigi.id_nat
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL
		   WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI AND WynikiALL.miejsce = 1 AND (WynikiALL.id_co > 0 AND WynikiALL.id_co < 10)
	           ORDER BY waznosc_wyscigow.waznosc, Wyscigi.dataP DESC ";
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
            echo ";";
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
	      
	      // wypisujemy tylko raz ale daty wklepujemy czyli
	      echo '';

	      
	      
	    } else {
	      echo '';
	    }
	    
	    
	    
	    
	    echo '1st place in ';
	    
	    if ($dane_osiagniecia[1] == 1) {
	      echo 'mountains classification in ';
	    } else {
	      echo 'points classification in ';
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
	   
	  //A teraz dorzucamy jeśli potrzeba wyniki z 2 i dalej miejsc wg punktów :D w generalce 
	  $ile_jeszcze = 6 - $ile_osiagniec;
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
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    //na razie wypisz wszystko
	    echo ";";
	    
	    
	    
	    
	    //sprawdzamy czy to etap czy co
	    if ($dane_osiagniecia[1] > 100) {
	      echo $dane_osiagniecia[3];
	    
	    
	      if ($dane_osiagniecia[3] == 2) {
	        echo 'nd';
	      } elseif ($dane_osiagniecia[3] == 3) {
	        echo 'rd';
	      } else {
	        echo 'th';
	      } 
	    
	      echo ' place ';
	      
	      
	      
	      echo ' on ';
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
	      echo $dane_czy_byly[0].' stages of '.$dane_osiagniecia[0];
	      
	      
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
	         
		echo 'stage of '.$dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')<br/>';
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
	      if ($dane_osiagniecia[3] == 2) {
	        echo 'nd';
	      } elseif ($dane_osiagniecia[3] == 3) {
	        echo 'rd';
	      } else {
	        echo 'th';
	      } 
	    
	      echo ' place in ';
	      
	    
	    
	   //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane_osiagniecia[4]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($dane_osiagniecia[6] == 1) {
             //MŚ TT
	     echo ' '.zwroc_tekst(1000, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 2)  {
             //MŚ
	     echo ' '.zwroc_tekst(1001, "EN").'
	     ';
	   }  elseif ($dane_osiagniecia[6] == 3)  {
             // MŚ TT U23
	     echo ' '.zwroc_tekst(1002, "EN").'
	     ';
	   }  elseif ($dane_osiagniecia[6] == 4)  {
             //MŚ U23
	     echo ' '.zwroc_tekst(1003, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 9)  {
             //Mistrzostwach Świata - jazda drużynowa na czas
	     echo ' '.zwroc_tekst(1004, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 5)  {
             //Igrzyskach Olipmpijskich
	     echo ' '.zwroc_tekst(1005, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 6)  {
             //Igrzyskach Olipmpijskich - jazda na czas
	     echo ' '.zwroc_tekst(1006, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 24)  {
             //Mistrzostwach Europy U23 - jazda na czas
	     echo ' '.zwroc_tekst(1007, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 25)  {
             //Mistrzostwach Europy U23
	     echo ' '.zwroc_tekst(1008, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 20)  {
             //Igrzyskach Europejskich - jazda na czas
	     echo ' '.zwroc_tekst(1009, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 21)  {
             //	Igrzyskach Europejskich
	     echo ' '.zwroc_tekst(1010, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 22)  {
             //Mistrzostwach Europy
	     echo ' '.zwroc_tekst(1012, "EN").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 23)  {
             //Mistrzostwach Europy TT
	     echo ' '.zwroc_tekst(1013, "EN").'
	     ';
	     } else {
	     if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, "EN").'
	     ';
	     //sprawdzam kraj
	     
	     echo zwroc_tekst_nat($dane_osiagniecia[5], "EN");
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
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
	      echo ';<br/>';
	    }
	  } 
	   	 
		 
		 
	
	
	
	
	
	
	
	
	
	
	
	   ECHO "ACHIEVEMENTS POL";
	
		 
		 
	  //ile osiągnięć
	  $ile_osiagniec = 0;
	  
	   
	  //Osiągnięcia kolarza.
	  //
	  //Najpierw wyrzucamy zwycięstwa (generalka)
	  
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), Wyscigi.id_wys, Wyscigi.id_nat, z_a_historiawyscig.id_hiswys
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig
		   WHERE WynikiALL.id_kol='$id_kol' 
		      AND Wyscigi.id_wys = WynikiALL.id_wys 
		      AND Nat.id_nat = Wyscigi.id_nat 
		      AND Co.id_co = WynikiALL.id_co 
		      AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI 
		      AND WynikiALL.miejsce = 1 AND WynikiALL.id_co = 0 
		      AND Wyscigi.id_wys = z_a_historiawyscig.id_wys
	           ORDER BY waznosc_wyscigow.waznosc, z_a_historiawyscig.id_hiswys, Wyscigi.dataP DESC";
	  //echo $sql_osiagniecia.' <- test1 <br/>';	   
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    echo ";";
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
	      
	      // wypisujemy tylko raz ale daty wklepujemy czyli
	      echo '1. miejsce w ';

	      
	      
	    } else {
	      echo '1. miejsce w ';
	    }
	    
	    
	    //echo '1. miejsce w ';
	    
	   //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane_osiagniecia[3]%1000;
           //echo $reszta_z_dzielenia;
           
           if ($dane_osiagniecia[5] == 1) {
             //MŚ TT
	     echo ' '.zwroc_tekst(1000, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 2)  {
             //MŚ
	     echo ' '.zwroc_tekst(1001, "PL").'
	     ';
	   }  elseif ($dane_osiagniecia[5] == 3)  {
             // MŚ TT U23
	     echo ' '.zwroc_tekst(1002, "PL").'
	     ';
	   }  elseif ($dane_osiagniecia[5] == 4)  {
             //MŚ U23
	     echo ' '.zwroc_tekst(1003, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 9)  {
             //Mistrzostwach Świata - jazda drużynowa na czas
	     echo ' '.zwroc_tekst(1004, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 5)  {
             //Igrzyskach Olipmpijskich
	     echo ' '.zwroc_tekst(1005, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 6)  {
             //Igrzyskach Olipmpijskich - jazda na czas
	     echo ' '.zwroc_tekst(1006, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 24)  {
             //Mistrzostwach Europy U23 - jazda na czas
	     echo ' '.zwroc_tekst(1007, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 25)  {
             //Mistrzostwach Europy U23
	     echo ' '.zwroc_tekst(1008, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 20)  {
             //Igrzyskach Europejskich - jazda na czas
	     echo ' '.zwroc_tekst(1009, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 21)  {
             //	Igrzyskach Europejskich
	     echo ' '.zwroc_tekst(1010, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 22)  {
             //Mistrzostwach Europy
	     echo ' '.zwroc_tekst(1012, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[5] == 23)  {
             //Mistrzostwach Europy TT
	     echo ' '.zwroc_tekst(1013, "PL").'
	     ';
	     } else {
	     if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, "PL").'
	     ';
	     //sprawdzam kraj
	     
	     echo zwroc_tekst_nat($dane_osiagniecia[4], "PLdop");
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
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
	    
	    
	    
	    //echo ' ('.$dane_osiagniecia[2].')<br/>';
	    
	    //echo $dane_osiagniecia[0].' ('.$dane_osiagniecia[2].') <br/>';
	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	   
	  $ile_jeszcze = 6 - $ile_osiagniec;
	  if ($ile_jeszcze <= 0) {$ile_jeszcze = 0;}
	  //teraz wyrzucamy zwycięstwa (etapy)
	  //                                    0          1        2                 3                     4                                 
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), WynikiALL.id_wys, z_a_historiawyscig.id_hiswys
	  
	                       FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL, z_a_historiawyscig 
			       WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys
			          AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co 
				  AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI 
				  AND WynikiALL.miejsce = 1 AND WynikiALL.id_co > 100
				  AND Wyscigi.id_wys = z_a_historiawyscig.id_wys
				  
			       ORDER BY waznosc_wyscigow.waznosc, z_a_historiawyscig.id_hiswys, Wyscigi.dataP DESC";
			       
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    echo ";";
	    //sprawdzamy czy na tym wyścigu było więcej wyników takich:
	    $sql_czy_byly = "SELECT count(id_wyn) 
	                     FROM WynikiALL, z_a_historiawyscig
			     WHERE WynikiALL.id_kol='$id_kol' AND z_a_historiawyscig.id_hiswys='$dane_osiagniecia[4]' 
			       AND WynikiALL.id_co>100 AND WynikiALL.miejsce=1 
			       AND z_a_historiawyscig.id_wys = WynikiALL.id_wys
			     ";
	    $idzapytania_czy_byly = mysql_query($sql_czy_byly) or die(mysql_error());          
            $dane_czy_byly = mysql_fetch_row($idzapytania_czy_byly);
	    
	    echo '1. miejsce na ';
	    
	    if ($dane_czy_byly[0] > 1) {
	      //kilka wygranych etapów
	      echo $dane_czy_byly[0].' etapach '.$dane_osiagniecia[0];
	      
	      
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
	      echo 'etapie '.$dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')';
	    }
	    echo '<br/>';
	    $ile_osiagniec = $ile_osiagniec + 1;
	  }
	  
	  //Najpierw wyrzucamy zwycięstwa (klasyfikacje)
	  $ile_jeszcze = 6 - $ile_osiagniec;
	  if ($ile_jeszcze <= 0) {$ile_jeszcze = 0;}
	  
	  $sql_osiagniecia = " SELECT Wyscigi.nazwa, Co.id_co, YEAR(Wyscigi.dataP), Wyscigi.id_wys, Wyscigi.id_nat
	           FROM waznosc_wyscigow, Co, Nat, Wyscigi, WynikiALL
		   WHERE WynikiALL.id_kol='$id_kol' AND Wyscigi.id_wys = WynikiALL.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiALL.id_co AND waznosc_wyscigow.kategoria = Wyscigi.klaUCI AND WynikiALL.miejsce = 1 AND (WynikiALL.id_co > 0 AND WynikiALL.id_co < 10)
	           ORDER BY waznosc_wyscigow.waznosc, Wyscigi.dataP DESC ";
	  //echo $sql_osiagniecia.' <- test1 <br/>';
          $idzapytania_osiagniecia = mysql_query($sql_osiagniecia) or die(mysql_error());          
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
            //$dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia);
	    //na razie wypisz wszystko
	    echo ";";
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
	      
	      // wypisujemy tylko raz ale daty wklepujemy czyli
	      echo '';

	      
	      
	    } else {
	      echo '';
	    }
	    
	    
	    
	    
	    echo '1. miejsce w klasyfikacji ';
	    
	    if ($dane_osiagniecia[1] == 1) {
	      echo 'górskiej ';
	    } else {
	      echo 'punktowej ';
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
	   
	  //A teraz dorzucamy jeśli potrzeba wyniki z 2 i dalej miejsc wg punktów :D w generalce 
	  $ile_jeszcze = 6 - $ile_osiagniec;
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
          while ($ile_osiagniec < 6 AND $dane_osiagniecia = mysql_fetch_row($idzapytania_osiagniecia)) {
	    //na razie wypisz wszystko
	    
	    echo ";";
	    
	    
	    
	    //sprawdzamy czy to etap czy co
	    if ($dane_osiagniecia[1] > 100) {
	      echo $dane_osiagniecia[3].'. miejsce ';
	      echo ' na ';
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
	      echo $dane_czy_byly[0].' etapach '.$dane_osiagniecia[0];
	      
	      
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
	        echo 'etapie '.$dane_osiagniecia[0].' ('.$dane_osiagniecia[2].')<br/>';
	      }
	      
	      
	      //echo 'on stage of';
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
	      
	    
	      echo '. miejsce w ';
	      
	   //Sprawdzamy czy to był to wyścig mostrzost krejowych albo świata.
           $reszta_z_dzielenia = $dane_osiagniecia[4]%1000;
           //echo "LDDD ".$reszta_z_dzielenia." DDDLDDD ".$dane_osiagniecia[6]."gfDDDDDD   ";
           
           if ($dane_osiagniecia[6] == 1) {
             //MŚ TT
	     echo ' '.zwroc_tekst(1000, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 2)  {
             //MŚ
	     echo ' '.zwroc_tekst(1001, "PL").'
	     ';
	   }  elseif ($dane_osiagniecia[6] == 3)  {
             // MŚ TT U23
	     echo ' '.zwroc_tekst(1002, "PL").'
	     ';
	   }  elseif ($dane_osiagniecia[6] == 4)  {
             //MŚ U23
	     echo ' '.zwroc_tekst(1003, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 9)  {
             //Mistrzostwach Świata - jazda drużynowa na czas
	     echo ' '.zwroc_tekst(1004, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 5)  {
             //Igrzyskach Olipmpijskich
	     echo ' '.zwroc_tekst(1005, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 6)  {
             //Igrzyskach Olipmpijskich - jazda na czas
	     echo ' '.zwroc_tekst(1006, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 24)  {
             //Mistrzostwach Europy U23 - jazda na czas
	     echo ' '.zwroc_tekst(1007, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 25)  {
             //Mistrzostwach Europy U23
	     echo ' '.zwroc_tekst(1008, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 20)  {
             //Igrzyskach Europejskich - jazda na czas
	     echo ' '.zwroc_tekst(1009, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 21)  {
             //	Igrzyskach Europejskich
	     echo ' '.zwroc_tekst(1010, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 22)  {
             //Mistrzostwach Europy
	     echo ' '.zwroc_tekst(1012, "PL").'
	     ';
	   } elseif ($dane_osiagniecia[6] == 23)  {
             //Mistrzostwach Europy TT
	     echo ' '.zwroc_tekst(1013, "PL").'
	     ';
	     } else {
	     if ($reszta_z_dzielenia > 799)  {
             //Mistrzostwa Krajowe
	     echo ' '.zwroc_tekst(1011, "PL").'
	     ';
	     //sprawdzam kraj
	     
	     echo zwroc_tekst_nat($dane_osiagniecia[5], "PLdop");
	   
	   $gg = strlen($dane_osiagniecia[0]) - 2;
	   $gg1 = substr($dane_osiagniecia[0],$gg,2);
	   echo ' '.$gg1;	   
	   
	   } else {
	     echo ' '.$dane_osiagniecia[0].'
	     ';
	   }
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
	      echo ';<br/>';
	    }
	  } 
	  
	  
	  
	  
	   
	  //ile osiągnięć 
	  $ile_osiagniec = 0;
	  
	   
	  
	   
	   
	   
	   
	  
	  echo '------------------------------<br/><br/><br/><br/>';
          }
	  
	  
	  ?>
	  
	  
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
