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
  $id_kol=$_GET["id_kol"];
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <?php 
     echo '<meta http-equiv="Refresh" content="4; URL=kol.php?id_kol='.$id_kol.'">
	  ';
   ?>
   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - panel zarządzający</title>
</head>
<body>
<div>

<?php
  
  
    echo poczatek();
    if($_SESSION['logowanie'] == 'poprawne') {
    if ($_SESSION['boss'] >= 1) {
        //a tu zmieniamy nazwosiko dodajemy
        echo 'dodajemy nazwisko i kraj do listy kolarza o id='.$id_kol;
	
	$sql_dodaj = 'INSERT INTO `Kolarze_nazw`(`idkol`, `nazw`, `nat`) VALUES ('.$id_kol.',"'.$_POST["nazw"].'","'.$_POST["narodowosc"].'")';
	 
	echo $sql_dodaj;     
	$zap_dodaj = mysql_query($sql_dodaj) or die('mysql_query'); 
	     
	     
	     
    } else {
        echo '<h4>Nie masz uprawnień do tej strony</h4>';
    }
    } else {
      echo 'Musisz się zalogować';
    }
    
    
    
    echo koniec();
?>
