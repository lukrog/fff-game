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
   <title>FFF - transfer kolarza</title>
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
        $ile = $_POST['ile'];
        $id_kol = $_GET['id_kol'];
        

        
        // wybieramy kolarza o którego nam chodzi -------------------------------
        $sql1 = " SELECT imie, nazw, dataU, cena, id_user "
              . " FROM Kolarze "
              . " WHERE id_kol = '$id_kol' ";
      
        
        $zap1 = mysql_query($sql1) or die(mysql_error());
          
        $dan1 = mysql_fetch_row($zap1);
        
        echo 'Wybrałeś: <br/>';
        echo $dan1[0].' '.$dan1[1].'('.$dan1[4].'), który kosztując: <b>'.$dan1[3].'C</b> zdobył: <b>'.$dan1[2].'</b> punktów.<br/>';
        echo 'Ty zaproponowałeś: <b>'.$ile;
        $procent = round(100 * $ile / $dan1[3], 2);
        echo 'C</b> co stanowi <b>'.$procent.'%</b><br/><br/>';
        if ($procent >= 75) 
	{
          echo 'proponowana stawka jest zaakceptowana<br/>';
          
          $sql2 = " SELECT ile, id_tp "
                . " FROM transprop "
                . " WHERE id_kol = '$id_kol' AND id_userK = '$idek'";
          $zap2 = mysql_query($sql2) or die(mysql_error());
          if (mysql_num_rows($zap2) == 1) {
            $dan2 = mysql_fetch_row($zap2);
            $ileS = $dan2[0];
            echo '<br/>już zgłaszałeś się po tego kolarza oferując: <b>'.$ileS.'</b><br/><br/>';
          } else {
            $ileS = 0;
          }
          
          
          $sql10 = " SELECT id_tp FROM transprop ORDER BY id_tp DESC LIMIT 0, 1 ";
          $zap10 = mysql_query($sql10) or die('mysql_query');
          $wyn10 = mysql_fetch_row($zap10);
          $kolejne_id=$wyn10[0]+1;
          $dzis = date("Y-m-d");
          
          if ($ileS > 0) {
            
            //if ($ile > $ileS) {	  
            echo ' Aktualizowanie zgłoszenia nr: '.$dan2[1];
          
            $sql12 = " UPDATE transprop "
		   . " SET kiedy='$dzis', ile = '$ile' "
		   . " WHERE id_tp = '$dan2[1]' ";
	    $zap12 = mysql_query($sql12) or die('mysql_query');
	    //} else {
            //  echo '<font color=red>Zaproponowana przez Ciebie kwota jest niższa od poprzedniej lub równa!</font><br/>Wróć i zaproponuj kwotę wyższą niż '.$ileS;  
            //}
            echo ' ze stawką '.$ile.'C <br/> ';
	    
            } else {
            echo ' Dodawanie zgłoszenia';
            $sql12 = " INSERT INTO transprop "
		   . " VALUES ('$kolejne_id', '$dzis', '$id_kol', '$idek', '$dan1[4]', '$ile', 0) ";
	    $zap12 = mysql_query($sql12) or die('mysql_query');
 	    }
 	    
           
         
  		 
         } else {
          $stawN = round(0.75 * $dan1[3]);
          echo 'proponowana stawka jest nieodpowiednia<br/>musi się byś większa od <b>'.$stawN.'C</b> (75%)<br/><font color=red>Wróć i popraw zgłoszenie</font>';
         }
        
        
      } else {
        echo 'Nie masz uprawnień dostępu do tej strony';
      }
      
      
      
      
      echo koniec();
    ?>
    

    
    
    
    
    
