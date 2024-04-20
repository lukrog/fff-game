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
    
    
    
    
    
      if($_SESSION['logowanie'] == 'poprawne') {
     
        $id_kol = $_GET['id_kol'];
        

        
        // wybieramy kolarza o którego nam chodzi -------------------------------
        $sql1 = " SELECT imie, nazw, dataU, cena, id_user "
              . " FROM Kolarze "
              . " WHERE id_kol = '$id_kol' ";             
        $zap1 = mysql_query($sql1) or die(mysql_error());         
        $dan1 = mysql_fetch_row($zap1);
        
        echo 'Wybrałeś: <br/>';
        echo $dan1[0].' '.$dan1[1].'('.$dan1[4].'), który kosztował: <b>'.$dan1[3].'C</b><br/>';
        $oplata = round ($dan1[3] / 10);
        if ($oplata == 0) 
	  { 
	    $oplata = 1; 
	  }
        if ($idek == $dan1[4]) {
          
          $dzis1=date("Y-m-d");
          $squlek = " SELECT dok, typ, id_wyd FROM wydarzenia "
                  . " WHERE ((dataP <= '$dzis1') AND (dataK >= '$dzis1')) AND ((typ = 1) OR (typ = 3)) ";
          $zapuek  = mysql_query($squlek) or die('mysql_query');
          if(mysql_num_rows($zapuek) > 0) {
             echo "W trakcie licytacji nie można zwolnić kolarza. Podyktowane to jest bezpieczeństwem interesów graczy. ";
             
          } else {
          
          echo 'możesz zwolnić kolarza <br/><br/> Ale najperw zastanów się dwa razy bo tej operacji nie cofniesz<br/> Stracisz 10% (<b>'.$oplata.'C</b>) ceny kolarza <br/><br/>jeśli chcesz zwolnić kolarza (koks koniec kariery), <br/>bez kary pieniężnej napisz na forum do któregoś z bosów gry <br/><br/>';
          echo '<form action="kolZEXE.php?id_kol='.$id_kol.'" method="post">';
          //echo '  <input type="hidden" neme="id_kol" value="'.$id_kol.'">';
   	  echo '  <input class="form2" type="submit" name="zwolnij" value="Zwolnij" />';
   	  echo '</form>';
          }
          
          
          
        } else {
          echo '<h5 style="color: red;">TO NIE TWÓJ KOLARZ. (oj nieładnie kantować)</h5>';
        }
        
        
      } else {
        echo 'Nie masz uprawnień dostępu do tej strony';
      }
      
      
      
      echo koniec();
    ?>
    

   
