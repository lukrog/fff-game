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
   <title>FFF - podliczanie rankingu</title>
</head>
<body>
<div>

<?php
  echo google();

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
    
	  
	  
	  //------------------------------------//
	  // Mamy podliczone punkty za 2007 rok //
	  //                                    //
	  // Teraz liczymy średnią il. etapów   //
	  //    w których kolarze punktowali    //
	  //------------------------------------//
	  
	  $sqladv = " SELECT AVG(z_ranking2.CliM) AS avg "
	          . " FROM z_ranking2 "
	          . " WHERE z_ranking2.CliM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $CliAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking2.HilM) AS avg "
	          . " FROM z_ranking2 "
	          . " WHERE z_ranking2.HilM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $HilAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking2.FlM) AS avg "
	          . " FROM z_ranking2 "
	          . " WHERE z_ranking2.FlM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $FlAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking2.SprM) AS avg "
	          . " FROM z_ranking2 "
	          . " WHERE z_ranking2.SprM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $SprAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking2.CblM) AS avg "
	          . " FROM z_ranking2 "
	          . " WHERE z_ranking2.CblM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $CblAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking2.TTM) AS avg "
	          . " FROM z_ranking2 "
	          . " WHERE z_ranking2.TTM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $TTAv = mysql_fetch_row($zapavg);
	  
	  if ($CliAv[0] == 0) {$CliAv[0] = 1;}
	  if ($HilAv[0] == 0) {$HilAv[0] = 1;}
	  if ($FlAv[0] == 0) {$FlAv[0] = 1;}
	  if ($SprAv[0] == 0) {$SprAv[0] = 1;}
	  if ($CblAv[0] == 0) {$CblAv[0] = 1;}
	  if ($TTAv[0] == 0) {$TTAv[0] = 1;}
	  
	  //echo '<tr><td>avg</td><td>'.$CliAv[0].'</td><td>'.$HilAv[0].'</td><td>'.$FlAv[0].'</td><td>'.$SprAv[0].'</td><td>'.$CblAv[0].'</td><td>'.$TTAv[0].'</td></tr>';
	  
	  //echo '</table>';
	  
	  echo 'Przeliczam przez średnie <br/><br/>';
	  
	  //echo '<table id="menu2">';
	  //echo '<tr><td class="wyscig6">id kol</td><td class="wyscig6">Cli</td><td class="wyscig6">Hil</td><td class="wyscig6">Fl</td><td class="wyscig6">Spr</td><td class="wyscig6">Cbl</td><td class="wyscig6">TT</td></tr>';
	  
	  $sqlwyciagaj = " SELECT id_kol, Cli, CliM, Hil, HilM, Fl, FlM, Spr, SprM, Cbl, CblM, TT, TTM "
	               . " FROM z_ranking2 ";
          $zapwyciagaj = mysql_query($sqlwyciagaj) or die('mysql_query'); 
	  while ($danekol = mysql_fetch_row($zapwyciagaj)) {
	    //test
	    $Cli = $danekol[1] / sqrt($CliAv[0]);
	    $Hil = $danekol[3] / sqrt($HilAv[0]);
	    $Fl = $danekol[5] / sqrt($FlAv[0]);
            $Spr = $danekol[7] / sqrt($SprAv[0]);
            $Cbl = $danekol[9] / sqrt($CblAv[0]);
            $TT = $danekol[11] / sqrt($TTAv[0]);
	    
	    
	    //test
	    
	    
	    /*if ($danekol[2] > ($CliAv[0] * 10)) {
              $Cli = $danekol[1] / (sqrt($danekol[2]) * 1.5);
            } elseif ($danekol[2] > ($CliAv[0] * 6)) {  
              $Cli = $danekol[1] / (sqrt($danekol[2]) * 1.25);
            } elseif ($danekol[2] > ($CliAv[0] * 2)) {
              $Cli = $danekol[1] / sqrt($danekol[2]);
            } else {
              $Cli = $danekol[1] / sqrt($CliAv[0] * 2);
            }
            if ($danekol[4] > ($HilAv[0] * 10)) {
              $Hil = $danekol[3] / (sqrt($danekol[4]) * 1.5);
            } elseif ($danekol[4] > ($HilAv[0] * 6)) {  
              $Hil = $danekol[3] / (sqrt($danekol[4]) * 1.25);
            } elseif ($danekol[4] > ($HilAv[0] * 2)) {
              $Hil = $danekol[3] / sqrt($danekol[4]);
            } else {
              $Hil = $danekol[3] / sqrt($HilAv[0] * 2);
            }
            if ($danekol[6] > ($FlAv[0] * 10)) {
              $Fl = $danekol[5] / (sqrt($danekol[6]) * 1.5);
            } elseif ($danekol[6] > ($FlAv[0] * 6)) {  
              $Fl = $danekol[5] / (sqrt($danekol[6]) * 1.25);
            } elseif ($danekol[6] > (2 * $FlAv[0] )) {
              $Fl = $danekol[5] / sqrt($danekol[6]);
            } else {
              $Fl = $danekol[5] / sqrt(2 * $FlAv[0]);
            }
            if ($danekol[8] > ($SprAv[0] * 10)) {
              $Spr = $danekol[7] / (sqrt($danekol[8]) * 1.5);
            } elseif ($danekol[8] > ($SprAv[0] * 6)) {  
              $Spr = $danekol[7] / (sqrt($danekol[8]) * 1.25);
            } elseif ($danekol[8] > ($SprAv[0] * 2)) {
              $Spr = $danekol[7] / sqrt($danekol[8]*2);
            } else {  
              $Spr = $danekol[7] / sqrt($SprAv[0] * 4);
            }
            if ($danekol[10] > ($CblAv[0] * 10)) {
              $Cbl = $danekol[9] / (sqrt($danekol[10]) * 1.5);
            } elseif ($danekol[10] > ($CblAv[0] * 6)) {  
              $Cbl = $danekol[9] / (sqrt($danekol[10]) * 1.25);
            } elseif ($danekol[10] > ($CblAv[0] * 2)) {
              $Cbl = $danekol[9] / sqrt($danekol[10]);
            } else {
              $Cbl = $danekol[9] / sqrt($CblAv[0] * 2);
            }
            if ($danekol[12] > ($TTAv[0] * 10)) {
              $TT = $danekol[11] / (sqrt($danekol[12]) * 1.5);
            } elseif ($danekol[12] > ($TTAv[0] * 6)) {  
              $TT = $danekol[11] / (sqrt($danekol[12]) * 1.25);
            } elseif ($danekol[12] > ($TTAv[0] * 2)) {
              $TT = $danekol[11] / sqrt($danekol[12]);
            } else {
              $TT = $danekol[11] / sqrt($TTAv[0] * 2);
            }
            */
            $sqlwstaw = " UPDATE z_ranking2 SET Cli = '$Cli', Hil = '$Hil', Fl = '$Fl', Spr = '$Spr', Cbl = '$Cbl', TT = '$TT' WHERE id_kol = '$danekol[0]' ";
            $zapwstaw = mysql_query($sqlwstaw) or die('mysql_query');
            //echo '<tr><td class="wyscig6">'.$danekol[0].'</td><td class="wyscig6">'.$Cli.'</td><td class="wyscig6">'.$Hil.'</td><td class="wyscig6">'.$Fl.'</td><td class="wyscig6">'.$Spr.'</td><td class="wyscig6">'.$Cbl.'</td><td class="wyscig6">'.$TT.'</td></tr>';
          }
	  //echo '</table>';
	  echo '<h3>GÓRALE</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Cli FROM z_ranking2 ORDER BY Cli DESC ";
	  $zapost = mysql_query($sqlost) or die('mysql_query');
	  while ($daneost = mysql_fetch_row($zapost)) {
	    if ($daneost[1] > 0) {
              $wklej = $j;
            } else {
              $wklej = 0;
            }
            if ($j <= 20) {
            	echo ' '.$j.') '.$daneost[0].' - '.$daneost[1].'<br/>';
            }	
            $sqlwrzuc = " UPDATE z_ranking2 SET CliM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  }   
	  
	  
	  
	  echo '<h3>HILOWCY:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Hil FROM z_ranking2 ORDER BY Hil DESC ";
	  $zapost = mysql_query($sqlost) or die('mysql_query');
	  while ($daneost = mysql_fetch_row($zapost)) {
	    if ($daneost[1] > 0) {
              $wklej = $j;
            } else {
              $wklej = 0;
            }
            if ($j <= 20) {
            	echo ' '.$j.') '.$daneost[0].' - '.$daneost[1].'<br/>';
            }	
            $sqlwrzuc = " UPDATE z_ranking2 SET HilM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  echo '<h3>PŁASZCZAKI:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Fl FROM z_ranking2 ORDER BY Fl DESC ";
	  $zapost = mysql_query($sqlost) or die('mysql_query');
	  while ($daneost = mysql_fetch_row($zapost)) {
	    if ($daneost[1] > 0) {
              $wklej = $j;
            } else {
              $wklej = 0;
            }
            if ($j <= 20) {
            	echo ' '.$j.') '.$daneost[0].' - '.$daneost[1].'<br/>';
            }	
            $sqlwrzuc = " UPDATE z_ranking2 SET FlM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  
	  echo '<h3>SPRINTERZY:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Spr FROM z_ranking2 ORDER BY Spr DESC ";
	  $zapost = mysql_query($sqlost) or die('mysql_query');
	  while ($daneost = mysql_fetch_row($zapost)) {
	    if ($daneost[1] > 0) {
              $wklej = $j;
            } else {
              $wklej = 0;
            }
            if ($j <= 20) {
            	echo ' '.$j.') '.$daneost[0].' - '.$daneost[1].'<br/>';
            }	
            $sqlwrzuc = " UPDATE z_ranking2 SET SprM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  echo '<h3>Brukowcy:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Cbl FROM z_ranking2 ORDER BY Cbl DESC ";
	  $zapost = mysql_query($sqlost) or die('mysql_query');
	  while ($daneost = mysql_fetch_row($zapost)) {
	    if ($daneost[1] > 0) {
              $wklej = $j;
            } else {
              $wklej = 0;
            }
            if ($j <= 20) {
            	echo ' '.$j.') '.$daneost[0].' - '.$daneost[1].'<br/>';
            }	
            $sqlwrzuc = " UPDATE z_ranking2 SET CblM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  echo '<h3>Czasowcy:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, TT FROM z_ranking2 ORDER BY TT DESC ";
	  $zapost = mysql_query($sqlost) or die('mysql_query');
	  while ($daneost = mysql_fetch_row($zapost)) {
	    if ($daneost[1] > 0) {
              $wklej = $j;
            } else {
              $wklej = 0;
            }
            if ($j <= 20) {
            	echo ' '.$j.') '.$daneost[0].' - '.$daneost[1].'<br/>';
            }	
            $sqlwrzuc = " UPDATE z_ranking2 SET TTM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  
	  
        echo koniec();
?>
