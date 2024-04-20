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
   <title>FFF - transfer</title>
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
    <h3  style="color: red">
     Nie odświeżaj tej strony. Gdy przemieli ona informacje przejdx do kolenych.
    </h3>
    <?php 
      if($_SESSION['logowanie'] == 'poprawne') { 
        $id_tp = $_GET['id_tp'];

        
  
        

        $sql2 = " SELECT transprop.kiedy , transprop.id_kol , transprop.id_userK , transprop.id_userS , transprop.ile , Kolarze.cena, transprop.typ "
              . " FROM transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol "
	      . " WHERE id_tp = '$id_tp' ";
        $zap2 = mysql_query($sql2) or die('mysql_query');
        $dan2 = mysql_fetch_row($zap2);
        
        
        
        if ($dan2[6] == 0) {
        
        echo 'id tranz: '.$id_tp.'<br/>kiedy'.$dan2[0].'<br/> id_kolarza:'.$dan2[1].'<br/>id Usera KUPUJĄCEGO'.$dan2[2].'<br/>id Usera SPRZEDAJĄCEGO'.$dan2[3].'<br/>ile za tranzakcję'.$dan2[4].'<br/>ile proprzednio kosztował kolarz:'.$dan2[5];
        
        $sql3 = " DELETE FROM transprop WHERE id_tp = '$id_tp' ";
        $zap3 = mysql_query($sql3) or die('mysql_query');
        echo 'Kasuję dane zawodnika z listy proponowanych transferów <br/><br/>';
        
        
        
        } else {
          echo 'wymiana kolarzy <br/><br/>';
          
          
          
          
          
          echo 'id tranz: '.$id_tp.'<br/>kiedy '.$dan2[0].'<br/> id_kolarza: '.$dan2[1].'<br/>id Usera KUPUJĄCEGO '.$dan2[2].'<br/>id Usera SPRZEDAJĄCEGO '.$dan2[3].'<br/>kolarz który idzie na wymianę '.$dan2[4].'<br/>ile proprzednio kosztował kolarz: '.$dan2[5];
        
        $sql3 = " DELETE FROM transprop WHERE id_tp = '$id_tp' ";
        $zap3 = mysql_query($sql3) or die('mysql_query');
        
        
        $za_kogo = $dan2[4] * (-1);
        $sql3 = " DELETE FROM transprop WHERE ((id_kol = '$za_kogo') AND (ile = '$dan2[1]')) ";
        $zap3 = mysql_query($sql3) or die('mysql_query');
        
        echo '<br/><br/>Kasuję dane zawodników z listy proponowanych transferów:.'.$dan2[1].' i '.$za_kogo.' <br/><br/>';
        
        } 
 
 
 
       } else {
         echo 'Nie masz uprawnień do tej strony';
       }  
       
       
       
       
       echo koniec();  
    ?>
    
    
    
    
