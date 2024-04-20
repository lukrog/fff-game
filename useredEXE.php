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
   <title>FFF - panel zarządzający</title>
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
	    $koszulka = $_POST['koszulka'];
	    $rekawki = $_POST['rekawki'];
	    $boki = $_POST['boki'];
	    $logo = $_POST['logo'];
	    $opis = strip_tags($_POST['opis'], '<b><i><br><br/><u><img><a>');
	    //echo $koszulka.' -> '.$rekawki.' -> '.$boki.' ['.$idek.'] '.$opis.'<br/><br/>';
	    

	          
	    $sqlas = "UPDATE User SET kosz='$koszulka' WHERE id_user = '$idek' ";
	    $zapas = mysql_query($sqlas) or die('mysql_query');
	    //echo $sqlas.'<br/>';
	    
	    $sqlas = "UPDATE User SET reka='$rekawki' WHERE id_user = '$idek' ";
	    $zapas = mysql_query($sqlas) or die('mysql_query');
	    //echo $sqlas.'<br/>';
	    
	    $sqlas = "UPDATE User SET boki='$boki' WHERE id_user = '$idek' ";
	    $zapas = mysql_query($sqlas) or die('mysql_query');
            //echo $sqlas.'<br/>';
            
            $sqlas = "UPDATE User SET spon='$logo' WHERE id_user = '$idek' ";
	    $zapas = mysql_query($sqlas) or die('mysql_query');
	    //echo $sqlas.'<br/>';
	    
	    $sqlas = "UPDATE User SET opis='$opis' WHERE id_user = '$idek' ";
	    $zapas = mysql_query($sqlas) or die('mysql_query');
	    //echo $sqlas.'<br/>';
	    
	          echo ' <table style="text-align: justify;"><tr><td>';
                  
	          echo ' <table ALIGN="left"  width="220" height="220" cellpadding="0" cellspacing="0">';
		  echo ' <tr align="center" valign="middle"><td>';
		  
		  echo ' <table background="img/koszulki/koszulka_0'.$koszulka.'.gif" width="220" height="220" cellpadding="0" cellspacing="0"> ';
	          echo ' <tr style="vertical-align: middle; align: center;"> ';
	          echo ' <td background="img/koszulki/rekawki_0'.$rekawki.'.gif" margin-left="10"> ';
	          
	          echo ' <table background="img/koszulki/boki_0'.$boki.'.gif" width="220" height="220" cellpadding="0" cellspacing="0" style="vertical-align: middle; align: center;">';
		  echo ' <tr style="vertical-align: middle; text-align: center;">';
		  echo ' <td>';
		  
		  echo ' <img src="'.$logo.'" /> ';
		  
		  echo ' </td></tr></table>';
		  		  
		  echo ' </td></tr> ';
	          echo ' </table> ';
	          
	          echo ' </td></tr>';
		  echo ' </table> ';
		  
	          echo $opis.'</td></tr></table><br/><br/>';
	          
        } else {
   	  echo '<h3>Ta strona dostępna tylko po zalogowaniu</h3>';
   
        }
        
        
        
        
        
        
        
        
        echo koniec();
        ?>
     
