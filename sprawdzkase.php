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
   <title>FFF - ligi fff</title>
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


       	  echo '<h3>I liga</h3>';
       	  
       	  $poczatek = 1000 * (date("Y")-2000);
	  $koniec = 1000 * (date("Y")+1-2000);
	  
	  
	  $li = 1;
	  $licz = 1;
	  $sql = " SELECT User.id_user , User.login , User.ekipa , User.kasa , User.liga , Sum( wynikidru.punkty ) AS SPunkty, Sum( wynikidru.punkty )-Sum( wynikidru.wydat ) AS SWydat "
               . " FROM wynikidru RIGHT JOIN User ON wynikidru.id_user = User.id_user "
               . " WHERE User.liga = '$li' AND wynikidru.id_wys > '$poczatek' AND wynikidru.id_wys < '$koniec' "
               . " GROUP BY User.id_user "
               . " ORDER BY SPunkty DESC, SWydat DESC, User.ekipa ";
          $idzapytania = mysql_query($sql) or die(mysql_error());
          $ile = mysql_num_rows($idzapytania);
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig1">lp</td><td class="wyscig7">Ekipa</td><td class="wyscig6">punkty</td><td class="wyscig6" style=" color: #8c8c8c;">Zarobek</td></tr>';
          $dane = mysql_fetch_row($idzapytania);
          $poprz=$dane[5];
          echo '<tr><td style="background-color: #f6fa82;">'.$licz.'</td><td style="background-color: #f6fa82;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #f6fa82; text-align: right;"><b>'.$dane[5].'</b></td><td style="background-color: #f6fa82; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          $licz++;
          $dane = mysql_fetch_row($idzapytania);
          $rozn = $poprz - $dane[5];
          echo '<tr><td style="background-color: #cacaca;">'.$licz.'</td><td style="background-color: #cacaca;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #cacaca; text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="background-color: #cacaca; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          $licz++;
          $poprz=$dane[5];
          $dane = mysql_fetch_row($idzapytania);
          $rozn = $poprz - $dane[5];
          echo '<tr><td style="background-color: #d3afaf;">'.$licz.'</td><td style="background-color: #d3afaf;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #d3afaf; text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="background-color: #d3afaf; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          $licz++;
          
          for ($licz=4; $licz <= $ile-3; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
	    $rozn = $poprz - $dane[5];
            echo '<tr><td>'.$licz.'</td><td><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> <i>- '.$dane[1].'</i></td><td style="text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
	  } 
	  for ($licz=$ile-2; $licz <= $ile; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
	    $rozn = $poprz - $dane[5];
            echo '<tr><td style="background-color: #fcadad;">'.$licz.'</td><td style="background-color: #fcadad;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #fcadad; text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="background-color: #fcadad; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          }
          echo '</table><br/><br/>';

       
       	  echo '<h3>II liga</h3>';
	  $li = 2;
	  $licz = 1;
	  $sql = " SELECT User.id_user , User.login , User.ekipa , User.kasa , User.liga , Sum( wynikidru.punkty ) AS SPunkty, Sum( wynikidru.punkty )-Sum( wynikidru.wydat ) AS SWydat "
               . " FROM wynikidru RIGHT JOIN User ON wynikidru.id_user = User.id_user "
               . " WHERE User.liga = '$li' AND wynikidru.id_wys > '$poczatek' AND wynikidru.id_wys < '$koniec' "
               . " GROUP BY User.id_user "
               . " ORDER BY SPunkty DESC, SWydat DESC, User.ekipa ";
          $idzapytania = mysql_query($sql) or die(mysql_error());
          $ile = mysql_num_rows($idzapytania);
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig1">lp</td><td class="wyscig7">Ekipa</td><td class="wyscig6">punkty</td><td class="wyscig6" style=" color: #8c8c8c;">Zarobek</td></tr>';
	    
	  for ($licz=1; $licz <= 4; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
            if ($licz == 1) {$rozn = "";} else {$rozn = $poprz - $dane[5];}
            echo '<tr><td style="background-color: #adfcad;">'.$licz.'</td><td style="background-color: #adfcad;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #adfcad; text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="background-color: #adfcad; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          }
	  for ($licz=5; $licz <= $ile-2; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
	    $rozn = $poprz - $dane[5];
            echo '<tr><td>'.$licz.'</td><td><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
	  }  
	  for ($licz=$ile-1; $licz <= $ile; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
	    $rozn = $poprz - $dane[5];
            echo '<tr><td style="background-color: #fcadad;">'.$licz.'</td><td style="background-color: #fcadad;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #fcadad; text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="background-color: #fcadad; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          }
          echo '</table><br/><br/>'; 
	    

	         
       
       	  echo '<h3>III liga</h3>';
	  $li = 3;
	  $licz = 1;
	  $sql = " SELECT User.id_user , User.login , User.ekipa , User.kasa , User.liga , Sum( wynikidru.punkty ) AS SPunkty, Sum( wynikidru.punkty )-Sum( wynikidru.wydat ) AS SWydat "
               . " FROM wynikidru RIGHT JOIN User ON wynikidru.id_user = User.id_user "
               . " WHERE User.liga = '$li' AND wynikidru.id_wys > '$poczatek' AND wynikidru.id_wys < '$koniec' "
               . " GROUP BY User.id_user "
               . " ORDER BY SPunkty DESC, SWydat DESC, User.ekipa ";
          $idzapytania = mysql_query($sql) or die(mysql_error());
          $ile = mysql_num_rows($idzapytania);
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig1">lp</td><td class="wyscig7">Ekipa</td><td class="wyscig6">punkty</td><td class="wyscig6" style=" color: #8c8c8c;">Zarobek</td></tr>';
	  for ($licz=1; $licz <= 5; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
	    if ($licz == 1) {$rozn = "";} else {$rozn = $poprz - $dane[5];}
            echo '<tr><td style="background-color: #adfcad;">'.$licz.'</td><td style="background-color: #adfcad;"><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="background-color: #adfcad; text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="background-color: #adfcad; text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
          }
	  for ($licz=6; $licz <= $ile; $licz++) 
          {
            $poprz=$dane[5];
	    $dane = mysql_fetch_row($idzapytania);
	    $rozn = $poprz - $dane[5];
            echo '<tr><td>'.$licz.'</td><td><a href="user.php?id_user='.$dane[0].'">'.$dane[2].'</a> - <i>'.$dane[1].'</i></td><td style="text-align: right;"><i>(-'.$rozn.')</i> <b>'.$dane[5].'</b></td><td style="text-align: right; color: #8c8c8c;">'.$dane[6].'</td></tr>';
	  }           
	  
	  echo '</table><br/><br/>';   
          
	  echo '<h3>wolny rynek</h3>';
	   
	  echo '<a href="user.php?id_user=0">Wolni kolarze</a>';
	  
	  echo '<h3>osttanie 3 podsumowane wyścigi:</h3>';
	  $sql = " SELECT Wyscigi.nazwa, Wyscigi.id_wys, DATE(Wyscigi.dataP) FROM Wyscigi INNER JOIN wynikidru ON Wyscigi.id_wys = wynikidru.id_wys GROUP BY Wyscigi.nazwa ORDER BY Wyscigi.dataP DESC LIMIT 0, 3 ";
	  $zap = mysql_query($sql) or die(mysql_error());
	  while ($dan = mysql_fetch_row($zap)) {
            echo '<a href="wyscig.php?id_wys='.$dan[1].'"><b>'.$dan[0].'</b></a> ('.$dan[2].') a w tym podliczone:<br/>';
            
            $sql1 = " SELECT Co.nazwa FROM Co INNER JOIN Wyniki ON Co.id_co = Wyniki.id_co WHERE Wyniki.id_wys = '$dan[1]' GROUP BY Co.nazwa ORDER BY Co.id_co ";
            $zap1 = mysql_query($sql1) or die(mysql_error());
	    while ($dan1 = mysql_fetch_row($zap1)) {
	      echo ' - '.$dan1[0].'<br/>';
	    }
            
          }
          
          
          
          
          
          
          echo koniec();
       ?>
    
    
    
   
