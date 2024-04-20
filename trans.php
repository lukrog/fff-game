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
   
   <meta http-equiv="Refresh" content="5; URL=trans.php"> 

   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - transakcje proponowane</title>
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
        $wydatki=0;
        $zarobki=0;
	echo '<h4 style="color=red;">Kolarze których chcesz kupić</h4>';

        $sql1 = " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , User.login , transprop.ile, Kolarze.id_kol "
              . " FROM User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transprop.id_userS "
	      . " WHERE id_userK = '$idek' AND transprop.typ = 0";
        $zap1 = mysql_query($sql1) or die('mysql_query');
        echo '<table class="wyscig">';
       	echo '<tr><td class="wyscig9"> Kolarz </td><td class="wyscig6"> Od kogo </td><td class="wyscig6"> kiedy </td><td class="wyscig6" style="text-align: right;"> za ile  </td></tr>';
        while ($dan1 = mysql_fetch_row($zap1)) 
        {
         $wydatki=$wydatki+$dan1[4];
         echo '<tr><td class="wyscig9"><a href="kol.php?id_kol='.$dan1[5].'">'.$dan1[0].' '.$dan1[1].'</a></td><td class="wyscig6">'.$dan1[3].'</td><td class="wyscig6">'.$dan1[2].'</td><td class="wyscig6" style="text-align: right;"><b> -'.$dan1[4].'C</b> </td></tr>';
        }
        
        //p-------------=-=-=-==================
        
        $sql1 = " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , User.login , transprop.ile, Kolarze.id_kol "
              . " FROM User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transprop.id_userS "
	      . " WHERE id_userK = '$idek' AND transprop.typ = 1";
        $zap1 = mysql_query($sql1) or die('mysql_query');
        while ($dan1 = mysql_fetch_row($zap1)) 
        {
          
          $id_zakogo = (-1) * $dan1[4];

        
        $sqlp4 = " SELECT imie, nazw, id_kol, id_user FROM Kolarze WHERE id_kol = '$id_zakogo' ";
        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
        $danp4 = mysql_fetch_row($zapp4);
	
         echo '<tr><td class="wyscig9"><a href="kol.php?id_kol='.$dan1[5].'">'.$dan1[0].' '.$dan1[1].'</a></td><td class="wyscig6">'.$dan1[3].'</td><td class="wyscig6">'.$dan1[2].'</td><td class="wyscig6" style="text-align: right;">';
	 echo '<br/>wymiana: ';
	 echo $danp4[0].' <b>'.$danp4[1].'</b>';
	 echo '</td></tr>';
	 
        }
        
        //k-------------=-=-=-==================
        
        echo '</table>';
        
        echo '<h4 style="color=red;">Kolarze których możesz sprzedać</h4>';
        $sql2 = " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , User.login , transprop.ile, transprop.id_tp, Kolarze.id_kol "
              . " FROM User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transprop.id_userK "
	      . " WHERE id_userS = '$idek' AND transprop.typ = 0";
        $zap2 = mysql_query($sql2) or die('mysql_query');
        echo '<table class="wyscig">';
        echo '<tr><td class="wyscig9"> Kolarz </td><td class="wyscig6"> Komu </td><td class="wyscig6"> kiedy </td><td class="wyscig6" style="text-align: right;"> za ile </td><td class="wyscig6" style="text-align: right;"> potwierdź </td></tr>';        
	while ($dan2 = mysql_fetch_row($zap2)) 
        {
       	  $string1  = '<form action="transP.php?id_tp='.$dan2[5].'"  method="post" >';
       	  $string1 .= '	<input type="hidden" name="typ" value=0 />';
   	  $string1 .= '	<input class="form2" type="submit" name="potwierdź" value="Potwierdź" />';
   	  $string1 .= '</form>';

          $string1 .= '<form action="transOD.php?id_tp='.$dan2[5].'"  method="post" >';
       	  $string1 .= '	<input type="hidden" name="typ" value=1 />';
   	  $string1 .= '	<input class="form2" type="submit" name="Odrzuć" value="Odrzuć" />';
   	  $string1 .= '</form>';

          $zarobki=$zarobki+$dan2[4];
           echo '<tr><td class="wyscig9"><a href="kol.php?id_kol='.$dan2[6].'">'.$dan2[0].' '.$dan2[1].'</a></td><td class="wyscig6">'.$dan2[3].'</td><td class="wyscig6">'.$dan2[2].'</td><td class="wyscig6" style="text-align: right;"><b>'.$dan2[4].'C</b></td><td style="text-align: right;">'.$string1.'</td></tr>';
        }
        
        //p-------------=-=-=-==================
        
        $sql2 = " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , User.login , transprop.ile, Kolarze.id_kol, transprop.id_tp "
              . " FROM User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transprop.id_userS "
	      . " WHERE id_userS = '$idek' AND transprop.typ = 1";
        $zap2 = mysql_query($sql2) or die('mysql_query');
        while ($dan2 = mysql_fetch_row($zap2)) 
        {
          $string1  = '<form action="transP.php?id_tp='.$dan2[6].'"  method="post" >';
       	  $string1 .= '	<input type="hidden" name="typ" value=1 />';
   	  $string1 .= '	<input class="form2" type="submit" name="potwierdź" value="Potwierdź" />';
   	  $string1 .= '</form>';

          $string1 .= '<form action="transOD.php?id_tp='.$dan2[6].'"  method="post" >';
       	  $string1 .= '	<input type="hidden" name="typ" value=1 />';
   	  $string1 .= '	<input class="form2" type="submit" name="Odrzuć" value="Odrzuć" />';
   	  $string1 .= '</form>';
          
          $id_zakogo = (-1) * $dan2[4];
        
        
        $sqlp4 = " SELECT Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, User.login FROM Kolarze INNER JOIN User ON Kolarze.id_user = User.id_user WHERE id_kol = '$id_zakogo' ";
        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
        $danp4 = mysql_fetch_row($zapp4);
	
         echo '<tr><td class="wyscig9"><a href="kol.php?id_kol='.$danp4[2].'">'.$danp4[0].' <b>'.$danp4[1].'</b></a></td><td class="wyscig6">'.$danp4[3].'</td><td class="wyscig6">'.$dan2[2].'</td><td class="wyscig6" style="text-align: right;">';
	 echo '<br/>wymiana: ';
	 echo $dan2[0].' <b>'.$dan2[1].'</b>';
	 echo '</td><td style="text-align: right;">'.$string1.'</td></tr>';
	 
        }
        
        //k-------------=-=-=-==================
        
        echo '</table>';
        $roznica = $zarobki - $wydatki;
        
        
        
        echo '<br/><table>';
	echo '<tr><td class="wyscig9">planowane pieniądze na wydatki:</td><td style="text-align: right;"><b>-'.$wydatki.'C</b></td></tr>';
        echo '<tr><td class="wyscig9">planowane pieniądze do zarobienia:</td><td style="text-align: right;"><b>'.$zarobki.'C</b></td></tr>';
        echo '<tr><td class="wyscig9">różnica:</td><td style="text-align: right;"d><b>'.$roznica.'C<b></td></tr>';
	echo '</table>';
		
       
       } else {
         echo '<h4>Okno transferowe zamknięte</h4>';
       }
       } else {
         echo 'Nie masz uprawnień do tej strony';
       } 
       
       
       
       
       
       echo koniec();   
    ?>
    
    
    
   
