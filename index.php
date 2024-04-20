<?php 
  //Łączenie się z bazą php
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
   <link rel="shortcut icon" href="favicon.ico" />
   <title>FFF - strona glowna</title>
</head>
<body>
<div>

<?php
  echo google();

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
    ?>
    
    
    <?php

         if($_SESSION['logowanie'] == 'poprawne') {
           
           
           
         echo '<br />
		Stare forum umarło chyba na zawsze. Zapraszamy na nowe:<br />
		<a href="https://kolarstwo.atspace.eu/forums/">https://kolarstwo.atspace.eu/forums/</a>
		<br />
		<br />
		<br />
		';  
           
           
         if ($_SESSION['boss'] > 2) {
	   $dzis = date('Y-m-d');
           $sqlptr = " SELECT id_kol, kiedy, id_z, id_do, id_hk, id_user FROM z_a_historiakolprop WHERE kiedy <= '$dzis' ORDER BY kiedy";
           $zapptr = mysql_query($sqlptr) or die('mysql_query');
           //$iletrans = 
           echo 'w bazie jest '.mysql_num_rows($zapptr).' transferów zaległy<br/>
	   <a href="http://fff.xon.pl/transferyEXE.php">Przeprowadź transfery</a>
	   <br/><br/>
	   ';
	 }  
           
           
           
         $dzis=date("Y-m-d");
         $miesiac_za = strtotime($dzis) + 30 * 24 * 3600;
         $miesiac_za = date('Y-m-d',$miesiac_za);
         $tydzien_za = strtotime($dzis)+ 7 * 24 * 3600;
         $tydzien_za = date('Y-m-d',$tydzien_za);
         
         echo ' <h4 style="color: red;">Właśnie odbywające się wydarzenia: ('.$dzis.')</h4>';
         $sql1 = " SELECT dok, dataP, dataK FROM wydarzenia "
               . " WHERE DATE(dataP) <= '$dzis' AND DATE(dataK) >= '$dzis' ";
         $zap1  = mysql_query($sql1) or die('mysql_query');
         while ($wie1 = mysql_fetch_row($zap1)) {
           echo ' - '.$wie1[0].'('.$wie1[1].' --- '.$wie1[2].')<br/>';
         }
         
                  if(mysql_num_rows($zap1) == 0) {
           echo ' - brak <br/>';
         }
         
         echo '<h5>Wyścigi</h5>';
         $sql1 = " SELECT Wyscigi.nazwa, Wyscigi.klaPC, Nat.flaga, DATE(Wyscigi.dataP), Wyscigi.dataK, Wyscigi.id_wys, Wyscigi.dataP, Wyscigi.klaUCI, Wyscigi.id_wys "
               . " FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat "
	       . " WHERE DATE(Wyscigi.dataP) <= '$dzis' AND Wyscigi.dataK >= '$dzis' "
	       . " ORDER BY Wyscigi.dataP ";
         $zap1  = mysql_query($sql1) or die('mysql_query');
         while ($wie1 = mysql_fetch_row($zap1)) {
           echo ' - <a href="wyscig.php?id_wys='.$wie1[8].'">'.$wie1[0].'</a> ('.$wie1[1].') <img src="img/flagi/'.$wie1[2].'" alt="flaga" /> ('.$wie1[3];

	   if ($wie1[3] == $wie1[4]) 
	   {

           } else {
             echo ' --- '.$wie1[4];
           }
	   echo ')
	   ';
	   
	          $sqla = " SELECT *  "
                        . " FROM zgloszenia "
                        . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$wie1[8]')  "; 
                  $dan = mysql_query($sqla) or die(mysql_error());
                  
		  //echo $idek;
		  //echo ' > '.$dane[7].' <> '.date("Y-m-d H:i:s").' < ';
                  
		  if ($wie1[6] >= date("Y-m-d H:i:s")) {
                    if (($wie1[7] == "OG  ") OR ($wie1[7] == "MŚ  ") OR ($wie1[7] == "NC" )) {
                    echo '<img src="img/wyscig/auto.jpg" alt="automat zgłoszenie" />';
                    } else {
                    if(mysql_num_rows($dan) > 0) {
                      
                      echo '<a href="zglaszanie.php?id_wys='.$wie1[8].'"><img src="img/wyscig/edytuj.jpg" alt="edytuj zgłoszenie" border=0 /></a>';
                    } else {
	              echo '<a href="zglaszanie.php?id_wys='.$wie1[8].'"><img src="img/wyscig/ustaw.jpg" alt="dodaj zgłoszenie" border=0 /></a>';
	            }
	            }
                  } else {
                    echo '<img src="img/wyscig/nici.jpg" alt="za późno" />';
                  }
                  
	   
	   
	   echo '
	   <br/>';
	   
	   
         }
         if(mysql_num_rows($zap1) == 0) {
           echo ' - brak wyścigów <br/>';
         }
         echo '<br/><br/>';


         
         echo ' <h4 style="color: green;">Wydarzenia w najbliższym tygodniu: (do: '.$tydzien_za.')</h4>';
         $sql1 = " SELECT dok, dataP, dataK FROM wydarzenia "
               . " WHERE dataP > '$dzis' AND dataP <= '$tydzien_za' ";
         $zap1  = mysql_query($sql1) or die('mysql_query');
         while ($wie1 = mysql_fetch_row($zap1)) {
           echo ' - '.$wie1[0].' ('.$wie1[1].' --- '.$wie1[2].')<br/>';
         }
         if(mysql_num_rows($zap1) == 0) {
           echo ' - brak <br/>';
         }
         echo '<h5>Wyścigi</h5>';         
         $sql1 = " SELECT Wyscigi.nazwa, Wyscigi.klaPC, Nat.flaga, DATE(Wyscigi.dataP), Wyscigi.dataK, Wyscigi.id_wys, Wyscigi.dataP, Wyscigi.klaUCI, Wyscigi.id_wys "
              . " FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat "
	      . " WHERE DATE(Wyscigi.dataP) > '$dzis' AND DATE(Wyscigi.datap) <= '$tydzien_za' "
	      . " ORDER BY Wyscigi.dataP ";
         $zap1  = mysql_query($sql1) or die('mysql_query');
         while ($wie1 = mysql_fetch_row($zap1)) {
           
           
           echo ' - <a href="wyscig.php?id_wys='.$wie1[8].'">'.$wie1[0].'</a> ('.$wie1[1].') <img src="img/flagi/'.$wie1[2].'" alt="flaga" /> ('.$wie1[3];

	   if ($wie1[3] == $wie1[4]) 
	   {

           } else {
             echo ' --- '.$wie1[4];
           }
	   echo ')
	   ';
	   
	   $sqla = " SELECT *  "
                        . " FROM zgloszenia "
                        . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$wie1[8]')  "; 
                  $dan = mysql_query($sqla) or die(mysql_error());
                  
		  //echo $idek;
		  //echo ' > '.$wie1[6].' <> '.date("Y-m-d H:i:s").' < ';
                  
		  if ($wie1[6] >= date("Y-m-d H:i:s")) {
                    if (($wie1[7] == "OG  ") OR ($wie1[7] == "MŚ  ") OR ($wie1[7] == "NC" )) {
                    echo '<img src="img/wyscig/auto.jpg" alt="automat zgłoszenie" />';
                    } else {
                    if(mysql_num_rows($dan) > 0) {
                      
                      echo '<a href="zglaszanie.php?id_wys='.$wie1[8].'"><img src="img/wyscig/edytuj.jpg" alt="edytuj zgłoszenie" border=0 /></a>';
                    } else {
	              echo '<a href="zglaszanie.php?id_wys='.$wie1[8].'"><img src="img/wyscig/ustaw.jpg" alt="dodaj zgłoszenie" border=0 /></a>';
	            }
	            }
                  } else {
                    echo '<img src="img/wyscig/nici.jpg" alt="za późno" />';
                  }
                  
	   
	   
	   echo '<br/>';
	   
	   
	   }
         if(mysql_num_rows($zap1) == 0) {
           echo ' - brak wyścigów <br/>';
         }
         echo '<br/><br/>';
         
         
         echo ' <h4 style="color: green;">Wydarzenia w najbliższym miesiącu: (do: '.$miesiac_za.')</h4>';
         $sql1 = " SELECT dok, dataP, dataK FROM wydarzenia "
               . " WHERE DATE(dataP) > '$tydzien_za' AND DATE(dataP) <= '$miesiac_za' ";
         $zap1  = mysql_query($sql1) or die('mysql_query');
         while ($wie1 = mysql_fetch_row($zap1)) {
           echo ' - '.$wie1[0].' ('.$wie1[1].' --- '.$wie1[2].')<br/>';
         }
         if(mysql_num_rows($zap1) == 0) {
           echo ' - brak <br/>';
         }
         echo '<h5>Wyścigi</h5>';
         $sql1 = " SELECT Wyscigi.nazwa, Wyscigi.klaPC, Nat.flaga, DATE(Wyscigi.dataP), Wyscigi.dataK, Wyscigi.id_wys, Wyscigi.dataP, Wyscigi.klaUCI, Wyscigi.id_wys "
              . " FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat "
	      . " WHERE DATE(Wyscigi.dataP) > '$tydzien_za' AND Wyscigi.datap <= '$miesiac_za' "
	      . " ORDER BY Wyscigi.dataP ";
         $zap1  = mysql_query($sql1) or die('mysql_query');
         while ($wie1 = mysql_fetch_row($zap1)) {
           
           
           echo ' - <a href="wyscig.php?id_wys='.$wie1[8].'">'.$wie1[0].'</a> ('.$wie1[1].') <img src="img/flagi/'.$wie1[2].'" alt="flaga" /> ('.$wie1[3];

	   if ($wie1[3] == $wie1[4]) 
	   {

           } else {
             echo ' --- '.$wie1[4];
           }
	   echo ')
	   ';
	   
	   $sqla = " SELECT *  "
                        . " FROM zgloszenia "
                        . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$wie1[8]')  "; 
                  $dan = mysql_query($sqla) or die(mysql_error());
                  
		  //echo $idek;
		  //echo ' > '.$wie1[6].' <> '.date("Y-m-d H:i:s").' < ';
                  
		  if ($wie1[6] >= date("Y-m-d H:i:s")) {
                    if (($wie1[7] == "OG  ") OR ($wie1[7] == "MŚ  ") OR ($wie1[7] == "NC" )) {
                    echo '<img src="img/wyscig/auto.jpg" alt="automat zgłoszenie" />';
                    } else {
                    if(mysql_num_rows($dan) > 0) {
                      
                      echo '<a href="zglaszanie.php?id_wys='.$wie1[8].'"><img src="img/wyscig/edytuj.jpg" alt="edytuj zgłoszenie" border=0 /></a>';
                    } else {
	              echo '<a href="zglaszanie.php?id_wys='.$wie1[8].'"><img src="img/wyscig/ustaw.jpg" alt="dodaj zgłoszenie" border=0 /></a>';
	            }
	            }
                  } else {
                    echo '<img src="img/wyscig/nici.jpg" alt="za późno" />';
                  }
                  
	   
	   
	   echo '<br/>';
	   
	   
	   }
         if(mysql_num_rows($zap1) == 0) {
           echo ' - brak wyścigów<br/>';
         }
         echo '<h5><a href="wydarzenia.php">wszystkie planowane wydarzenia</a></h5>';
         
         
         }
       ?>

    <br/> <br/>
    <h4 style="color: green;">Informacje ogólne:</h4> 
     
    <i>28-01-2009</i> - wprowadzono historię kolarzy i ekip (odchodzący przychodzący i przyszłe transfery) <br/>
    <i>20-01-2009</i> - przeprowadzono aktualizację kolarzy na wileką skalę   <br/> 
    <i>20-12-2008</i> - wprowadzono moduł licytacji kolarzy <br/> 
    <i>29-03-2008</i> - uruchomienie pakietu rankingów <br/>     
    <i>14-01-2008</i> - uruchomienie pakietu dodatkow (opis ekipy i koszulka)<br/>      
    <i>06-01-2008</i> - uruchomienie wersji finalnej<br/>   
    <i>28-12-2007</i> - uruchominie w całości modułów transferów i zwolnien kolarzy - moduł liytacji zostawiony na potem (trwają testy)<br/>
    <i>28-12-2007</i> - uruchominie w całości modułów wyścigów i modułów zgłaszania kolarzy i weryfikacji startowego (do zrobienia: transfery i FA)<br/>
    <i>24-12-2007</i> - przenosiny strony na docelowy płatny serwer i jej rozwój<br/>
    <i>20-12-2007</i> - przenosiny strony i jej rozwój<br/>
    <i>15-12-2007</i> - strona pojawiła się w ramach testów na pierwszym serwerze<br/>


    
    <?php  
    echo koniec();
    ?>
