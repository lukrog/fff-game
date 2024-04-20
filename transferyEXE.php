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
   <title>przeprowadzanie transferów</title>
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
    if ($_SESSION['boss'] >= 1) {
    echo 'Przeprowadzamy transfery: 
    <br/><br/>';
    $dzis = date('Y-m-d');
    $sqlp1 = " SELECT id_kol, kiedy, id_z, id_do, id_hk, id_user FROM z_a_historiakolprop WHERE kiedy <= '$dzis' ORDER BY kiedy";
    $zapp1 = mysql_query($sqlp1) or die('mysql_query');
    while ($danp1 = mysql_fetch_row($zapp1)) { 
        echo 'Transfer kolarza '.$danp1[0].' kiedy '.$danp1[1].' z ekipy '.$danp1[2].' do '.$danp1[3].' <br/> ';
        
        $sqlp2 = " SELECT id_hk, id_kol, id_z, id_do, kiedy FROM z_a_historiakol WHERE (id_kol = '$danp1[0]' AND kiedy = '$danp1[1]') ";
        $zapp2 = mysql_query($sqlp2) or die('mysql_query');
	if (mysql_num_rows($zapp2) > 0 )
	{
	  $zapp2 = mysql_query($sqlp2) or die('mysql_query');
          $danp2 = mysql_fetch_row($zapp2);
          echo ' - '.$danp2[0].' | '.$danp2[1].' | '.$danp2[2].' | '.$danp2[3].' | '.$danp2[4].' / '.$danp2[5].'<br/>
	  ';
	  	  
	  $sqlkol = " UPDATE Kolarze SET id_team = '$danp1[3]' WHERE id_kol = '$danp1[0]' ";
          $zapkol = mysql_query($sqlkol) or die('mysql_query');
	  echo $sqlkol.'
	  <br/>
	  ';
	  
	  $sqlp4 = " UPDATE z_a_historiakol SET id_do = '$danp1[3]', id_user='$danp1[5]' WHERE id_hk = '$danp2[0]' ";
          $zapp4 = mysql_query($sqlp4) or die('mysql_query');
	  echo $sqlp4.'
	  <br/>
	  ';
	  
	  $sqlp5 = " DELETE FROM z_a_historiakolprop WHERE id_hk = '$danp1[4]' ";
	  $zapp5 = mysql_query($sqlp5) or die('mysql_query');
	  echo $sqlp5.'
	  <br/>
	  ';
	  
	  
        } else {
          
	  $sqlp3 = " SELECT id_hk FROM z_a_historiakol ORDER BY id_hk DESC LIMIT 0, 1 ";
          $zapp3 = mysql_query($sqlp3) or die('mysql_query');
          $danp3 = mysql_fetch_row($zapp3);
          echo 'brak transferów w tej dacie <br/>
	  ';
	  
	  $sqlp9 = " SELECT id_team FROM Kolarze WHERE id_kol = '$danp1[0]' ";
          $zapp9 = mysql_query($sqlp9) or die('mysql_query');
	  $danp9 = mysql_fetch_row($zapp9); 
	  
	  $sqlkol = " UPDATE Kolarze SET id_team = '$danp1[3]' WHERE id_kol = '$danp1[0]' ";
          $zapkol = mysql_query($sqlkol) or die('mysql_query');
	  echo $sqlkol.'
	  <br/>
	  ';
	  
	  $sqlp5 = " DELETE FROM z_a_historiakolprop WHERE id_hk = '$danp1[4]' ";
	  $zapp5 = mysql_query($sqlp5) or die('mysql_query');
	  echo $sqlp5.'
	  <br/>
	  ';
	  
	  
	  
	  $idhk = $danp3[0] + 1;
	  $sqlp6 = " INSERT INTO z_a_historiakol (id_hk, id_kol, id_z, id_do, kiedy, id_user) VALUES ('$idhk', '$danp1[0]', '$danp9[0]', '$danp1[3]', '$danp1[1]', '$danp1[5]' ) ";
	  $zapp6 = mysql_query($sqlp6) or die('mysql_query');
	  echo $sqlp6.'
	  <br/>
	  ';
	  
        }  
        
        echo '<br/><br/>';
    }      
          
    }      
    echo koniec();
       ?>
    
    
    
   
