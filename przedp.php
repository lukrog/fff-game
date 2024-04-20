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
   <meta http-equiv="Refresh" content="1; URL=przed.php">
   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - kto tu rządzi</title>
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
    
    echo 'tu cos napisze '.$_POST['ile'].'<br/><br/>';
    $ilukolarzy=$_POST['ile'];

   
    echo $ilukolarzy;

    $zapytanie = "DELETE FROM przed WHERE id_user = \"".$idek."\"";
    $idzapytania = mysql_query($zapytanie) or die('mysql_query');

    echo '<br/><br/>';

    $i=1;
    while ($i <= $ilukolarzy) 
    {
       $co='przed'.$i;
       echo 'id kolarza: '.$_POST[$co].'<br/>';
       $i++;
       $zapytanie = "INSERT INTO przed (id_user, id_kol) VALUES ('.$idek.','.$_POST[$co].')";
       $idzapytania = mysql_query($zapytanie) or die('mysql_query');
    }


    $zapytanie = "DELETE FROM przed WHERE id_kol = 0";
    $idzapytania = mysql_query($zapytanie) or die('mysql_query');



    echo koniec(); 
    ?>

    
