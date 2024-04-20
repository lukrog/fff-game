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
	  $sqlas = "SELECT kosz, reka, boki, spon, opis FROM User Where id_user = '$idek' ";
	  $zapas = mysql_query($sqlas) or die('mysql_query');
	  $daneas = mysql_fetch_row($zapas);
	  
	  
	  
	  echo '<h3>Chcesz wyedytować dane swojej ekipy</h3>na dole podpowiedzi';
	  
	  
	  echo ' <form action="useredEXE.php" method="POST">';
                    
	  
	  echo '<table class="wyscig">';
	  echo '<tr><td class="wyscig7">Kolor</td>';
	  for ($i=1; $i<=9; $i++) {
	    
	     echo '<td><img src="img/koszulki/kolor_0'.$i.'.jpg" alt="biały" /></td>';
	  
	  }
	  echo '</tr>';
	  
	  echo '<tr><td>podaj kolor koszulki</td>';
	  for ($i=1; $i<=9; $i++) {
	  
	  	  echo '<td><INPUT ';
                  if ($daneas[0] == $i) { echo 'CHECKED'; }
		  echo ' type="radio" name="koszulka" value='.$i.' /></td>';
	  	  
	  }	
	  echo '</tr>';
	  
	  echo '<tr><td>podaj kolor rękawków</td>';
	  for ($i=1; $i<=9; $i++) {
	  
	  	  echo '<td><INPUT ';
                  if ($daneas[1] == $i) { echo 'CHECKED'; }
		  echo ' type="radio" name="rekawki" value='.$i.' /></td>';
	  	  
	  }	
	  echo '</tr>';  
	  
	  echo '<tr><td>podaj kolor boków</td>';
	  for ($i=1; $i<=9; $i++) {
	  
	  	  echo '<td><INPUT ';
                  if ($daneas[2] == $i) { echo 'CHECKED'; }
		  echo ' type="radio" name="boki" value='.$i.' /></td>';
	  	  
	  }	
	  echo '</tr>'; 
	  
	  echo '<tr><td>podaj adres loga</td><td colspan=9><INPUT type="text" value="'.$daneas[3].'" name="logo" /></td></tr>';
	  echo '<tr><td>podaj opis ekipy</td><td colspan=9><TEXTAREA name="opis" rows="20" cols="40">'.$daneas[4].'</TEXTAREA></td></tr>';
	  echo '<tr><td colspan=10 align=right><input class="form2" type=submit value="Zatwierdź" /></td></tr>';
	  echo '</table>';
	  
          echo ' </form>';
          
          echo 'Podpowiedzi:<br/> W opisie ekipy znaczniki HTML działają ( &lt;b&gt; &lt;i&gt; &lt;u&gt; &lt;br/&gt; &lt;img&gt; ). Opis ekipy powinien być na teamat';
          echo '<br/>Obrazek loga nie powinien być większy niż 75x75 i jego wielkość będzie wpływać na jego wyświetlanie (wyświetlony będzie na środku koszulki)';
	          
	} else {
   	  echo '<h3>Ta strona dostępna tylko po zalogowaniu</h3>';
   
        }




	  echo koniec();
        ?>
         
    
