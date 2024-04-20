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
        if ($_SESSION['boss'] >= 0) {
             if ($_GET['sort'] == "") {
               $sort1 = 1;
             } else {
               $sort1=$_GET['sort'];
             }
             
             echo  '<form action="transADM.php" method="get">';
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po nazwiskach kolarzy<br>';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po kupujących<br>';
             echo  '<input class="form" type=radio name=sort value=3 ';
	     if ($sort1 == 3) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po sprzedających<br>';
	     echo  '<input class="form" type=radio name=sort value=4 ';
	     if ($sort1 == 4) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po cenie<br>';
	     echo  '<input class="form" type=radio name=sort value=5 ';
	     if ($sort1 == 5) {
               echo 'checked="checked"';
             }
             echo '>Sortowanie po dacie transferu<br/>';
	     
	     
             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';

          

          
          
            $sort1=$_GET['sort'];
            if ($sort1 == 3) {
              $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, Kolarze.cena, transzaak.poprzednia_cena 
	                FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS
			WHERE User_1.login <> User.login
			ORDER BY User_1.login
			LIMIT 0, 100 ";
            } elseif ($sort1 == 2)
            {
    	      $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, Kolarze.cena, transzaak.poprzednia_cena  
		        FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS 
			WHERE User_1.login <> User.login
			ORDER BY User.login
			LIMIT 0, 100 ";
	    } elseif ($sort1 == 4)
            {
    	      $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, Kolarze.cena, transzaak.poprzednia_cena
		        FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS
			WHERE User_1.login <> User.login
			ORDER BY transzaak.ile DESC
			LIMIT 0, 100 ";
	    } elseif ($sort1 == 1) {
	      $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, Kolarze.cena, transzaak.poprzednia_cena
	                FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS
			WHERE User_1.login <> User.login
			ORDER BY Kolarze.nazw
			LIMIT 0, 100 ";
            } else {
	      $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, Kolarze.cena, transzaak.poprzednia_cena
	                FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS
			WHERE User_1.login <> User.login
			ORDER BY transzaak.kiedy DESC, transzaak.id_tpZ DESC
			LIMIT 0, 100 ";
            }
            $wydatki=0;
            $zarobki=0;
	    echo '<h5 style="color=red;"> Kolarze którzy zmienili barwy: </h5>';
	    
            $zap3 = mysql_query($sql3) or die('mysql_query');
            echo '<table class="wyscig">';
            echo '<tr><td class="wyscig9"> Kolarz </td><td class="wyscig6" style="text-align: middle;"> kiedy zapr. </td><td class="wyscig6" style="text-align: middle;"> Sprzedający </td><td class="wyscig6" style="text-align: middle;"> Kupujący </td><td class="wyscig1" style="text-align: right;"> za ile </td><td class="wyscig6" style="text-align: middle;"> ile kosztował poprzednio </td></tr>';
            while ($dan3 = mysql_fetch_row($zap3)) 
            {
              echo '<tr><td class="wyscig9">'.$dan3[0].' '.$dan3[1].'</td></td><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;"> <b>';
	      
	      if ($dan3[3] < 0) {
                 echo 'wymiana';
              } else {
	         echo $dan3[3].'C';
	      }
	      
	      
	      
	      echo '</b><td class="wyscig6" style="text-align: right;"> ';
	      
	      echo $dan3[8].'C';
	      
     
	      echo '</td></tr>
	      ';
            }
              echo '</table>';
            
       
          } else {
            echo 'Nie masz uprawnień do tej strony';
          } 
       } else {
      echo 'Musisz się zalogować';
    }   
    
    
    
    echo koniec();
    ?>
    
    
    
 
