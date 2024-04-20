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
   <title>FFF - narody</title>
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
    
    
    
    
	  echo '<h3>Kraje</h3>';
	  /*
	  if ($_POST['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_POST['sort'];
	          }
             
             echo  '<form action="country.php" method="POST">';
             //echo  '<input type="hidden" name="id_user" value="'.$id_user.'">'
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>wg krajów ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>wg ilości punktów ';

             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';
             
             */
             
	  $pocz = 1000 * (date("Y")-2000);
	  
	  
	  $kon = 1000 * (date("Y")+1-2000);
	  
	  $sql = " SELECT Nat.id_nat, Nat.nazwa, Nat.flaga, Nat.skr "
	       . " FROM Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat "
	       . " GROUP BY Nat.id_nat, Nat.nazwa, Nat.flaga, Nat.skr "
               . " ORDER BY Nat.nazwa ";
	  
	  /*if ($sort1 == 2) {
	  $sql = " SELECT Nat.id_nat, Nat.nazwa, Nat.flaga, Nat.skr, Sum(Wyniki.punkty) "
	       . " FROM Wyniki RIGHT JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Wyniki.id_kol = Kolarze.id_kol "
	       . " WHERE Wyniki.id_wys < 8999 AND Wyniki.id_wys >= 8000 "
	       . " GROUP BY Nat.id_nat, Nat.nazwa, Nat.flaga, Nat.skr "
               . " ORDER BY Sum(Wyniki.punkty) DESC ";
          }  else {
          $sql = " SELECT Nat.id_nat, Nat.nazwa, Nat.flaga, Nat.skr, Sum(Wyniki.punkty) "
	       . " FROM Wyniki RIGHT JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Wyniki.id_kol = Kolarze.id_kol "
	       //. " WHERE Wyniki.id_wys < 8800 "
	       . " GROUP BY Nat.id_nat, Nat.nazwa, Nat.flaga, Nat.skr "
               . " ORDER BY Nat.nazwa ";  
          }*/
         
          $idzapytania = mysql_query($sql) or die(mysql_error());
          
	  
	  
	  
	  echo '<table id="menu2">';
          echo '<tr><td class="wyscig2">nazwa</td><td class="wyscig2">skrót</td><td class="wyscig6">ilu kolarzy</td><td class="wyscig6">punkty (bez mistrzostw krajowych)</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    $sqlkrajowe = " SELECT Sum(Wyniki.punkty) FROM Wyniki RIGHT JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Wyniki.id_kol = Kolarze.id_kol WHERE Wyniki.id_wys < 8800 AND Wyniki.id_wys >= 8000 AND Nat.id_nat = '$dane[0]' ";
	    $zapkrajowe = mysql_query($sqlkrajowe) or die(mysql_error());
	    $danekrajowe = mysql_fetch_row($zapkrajowe);
	    
	    $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_nat = '$dane[0]' ";
	    $zapaa = mysql_query($sqlaa) or die(mysql_error());
	    $daneaa = mysql_fetch_row($zapaa);
	    if ($sort1 == 2) {
	      $punktybez = $dane[4];
	    } else {
              $punktybez = $danekrajowe[0];
            }  
            echo '<tr><td><img src="img/flagi/'.$dane[2].'" alt="'.$dane[1].'"/> <a href="nat.php?id_nat='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[3].'</td><td style="text-align: right;">'.$daneaa[0].'</td><td style="text-align: right;">'.$punktybez.'</td></tr>';
          }  
          echo '</table><br/><br/>';
	  
	  
	  
	  
	  
	  
	  
	  
	  echo koniec();
       ?>
    
    
    
