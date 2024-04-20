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
   <title>FFF - dane drużyn fff</title>
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
	          $id_user = $_GET['id_user'];
	    
	          if ($_SESSION['boss'] >= 2) {
	          

	
		  
		    
		    $sql9 = " SELECT id_kol
		              FROM Kolarze
			      ORDER BY id_kol ";
			            
                    echo "Pierwsze zapytanie: '".$sql9."' <br>";
		    		  
		    $zap9 = mysql_query($sql9) or die('mysql_query $zap9');
		    while ($dan9 =  mysql_fetch_row($zap9)) {
		       $sql8 = " SELECT SUM(punkty)
		                 FROM Wyniki
		                 WHERE id_kol='$dan9[0]'
		                 GROUP BY id_kol
			         ORDER BY id_kol "; 
				     
		       //echo 'Zapytanie o kolarza nr: '.$dan9[0].': '.$sql8.' //<br/>'; 
                   		  
		       $zap8 = mysql_query($sql8) or die('mysql_query $zap8');
		       $dan8 =  mysql_fetch_row($zap8);
		       
		       echo 'kolarz: '.$dan9[0].' => '.$dan8[0].'<br/> ';
	         	if ($dan8[0]>0) {
	     			$dan8[0]=$dan8[0];	
	   		} else {
				$dan8[0]=0;
	     		}
	         
	               $sql7 = " UPDATE Kolarze
			         SET punkty = '$dan8[0]'
				 WHERE id_kol='$dan9[0]' ";
				 
 			//echo 'Tu aktualizuję punkty kolarza '.$dan9[0].' › '.$dan8[0].' zapytaniem: '.$sql7.' //<br/>';
				 
	               $zap7 = mysql_query($sql7) or die('mysql_query');
		       
		       //echo ' '.$sql7.'<br/>';
                     
		     }
	    
	 
	 
	          } else {echo 'To nie strona dla Ciebie';}
 
 
 
 
 
	} else {
   	  echo '<h3>Ta strona dostępna tylko po zalogowaniu</h3>';
   
        }


	  
	  
	  
	  
	  
	  echo koniec();
        ?>
