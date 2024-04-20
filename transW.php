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
   <title>FFF - tranzakcje proponowane</title>
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
        $dzis=date("Y-m-d");
        $sql1 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 1 ";
        $zap1  = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) > 0) {
        
	
//---------------------------------------------------------------------------

        echo 'Chcesz wymienić Kolarzy:';
	$id_kol = $_GET['id_kol'];
	$za_kogo = $_POST['zakogo'];
	
	
	$sqlp4 = " SELECT imie, nazw, id_kol, id_user, cena FROM Kolarze WHERE id_kol = '$id_kol' ";
        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
        $danp4 = mysql_fetch_row($zapp4);
	echo '<br/>id kolT: ';
	echo $danp4[0].' <b>'.$danp4[1].'</b>';
	$kto = $danp4[3];
	$cena1 = $danp4[4];
	
	$sqlp4 = " SELECT imie, nazw, id_kol, id_user, cena FROM Kolarze WHERE id_kol = '$za_kogo' ";
        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
        $danp4 = mysql_fetch_row($zapp4);
	echo '<br/>na kolS: ';
	echo $danp4[0].' <b>'.$danp4[1].'</b>';
        $zako = (-1) * $danp4[2];
        $cena2 = $danp4[4];
        
        
        
        if ($cena1 > $cena2) {
          $pro50 = round($cena1 / 2);
          echo 'Minimalna cena kolarza tańszego: '.$cena1.' * 50% = '.$pro50.'<br/>';
          if ($cena2 > $pro50) {
            $pytanie = "OK";
          } else {
            $pytanie = "NIE";  
          }
        } else {
          $pro50 = round($cena2 / 2);
          echo 'Minimalna cena kolarza tańszego: '.$cena2.' * 50% = '.$pro50.'<br/>';
          if ($cena1 > $pro50) {
            $pytanie = "OK";
          } else {
            $pytanie = "NIE";  
          }
        }
        
	 
	if ($pytanie == "OK") {       
      
          $sql10 = " SELECT id_tp FROM transprop ORDER BY id_tp DESC LIMIT 0, 1 ";
          $zap10 = mysql_query($sql10) or die('mysql_query');
          $wyn10 = mysql_fetch_row($zap10);
          $kolejne_id=$wyn10[0]+1;

            $sql12 = " INSERT INTO transprop "
		   . " VALUES ('$kolejne_id', '$dzis', '$id_kol', '$idek', '$kto', '$zako', 1) ";
	    $zap12 = mysql_query($sql12) or die('mysql_query');
        
        } else {
          echo 'Tańszy kolarz kosztuje za mało!!!';
        }
//--------------------------------------------------------------------------- 
	
	
		
       
       } else {
         
        
         
         
         
         echo '<h4>Okno transferowe zamknięte</h4>';
       }
       } else {
         echo 'Nie masz uprawnień do tej strony';
       } 
       
       
       
       
       
       echo koniec();   
    ?>
    
    
    
   
