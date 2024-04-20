<?php 
  //ł±czenie się z baz± php
  session_start();
  include_once('glowne.php');
?>
<?php 
$connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę poł±czyć się z baz± danych<br />Bł±d: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się poł±czyć z baz± dancych!</p>";
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
   <title>FFF - obniżanie kontraktów</title>
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
   //sprawdzanie poprawno¶ci logowania
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
    
    $obniz = 15;
    echo 'nastąpi obniżka kolarzy którzy nie zmieniali barw o '.$obniz.'%<br/><br/>
    ';
    
     $sql = " SELECT id_kol, imie, nazw, dataU, id_nat, id_team, id_user, cena, przed, pts_poprz
              FROM Kolarze
	      WHERE id_user <> 0
	      ORDER BY id_user, nazw, imie ";
     $zap = mysql_query($sql) or die('mysql_query');       
     while ($dan = mysql_fetch_row($zap)) {
       echo '<i>Kolarz </i>'.$dan[1].' <b>'.$dan[2].'</b> ('.$dan[0].') ['.$dan[6].'] - cena: '.$dan[7].'
       <br/>';
       
       $sql1 = " SELECT typ
                 FROM transzaakST
	         WHERE id_kol = '$dan[0]'
	         ORDER BY kiedy DESC, id_tpZ DESC ";
       $zap1 = mysql_query($sql1) or die('mysql_query');       
       $dan1 = mysql_fetch_row($zap1);
       if ($dan1[0] == 4 ) {
         echo '<i>kolarz przedłużany - Obniżka o: </i>'; 
         $procent = ($dan[7] * 15) / 100;
         echo $procent.' <i>nowa cena to: </i>';
         $nowa_cena = $dan[7] - $procent;
         echo round($nowa_cena).' ('.$nowa_cena.')';
         $nowa_cena = round($nowa_cena);
         $sql2 = "INSERT INTO transzaak (id_tpZ, kiedy, id_kol, id_userK, id_userS, ile, poprzednia_cena, typ) 
	          VALUES ('', '2010-11-01', '$dan[0]', '$dan[6]', '$dan[6]', '$nowa_cena', '$dan[7]', 5)";
         
         
	 
	 // TU ZMIANY BY ZADZIAŁAŁY OBNIŻKI
	 //$zap2 = mysql_query($sql2) or die('mysql_query'); 
	 
	 echo '<br/>'.$sql2;
         
         //$sql2 = "UPDATE Kolarze
         //         SET cena = $nowa_cena
	 //	    WHERE id_kol = '$dan[0]'";
         //$zap2 = mysql_query($sql2) or die('mysql_query');
         echo '<br/>'.$sql2;
         
       } else {
         echo '<i>były zmiany </i>';
       }
       echo '<br/><br/>';
       
     }
    
    
    
    
    
    echo koniec();
?>
