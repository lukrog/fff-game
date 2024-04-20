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
   <title>FFF - statystyki</title>
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
       $sql = " SELECT Kolarze.imie , Kolarze.nazw , Kolarze.dataU , Nat.nazwa , Ekipy.nazwa , User.login "
            . " FROM Ekipy INNER JOIN ( User INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON User.id_user = Kolarze.id_user ) ON Ekipy.id_team = Kolarze.id_team "
            . " WHERE Kolarze.dataU > \"1901-01-01\" AND User.id_user > 0 "
            . " ORDER BY Kolarze.dataU LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Najstarsi kolarze</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
         $dzis = strtotime(date("Y-m-d"));
         $wiek = strtotime($dane[2]);
	 $wiek = $dzis - $wiek;
	 $wiek = floor($wiek / (3600 * 24 * 365));
	 
         echo '<td><td class="wyscig1">'.$wiek.'</td><td class="wyscig2">'.$dane[0].' <b>'.$dane[1].'</b></td><td class="wyscig6">'.$dane[2].'</td><td class="wyscig6">'.$dane[3].'</td><td class="wyscig6">'.$dane[4].'</td><td class="wyscig6">'.$dane[5].'</td></tr>';
       }	  
       echo '</table>';
	  
	  
	  
	  
       $sql = " SELECT Kolarze.imie , Kolarze.nazw , Kolarze.dataU , Nat.nazwa , Ekipy.nazwa , User.login "
            . " FROM Ekipy INNER JOIN ( User INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON User.id_user = Kolarze.id_user ) ON Ekipy.id_team = Kolarze.id_team "
            . " WHERE User.id_user > 0 "
            . " ORDER BY Kolarze.dataU DESC LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Najmłodsi kolarze</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
         $dzis = strtotime(date("Y-m-d"));
         $wiek = strtotime($dane[2]);
	 $wiek = $dzis - $wiek;
	 $wiek = floor($wiek / (3600 * 24 * 365));
	 
         echo '<td><td class="wyscig1">'.$wiek.'</td><td class="wyscig2">'.$dane[0].' <b>'.$dane[1].'</b></td><td class="wyscig6">'.$dane[2].'</td><td class="wyscig6">'.$dane[3].'</td><td class="wyscig6">'.$dane[4].'</td><td class="wyscig6">'.$dane[5].'</td></tr>';
       }	  
       echo '</table>';  
       
       
       
       $sql = " SELECT Kolarze.imie , Kolarze.nazw , Kolarze.dataU , Nat.nazwa , Ekipy.nazwa , User.login, Kolarze.cena "
            . " FROM Ekipy INNER JOIN ( User INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON User.id_user = Kolarze.id_user ) ON Ekipy.id_team = Kolarze.id_team "
            . " ORDER BY Kolarze.cena DESC LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Najdrożsi kolarze</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
         $dzis = strtotime(date("Y-m-d"));
         $wiek = strtotime($dane[2]);
	 $wiek = $dzis - $wiek;
	 $wiek = floor($wiek / (3600 * 24 * 365));
	 
         echo '<td><td class="wyscig1">'.$dane[6].'</td><td class="wyscig2">'.$dane[0].' <b>'.$dane[1].'</b></td><td class="wyscig1">'.$wiek.'</td><td class="wyscig6">'.$dane[3].'</td><td class="wyscig8">'.$dane[4].'</td><td class="wyscig6">'.$dane[5].'</td></tr>';
       }	  
       echo '</table>'; 
       
       $sql = " SELECT Nat.nazwa , Count( Kolarze.id_kol ) AS PoliczOfid_kol "
            . " FROM Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat "
            . " GROUP BY Nat.nazwa "
            . " ORDER BY Count( Kolarze.id_kol ) DESC LIMIT 0, 15 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>najwięcej kolarzy z krajów</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
          echo '<td><td class="wyscig6">'.$dane[0].'</td><td class="wyscig1">'.$dane[1].'</td></tr>';
       }	  
       echo '</table>';     
            
       
       $sql = " SELECT Nat.nazwa, Count(Kolarze.id_kol) AS PoliczOfid_kol "
            . " FROM Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat "
            . " WHERE (((Kolarze.id_user)>0)) "
            . " GROUP BY Nat.nazwa "
            . " ORDER BY Count(Kolarze.id_kol) DESC LIMIT 0, 15 ";
