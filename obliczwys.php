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
         $id_wys =  $_POST['idwys'];
         if ($_SESSION['boss'] > 1) {
	 $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC FROM Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat WHERE (((Wyscigi.id_wys)= '$id_wys' ))";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
	  echo '<table id="menu2">';
          echo '<tr><td><i>id wyścigu: </i></td><td>'.$id_wys.'</td></tr>';
          echo '<tr><td><i>nazwa wyścigu: </i></td><td>[size=20]'.$dane[1].'[/size]</td></tr>';
          echo '<tr><td><i>kraj rozgrywania: </i></td><td>'.$dane[3].' <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>';
          echo '<tr><td><i>klasyfikacja UCI: </i></td><td>'.$dane[5].'</td></tr>';
          echo '<tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr>';
          echo '</table>';
	  echo '[size=20]'.$dane[1].'[/size]<br/><br/>';
	 // Sprawdzamy czy są wyniki: ---------------------------------------------------------------
	 echo '<h3>Wyniki znajdjące się w bazie</h3>';
	 $sql1 = " SELECT Count(Wyniki.id_wyn) AS ile_wynikow , Co.nazwa "
	       . " FROM Wyniki INNER JOIN Co ON Wyniki.id_co = Co.id_co "
	       . " WHERE Wyniki.id_wys = '$id_wys' GROUP BY Co.nazwa ";
	 $zap1 = mysql_query($sql1) or die('mysql_query');
         while ($wyn1 = mysql_fetch_row($zap1)) 
         { 
           echo $wyn1[1].' - znaleziono <b>'.$wyn1[0].'</b> wyników w tej kategorii <br/>';
         }
         if (mysql_num_rows($zap1) == 0) {
           echo '<font color=red>NIE MA WKLEPANYCH WYNIKÓW</font>';
         }
         echo '<br/><br/>';
         
         //Sprawdzamy zgłoszenia do tego wyścigu ----------------------------------------------------
         echo '<h3>Zgłoszenia znajdjące się w bazie</h3>';
       	 $sql2 = " SELECT count( id_zgl ) , id_wys   "
	       . " FROM zgloszenia "
	       . " WHERE id_wys = '$id_wys' "
	       . " GROUP BY id_wys  ";
	 $zap2 = mysql_query($sql2) or die('mysql_query');
         while ($wyn2 = mysql_fetch_row($zap2)) 
         { 
           echo ' - znaleziono <b>'.$wyn2[0].'</b> wyników w tej kategorii <br/>';
         }
         if (mysql_num_rows($zap2) == 0) {
           echo '<font color=red>NIE MA WKLEPANYCH WYNIKÓW</font>';
         }
         echo '<br/><br/>';
         
         //Sprawdzamy listę kolarzy którzy pojechali -------------------------------------------------
         echo '<h3>Kolarze którzy pojechali w wyścigu znajdjące się w bazie</h3>';
       	 $sql3 = " SELECT count( id_kp ) , id_wys   "
	       . " FROM ktopoj "
	       . " WHERE id_wys = '$id_wys' "
	       . " GROUP BY id_wys  ";
	 $zap3 = mysql_query($sql3) or die('mysql_query');
         while ($wyn3 = mysql_fetch_row($zap3)) 
         { 
           echo ' - znaleziono <b>'.$wyn3[0].'</b> wyników w tej kategorii <br/>';
         }
         if (mysql_num_rows($zap3) == 0) {
           echo '<font color=red>NIE MA WKLEPANYCH WYNIKÓW</font>';
         }
         echo '<br/><br/>';
         echo '<form action="obliczwysW.php" method="post">';
         echo '<input type="hidden" name="idwys" value="'.$id_wys.'" />';
         //echo '<input type="hidden" name="idwys1" value="" />';
         
         echo ' <h5><font color=green> UWAGA NACIŚNIĘCIE [ZATWERDŹ] SKASUJE AKTUALNE DENE Z WYŚCIGU I POLICZONE ZOSTANĄ NOWE</font></h5>';
         echo '<input type=submit value="Zatwierdź" />';
         echo '</form>';
         
         } else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
         }
         
         
         
         
         echo koniec();
      ?>
  
    
    
    
   
