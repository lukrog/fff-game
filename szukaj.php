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
   <title>FFF - szukaj</title>
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
    
    
    
      $czego=$_POST['czego'];
      
      $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy.nazwa
               FROM Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team
	       WHERE ((CONCAT_WS(' ',Kolarze.imie, Kolarze.nazw) Like '%".$czego."%') OR (CONCAT_WS(' ', Kolarze.nazw,Kolarze.imie) Like '%".$czego."%'))
	       ORDER BY Kolarze.nazw ";
      $zap  = mysql_query($sql) or die('mysql_query');
      echo '<table class="wyscig">';
      echo '<tr><td class="wyscig2"> Kolarz </td><td class="wyscig5"> Kraj </td><td class="wyscig2"> Ekipa </td></tr>';
      while ($dane = mysql_fetch_row($zap)) {
        echo '<tr><td><a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' '.$dane[2].'</a> </td><td> <img src="img/flagi/'.$dane[3].'" </td><td> '.$dane[4].' </td></tr>';  
        }
      echo '</table>';
    
    
    
    echo koniec();
    ?>
    

  