;
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>najwięcej kolarzy zakontraktowanych z krajów</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
          echo '<td><td class="wyscig6">'.$dane[0].'</td><td class="wyscig1">'.$dane[1].'</td></tr>';
       }	  
       echo '</table>'; 
       
       
       $sql = " SELECT User.ekipa, User.login, Avg(Kolarze.cena), User.liga "
            . " FROM User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user "
            . " WHERE User.id_user > 0 "
            . " GROUP BY Kolarze.id_user, User.ekipa, User.login "
            . " ORDER BY Avg(Kolarze.cena) DESC "
	    . " LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Średnia cena kolarzy w ekipach - najwyższe</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
          echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') ['.$dane[3].'] </td><td class="wyscig6">'.$dane[2].'</td></tr>';
       }	  
       echo '</table>'; 
       
       $sql = " SELECT User.ekipa, User.login, Avg(Kolarze.cena), User.liga "
            . " FROM User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user "
            . " WHERE User.id_user >0 "
            . " GROUP BY Kolarze.id_user, User.ekipa, User.login "
            . " ORDER BY Avg(Kolarze.cena) "
	    . " LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Średnia cena kolarzy w ekipach - najniższe</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
          echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') ['.$dane[3].'] </td><td class="wyscig6">'.$dane[2].'</td></tr>';
       }	  
       echo '</table>'; 
       
       $sql = " SELECT User.ekipa, User.login, Count(Kolarze.id_kol), User.liga "
            . " FROM User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user "
            . " WHERE User.id_user >0 "
            . " GROUP BY Kolarze.id_user, User.ekipa, User.login "
            . " ORDER BY Count(Kolarze.id_kol) DESC "
	    . " LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Najliczniejsze ekipy</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
          echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') ['.$dane[3].'] </td><td class="wyscig6">'.$dane[2].'</td></tr>';
       }	  
       echo '</table>'; 
       
       
       
       $sql = " SELECT User.ekipa, User.login, Count(Kolarze.id_kol), User.liga "
            . " FROM User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user "
            . " WHERE User.id_user >0 "
            . " GROUP BY Kolarze.id_user, User.ekipa, User.login "
            . " ORDER BY Count(Kolarze.id_kol) "
	    . " LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       echo '<h4>Najmniej liczne ekipy</h4>';
       echo '<table class="wyscig">';
       while ($dane = mysql_fetch_row($zap)) 
       {
          echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') ['.$dane[3].'] </td><td class="wyscig6">'.$dane[2].'</td></tr>';
       }	  
       echo '</table>'; 
       
       

       echo '<h4>Najstarsze ekipy</h4>';
       echo '<table class="wyscig">';
       
       $sql = " SELECT User.ekipa, User.login, Avg(Year(CURRENT_TIMESTAMP)-Year(Kolarze.dataU)), User.liga, User.id_user "
            . " FROM User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user "
            . " WHERE User.id_user >0 "
            . " GROUP BY User.ekipa, User.login, User.id_user "
            . " ORDER BY Avg(Year(CURRENT_TIMESTAMP)-Year(Kolarze.dataU)) DESC "
	    . " LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       while ($dane = mysql_fetch_row($zap)) 
       {
         $sql1 = " SELECT dataU FROM Kolarze WHERE id_user='$dane[4]' ";
         $zap1 = mysql_query($sql1) or die('mysql_query');
         $count = 0;
         $sumaW = 0;
         while ($dan1 = mysql_fetch_row($zap1)) 
         {
           $count++;
           $dzis = strtotime(date("Y-m-d"));
	   $wiek = strtotime($dan1[0]);
	   $wiek = $dzis - $wiek;
	   $wiek = floor($wiek / (3600 * 24 * 365));
           $sumaW = $sumaW + $wiek;
         }
         $srednia = round($sumaW / $count, 3);
         echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') ['.$dane[3].'] </td><td class="wyscig6">'.$srednia.'</td></tr>';
       }     
       echo '</table>'; 
       
       
       
       echo '<h4>Najmłodsze ekipy</h4>';
       echo '<table class="wyscig">';
       
       $sql = " SELECT User.ekipa, User.login, Avg(Year(CURRENT_TIMESTAMP)-Year(Kolarze.dataU)), User.liga, User.id_user "
            . " FROM User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user "
            . " WHERE User.id_user >0 "
            . " GROUP BY User.ekipa, User.login, User.id_user "
            . " ORDER BY Avg(Year(CURRENT_TIMESTAMP)-Year(Kolarze.dataU)) "
	    . " LIMIT 0, 10 ";
       $zap = mysql_query($sql) or die('mysql_query');
       while ($dane = mysql_fetch_row($zap)) 
       {
         $sql1 = " SELECT dataU FROM Kolarze WHERE id_user='$dane[4]' ";
         $zap1 = mysql_query($sql1) or die('mysql_query');
         $count = 0;
         $sumaW = 0;
         while ($dan1 = mysql_fetch_row($zap1)) 
         {
           $count++;
           $dzis = strtotime(date("Y-m-d"));
	   $wiek = strtotime($dan1[0]);
	   $wiek = $dzis - $wiek;
	   $wiek = floor($wiek / (3600 * 24 * 365));
           $sumaW = $sumaW + $wiek;
         }
         $srednia = round($sumaW / $count, 3);
         echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') ['.$dane[3].'] </td><td class="wyscig6">'.$srednia.'</td></tr>';
       }   
       echo '</table>'; 
       
       echo '<h4>Ostatnio logowali się</h4>';
       echo '<table class="wyscig">';
       
       $sql = " SELECT ekipa, login, ost_log FROM User ORDER BY ost_log ";
       $zap = mysql_query($sql) or die('mysql_query');
       while ($dane = mysql_fetch_row($zap)) 
       {
         
         echo '<td><td class="wyscig7"><b>'.$dane[0].' </b>('.$dane[1].') </td><td class="wyscig6">'.$dane[2].'</td></tr>';
       }   
       echo '</table>'; 
       
       
       
       
       
       echo koniec();
       ?>
    
    
 
