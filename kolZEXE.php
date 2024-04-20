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
   <title>FFF - zwalnianie</title>
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
    ?>
    <h3  style="color: red">
     Nie odświeżaj tej strony. Gdy przemieli ona informacje przejdź do kolenych.
    </h3>
    <?php 
      if($_SESSION['logowanie'] == 'poprawne') {
     
        $id_kol = $_GET['id_kol'];
        

        
        // wybieramy kolarza o którego nam chodzi -------------------------------
        $sql1 = " SELECT imie, nazw, dataU, cena, id_user "
              . " FROM Kolarze "
              . " WHERE id_kol = '$id_kol' ";             
        $zap1 = mysql_query($sql1) or die(mysql_error());         
        $dan1 = mysql_fetch_row($zap1);
        
        echo 'Wybrałeś: <br/>';
        echo $dan1[0].' '.$dan1[1].'('.$dan1[4].'), który kosztując: <b>'.$dan1[3].'C</b> [Urodzony: '.$dan1[2].']<br/>';
       
        if ($idek == $dan1[4]) {
          echo 'Zwalniasz kolarza';
          
          $sql111 = " SELECT cena FROM Kolarze WHERE id_kol = '$id_kol' ";
          $zap111 = mysql_query($sql111) or die(mysql_error());         
          $dan111 = mysql_fetch_row($zap111);
          
          echo '<br/><br/>- cena kolarza zwalnianego: '.$dan111[0].'<br/>';
          $oplata = round ($dan111[0] / 10);
          if ($oplata <= 25) 
	  { 
	    $oplata = 25; 
	  }
          echo 'opłata za zwolnienie: '.$oplata.'<br/><br/>';
          echo 'drużyna obciążona: '.$idek.'<br/><br/>';
          
          echo 'aktualizuje kolarza';
          $sql121 = " UPDATE Kolarze "
                  . " SET id_user = 0, przed = 0, cena = pts_poprz"
                  . " WHERE id_kol = '$id_kol'";
          $zap121 = mysql_query($sql121) or die(mysql_error());         
          
          
	  $sql123 = " SELECT kasa FROM User WHERE id_user = '$idek' ";
          $zap123 = mysql_query($sql123) or die(mysql_error());         
          $dane123 = mysql_fetch_row($zap123);
          echo '<br/><br/>zczytuję finanse drużyny = '.$dane123[0].'<br/>';
          
          $kasaN = $dane123[0] - $oplata;
          $sql126 = " UPDATE User "
                  . " SET kasa = '$kasaN' "
                  . " WHERE id_user = '$idek'";
          $zap126 = mysql_query($sql126) or die(mysql_error());
          
          echo 'aktualizuje finanse drużyny: '.$kasaN.' = ('.$dane123[0].' - '.$oplata.')<br/>';
          
          echo 'Usuwam zgłoszenia z następnych wyścigów.';
        
	$dzis = date ("Y:m:d");
        $sql10 = " SELECT zgloszenia.id_kol, Wyscigi.dataP, Wyscigi.id_wys, zgloszenia.id_zgl "
	       . " FROM zgloszenia INNER JOIN Wyscigi ON zgloszenia.id_wys = Wyscigi.id_wys "
	       . " WHERE (zgloszenia.id_kol = '$id_kol' AND  Wyscigi.dataP >= '$dzis' )  ";
	$zap10 = mysql_query($sql10) or die('mysql_query');
	while ($dan10 = mysql_fetch_row($zap10))  {
           echo $dan10[3].'znaleziono zgłoszenia tego kolarza do wyścigu id='.$dan10[2].' = i je skasowano<br/>'; 
           $sql11 = " DELETE FROM zgloszenia WHERE id_zgl = '$dan10[3]' ";
	   $zap11 = mysql_query($sql11) or die('mysql_query');
        }
        
        echo 'wyszukuję koleny numer zgłoszenia';
        $sql311 = " SELECT id_tpZ"
                . " FROM transzaak"
                . " ORDER BY id_tpZ DESC"
                . " LIMIT 0, 1";
        $zap311 = mysql_query($sql311) or die('mysql_query');
        $dan311 = mysql_fetch_row($zap311);
        $id_tp = $dan311[0] + 1;
        echo ''.$id_tp.', '.$dzis.', id_kol'.$id_kol.', 0, '.$idek.', '.$oplata.', '.$dan111[0].', 1';
        $sql411 = " INSERT INTO transzaak VALUES ('$id_tp', '$dzis', '$id_kol', 0, '$idek', '$oplata', '$dan111[0]', 1) ";
        $zap411 = mysql_query($sql411) or die('mysql_query');
        echo 'Dodaję transfer zawodnika do historii transferów<br/>';
        
        echo '<h4>Przeliczanie skończone --- Możesz przejść do innych stron</h4>';
        } else {
          echo '<h5 style="color: red;">TO NIE TWÓJ KOLARZ. (oj nieładnie kantować)</h5>';
        }

        
        
      } else {
        echo 'Nie masz uprawnień dostępu do tej strony';
      }
      
      echo '<h3>Stało się, możesz przejść do innych stron</h3>';
      
      
      
      
      echo koniec();
    ?>
    

    
    
    
