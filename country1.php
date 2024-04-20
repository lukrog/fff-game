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
   <title>FFF - dane kraju</title>
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
    
    
    
    
	  
    
	  $zap1 = "SELECT Nat.nazwa, Nat.flaga, Nat.skr, Nat.id_nat FROM Nat ORDER BY Nat.id_nat LIMIT 102, 50 ";
	  $idz1 = mysql_query($zap1) or die('mysql_query');
  	  WHILE ($dane1 = mysql_fetch_row($idz1)) {
	  
          echo '<br/>'.$dane1[0].";".$dane1[3].";";
          $id_nat = $dane1[3];
             
             
             
          $poczatek = 8000;
	  $koniec = 8500;
	     
          

          //echo '<table id="menu3">';
          //echo '<tr><td class="wyscig7">kolarz</td><td class="wyscig8">Ekipa</td><td class="wyscig6">data urodzenia</td><td class="wyscig5">punkty</td></tr>';
          $zap = " SELECT Kolarze.id_kol , Kolarze.imie , Kolarze.nazw , Nat.flaga , Kolarze.dataU , Kolarze.dataU , Ekipy.nazwa , Ekipy.id_team , Sum( Wyniki.punkty ) AS SumaOfpunkty , Nat.id_nat" 
	       . " FROM Ekipy INNER JOIN ( Nat INNER JOIN ( Kolarze INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol ) ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team "
	       . " WHERE Wyniki.id_wys > '$poczatek' AND Wyniki.id_wys < '$koniec' "
	       . " GROUP BY Kolarze.id_kol , Kolarze.imie , Kolarze.nazw , Nat.flaga , Kolarze.dataU , Kolarze.dataU , Ekipy.nazwa , Ekipy.id_team , Nat.id_nat " 
	       . " HAVING Nat.id_nat = '$id_nat'  "
	       . " ORDER BY SumaOfpunkty DESC , Kolarze.nazw "
               . " LIMIT 0, 8 ";
	  $idz = mysql_query($zap) or die('mysql_query');
          $punku = 0;
  	  while ($dane = mysql_fetch_row($idz)) {
  	    if ($dane[8] > 0 ) {
	       //echo '<tr><td><img src="img/flagi/'.$dane[3].'" alt="flaga"/> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a></td><td><a href="team.php?id_team='.$dane[7].'">'.$dane[6].'</a></td><td>'.$dane[4].'</td><td>'.$dane[8].'</td></tr>';
               $punku = $punku + $dane[8];
               
	    }   
          }
          echo $punku;
          //echo '</table>';
          
	  
	  
          
	  
	  }
	  
	  
	  



	  echo koniec();
        ?>
         
    
