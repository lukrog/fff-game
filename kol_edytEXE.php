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
    $id_ekipDO = $_POST['ekipgdzie'];
    $data = $_POST['data'];
    //$data = date('Y-m-d',$id_data);
    echo 'Kolarz o id = '.$id_kol.' przechodzi do ekipy o id = '.$id_ekipDO.' dnia '.$id_data.'<br/><br/>
    ';
    
    $sqlp1 = " SELECT id_kol, kiedy, id_z, id_do, id_hk FROM z_a_historiakolprop WHERE (id_kol = '$id_kol' AND kiedy='$data') ";
    $zapp1 = mysql_query($sqlp1) or die('mysql_query');
    if (mysql_num_rows($zapp1) > 0) {
             echo '<h3>TEN KOLARZ MA JUŻ WPROWADZONY PROPONOWANY TRANSFER:</h3>
	     ';
	     $zapp2 = mysql_query($sqlp1) or die('mysql_query');
	     $danp2 = mysql_fetch_row($zapp2); 
             echo 'Transfer zakontraktowany z '.$danp2[2].' do '.$id_ekipDO.' na '.$danp2[1].' (id trans:'.$danp2[4].')<br/>
	     Zostanie wyedytowany.
	     ';
	     
	     $sqlp3 = " UPDATE z_a_historiakolprop SET id_do = '$id_ekipDO', id_user='$idek' WHERE id_hk = '$danp2[4]' ";
             $zapp3 = mysql_query($sqlp3) or die('mysql_query');
	     
     } else {
             echo '<h3>TEN KOLARZ dostanie transfer:</h3>
	     ';
	     
	     $id_HKZ = 1;
             
             $sqlp3 = " SELECT id_hk FROM z_a_historiakolprop ORDER BY id_hk DESC LIMIT 0, 1 ";
             $zapp3 = mysql_query($sqlp3) or die('mysql_query');
             $danp3 = mysql_fetch_row($zapp3); 
             
             //echo '<br/><br/>aaaaaaa'.$danp3[0].'aaaaaaaa<br/><br/>';
             
             if ($danp3[0] > 0) {
               $id_HKZ = $danp3[0] + 1;
             }
             
	     $sqlp4 = " SELECT Kolarze.id_team  FROM Kolarze WHERE Kolarze.id_kol = '$id_kol' ";
             $zapp4 = mysql_query($sqlp4) or die('mysql_query');
	     $danp4 = mysql_fetch_row($zapp4); 
             
             echo 'Kolarzowi zostaje dopisany transfer:
             <br/>'.$id_HKZ.' | '.$id_kol.' | '.$danp4[0].' | '.$id_ekipDO.' | '.$data.' | '.$idek.' <BR/>
	     '; 
             
             $sqlp5 = " INSERT INTO z_a_historiakolprop (id_hk, id_kol, id_z, id_do, kiedy, id_user) VALUES ( '$id_HKZ', '$id_kol', '$danp4[0]', '$id_ekipDO', '$data', '$idek' ) ";
             $zapp5 = mysql_query($sqlp5) or die('mysql_query');
     }
	  
	  
	  
    
    } else {
      echo 'nie masz dostępu do tej strony ;/';
    }
    echo koniec();
?>
    
    
    
