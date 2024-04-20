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
   <title>FFF - ranking</title>
</head>
<body>
<div>

<?php
  echo google();

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

    $sort1 = $_GET['sort'];
    if ($sort1 == "") {$sort1 = 1;}

    echo  '<form action="rankingi2007.php" method="GET">';
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>Cli ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>Hil ';
	     echo  '<input class="form" type=radio name=sort value=3 ';
	     if ($sort1 == 3) {
               echo 'checked="checked"';
             }
	     echo  '>Fl ';
	     echo  '<input class="form" type=radio name=sort value=4 ';
	     if ($sort1 == 4) {
               echo 'checked="checked"';
             }
	     echo  '>Spr ';
	     echo  '<input class="form" type=radio name=sort value=5 ';
	     if ($sort1 == 5) {
               echo 'checked="checked"';
             }
	     echo  '>Cbl ';
	     echo  '<input class="form" type=radio name=sort value=6 ';
	     if ($sort1 == 6) {
               echo 'checked="checked"';
             }
	     echo  '>TT ';
    $limitd = $_GET['limit1'];	     
    if ($limitd == "") {$limitd = 1;}
    if ($limitd <= 0) {$limitd = 1;}
    $limitg = $_GET['limit2'];
    if ($limitg == "") {$limitg = 50;}
    
	     echo  ' Od:<input class="forma" type="input" value='.$limitd.' name="limit1">';
	     echo  ' Do:<input class="forma" type="input" value='.$limitg.' name="limit2">';
             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form><br/>';

    $limitd--;
    $limitg = $limitg - $limitd;
    
    
    
    if ($sort1 == 2) 
    
		  {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking.Cli, z_ranking.Hil, z_ranking.Fl, z_ranking.Spr, z_ranking.Cbl, z_ranking.TT, Ekipy.nazwa, Kolarze.id_user "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking ON Kolarze.id_kol = z_ranking.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking.Hil DESC "
			 . " LIMIT $limitd, $limitg ";
		  } elseif ($sort1 == 3) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking.Cli, z_ranking.Hil, z_ranking.Fl, z_ranking.Spr, z_ranking.Cbl, z_ranking.TT, Ekipy.nazwa, Kolarze.id_user "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking ON Kolarze.id_kol = z_ranking.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking.Fl DESC "
			 . " LIMIT $limitd, $limitg ";
                  } elseif ($sort1 == 4) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking.Cli, z_ranking.Hil, z_ranking.Fl, z_ranking.Spr, z_ranking.Cbl, z_ranking.TT, Ekipy.nazwa, Kolarze.id_user "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking ON Kolarze.id_kol = z_ranking.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking.Spr DESC "
			 . " LIMIT $limitd, $limitg ";
                  } elseif ($sort1 == 5) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking.Cli, z_ranking.Hil, z_ranking.Fl, z_ranking.Spr, z_ranking.Cbl, z_ranking.TT, Ekipy.nazwa, Kolarze.id_user "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking ON Kolarze.id_kol = z_ranking.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking.Cbl DESC "
			 . " LIMIT $limitd, $limitg ";
		  } elseif ($sort1 == 6) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking.Cli, z_ranking.Hil, z_ranking.Fl, z_ranking.Spr, z_ranking.Cbl, z_ranking.TT, Ekipy.nazwa, Kolarze.id_user "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking ON Kolarze.id_kol = z_ranking.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking.TT DESC " 
			 . " LIMIT $limitd, $limitg ";
		  } else {
                    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking.Cli, z_ranking.Hil, z_ranking.Fl, z_ranking.Spr, z_ranking.Cbl, z_ranking.TT, Ekipy.nazwa, Kolarze.id_user "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking ON Kolarze.id_kol = z_ranking.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking.Cli DESC "
			 . " LIMIT $limitd, $limitg ";
                  }
                  
    
      
    $runsql = mysql_query($sql) or die('mysql_query');
    $i=$limitd+1;
    echo '<table class="wyscig">';
    echo '<tr><td class="wyscig1">lp</td><td class="wyscig7">kolarz</td><td class="wyscig12">Cli</td></tr>';
		  
    $podaj = 4 + $sort1; 		  
    
    while ($dane = mysql_fetch_row($runsql)) {
    if ($i == $_GET['zazn'])  {
      echo '<tr><td class="wyscig1"><b>'.$i.'</b></td><td class="wyscig7"><b><img src=img/flagi/'.$dane[3].' alt='.$dane[4].' /> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' '.$dane[2].'</a><br/>'.$dane[11].' (';
    if ($_SESSION['boss'] >0) {
      echo $dane[12];
    }
    
    echo ')</b></td><td class="wyscig12"><b>'.$dane[$podaj].'</b></td></tr>';
      $i++;
      
      
    } else {
      
    echo '<tr><td class="wyscig1">'.$i.'</td><td class="wyscig7"><img src=img/flagi/'.$dane[3].' alt='.$dane[4].' /> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a><br/>'.$dane[11].' (';
    if ($_SESSION['boss'] >0) {
      echo $dane[12];
    }
    
    echo ')</td><td class="wyscig12">'.$dane[$podaj].'</td></tr>';
      $i++;
      
      }
    }
    
    
    
    
    
    
    echo '</table>';
    
    
    
    
    
    
    
    
    
    
    
    echo koniec();
    ?>
    
