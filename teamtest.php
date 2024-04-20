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
   <title>FFF - dane ekipy</title>
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
	  $id_team = $_GET['id_team'];
	  $zap = "SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga, Ekipy.liga, Nat.id_nat FROM Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj WHERE (((Ekipy.id_team)= '$id_team' ))";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
	  echo '<table id="menu2">';
          echo '<tr><td><i>id ekipy: </i></td><td>'.$id_team.'</td></tr>';
          echo '<tr><td><i>nazwa: </i></td><td>'.$dane[1].' ('.$dane[2].')</td></tr>';
          echo '<tr><td></td></tr>';
          echo '<tr><td><i>kraj ekipy: </i></td><td><a href="nat.php?id_nat='.$dane[6].'">'.$dane[3].'</a> <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>';
          echo '<tr><td><i>Liga: </i></td><td>'.$dane[5].'</td></tr>';
          $roczek = date('Y');
          echo '<tr><td><i>zmiany:</i></td><td><a href="teamh.php?id_team='.$id_team.'&rok='.$roczek.'">w tym sezonie</a></td></tr>';
          $roczek = $roczek + 1;
          echo '<tr><td><i>zmiany:</i></td><td><a href="teamh.php?id_team='.$id_team.'&rok='.$roczek.'">w przyszłym sezonie</a></td></tr>';
          echo '</table>';
          echo '<br/><br/>';
          
          if ($_POST['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_POST['sort'];
	          }
          
	  echo  '<form action="team.php?id_team='.$id_team.'" method="POST">';

             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>wg nazwisk ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>wg ilości punktów ';

             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';
             
             
	  echo '<table class="wyscig">';
          echo '<tr><td>kolarz</td><td>data urodzenia</td><td>punkty';
	  if($_SESSION['logowanie'] == 'poprawne') {
	    echo '</td><td>właściciel</td></tr>';
	  } else {
            echo '</td></tr>';
          }
          
          $pocz = 1000 * (date("Y")-2000);
	  $kon = 1000 * (date("Y")+1-2000);
          
          if ($sort1 == 2) {
          $zap = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, User.login, User.id_user, Sum(Wyniki.punkty) "
	       . " FROM Wyniki RIGHT JOIN (Nat INNER JOIN (Kolarze INNER JOIN User ON Kolarze.id_user = User.id_user ) On Nat.id_nat = Kolarze.id_nat) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Kolarze.id_team= '$id_team' "
	       . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, User.login, User.id_user "
               . " ORDER BY Sum(Wyniki.punkty) DESC";
          } else {
          $zap = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, User.login, User.id_user, Sum(Wyniki.punkty) "
	       . " FROM Wyniki RIGHT JOIN (Nat INNER JOIN (Kolarze INNER JOIN User ON Kolarze.id_user = User.id_user ) On Nat.id_nat = Kolarze.id_nat) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Kolarze.id_team= '$id_team'"
	       . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Kolarze.dataU, Kolarze.cena, User.login, User.id_user "
               . " ORDER BY Kolarze.nazw";
          }     
               
               
               
               
	  $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    //$pun = 0;
  	    //$sql1 = " SELECT punkty FROM Wyniki WHERE id_kol = '$dane[0]'";
	    //$zap1 = mysql_query($sql1) or die('mysql_query');
  	    //while ($dan1 = mysql_fetch_row($zap1)) {
            //  $pun = $pun + $dan1[0];
            //}
  	    
            echo '<tr><td class="wyscig7"><img src="img/flagi/'.$dane[3].'" alt="flaga"/> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a></td><td>'.$dane[4].'</td><td>'.$dane[8];//$pun;
            if($_SESSION['logowanie'] == 'poprawne') {
	      echo '</td><td><a href="user.php?id_user='.$dane[7].'">'.$dane[6].'</a></td></tr>';
            } else {
              echo '</td></tr>';
            }
	  
	  }
          echo '</table>';

	  





	  echo koniec();
        ?>
         
    


    
