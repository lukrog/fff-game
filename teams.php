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
   <title>FFF - Ekipy</title>
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
         /*if ($_POST['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_POST['sort'];
	          }
             
             echo  '<form action="teams.php" method="POST">';

             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>wg nazw ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>wg ilości punktów ';

             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';          */
             
             
	  echo '<h3>Drużyny PRO TOUR</h3>';
	  $li = 'PT';
	  $pocz = 1000 * (date("Y")-2000);
	  $kon = 1000 * (date("Y")+1-2000);
	  
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
	  
	  
	  /*if ($sort1 == 2) {
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Sum(Wyniki.punkty) DESC ";
          } else {
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
          }  */
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig7">nazwa</td><td class="wyscig5">skrót</td><td class="wyscig6">ilu kol.</td><td class="wyscig6">punkty</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	    $zapaa = mysql_query($sqlaa) or die(mysql_error());
	    $daneaa = mysql_fetch_row($zapaa);
            echo '<tr><td><img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td><td>x</td></tr>';
          }  
          echo '</table><br/><br/>';
	  
	  $li = 'PR';
	  echo '<h3>Drużyny PROFFESIONAL</h3>';
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
	  
	  
	  /*if ($sort1 == 2) {
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Sum(Wyniki.punkty) DESC ";
          } else {
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
          }  */
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig7">nazwa</td><td class="wyscig5">skrót</td><td class="wyscig6">ilu kol.</td><td class="wyscig6">punkty</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	    $zapaa = mysql_query($sqlaa) or die(mysql_error());
	    $daneaa = mysql_fetch_row($zapaa);
            echo '<tr><td><img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td><td>x</td></tr>';
          }  
          echo '</table><br/><br/>';
          
          $li = 'CT';
	  echo '<h3>Drużyny CONTINENTAL</h3>';
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
	  
	  
	  /*if ($sort1 == 2) {
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Sum(Wyniki.punkty) DESC ";
          } else {
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
          }  */
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig7">nazwa</td><td class="wyscig5">skrót</td><td class="wyscig6">ilu kol.</td><td class="wyscig6">punkty</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    if ($dane[0] == 0) {} else {
	      $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	      $zapaa = mysql_query($sqlaa) or die(mysql_error());
	      $daneaa = mysql_fetch_row($zapaa);
              echo '<tr><td><img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td><td>x</td></tr>';
            }
          }  
          echo '</table><br/><br/>';
          
          
          $li = 'AM';
	  echo '<h3>Drużyny Amatorskie</h3>';
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
	  
	  
	  /*if ($sort1 == 2) {
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Sum(Wyniki.punkty) DESC ";
          } else {
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Sum(Wyniki.punkty) "
               . " FROM Wyniki RIGHT JOIN (Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Ekipy.liga='$li' "
	       . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
               . " ORDER BY Ekipy.nazwa ";
          }  */
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig7">nazwa</td><td class="wyscig5">skrót</td><td class="wyscig6">ilu kol.</td><td class="wyscig6">punkty</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    if ($dane[0] == 0) {} else {
	      $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	      $zapaa = mysql_query($sqlaa) or die(mysql_error());
	      $daneaa = mysql_fetch_row($zapaa);
              echo '<tr><td><img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td><td>x</td></tr>';
            }
          }  
          echo '</table><br/><br/>';
          
          
          echo '<h3>Wolny rynek</h3>';
          
          
          echo '<a href="team.php?id_team=0">Wolny rynek</a>';
          
          
          
          
        echo koniec();  
       ?>
    
    
  
