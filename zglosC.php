<?php 
  //łączenie się z bazą php
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
   <title>FFF - wrzuć graczy BB</title>
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
    $i = 1;
    $id_wys = $_GET['id_wys'];
    $id_ekc = 14;
    if ($id_wys > 11999) {
    
     $zapyt1 = "SELECT Kolarze.id_kol, Kolarze.nazw FROM Kolarze INNER JOIN ktopoj ON Kolarze.id_kol=ktopoj.id_kol WHERE Kolarze.id_user=\"".$id_ekc."\" AND ktopoj.id_wys=\"".$id_wys."\" AND Kolarze.id_user > 0";
     $idzapyt1 = mysql_query($zapyt1) or die('mysql_query');
     while ($wiersz = mysql_fetch_row($idzapyt1)) 
     {
      echo 'Wystartował ',$wiersz[1];
      
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
      
      
      //$datka = date("Y-m-d H:i:s");
      
      echo $idzg, " - ",$i," - ",$wiersz[0]," - ",$id_wys," - ",$data,"<br/>";
      $prio = 0;
      
      $zapyt2 = "INSERT INTO zgloszenia (id_zgl, kolej, id_kol, id_wys, id_user, pri, dataZ) VALUES ('$idzg', '$i', '$wiersz[0]', '$id_wys', '$id_ekc', '$prio', '$datka')";
      $idzapyt2 = mysql_query($zapyt2) or die('mysql_query');
      echo $zapyt2,"<br/><br/>";
      $i = $i + 1;
      
     }

    
    
    } else {
      echo "Nie podałeś id wyścigu";
    }
    
      $zapyt3 = "DELETE FROM zgloszenia WHERE  zgloszenia.id_user = 0";
      $idzapyt3 = mysql_query($zapyt3) or die('mysql_query');
      echo $zapyt3,"<br/><br/>";
      

    echo koniec();
?>
    
    
    
