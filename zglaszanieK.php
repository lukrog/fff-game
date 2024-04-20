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
  $id_wys = $_GET['id_wys'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <?php 
   echo '<meta http-equiv="Refresh" content="5; URL=wyscig.php?id_wys='.$id_wys.'#ZGL">';
   ?>
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
    
    
    
    
    if ($_POST['pri'] == "on") {
          $prio = 1;
        } else {
          $prio = 0;
        }
    $sql1= " SELECT ilu_kol, dataP "
         . " FROM Wyscigi "
         . " WHERE ( ( id_wys = '$id_wys'))";
    $runsql1 = mysql_query($sql1) or die('mysql_query');
    $dan = mysql_fetch_row($runsql1);
    
    $sqlb = " SELECT id_kol, id_zgl  "
          . " FROM zgloszenia "
          . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$id_wys')  "
	  . " ORDER BY kolej "; 
	echo $sqlb."<br/><br/>";  
    $runsql2 = mysql_query($sqlb) or die(mysql_error());
    $wyslij="NEW";
    if (mysql_num_rows($runsql2) > 0) {
      $wyslij = "OLD";
    } else {
      $wyslij = "NEW";
    }
    $ilu=$dan[0];   
    $e=1;
    if ($wyslij == "OLD")  {
      $sqlb = " SELECT id_kol, id_zgl  "
            . " FROM zgloszenia "
            . " WHERE ((zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$id_wys'))  "
  	    . " ORDER BY kolej "; 
  	    echo $sqlb."<br/><br/>";  
      $runsql2 = mysql_query($sqlb) or die(mysql_error());
      while ($wiersz = mysql_fetch_row($runsql2)) 
      {
        $kola[$e] = $wiersz[1];
        $e++;
      }
    }
    

    $zglosz[1] = $_POST["K1"];
    $zglosz[2] = $_POST["K2"];
    $zglosz[3] = $_POST["K3"];
    $zglosz[4] = $_POST["K4"];
    $zglosz[5] = $_POST["K5"];
    $zglosz[6] = $_POST["K6"];
    $zglosz[7] = $_POST["K7"];
    $zglosz[8] = $_POST["K8"];
    $zglosz[9] = $_POST["K9"];
    $zglosz[10] = $_POST["K10"];
    $zglosz[11] = $_POST["K11"];
    $zglosz[12] = $_POST["K12"];
    $zglosz[13] = $_POST["K13"];
    $zglosz[14] = $_POST["K14"];
    $zglosz[15] = $_POST["K15"];
    $zglosz[16] = $_POST["K16"];
    $zglosz[17] = $_POST["K17"];
    $zglosz[18] = $_POST["K18"];
    
    if ($wyslij == "NEW") {
      $sqlb = " SELECT id_kol, id_zgl  "
            . " FROM zgloszenia Order by id_zgl DESC";
            echo $sqlb."<br/><br/>";  
      $runadd = mysql_query($sqlb) or die(mysql_error());
      //$ile = mysql_num_rows($runadd);
      $ile2 = mysql_fetch_row($runadd);
      echo $ile2." - = - ";
      $ile = $ile2[1];
      echo $ile."<-Tyle <br/>";
      for ($r=1 ; $r <= $ilu * 2 - 4 ; $r++) {
        $idzgl = $ile+$r;
        if ($_POST['pri'] == "on") {
          $prio = 1;
        } else {
          $prio = 0;
        }
        $dzis = date("Y-m-d H:i:s");
        $sqladd = " INSERT INTO zgloszenia (id_zgl, kolej, id_kol, id_wys, id_user, pri, dataZ) VALUES ('$idzgl', '$r', '$zglosz[$r]', '$id_wys', '$idek', '$prio', '$dzis')";
        echo $sqladd."<br/><br/>"; 
	$runadd = mysql_query($sqladd) or die(mysql_error());
      }
    } else {         
      if ($_POST['pri'] == "on") {
          $prio = 1;
        } else {
          $prio = 0;
        }
      $dzis = date("Y-m-d H:i:s");  
      for ($r=1 ; $r <= $ilu * 2 - 4 ; $r++) {
      echo $kola[$r],' -> ',$zglosz[$r],' ; ',$prio,' ; ',$dzis,'<br/>';
      $sqladd = " UPDATE zgloszenia SET id_kol='$zglosz[$r]', pri = '$prio', dataZ = '$dzis' WHERE (id_zgl='$kola[$r]' AND id_user='$idek')";
      echo $sqladd."<br/><Br/>";
      $runadd = mysql_query($sqladd) or die(mysql_error());
      }
    }
  
?>
     <h3> Zgłoszenie zostało zaakceptowane </h3>
     poczekaj na akceptację nie przechodź na inne strony i się nie wylogowywuj.
    
    
<?php 
  echo koniec();    
    
?>
