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
   <title>FFF - transfer kolarza</title>
</head>
<body>
<div>

<?php
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
    echo poczatek();
    
    
    
    $id_kol = $_GET['id_kol'];
    
    $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, Kolarze.przed, User.id_user, Kolarze.dataU, Kolarze.cena, Kolarze.pts_poprz, User.login, Kolarze.zdjecie "
           . " FROM User INNER JOIN ( Ekipy INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) ON User.id_user = Kolarze.id_user "
           . " WHERE ( ( ( Kolarze.id_kol ) = '$id_kol' ) ) ";
    $idzapytania = mysql_query($sql) or die(mysql_error());
    $dane = mysql_fetch_row($idzapytania);      
    if (($_SESSION['boss'] >= 1) OR ($dane[10] == $idek)) { 
    
    if (($dane[10] <> $idek)) {
      } else {
      echo 'To twój kolarz więc możesz go przetransferować <br/>
      
      ';
      
    }
    
           
    
          echo '<img src="'.$dane[15].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right />
	  <table id="menu2">
	    <tr><td class="wyscig2"><i>id kolarza: </i></td><td class="wyscig2">'.$id_kol.'</td></tr>
	    <tr><td><i>kolarz: </i></td><td>'.$dane[0].' '.$dane[1].'</td></tr>
	    <tr><td></td></tr>
	    <tr><td><i>data urodzenia: </i></td><td>'.$dane[2].'</td></tr>
	    ';
          $dzis = strtotime(date("Y-m-d"));
	  $wiek = strtotime($dane[2]);
	  $wiek = $dzis - $wiek;
	  $wiek = floor($wiek / (3600 * 24 * 365));
	  echo '<tr><td><i>wiek: </i></td><td>'.$wiek.'</td></tr>
	  <tr><td><i>narodowość: </i></td><td><a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a> <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>
	  <tr><td><i>ekipa: </i></td><td><a href="team.php?id_team='.$dane[7].'">'.$dane[5].'</a></td></tr>
	  ';
	  
          if($_SESSION['logowanie'] == 'poprawne') 
	  {
            echo '<tr><td></td></tr>
	    <tr><td><i>drużyna fff:</i></td><td><a href="user.php?id_user='.$dane[10].'">'.$dane[6].'</a> <i>'.$dane[14].'</i></td></tr><tr><td><i>cena kolarza:</i></td><td>'.$dane[12].'</td></tr>';
	    echo '<tr><td><i>punkty w poprz. sez.:</i></td><td>'.$dane[13].'</td></tr>
	    ';
	  } else {}
	  
	  $pun = 0;
	  $pocz = 1000 * (date("Y")-2000);
	  $kon = 1000 * (date("Y")+1-2000);
  	  $sql113 = " SELECT punkty FROM Wyniki WHERE id_kol = '$id_kol' AND id_wys > '$pocz' AND id_wys < '$kon'";
	  $zap113 = mysql_query($sql113) or die('mysql_query');
  	  while ($dan113 = mysql_fetch_row($zap113)) {
            $pun = $pun + $dan113[0];
          }
          echo '
	  <tr><td><i>punkty: </i></td><td>'.$pun.'</td></tr>
	  </table>
	  
	  ';
	  
	  $sqlp1 = " SELECT id_kol, kiedy, id_z, id_do FROM z_a_historiakolprop WHERE id_kol = '$id_kol' ";
          $zapp1 = mysql_query($sqlp1) or die('mysql_query');
	  if (mysql_num_rows($zapp1) >0) {
             echo '<h2>TEN KOLARZ MA JUŻ WPROWADZONY PROPONOWANY TRANSFER:</h2>
	     ';
	     $zapp2 = mysql_query($sqlp1) or die('mysql_query');
	     while ($danp2 = mysql_fetch_row($zapp2)) { 
	       echo 'Transfer zakontraktowany z '.$danp2[2].' do '.$danp2[3].' na '.$danp2[1].'<br/>
	       ';
	     }
	     echo ' Jeśli wklepiesz transfer na jedną z tych dat to zostanie on wyedytowany.<br/><br/>
	     ';
          }
	  
	  
	  echo '
	  <h1>chcesz przeprowadzić transfer do:</h1>
	   
	  <br/> 
	  <form action="kol_edytEXE.php?id_kol='.$id_kol.'" method="POST">
	  <select class="form3"  name="ekipgdzie">
	  ';
                        
          $sqlp6 = " SELECT id_team, nazwa, skr, liga FROM Ekipy ORDER BY liga DESC, nazwa ";
          $zapp6 = mysql_query($sqlp6) or die('mysql_query');
          while ($danp6 = mysql_fetch_row($zapp6)) {  
	    echo '  <option value='.$danp6[0];
	    
	    if ($danp6[0] == $dane[7]) {
	      echo ' selected="selected" ';
	    }
	    
	    
	    echo '>'.$danp6[3].' | '.$danp6[0].' | '.$danp6[1].' ('.$danp6[2].')</OPTION>
            ';
		}
          $dzis = date('Y-m-d');
          
	  //tu ustawiam datę na następny rok
	  
	  if (date('m') > 8) {
	    $datka = date('Y')+1;
	    $dzis = $datka.'-01-01';
	  }
	   
	  
	  
	  echo '</select>
          <br/>Data (YYYY-MM-DD) na przykład 2009-01-01<br/>
          <input class="form" type="input" name="data" value="'.$dzis.'" />
          <br/>
	  <input class="form2" type=submit value="Wklep transfer" />
          </form>';
	  
	  
    
    } else {
      echo 'nie masz dostępu do tej strony ;/';
    }
    echo koniec();
?>
    
    
    
