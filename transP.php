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
   <title>FFF - transfer</title>
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
    ?>
    <h3  style="color: red">
     Nie odświeżaj tej strony. Gdy przemieli ona informacje przejdx do kolenych.
    </h3>
    <?php 
      if($_SESSION['logowanie'] == 'poprawne') { 
        $id_tp = $_GET['id_tp'];

        
  
        

        $sql2 = " SELECT transprop.kiedy , transprop.id_kol , transprop.id_userK , transprop.id_userS , transprop.ile , Kolarze.cena, transprop.typ "
              . " FROM transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol "
	      . " WHERE id_tp = '$id_tp' ";
        $zap2 = mysql_query($sql2) or die('mysql_query');
        $dan2 = mysql_fetch_row($zap2);
        
        
        
        if ($dan2[6] == 0) {
        
        echo 'id tranz: '.$id_tp.'<br/>kiedy'.$dan2[0].'<br/> id_kolarza:'.$dan2[1].'<br/>id Usera KUPUJĄCEGO'.$dan2[2].'<br/>id Usera SPRZEDAJĄCEGO'.$dan2[3].'<br/>ile za tranzakcję'.$dan2[4].'<br/>ile proprzednio kosztował kolarz:'.$dan2[5];
        
        $sql3 = " DELETE FROM transprop WHERE id_kol = '$dan2[1]' ";
        $zap3 = mysql_query($sql3) or die('mysql_query');
        echo 'Kasuję dane zawodnika z listy proponowanych transferów <br/><br/>';
        
        $sql311 = " SELECT id_tpZ "
                . " FROM transzaak "
                . " ORDER BY id_tpZ DESC "
                . " LIMIT 0, 1 ";
        $zap311 = mysql_query($sql311) or die('mysql_query');
        $dan311 = mysql_fetch_row($zap311);
        $id_tp1 = $dan311[0] + 1;
        
        $sql4 = " INSERT INTO transzaak VALUES ('$id_tp1', '$dan2[0]', '$dan2[1]', '$dan2[2]', '$dan2[3]', '$dan2[4]', '$dan2[5]', 0) ";
        $zap4 = mysql_query($sql4) or die('mysql_query');
        echo 'Dodaję transfer zawodnika do historii transferów<br/>';
        
        // ------------------------------------------------------------------------------------
        
        
        
        $sql5 = "SELECT kasa FROM User WHERE id_user='$dan2[2]'";
        $zap5 = mysql_query($sql5) or die('mysql_query');
        $dan5 = mysql_fetch_row($zap5);
        echo '<br/><br/>sprawdzam pieniądze kupującego ('.$dan2[2].') --- '.$dan5[0].'<br/>';
             
        // ------------------------------------------------------------------------------------
        
	$pieniadze = $dan5[0] - $dan2[4];
	echo 'zabieram pieniądze do kupującego ('.$dan2[2].') Nowa kasa='.$pieniadze.' = '.$dan5[0].' - '.$dan2[4].' <br/>';
	
	$sql6 = " UPDATE User SET kasa='$pieniadze' WHERE id_user='$dan2[2]' ";
	$zap6 = mysql_query($sql6) or die('mysql_query');
        
        // ------------------------------------------------------------------------------------
	
	$sql8 = "SELECT kasa FROM User WHERE id_user='$dan2[3]'";
        $zap8 = mysql_query($sql8) or die('mysql_query');
        $dan8 = mysql_fetch_row($zap8);
        echo '<br/><br/>sprawdzam pieniądze sprzedającemu ('.$dan2[3].') --- '.$dan8[0].'<br/>';
        
        // ------------------------------------------------------------------------------------
        
	$pieniadze = $dan8[0] + $dan2[4];
	echo 'dodaję zabieram pieniądze sprzedającemu ('.$dan2[2].') Nowa kasa='.$pieniadze.' = '.$dan8[0].' + '.$dan2[4].' <br/>';
	
	$sql9 = " UPDATE User SET kasa='$pieniadze' WHERE id_user='$dan2[3]' ";
	$zap9 = mysql_query($sql9) or die('mysql_query');
        
        // ------------------------------------------------------------------------------------
        
        $sql7 = "UPDATE Kolarze SET id_user='$dan2[2]', cena='$dan2[4]'  WHERE id_kol='$dan2[1]'";
        $zap7 = mysql_query($sql7) or die('mysql_query');
        echo '<br/><br/>zmieniam drużynę kolarzowi na ('.$dan2[2].') a jego cenę na: '.$dan2[4];
          
        
        
        echo 'Usuwam zgłoszenia z następnych wyścigów.';
        $dzis = date ("Y-m-d");
        $sql10 = " SELECT zgloszenia.id_kol, Wyscigi.dataP, Wyscigi.id_wys, zgloszenia.id_zgl "
	       . " FROM zgloszenia INNER JOIN Wyscigi ON zgloszenia.id_wys = Wyscigi.id_wys "
	       . " WHERE (zgloszenia.id_kol = '$dan2[1]' AND  Wyscigi.dataP >= '$dzis' )  ";
	$zap10 = mysql_query($sql10) or die('mysql_query');
	while ($dan10 = mysql_fetch_row($zap10))  {
           echo $dan10[3].'znaleziono zgłoszenia tego kolarza do wyścigu id='.$dan10[2].' = i je skasowano<br/>'; 
           $sql11 = " DELETE FROM zgloszenia WHERE id_zgl = '$dan10[3]' ";
	   $zap11 = mysql_query($sql11) or die('mysql_query');
	   
        }
        
        } else {
          echo 'wymiana kolarzy <br/><br/>';
          
          
          
          
          
          echo 'id tranz: '.$id_tp.'<br/>kiedy '.$dan2[0].'<br/> id_kolarza: '.$dan2[1].'<br/>id Usera KUPUJĄCEGO '.$dan2[2].'<br/>id Usera SPRZEDAJĄCEGO '.$dan2[3].'<br/>kolarz który idzie na wymianę '.$dan2[4].'<br/>ile proprzednio kosztował kolarz: '.$dan2[5];
        
        $sql3 = " DELETE FROM transprop WHERE id_kol = '$dan2[1]' ";
        $zap3 = mysql_query($sql3) or die('mysql_query');
        
        
        $za_kogo = $dan2[4] * (-1);
        $sql3 = " DELETE FROM transprop WHERE id_kol = '$za_kogo' ";
        $zap3 = mysql_query($sql3) or die('mysql_query');
        
        echo '<br/><br/>Kasuję dane zawodników z listy proponowanych transferów:.'.$dan2[1].' i '.$za_kogo.' <br/><br/>';
        
        $sql311 = " SELECT id_tpZ "
                . " FROM transzaak "
                . " ORDER BY id_tpZ DESC "
                . " LIMIT 0, 1 ";
        $zap311 = mysql_query($sql311) or die('mysql_query');
        $dan311 = mysql_fetch_row($zap311);
        $id_tp1 = $dan311[0] + 1;
        
        echo '<br/>Do tej pory przeprowadzono '.$dan311[0].' Transferów<br/>';
        
        $za_kogo2 = $za_kogo * (-1);
        
        $sql4 = " INSERT INTO transzaak VALUES ('$id_tp1', '$dan2[0]', '$dan2[1]', '$dan2[3]', '$dan2[2]', '$za_kogo2', '$dan2[5]', 3) ";
        $zap4 = mysql_query($sql4) or die('mysql_query');
        
        echo 'Wstawiam dane: '.$id_tp1.', '.$dan2[0].', '.$dan2[1].', '.$dan2[2].', '.$dan2[3].', '.$za_kogo2.', '.$dan2[5].', 3<br/><br/>';
        
        $za_kogo3 = $dan2[1] * (-1);
        
        $id_tp1++;
        
        echo '<br/>  --  '.$za_kogo;
        
        $sql876 = " SELECT cena FROM Kolarze WHERE id_kol = '$za_kogo' ";
        $zap876 = mysql_query($sql876) or die('mysql_query');
        $dan876 = mysql_fetch_row($zap876);
        
        
        $sql4 = " INSERT INTO transzaak VALUES ('$id_tp1', '$dan2[0]', '$za_kogo', '$dan2[2]', '$dan2[3]', '$za_kogo3', '$dan876[0]', 3) ";
        $zap4 = mysql_query($sql4) or die('mysql_query');
        
        echo 'Wstawiam '.$id_tp1.', '.$dan2[0].', '.$za_kogo.', '.$dan2[2].', '.$dan2[3].', '.$za_kogo3.', '.$dan798[0].', 3 <br/><br/>';
        
        echo 'Dodaję transfer zawodnika do historii transferów<br/>';
        
        // ------------------------------------------------------------------------------------
        
        
        
                
        // ------------------------------------------------------------------------------------
        
        $sql7 = "UPDATE Kolarze SET id_user='$dan2[2]' WHERE id_kol='$dan2[1]'";
        $zap7 = mysql_query($sql7) or die('mysql_query');
        echo '<br/><br/>zmieniam drużynę kolarzowi (id:'.$dan2[1].') na ('.$dan2[2].')';
        
	$sql7 = "UPDATE Kolarze SET id_user='$dan2[3]' WHERE id_kol='$za_kogo'";
        $zap7 = mysql_query($sql7) or die('mysql_query');
        echo '<br/><br/>zmieniam drużynę kolarzowi (id:'.$za_kogo.') na ('.$dan2[3].')';  
        
        
        echo '<br/><br/>Usuwam zgłoszenia z następnych wyścigów.';
        $dzis = date ("Y-m-d");
        $sql10 = " SELECT zgloszenia.id_kol, Wyscigi.dataP, Wyscigi.id_wys, zgloszenia.id_zgl "
	       . " FROM zgloszenia INNER JOIN Wyscigi ON zgloszenia.id_wys = Wyscigi.id_wys "
	       . " WHERE (zgloszenia.id_kol = '$dan2[1]' AND  Wyscigi.dataP >= '$dzis' )  ";
	$zap10 = mysql_query($sql10) or die('mysql_query');
	while ($dan10 = mysql_fetch_row($zap10))  {
           echo $dan10[3].'znaleziono zgłoszenia tego kolarza do wyścigu id='.$dan10[2].' = i je skasowano<br/>'; 
           $sql11 = " DELETE FROM zgloszenia WHERE id_zgl = '$dan10[3]' ";
	   $zap11 = mysql_query($sql11) or die('mysql_query');
	   
        }
          
          
        } 
 
 
 
       } else {
         echo 'Nie masz uprawnień do tej strony';
       }  
       
       
       
       
       echo koniec();  
    ?>
    
    
    
    
