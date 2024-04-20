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
   <title>FFF - wyscigi</title>
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
	  
	  
	  
	  if ($_GET['rok'] == "") {
            $rokteraz = date("Y");
          } else {
            $rokteraz = $_GET['rok'];
          }
          
	  echo '<h3>Wyścigi w '.$rokteraz.' roku</h3>';
	  $poczatek = 1000 * ($rokteraz - 2000);
	  $koniec = 1000 * ($rokteraz + 1 - 2000);	  
	  	  
	  	  
	  $sql = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.nazwa, Nat.flaga, Wyscigi.klaPC, DATE(Wyscigi.dataP), Wyscigi.klaUCI, Wyscigi.dataP "
	       . " FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat "
	       . " WHERE Wyscigi.id_wys >= '$poczatek' AND Wyscigi.id_wys < '$koniec' "
               . " ORDER BY DATE(Wyscigi.dataP), Wyscigi.id_wys ";
	       
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table id="menu2">';
          echo '<tr><td class="wyscig7">nazwa</td><td class="wyscig6">Klasyfikacja PC</td><td class="wyscig6">Data startu';
	  if ($_SESSION['logowanie'] == 'poprawne') {
	    echo '</td><td>zgloszenia';
	    }
	  echo '</td></tr>';
	  
	  while ($dane = mysql_fetch_row($idzapytania)) {
            echo '<tr><td><img src="img/flagi/'.$dane[3].'" alt="'.$dane[2].'"/> <a href="wyscig.php?id_wys='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[4].'</td><td>';
	    
	    $dzis=date("Y-m-d");
	    $dwadni_za = strtotime($dzis) + 2 * 24 * 3600;
            $dwadni_za = date('Y-m-d',$dwadni_za);
	    if (($dane[5] <= $dwadni_za) AND $dane[5] >= $dzis ) {
              echo '<b>'.$dane[5].'</b>';
            } else {
	      echo $dane[5]; 
	    }
	    
	      if ($_SESSION['logowanie'] == 'poprawne') {
                  $sqla = " SELECT *  "
                        . " FROM zgloszenia "
                        . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$dane[0]')  "; 
                  $dan = mysql_query($sqla) or die(mysql_error());
                  
		  //echo $idek;
		  //echo ' > '.$dane[7].' <> '.date("Y-m-d H:i:s").' < ';
                  if ($dane[7] >= date("Y-m-d H:i:s")) {
                    if (($dane[6] == "OG  ") OR ($dane[6] == "MŚ  ") OR ($dane[6] == "NC" )) {
                    echo '</td><td><img src="img/wyscig/auto.jpg" alt="automat zgłoszenie" />';
                    } else {
                    if(mysql_num_rows($dan) > 0) {
                      
                      echo '</td><td><a href="zglaszanie.php?id_wys='.$dane[0].'"><img src="img/wyscig/edytuj.jpg" alt="edytuj zgłoszenie" border=0 /></a>';
                    } else {
	              echo '</td><td><a href="zglaszanie.php?id_wys='.$dane[0].'"><img src="img/wyscig/ustaw.jpg" alt="dodaj zgłoszenie" border=0 /></a>';
	            }
	            }
                  } else {
                    echo '</td><td><img src="img/wyscig/nici.jpg" alt="za późno" />';
                  }
                  
                  
	      
	      
	      $sqlas = " SELECT pri FROM zgloszenia WHERE id_user = '$idek' AND id_wys = '$dane[0]' ";
              $danas = mysql_query($sqlas) or die(mysql_error());
              $daneas = mysql_fetch_row($danas);
              if ($daneas[0] > 0) 
	        {
		  echo ' <img src="img/wyscig/prio.jpg" alt="priorytet" border=1 />';
		}
		
	      
	      $sqlpol = " SELECT wynikidru.id_wdr FROM wynikidru WHERE wynikidru.id_wys = '$dane[0]' ";
	      $danpol = mysql_query($sqlpol) or die(mysql_error());
	      if (mysql_num_rows($danpol) > 0) {
                echo " +";
              }
	      	
	      }
            echo '</td></tr>';
          }  
          echo '</table><br/><br/>';
          
          
          
          
          echo koniec();
	  
       ?>
    
    
   
