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
   <title>FFF - panel zarządzający</title>
</head>
<body>
<div>

<?php
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
    
    $dzis=date("Y-m-d");
	
    $czyFA="NIE";
    $sql2 = " SELECT dok, typ FROM wydarzenia "
          . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 2 ";
    $zap2  = mysql_query($sql2) or die('mysql_query');
    if(mysql_num_rows($zap2) > 0) {
          $czyFA="OK";
    } else {
          $czyFA="nie";
    }
    
    //echo $czyFA;
    
    if (($czyFA == "OK") AND ($_SESSION['boss'] < 3)) {
      
      echo 'A ty czemu tu zaglądasz nieproszony :P ['.$_SESSION['boss'].']
      <br/><br/>
      Przecież prawdopodobnie trwa I runda licytacji więc nie ma co tu patrzeć.';
      
      } else {
        
      
      $zap1 = "SELECT User.id_user, User.login, User.kasa, User.liga, SUM(licytacje.ile), COUNT(licytacje.ile)
               FROM User INNER JOIN licytacje ON User.id_user = licytacje.id_user
               GROUP BY  User.id_user, User.login, User.kasa, User.liga";
      $idzap1 = mysql_query($zap1) or die('mysql_query');
      
      echo '<table class="wyscig">
            <tr><td>login</td><td>posiadane pieniądze<br/>--------<br/>-100C -kasa*20%</td><td>kasa za licyt.</td><td>Zalicytowane za C<br/>--------<br/>wygrywa</td><td>zalicytowano<br/>--------<br/>wygrywa</td><td>ilość po licytacjach</td></tr>
           ';

      while ($dan1 = mysql_fetch_row($idzap1)) {

      $zap2 = "SELECT COUNT(id_kol)
               FROM Kolarze
               WHERE id_user='$dan1[0]'
               GROUP BY id_user
               ";
      $idzap2 = mysql_query($zap2) or die('mysql_query');
      $dan2 = mysql_fetch_row($idzap2);
      $makolarzy = $dan2[0];

      $ilewygranych = 0;
      $sumawygranych = 0;
      $zap3 = "SELECT ile, id_kol
               FROM licytacje
               WHERE id_user='$dan1[0]'";
      $idzap3 = mysql_query($zap3) or die('mysql_query');
      while ($dan3 = mysql_fetch_row($idzap3)) {
         $zap4 = "SELECT id_user
                  FROM licytacje
                  WHERE id_kol = '$dan3[1]'
                  ORDER BY ile DESC, id_lic
                  LIMIT 0, 1";
         $idzap4 = mysql_query($zap4) or die('mysql_query');
         $dan4 = mysql_fetch_row($idzap4);
         if ($dan4[0] == $dan1[0]) {
           $ilewygranych++;
           $sumawygranych = $sumawygranych + $dan3[0];
         }
      }


      $maxzadl = - 100;// - 0.2 * $dan1[2];
      //$maxzadl = round($maxzadl*100)/100;
      echo '<tr><td><br/><br/>'.$dan1[1].' ('.$dan1[0].')<br/><br/><br/></td><td>'.$dan1[2].'<br/>'.$maxzadl.'</td><td>'.$dan1[4].'<br/>'.$sumawygranych.'</td><td>';


      $SUMAwsz = $dan1[2] - $dan1[4];
      if ($SUMAwsz < $maxzadl) {
         echo '<b>';
      }
      echo $dan1[2].' - '.$dan1[4].' = '.$SUMAwsz.'<br/>';
            if ($SUMAwsz < $maxzadl) {
         echo '</b>';
      }


      $SUMAwyg = $dan1[2] - $sumawygranych;
      if ($SUMAwyg < $maxzadl) {
         echo '<font color="red">';
      }
      echo $dan1[2].' - '.$sumawygranych.' = '.$SUMAwyg;
      if ($SUMAwyg < $maxzadl) {
         echo '</font>';
      }

      echo '</td><td>';


      echo $dan1[5].'<br/>'.$ilewygranych.'</td><td>';

      if ($dan1[3] == 1) {
         $ilemozekolarzy = 46;
      } elseif ($dan1[3] == 2) {
         $ilemozekolarzy = 40;
      } elseif ($dan1[3] == 3) {
         $ilemozekolarzy = 34;
      } else {
         $ilemozekolarzy = 0;
      }
      
      $SUMAkol = $makolarzy + $dan1[5];
      $SUMAkolw = $makolarzy + $ilewygranych;
      if ($SUMAkol > $ilemozekolarzy) {
         echo '<font color="red">';
      }
      echo $makolarzy.' + '.$dan1[5].' = '.$SUMAkol;
      if ($SUMAkol > $ilemozekolarzy) {
         echo ' max='.$ilemozekolarzy.'</font>';
      }
      echo '<br/>';
      $SUMAkolw = $makolarzy + $ilewygranych;
      if ($SUMAkolw > $ilemozekolarzy) {
         echo '<b>';
      }
      echo $makolarzy.' + '.$ilewygranych.' = '.$SUMAkolw;
      if ($SUMAkolw > $ilemozekolarzy) {
         echo '</b>';
      }

      echo '
      </td></tr>';
      }

      echo '</table>';

    } 
       
    
    
    
    echo koniec();
    ?>
