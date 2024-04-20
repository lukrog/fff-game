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
  include_once('logowanie.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - obliczanie wyścigu</title>
</head>
<body>
<div>

<?php
  $zapyt = "SELECT id_user, login, haslo, ekipa, boss FROM User WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapyt = mysql_query($zapyt) or die('mysql_query');
  while ($wiersza = mysql_fetch_row($idzapyt)) 
   {
      $logi=$wiersza[1];
      $idek=$wiersza[0];
      $ekipa = $wiersza[3];
      $_SESSION['boss']=$wiersza[4];
   }
   //sprawdzanie poprawności logowania
  if($_SESSION['logowanie'] == 'poprawne') { 
  $log=$_POST['login'];
  $zapytanie = "SELECT `id_user`,`login`,`haslo`,`ekipa`, `boss` FROM `User` WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapytania = mysql_query($zapytanie) or die('mysql_query');
  while ($wiersz = mysql_fetch_row($idzapytania)) 
   {
      $logi=$wiersz[1];
      $idek=$wiersz[0];
      $ekipa = $wiersz[3];
      $_SESSION['boss']=$wiersz[4];
   }
  } else {}
    echo poczatek();
         //dodajemy wyniki do bazy dla tego wyścigu
         $id_wys =  $_POST['idwys'];
         if ($_SESSION['boss'] >= 1) {
	  $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, DATE(Wyscigi.dataP), Wyscigi.dataK FROM Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat WHERE (((Wyscigi.id_wys)= '$id_wys' ))";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  
  	  //zaczynamy formularz podsumowujący!!!!
  	  echo '<form action="WKLEP_WYNIKI_POTW_EXE.php" method="post">
	       ';
	  echo '<input type="hidden" name="idwys" value="'.$id_wys.'" />';     
	       
	  echo '<table id="menu2">';
          echo '<tr><td><i>id wyścigu: </i></td><td>'.$id_wys.'</td></tr> 
	        <tr><td><i>nazwa wyścigu: </i></td><td>[size=20]'.$dane[1].'[/size]</td></tr> 
		<tr><td><i>kraj rozgrywania: </i></td><td>'.$dane[3].' <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr> 
		<tr><td><i>klasyfikacja UCI: </i></td><td>'.$dane[5].'</td></tr> 
		<tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr> 
		<tr><td><i>Data początku: </i></td><td>'.$dane[7].'</td></tr> 
		<tr><td><i>Data końca: </i></td><td>'.$dane[8].'</td></tr>';
          
	  //Sprawdzamy ile dni trwa wyścig.
          $ile_dni_różnicy = strtotime($dane[8]) - strtotime($dane[7]);
          $ile_dni_różnicy = date('d',$ile_dni_różnicy);
          echo '<tr><td><i>w związku z tym trwa dni: </i></td><td>'.$ile_dni_różnicy.'</td></tr>';
          //czy to jedno czy wieloetapowy.
          if ($ile_dni_różnicy == 1) {
            $jaki_wyscig = "jednodniowy";
          } else {
            $jaki_wyscig = "wielodniowy";
          }
          echo '<tr><td><i>i jest to wyścig:</i></td><td>'.$jaki_wyscig.'</td></tr>';
          
          //sprawdzamy, czy był dodatkowy etap:
          if ($_POST['dod'] == "on") {
             $ile_dni_różnicywyslane = $ile_dni_różnicy + 1;
          } else {
             $ile_dni_różnicywyslane = $ile_dni_różnicy;
          }
          echo '<tr><td><i>a to będzie etapów: </i></td><td>'.$ile_dni_różnicywyslane.'</td></tr>';
	  
	  echo '<tr><td><i>podaj kategorię wyścigu: </i></td><td>'.$_POST['kat'].'</td></tr>
	        <tr><td><i>podaj punktację wyścigu: </i></td><td>'.$_POST['pun'].'</td></tr>
	       ';
	  // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!11
	   
	  //sprawdzamy czy były już wyniki w bazie
	$sql_czy_sa_wyniki_w_bazie = "SELECT id_wyn FROM Wyniki WHERE id_wys='$id_wys'";
	$idz_czy_sa_wyniki_w_bazie = mysql_query($sql_czy_sa_wyniki_w_bazie) or die('mysql_query');
        $dane_czy_sa_wyniki_w_bazie = mysql_num_rows($idz_czy_sa_wyniki_w_bazie);
	   echo '<tr><td><i>w bazie jest już : </i></td><td>'.$dane_czy_sa_wyniki_w_bazie.' wyników</td></tr>
	        ';
	  
	  echo '</table>';
	  
	  //Sprawdźmy czy istnieje już wklepana kategoria dle tego wyścigu i jeśli tak to usuwamy je by stworzyć nowe :D
	  $sql_czy_sa_kategorie = "DELETE FROM `z_EtapyKat` WHERE `id_wys`= '$id_wys' ";
	  $idz_czy_sa_kategorie = mysql_query($sql_czy_sa_kategorie) or die('mysql_query');
	  
	 //Trzeba dodać kategorie i punktacje
         //Dlatego teraz trzeba sprawdzić ostatnie id w 
	  $sql_ostatnie_id_kategorii = "SELECT id_ek FROM z_EtapyKat ORDER BY id_ek DESC LIMIT 0,1";
	  $idz_ostatnie_id_kategorii = mysql_query($sql_ostatnie_id_kategorii) or die('mysql_query');
  	  $id_ostatnie_id_kategorii_z_bazy = mysql_fetch_row($idz_ostatnie_id_kategorii);
	  $id_nowe_id_kategorii = $id_ostatnie_id_kategorii_z_bazy[0] +1;
	  
	  //Dodajemy też do z_Kategorie
	  $data00 = $_POST['data00'];
	  $kat = $_POST['kat'];
	  $kat1_00 = $_POST['kat1_00'];
	  $peleton_0 = $_POST['peleton_00'];
	  $pun = $_POST['pun'];
	  
	  
	  
	  
	  $sql_z_Kategorie_wstaw = "INSERT INTO 
	                            z_EtapyKat (`id_ek`, `data`, `id_kat`, `id_kat2`, `id_wys`, `id_co`, `id_pun`, `pierwszy_z_pel`) 
	                            VALUES ('$id_nowe_id_kategorii', '$data00', '$kat1_00', '$kat', '$id_wys', '0', '$pun', '$peleton_0')";
	  
	  
	  
	  echo '<br/>Zapytanie dodające kategorie <br/><font color=blue>'.$sql_z_Kategorie_wstaw.'</font> <br/>';
	  $id_nowe_id_kategorii = $id_nowe_id_kategorii + 1;
	  $idz_z_Kategorie_wstaw = mysql_query($sql_z_Kategorie_wstaw) or die('mysql_query');
	  
	  //Za drugim razem też rozbijamy.
	       
	 
         echo '<h5><font color=green>Klasyfikacja końcowa </font></h5> wpisałeś to:';
         
         //Rozbicie na części tych co dojechali
         $miejsca=explode(";",$_POST["wynikiKON"]);
	 
	 echo '<br/>wpisano '.count($miejsca).' miejsc <br/>'; 
	 echo 'Analizuję zawodników wg nazwiska imienia i narodowości<br/><br/>';
	 
	 //musimy sprawdzić ostatnie ID w wynikach i w ktopoj
	  $sql_ostatnie_id_wyscigi = "SELECT id_wyn FROM Wyniki ORDER BY id_wyn DESC LIMIT 0,1";
	  $idz_ostatnie_id_wyscigi = mysql_query($sql_ostatnie_id_wyscigi) or die('mysql_query');
  	  $id_ostatnie_id_wyscigi_z_bazy = mysql_fetch_row($idz_ostatnie_id_wyscigi);
	  $id_nowe_id_wyscigi = $id_ostatnie_id_wyscigi_z_bazy[0] +1;
	  
	  $sql_ostatnie_id_wyscigiALL = "SELECT id_wyn FROM WynikiALL ORDER BY id_wyn DESC LIMIT 0,1";
	  $idz_ostatnie_id_wyscigiALL = mysql_query($sql_ostatnie_id_wyscigiALL) or die('mysql_query');
  	  $id_ostatnie_id_wyscigi_z_bazyALL = mysql_fetch_row($idz_ostatnie_id_wyscigiALL);
	  $id_nowe_id_wyscigiALL = $id_ostatnie_id_wyscigi_z_bazyALL[0] +1;
	  
	  $sql_ostatnie_id_ktopoj = "SELECT id_kp FROM ktopoj ORDER BY id_kp DESC LIMIT 0,1";
	  $idz_ostatnie_id_ktopoj = mysql_query($sql_ostatnie_id_ktopoj) or die('mysql_query');
  	  $id_ostatnie_id_ktopoj_z_bazy = mysql_fetch_row($idz_ostatnie_id_ktopoj);
	  $id_nowe_id_ktopoj = $id_ostatnie_id_ktopoj_z_bazy[0] +1;
	 
	 for($i=0;$i<count($miejsca)-1;$i++)
         {
            $danekol=explode("|",$miejsca[$i]);
            
            //teraz trzeba wyczytać punkty
            $sql_punktacja_fff = "SELECT punkty FROM z_puntacja_fff WHERE miejsce='$danekol[0]' AND kat_fff='$dane[6]' ";
	    $idz_punktacja_fff = mysql_query($sql_punktacja_fff) or die('mysql_query');
  	    $id_punktacja_fff = mysql_fetch_row($idz_punktacja_fff);
            
            
            //Sprawdzamy id z Kolarze_nazw
            $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
            
	    //czy jest wynik z tego miejsca jest w bazie
	    $sql_czy_wstaw_wynik = "SELECT id_wyn, id_kol FROM Wyniki WHERE miejsce=".$danekol[0]." AND id_wys='$id_wys' AND id_co=0";
	    $idz_czy_wstaw_wynik = mysql_query($sql_czy_wstaw_wynik) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_wstaw_wynik) > 0) {
	      //są wyniki z tego miejsca w bazie więc zmieniamy dane
	      $dane_czy_wstaw_wynik = mysql_fetch_row($idz_czy_wstaw_wynik);
	      
	      $sql_zmien_wynik = "UPDATE `Wyniki` 
	                          SET `id_kol`='$Kolarz[0]', `punkty`='$id_punktacja_fff[0]',`wynik`='$danekol[4]'
	                          WHERE id_wyn = ".$dane_czy_wstaw_wynik[0]." ";
              echo '<font color=blue size=1>'.$sql_zmien_wynik.'<br/></font>
	           ';                
	      $x_zmien__wynik = mysql_query($sql_zmien_wynik) or die('mysql_query');
	      
	      //jeśli na tym miejscu był inny kolarz to trzeba tego poprzedniego skasować z ktopoj
	      if ($Kolarz[0] == $dane_czy_wstaw_wynik[0]) {
	        //nie musimy nic robić
	      } else {
	        //trzeba skasować z ktopoj tego starego kolarza
	        $sql_skasuj_ktopoj = "DELETE FROM `ktopoj` WHERE `id_wys`='$id_wys' AND `id_kol`='$dane_czy_wstaw_wynik[0]' "; 
	        $x_skasuj_ktopoj = mysql_query($sql_skasuj_ktopoj) or die('mysql_query');
	      }
	      
	    } else {
	      //nie ma wyników w bazie za generalkę
	      $sql_wstaw_wynik = "INSERT INTO `Wyniki`(`id_wyn`, `miejsce`, `id_kol`, `id_wys`, `id_co`, `punkty`, `wynik`) 
                                  VALUES ('$id_nowe_id_wyscigi', ".$danekol[0].", '$Kolarz[0]', '$id_wys', 0, '$id_punktacja_fff[0]', '$danekol[4]')";
              echo '<font color=blue size=1>'.$sql_wstaw_wynik.'<br/></font>
	           ';                
	      $wstaw_wynik = mysql_query($sql_wstaw_wynik) or die('mysql_query');
  	      $id_nowe_id_wyscigi=$id_nowe_id_wyscigi+1;
	    }
	    
	    
	    
	    
	    //--------=-------------=---------=----------=------------=-----------=-----------=-------------
	    // WynikiALL
	    
	    
	    
	         $sqlhis1 = " SELECT id_do, kiedy, YEAR(kiedy)
		              FROM z_a_historiakol
		              WHERE (id_kol = '$Kolarz[0]') AND (kiedy <= '$dane[7]')
		              ORDER BY kiedy DESC ";
	         $zaphis1 = mysql_query($sqlhis1) or die('mysql_query');
	         
	         if (mysql_num_rows($zaphis1) > 0) { 
	           $danhis1 = mysql_fetch_row($zaphis1);
		 } else {
		   $danhis1[0] = 0;
		 }
	         
		 
	         //czyli w tym momencie był on w ekipie $danhis1[0]
	    
	    //czy jest wynik z tego miejsca jest w bazie
	    $sql_czy_wstaw_wynikALL = "SELECT id_wyn, id_kol FROM WynikiALL WHERE miejsce=".$danekol[0]." AND id_wys='$id_wys' AND id_co=0";
	    $idz_czy_wstaw_wynikALL = mysql_query($sql_czy_wstaw_wynikALL) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_wstaw_wynikALL) > 0) {
	      //są wyniki z tego miejsca w bazie więc zmieniamy dane
	      $dane_czy_wstaw_wynikALL = mysql_fetch_row($idz_czy_wstaw_wynikALL);
	      
	      $sql_zmien_wynikALL = "UPDATE `WynikiALL` 
	                          SET `id_kol`='$Kolarz[0]', `punkty`='$id_punktacja_fff[0]',`wynik`='$danekol[4]', `ekipaW`='$danhis1[0]'
	                          WHERE id_wyn = ".$dane_czy_wstaw_wynikALL[0]." ";
              echo '<font color=green size=1>'.$sql_zmien_wynikALL.'<br/></font>
	           ';                
	      $x_zmien__wynikALL = mysql_query($sql_zmien_wynikALL) or die('mysql_query');
	      
	    } else {
	      //nie ma wyników w bazie za generalkę
	      $sql_wstaw_wynikALL = "INSERT INTO `WynikiALL`(`id_wyn`, `miejsce`, `id_kol`, `id_wys`, `id_co`, `punkty`, `wynik`, `ekipaW`) 
                                  VALUES ('$id_nowe_id_wyscigiALL', ".$danekol[0].", '$Kolarz[0]', '$id_wys', 0, '$id_punktacja_fff[0]', '$danekol[4]', $danhis1[0])";
              echo '<font color=green size=1>'.$sql_wstaw_wynikALL.'<br/></font>
	           ';                
	      $wstaw_wynikALL = mysql_query($sql_wstaw_wynikALL) or die('mysql_query');
  	      $id_nowe_id_wyscigiALL=$id_nowe_id_wyscigiALL+1;
	    }
	    
	    
	    
	    
	    
	    
	    
	    //i wstawiamy do kto_poj
  	    //najpierw sprawdzamy czy dany kolarz był już zgłaszany do kto pojechał w tym wyścigu.
  	    $sql_czy_byly_dane_w_ktopoj ="SELECT `id_kp` FROM `ktopoj` WHERE `id_kol`='$Kolarz[0]'  AND `id_wys`='$id_wys'";
  	    $idz_czy_byly_dane_w_ktopoj = mysql_query($sql_czy_byly_dane_w_ktopoj) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_byly_dane_w_ktopoj) > 0) {
	      //był juź ten kolarz dodany więc nie robimy nic
	    } else {
	      //jak nie było to trzeba dodać
	      $sql_wstaw_ktopoj = "INSERT INTO `ktopoj`(`id_kp`, `id_wys`, `id_kol`) 
	                           VALUES ('$id_nowe_id_ktopoj', '$id_wys', '$Kolarz[0]')";
              echo '<font color=red size=1>'.$sql_wstaw_ktopoj.'<br/></font>';                
	      $wstaw_ktopoj = mysql_query($sql_wstaw_ktopoj) or die('mysql_query');
  	      $id_nowe_id_ktopoj=$id_nowe_id_ktopoj+1;
	    }
	    
	    echo '
	         ';
         }
         
         //rozbicie na części tych co nie dojechali
	 $miejsca=explode(";",$_POST["wynikiDNE"]);  
	 
	 echo '<br/><br/><font color=green><b>Nie ukończyli </b></font>(wpisano '.count($miejsca).' miejsc) <br/>'; 
	 echo 'Analizuję zawodników wg nazwiska imienia i narodowości<br/><br/>';

	 for($i=0;$i<count($miejsca)-1;$i++)
         {
            $danekol=explode("|",$miejsca[$i]);
            
            //Sprawdzamy id z Kolarze_nazw
            $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    
  	    //najpierw sprawdzamy czy dany kolarz był już zgłaszany do kto pojechał w tym wyścigu.
  	    $sql_czy_byly_dane_w_ktopoj ="SELECT `id_kp` FROM `ktopoj` WHERE `id_kol`='$Kolarz[0]'  AND `id_wys`='$id_wys'";
  	    $idz_czy_byly_dane_w_ktopoj = mysql_query($sql_czy_byly_dane_w_ktopoj) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_byly_dane_w_ktopoj) > 0) {
	      //był juź ten kolarz dodany więc nie robimy nic
	    } else {
	      //jak nie było to trzeba dodać
	      $sql_wstaw_ktopoj = "INSERT INTO `ktopoj`(`id_kp`, `id_wys`, `id_kol`) 
	                           VALUES ('$id_nowe_id_ktopoj', '$id_wys', '$Kolarz[0]')";
              echo '<font color=blue size=1>'.$sql_wstaw_ktopoj.'<br/></font>';                
	      $wstaw_ktopoj = mysql_query($sql_wstaw_ktopoj) or die('mysql_query');
  	      $id_nowe_id_ktopoj=$id_nowe_id_ktopoj+1;
	    }
         }
         
         //teraz jeśli to była jednoetapówka to już koniec, a jak nie to dzieje się to:
         echo '<br/><br/>ile dni różnicy '.$ile_dni_różnicy;
         
         if ($ile_dni_różnicy == 1) {
	   // w sumie to nic się nie dzieje jak jest 1 dzień bo już wyniki i ktopoj
	 } else {
	    //jeśli jednak trwa więcej niż jeden dzień to mamy etapówkę i trzeba sprawdzić lidera
	    //rozbicie na części tych co liderowali
	 
	 $miejsca=explode(";",$_POST["wyniki_10lider"]);
	 
	 echo '<br/><br/><font color=green><b>liderzy etapów </b></font>(wpisano '.count($miejsca).' miejsc) <br/>'; 
	 echo 'Analizuję zawodników wg nazwiska imienia i narodowości<br/><br/>';
	 
	 if ($_POST['pro'] == "on") {
	      echo 'był prolog więc zaczynamy od etapu 0 (1000)<br/><br/>';
	      $poczatek = 0;
	    } else {
	      echo 'prologu nie było więc zaczynamy od etapu 1 (1010) [bo np etap 1a to 1011 a 4b to 1042]<br/><br/>';
	      $poczatek = 1;
	    }
	
	
	 for($i=0;$i<count($miejsca)-1;$i++)
         {
            $danekol=explode("|",$miejsca[$i]);
	    
	    $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    $jo = $i + $poczatek;
  	    $etap_do_przej = $_POST["etap".$jo];
  	    switch ($etap_do_przej) {
	        case 1000: $co_jedziemy = "po .prologu"; break;
	        case 1010: $co_jedziemy = "po 1. etapie"; break;
	        case 1011: $co_jedziemy = "po 1a. etapie"; break;
	        case 1012: $co_jedziemy = "po 1b. etapie"; break;
	        case 1020: $co_jedziemy = "po 2. etapie"; break;
	        case 1021: $co_jedziemy = "po 2a. etapie"; break;
	        case 1022: $co_jedziemy = "po 2b. etapie"; break;
	        case 1030: $co_jedziemy = "po 3. etapie"; break;
	        case 1031: $co_jedziemy = "po 3a. etapie"; break;
	        case 1032: $co_jedziemy = "po 3b. etapie"; break;
	        case 1040: $co_jedziemy = "po 4. etapie"; break;
	        case 1041: $co_jedziemy = "po 4a. etapie"; break;
	        case 1042: $co_jedziemy = "po 4b. etapie"; break;
	        case 1050: $co_jedziemy = "po 5. etapie"; break;
	        case 1051: $co_jedziemy = "po 5a. etapie"; break;
	        case 1052: $co_jedziemy = "po 5b. etapie"; break;
	        case 1060: $co_jedziemy = "po 6. etapie"; break;
	        case 1061: $co_jedziemy = "po 6a. etapie"; break;
	        case 1062: $co_jedziemy = "po 6b. etapie"; break;
	        case 1070: $co_jedziemy = "po 7. etapie"; break;
	        case 1080: $co_jedziemy = "po 8. etapie"; break;
	        case 1090: $co_jedziemy = "po 9. etapie"; break;
	        case 1100: $co_jedziemy = "po 10. etapie"; break;
	        case 1110: $co_jedziemy = "po 11. etapie"; break;
	        case 1120: $co_jedziemy = "po 12. etapie"; break;
	        case 1130: $co_jedziemy = "po 13. etapie"; break;
	        case 1140: $co_jedziemy = "po 14. etapie"; break;
	        case 1150: $co_jedziemy = "po 15. etapie"; break;
	        case 1160: $co_jedziemy = "po 16. etapie"; break;
	        case 1170: $co_jedziemy = "po 17. etapie"; break;
	        case 1180: $co_jedziemy = "po 18. etapie"; break;
	        case 1190: $co_jedziemy = "po 19. etapie"; break;
	        case 1200: $co_jedziemy = "po 20. etapie"; break;
	        case 1210: $co_jedziemy = "po 21. etapie"; break;
	      }
  	    //Ponieważ etap to
            $kategoria_fff=$dane[6].'l';
	    $sql_punktacja_fff = "SELECT punkty FROM z_puntacja_fff WHERE miejsce=1 AND kat_fff='$kategoria_fff' ";
	    $idz_punktacja_fff = mysql_query($sql_punktacja_fff) or die('mysql_query');
  	    $id_punktacja_fff = mysql_fetch_row($idz_punktacja_fff);
  	    
  	    //sprawdzam czy może już było wklepane liderowanie po tym etapie
  	    $sql_czy_wstaw_wynik = "SELECT id_wyn, id_kol FROM Wyniki WHERE wynik='$co_jedziemy' AND id_wys='$id_wys' AND id_co=10";
	    $idz_czy_wstaw_wynik = mysql_query($sql_czy_wstaw_wynik) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_wstaw_wynik) > 0) {
	      // czyli było już liderowanie po tym etapie
	      //trzeba wyedytować
	      $dane_czy_wstaw_wynik = mysql_fetch_row($idz_czy_wstaw_wynik);
	      $sql_zmien_wynik = "UPDATE `Wyniki` 
	                          SET `id_kol`='$Kolarz[0]', `punkty`='$id_punktacja_fff[0]'
	                          WHERE id_wyn = ".$dane_czy_wstaw_wynik[0]." ";
              
	      if ($Kolarz[0] == '') {
	        //czyli nie podano kolarza liderującego po x etapie to nic
		echo '<font color=blue size=1>Nie podałeś lidera po tym etapie<br/></font>';	
	      } else {
	        echo '<font color=blue size=1>'.$sql_zmien_wynik.'<br/></font>
	           ';                
	        $x_zmien__wynik = mysql_query($sql_zmien_wynik) or die('mysql_query');
	      }
	      
	      
	    } else {
	      //nie było wyniku więc dodajemy nowy
	      $sql_wstaw_wynik = "INSERT INTO `Wyniki`(`id_wyn`, `miejsce`, `id_kol`, `id_wys`, `id_co`, `punkty`, `wynik`) 
                                  VALUES ('$id_nowe_id_wyscigi', 1, '$Kolarz[0]', '$id_wys', 10, '$id_punktacja_fff[0]', '$co_jedziemy')";
              echo '<font color=blue size=1>'.$sql_wstaw_wynik.'<br/></font>';                
	      $wstaw_wynik = mysql_query($sql_wstaw_wynik) or die('mysql_query');
  	      $id_nowe_id_wyscigi=$id_nowe_id_wyscigi+1;
	    } 
         }
         //koniec liderów gotowa także z edycją wyników.
         
         echo '<br/><br/>';
         
         //zaczynamy etapy
         
	    
         for ($i=$poczatek; $i <= $ile_dni_różnicywyslane+$poczatek+1; $i++) {
	   //lecimy po etapach:
	    
	   echo '<br/><br/><b><font color=green>'.$i.' etap ('.$_POST["etap".$i.""].')</font></b><br/>
	        data: '.$_POST["data".$i.""].'<br/>
		Peleton dojechał na miejscu '.$_POST["peleton_".$i.""].' = 
		kategoria wyścigu: '.$_POST["kat1_".$i.""].'<br/>
		';
		
	   //mamy pierwszy etap (może i prolog) trzeba zacząć od kategorii:
	   //Dodajemy też do z_Kategorie
	  $data00 = $_POST['data'.$i];
	  $kat1_00 = $_POST['kat1_'.$i];
	  $peleton_0 = $_POST['peleton_'.$i];
	  $etap_0 = $_POST['etap'.$i];
	  $sql_z_Kategorie_wstaw = "INSERT INTO 
	                            z_EtapyKat(`id_ek`, `data`, `id_kat`, `id_kat2`, `id_wys`, `id_co`, `id_pun`, `pierwszy_z_pel`) 
	                            VALUES ('$id_nowe_id_kategorii', '$data00', '$kat1_00', '$kat','$id_wys', '$etap_0', '$pun', '$peleton_0')";
          echo '<br/>Zapytanie dodające kategorie <br/><font color=blue>'.$sql_z_Kategorie_wstaw.'</font> <br/>';
	  $id_nowe_id_kategorii = $id_nowe_id_kategorii + 1;
	  $idz_z_Kategorie_wstaw = mysql_query($sql_z_Kategorie_wstaw) or die('mysql_query');
	  	
	   //rozbicie na części tych z etapów
	   $miejsca=explode(";",$_POST["wyniki_".$i.""]);
	
	   for($j=0;$j<count($miejsca)-1;$j++)
           {
            $danekol=explode("|",$miejsca[$j]);
	    
	    
	    //echo $danekol[0].'. '.$danekol[2].' ('.$danekol[1].') - '.$danekol[3]." = ".$danekol[4].' w bazie ma numer: ';
	    $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    
  	    //teraz trzeba wyczytać punkty
  	    //Ponieważ etap to
            $kategoria_fff=$dane[6].'e';
	    $sql_punktacja_fff = "SELECT punkty FROM z_puntacja_fff WHERE miejsce='$danekol[0]' AND kat_fff='$kategoria_fff' ";
	    $idz_punktacja_fff = mysql_query($sql_punktacja_fff) or die('mysql_query');
  	    $id_punktacja_fff = mysql_fetch_row($idz_punktacja_fff);
  	    
  	    //wypadałoby sprawdzić, czy może był taki wynik w takim etapie wpisany więc sprawdzamy czy był taki wyścig.
  	    $sql_czy_wstaw_wynik = "SELECT id_wyn, id_kol FROM Wyniki WHERE miejsce=".$danekol[0]." AND id_wys='$id_wys' AND id_co='$etap_0'";
	    $idz_czy_wstaw_wynik = mysql_query($sql_czy_wstaw_wynik) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_wstaw_wynik) > 0) {
	      //były wyniki już dodane dla tego etapu i miejsca
	      $dane_czy_wstaw_wynik = mysql_fetch_row($idz_czy_wstaw_wynik);
	      
	      $sql_zmien_wynik = "UPDATE `Wyniki` 
	                          SET `id_kol`='$Kolarz[0]', `punkty`='$id_punktacja_fff[0]',`wynik`='$danekol[4]'
	                          WHERE id_wyn = ".$dane_czy_wstaw_wynik[0]." ";
              echo '<font color=blue size=1>'.$sql_zmien_wynik.'<br/></font>
	           ';                
	      $x_zmien__wynik = mysql_query($sql_zmien_wynik) or die('mysql_query');
	      
            
	    } else {
	      //wyników do tej pory nie było wrzuconych dla tego miejsca więc dodajemy.
	      $sql_wstaw_wynik = "INSERT INTO `Wyniki`(`id_wyn`, `miejsce`, `id_kol`, `id_wys`, `id_co`, `punkty`, `wynik`) 
                                  VALUES ('$id_nowe_id_wyscigi', ".$danekol[0].", '$Kolarz[0]', '$id_wys', '$etap_0', '$id_punktacja_fff[0]', '$danekol[4]')";
              echo '<font color=blue size=1>'.$sql_wstaw_wynik.'<br/></font>';                
	      $wstaw_wynik = mysql_query($sql_wstaw_wynik) or die('mysql_query');
  	      $id_nowe_id_wyscigi=$id_nowe_id_wyscigi+1;
	    }
	    
	    
	    
  	    //-----------------
  	    //WYNIKI ALL
  	    //----------------
  	    
  	    //do znalezienia $czas_wyscigu o $idkol.
  	    //ustalmy Ekipę danego kolarza aktualnie z historii kolarza.
  	    //$dane[7] <- czaas wyścigu a właściwie jego początek
  	    
  	         $sqlhis1 = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$Kolarz[0]') AND (kiedy <= '$dane[7]')
		             ORDER BY kiedy DESC ";
		            // echo $sqlhis1.'<BR/><Br/>';
	         $zaphis1 = mysql_query($sqlhis1) or die('mysql_query');
	         $danhis1 = mysql_fetch_row($zaphis1);
	         
	         //czyli w tym momencie był on w ekipie $danhis1[0]
  	    
  	    
  	    
  	    
  	    
  	    
  	    $sql_czy_wstaw_wynikALL = "SELECT id_wyn, id_kol FROM WynikiALL WHERE miejsce=".$danekol[0]." AND id_wys='$id_wys' AND id_co='$etap_0'";
	    $idz_czy_wstaw_wynikALL = mysql_query($sql_czy_wstaw_wynikALL) or die('mysql_query');
	    if (mysql_num_rows($idz_czy_wstaw_wynikALL) > 0) {
	      //były wyniki już dodane dla tego etapu i miejsca
	      $dane_czy_wstaw_wynikALL = mysql_fetch_row($idz_czy_wstaw_wynikALL);
	      
	      $sql_zmien_wynikALL = "UPDATE `WynikiALL` 
	                          SET `id_kol`='$Kolarz[0]', `punkty`='$id_punktacja_fff[0]',`wynik`='$danekol[4]', `ekipaW`='$danhis1[0]'
	                          WHERE id_wyn = ".$dane_czy_wstaw_wynikALL[0]." ";
              echo '<font color=blue size=1>'.$sql_zmien_wynikALL.'<br/></font>
	           ';                
	      $x_zmien__wynikALL = mysql_query($sql_zmien_wynikALL) or die('mysql_query');
	      
            
	    } else {
	      //wyników do tej pory nie było wrzuconych dla tego miejsca więc dodajemy.
	      $sql_wstaw_wynikALL = "INSERT INTO `WynikiALL`(`id_wyn`, `miejsce`, `id_kol`, `id_wys`, `id_co`, `punkty`, `wynik`, `ekipaW`) 
                                  VALUES ('$id_nowe_id_wyscigiALL', ".$danekol[0].", '$Kolarz[0]', '$id_wys', '$etap_0', '$id_punktacja_fff[0]', '$danekol[4]', '$danhis1[0]')";
              //echo '<font color=blue size=1>'.$sql_wstaw_wynikALL.'<br/></font>';                
	      $wstaw_wynikALL = mysql_query($sql_wstaw_wynikALL) or die('mysql_query');
  	      $id_nowe_id_wyscigiALL=$id_nowe_id_wyscigiALL+1;
	    }
  	    
           }
	  }
         
	 } //tu koniec etapówek
         
	 
	 echo '
	      ';
	
	
	
	//Jeżeli nic nie dodałem to i wyścigi się nie zmieniły
	//wracamy do $dane_czy_sa_wyniki_w_bazie to było na początku sprawdzone.
	
	if ($dane_czy_sa_wyniki_w_bazie > 0) {
	   $jest = 'uzupełnione wyniki wys='.$id_wys.'.';
           $bylo = '----Do tej pory było '.$dane_czy_sa_wyniki_w_bazie.' wyników w bazie-----';  
	} else {
	   $jest = 'dodane wyniki wys='.$id_wys.'.';
           $bylo = '----NOWE WYNIKI-----';
	}
	      
 
 
 
 	   
	 
	 //i czas dodać kto co zmienił :D
      $a_edyt_OST_sql = "SELECT `id_edyt` FROM `a_edycje` ORDER BY `id_edyt` DESC LIMIT 0 , 1";
      $a_edyt_OST = mysql_query($a_edyt_OST_sql) or die('mysql_query');
      $dane_a_edyt_OST = mysql_fetch_row($a_edyt_OST); 
      
      $dzis = date("Y-m-d H:i:s");
      $id = $dane_a_edyt_OST[0] + 1;
      $a_edyt_sql = "INSERT INTO `a_edycje`(`id_edyt`, `było`, `jest`, `kto`, `kiedy`, `co`, `id`) VALUES (".$id.",'".$bylo."','".$jest."',".$idek.",'".$dzis."', \"WY\", ".$id_wys.")";
      echo '<br/><br/>'.$a_edyt_sql; 
      $a_edyt = mysql_query($a_edyt_sql) or die('mysql_query');  
	 
	 
	 
	 
	 //i teraz na koniec fałszywie dodaje swoje złoszenia
     $i1=1; 
     $zapyt1 = "SELECT Kolarze.id_kol, Kolarze.nazw FROM Kolarze, ktopoj WHERE Kolarze.id_user=20 AND ktopoj.id_wys=\"".$id_wys."\" AND Kolarze.id_kol=ktopoj.id_kol";
     $idzapyt1 = mysql_query($zapyt1) or die('mysql_query');
     while ($wiersz = mysql_fetch_row($idzapyt1)) 
     {
      //echo 'Wystartował ',$wiersz[1].'<br/>';
      
      $zapyt2 = "SELECT id_zgl FROM zgloszenia ORDER BY id_zgl DESC LIMIT 0, 1";
      $idzapyt2 = mysql_query($zapyt2) or die('mysql_query');
      while ($wiersz2 = mysql_fetch_row($idzapyt2)) 
      {
        //echo "Ostatnie zgłoszenie to: ",$wiersz2[0],"<br/>";
        $idzg = $wiersz2[0] + 1;
      }
      
      $zapyt3 = "SELECT dataP FROM Wyscigi WHERE id_wys = '$id_wys'";
      $idzapyt3 = mysql_query($zapyt3) or die('mysql_query');
      while ($wiersz3 = mysql_fetch_row($idzapyt3)) 
      {
        //echo "data wyścigu to: ",$wiersz3[0],"<br/>";
        $datka = $wiersz3[0];
      }
      
      
      //$datka = date("Y-m-d H:i:s");
      
      //echo $idzg, " - ",$i," - ",$wiersz[0]," - ",$id_wys," - ",$data,"<br/>";
      $prio = 0;
      
      
      //Sprawdzam czy było już zgłoszenie tego kolarza przeze mnie:
      $sql_czy_zglaszalem = "SELECT id_kol FROM zgloszenia WHERE id_user = 20 AND id_wys = '$id_wys' AND id_kol='$wiersz[0]'";
      $idz_czy_zglaszalem = mysql_query($sql_czy_zglaszalem) or die('mysql_query');
      $dane_sql_czy_zglaszalem = mysql_num_rows($idz_czy_zglaszalem);
      //echo ' aaaa <br/>'.$sql_czy_zglaszalem.'<br/>';
      
      $zapyt2 = "INSERT INTO zgloszenia (id_zgl, kolej, id_kol, id_wys, id_user, pri, dataZ) VALUES ('$idzg', '$i1', '$wiersz[0]', '$id_wys', 20, '$prio', '$datka')";
      //echo $dane_sql_czy_zglaszalem;
      if ($dane_sql_czy_zglaszalem == 0) {
        
        $idzapyt2 = mysql_query($zapyt2) or die('mysql_query');
        //echo '  - '.$zapyt2,"<br/><br/>";
        $i1 = $i1 + 1;
      }
      
     }
     
     
 
 
 
 
 
 
 
 
 
 
 
 	 //i teraz na koniec  dodaje swoje jasuły =3
     $i1=1; 
     $zapyt1 = "SELECT Kolarze.id_kol, Kolarze.nazw FROM Kolarze, ktopoj WHERE Kolarze.id_user=81 AND ktopoj.id_wys=\"".$id_wys."\" AND Kolarze.id_kol=ktopoj.id_kol";
     $idzapyt1 = mysql_query($zapyt1) or die('mysql_query');
     while ($wiersz = mysql_fetch_row($idzapyt1)) 
     {
      echo 'Wystartował ',$wiersz[1].'<br/>';
      
      $zapyt2 = "SELECT id_zgl FROM zgloszenia ORDER BY id_zgl DESC LIMIT 0, 1";
      $idzapyt2 = mysql_query($zapyt2) or die('mysql_query');
      while ($wiersz2 = mysql_fetch_row($idzapyt2)) 
      {
        echo "Ostatnie zgłoszenie to: ",$wiersz2[0],"<br/>";
        $idzg = $wiersz2[0] + 1;
      }
      
      $zapyt3 = "SELECT dataP FROM Wyscigi WHERE id_wys = '$id_wys'";
      $idzapyt3 = mysql_query($zapyt3) or die('mysql_query');
      while ($wiersz3 = mysql_fetch_row($idzapyt3)) 
      {
        echo "data wyścigu to: ",$wiersz3[0],"<br/>";
        $datka = $wiersz3[0];
      }
      
      
      $datka = date("Y-m-d H:i:s");
      
      echo $idzg, " - ",$i," - ",$wiersz[0]," - ",$id_wys," - ",$data,"<br/>";
      $prio = 0;
      
      
      //Sprawdzam czy było już zgłoszenie tego kolarza przez Jas:
      $sql_czy_zglaszalem = "SELECT id_kol FROM zgloszenia WHERE id_user = 3 AND id_wys = '$id_wys' AND id_kol='$wiersz[0]'";
      $idz_czy_zglaszalem = mysql_query($sql_czy_zglaszalem) or die('mysql_query');
      $dane_sql_czy_zglaszalem = mysql_num_rows($idz_czy_zglaszalem);
      echo ' aaaa <br/>'.$sql_czy_zglaszalem.'<br/>';
      
      $zapyt2 = "INSERT INTO zgloszenia (id_zgl, kolej, id_kol, id_wys, id_user, pri, dataZ) VALUES ('$idzg', '$i1', '$wiersz[0]', '$id_wys', 3, '$prio', '$datka')";
      echo $dane_sql_czy_zglaszalem;
      if ($dane_sql_czy_zglaszalem == 0) {
        
        $idzapyt2 = mysql_query($zapyt2) or die('mysql_query');
        //echo '  - '.$zapyt2,"<br/><br/>";
        $i1 = $i1 + 1;
      }
      
     }
 
 
     
     
	 
	echo '<br/><br/><a href="wyscig.php?id_wys='.$id_wys.'">Przejdź do strony wyścigu</a>';      
	 }
	 
	 else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
         }
         
         
         
         
         echo koniec();
      ?>
  
    
    
    
   
