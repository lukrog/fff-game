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
   <title>FFF - panel zarządzający - zwalnianie</title>
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
    
    
    
      if($_SESSION['logowanie'] == 'poprawne') {
      if ($_SESSION['boss'] > 1) {
        $id_kol = $_POST['idkol'];
        

        
        // wybieramy kolarza o którego nam chodzi -------------------------------
        $sql1 = " SELECT imie, nazw, dataU, cena, id_user "
              . " FROM Kolarze "
              . " WHERE id_kol = '$id_kol' ";             
        $zap1 = mysql_query($sql1) or die(mysql_error());         
        $dan1 = mysql_fetch_row($zap1);
        
        echo 'Wybrałeś: <br/>';
        echo $dan1[0].' '.$dan1[1].'('.$dan1[4].'), który kosztując: <b>'.$dan1[3].'C</b><br/>';
        $opłata = round ($dan1[3] / 10);

          echo 'UWAGA przed zwolnieniem skontaktuj się z osobą której to jest kolarz<br/><br/>';
          echo '<form action="kolZADMEXE.php?id_kol='.$id_kol.'" method="post">';
          echo '  <input class="form" type="text" name="kara">Wpisz karę pieniężną za zwolnienie (może być =0) <br/>';
          echo '  <input class="form1" type="checkbox" name="emeryt" /> emeryt<br/>';
          echo '  <input class="form1" type="checkbox" name="koks" /> koks<br/>';
   	  echo '  <input class="form2" type="submit" name="zwolnij" value="Zwolnij" />';
   	  echo 'Zaznacz tylko jedną opcję';
   	  echo '</form>';
          

        
      } else { 
        echo 'nieładnie podszywać się pod bossa';
      }
      } else {
        echo 'Nie masz uprawnień dostępu do tej strony';
      }
      
      
      
      
      echo koniec();
    ?>
    

    
    
    
