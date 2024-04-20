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
       while ($dan = mysql_fetch_row($id_zap)) 
       {
         $punktynat = 0;
         Echo $dan[0]." - ".$dan[1]."<br/>";
         
         $zap1= "SELECT Kolarze.imie, Kolarze.nazw, SUM( WynikiP.punkty )
                 FROM WynikiP
                 INNER JOIN Kolarze ON Kolarze.id_kol = WynikiP.id_kol
                 WHERE WynikiP.id_wys >=9000
                   AND WynikiP.id_wys < 9799
                   AND Kolarze.id_nat = '$dan[0]'
                 GROUP BY Kolarze.imie, Kolarze.nazw
                 ORDER BY SUM( WynikiP.punkty ) DESC , Kolarze.nazw
                 LIMIT 0 , 8";
         //echo $zap1."br/>";        
         $id_zap1 = mysql_query($zap1) or die('mysql_query');
         while ($dan1 = mysql_fetch_row($id_zap1)) 
         { 
	    echo "kolarz: ".$dan1[1]." punktów: ".$dan1[2]." <br/>";
	    $punktynat = $punktynat + $dan1[2];
	 }      
         echo "punkty Nat: ".$punktynat."<br/><br/>";
         
         //echo "<table>
	 //      <tr><td>";
       }
      

    }
       
    
    
    
    echo koniec();
    ?>
