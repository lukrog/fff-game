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
   <title>FFF - panel zarządzający</title>
</head>
<body>
<div>

<?php
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
    
    
    if ($_SESSION['boss'] >= 2) {
      
      $zap = "select * FROM Nat ";
      $id_zap = mysql_query($zap) or die('mysql_query');
      echo '<table><th>kolarza</th><th>kraj</th><th>punkty krajowe</th></tr>';
      
       while ($dan = mysql_fetch_row($id_zap)) 
       {
         $punktynat = 0;
         Echo '<tr><td>';
         
         $zap1= "SELECT Kolarze.imie, Kolarze.nazw, SUM( Wyniki.punkty )
                 FROM Wyniki
                 INNER JOIN Kolarze ON Kolarze.id_kol = Wyniki.id_kol
                 WHERE Wyniki.id_wys >=11000
                   AND Wyniki.id_wys < 11800
                   AND Kolarze.id_nat = '$dan[0]'
                 GROUP BY Kolarze.imie, Kolarze.nazw
                 ORDER BY SUM( Wyniki.punkty ) DESC , Kolarze.nazw
                 LIMIT 0 , 8";
                 //do 11800 bo bez Mistrzostw krajowych
         //echo $zap1."br/>";        
         $id_zap1 = mysql_query($zap1) or die('mysql_query');
         $licz = 1;
	 while ($dan1 = mysql_fetch_row($id_zap1)) 
         { 
	    echo $licz." <i>".$dan1[1]."</i> p.: ".$dan1[2]."";
	    $punktynat = $punktynat + $dan1[2];
	    $licz = $licz +1;
	    echo '</td><td><b>'.$dan[1].'</b> ('.$dan[0].')</td><td><b>'.$punktynat."</b></td></tr><tr><td>";
	 }     
	 
	 
         echo '</td></tr>';
         echo $punktynat.' = '.$dan[1]." (".$dan[0].')<br/>';
         //echo "<table>
	 //      <tr><td>";
       }
       echo '</table>';
      

    }
       
    
    
    
    echo koniec();
    ?>
