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
    
	  //----------------------------------------//
	  // Najpierw czyścimy tabele z poprzednich //
	  //               wyników                  //
	  //----------------------------------------//
	  
	  $sql = " TRUNCATE TABLE z_ranking ";
	  $zap = mysql_query($sql) or die('mysql_query'); 
	  
	  //$sql = " TRUNCATE TABLE z_ranking2 ";
	  //$zap = mysql_query($sql) or die('mysql_query'); 
	  
	  
	  echo '<table id="menu2">';
	  echo '<tr><td class="wyscig6">id kol</td><td class="wyscig6">Cli</td><td class="wyscig6">Hil</td><td class="wyscig6">Fl</td><td class="wyscig6">Spr</td><td class="wyscig6">Cbl</td><td class="wyscig6">TT</td></tr>';
	  echo 'Zaczynam podliczanie kolarzy <br/><br/>';
	  $sql = " SELECT id_kol FROM Kolarze ORDER BY id_kol ";
	  $zap = mysql_query($sql) or die('mysql_query');
	  while ($kolarz = mysql_fetch_row($zap)) {
	  //for ($a = 1; $a < 2; $a++) {  
	  //$kolarz[0] = 83;  
	    
            // ----------------------------------------//
            //                                         //
	    // zajmuję się kolarzem o id = $kolarz[0]  //
	    //                                         //
	    // najpierw podliczmy punkty kolarzy za    //
	    //          miejsca w wyścigach            //
	    //                                         //
	    // ----------------------------------------//
	    
	    
	    $Cli  = 0;
	    $CliM = 0;
	    $Hil  = 0;
	    $HilM = 0;
	    $Fl   = 0;
	    $FlM  = 0;
	    $Spr  = 0;
	    $SprM = 0;
	    $Cbl  = 0;
	    $CblM = 0;
	    $TT   = 0;
	    $TTM  = 0;
	    
	    $rokobecny = date("y");
	    $rokobecny = $rokobecny * 1000; 
            $rokpoprzedni = $rokobecny - 1000;
            
	    $coteraz = date("y-m-d");
	    //echo 'teraz: ',$coteraz,' <br/>';
            $coteraz = strtotime($coteraz) - 365 * 24 * 3600;
            $coteraz = date('Y-m-d',$coteraz);
	    //echo 'rok temu: ',$coteraz,' <br/>';
	    
	    $sqlmiejsca = " SELECT WynikiP.miejsce, z_EtapyKat.id_kat, z_EtapyKat.id_kat2, z_EtapyKat.id_co, z_EtapyKat.id_pun, z_EtapyKat.pierwszy_z_pel, YEAR(Wyscigi.dataP), WynikiP.id_wys "
	                . " FROM z_EtapyKat INNER JOIN (Wyscigi INNER JOIN WynikiP ON Wyscigi.id_wys = WynikiP.id_wys) ON (z_EtapyKat.id_co = WynikiP.id_co) AND (z_EtapyKat.id_wys = Wyscigi.id_wys) "
		        . " WHERE ((WynikiP.id_kol = '$kolarz[0]') AND (z_EtapyKat.id_kat <> 0) AND (Wyscigi.dataK >= '$coteraz')) ";
	    $zapmiejsca = mysql_query($sqlmiejsca) or die('mysql_query');
	    while ($wyniki = mysql_fetch_row($zapmiejsca)) {
	      //echo $wyniki[1].'----------------';
	      //-------------------------//
	      //    sprawdzam czy była   //
	      //         ucieczka        //
	      //-------------------------//
	      	      
              if ($wyniki[1] >=100) {
                $ucieczka_kat = $wyniki[1];
                $peleton_kat = $wyniki[1]+1;
              } else {
                $ucieczka_kat = $wyniki[1];
                $peleton_kat = $wyniki[1];
              }
	          
	      //-------------------------//
	      //  teraz wyciąga punkty z //
	      //       tych wyników      //
	      //-------------------------//
	      
	      if ($wyniki[3] == 0) {
                $id_pun = $wyniki[4];
              } else {
	        $id_pun = $wyniki[4]+100;
	      }
	  
	      $sqlpunkty = " SELECT z_pun.pun "
	                 . " FROM z_pun "
			 . " WHERE z_pun.id_punktacji = '$id_pun' AND z_pun.miejsce = '$wyniki[0]' ";
              $zappunkty = mysql_query($sqlpunkty) or die('mysql_query');
	      $punkty = mysql_fetch_row($zappunkty);
	      
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //echo 'zdobły punktów na '.$wyniki[7].' ('.$wyniki[3].') - '.$punkty[0].' za '.$wyniki[0].' miejsce<br/>';
              
              if ($wyniki[0] < $wyniki[5]) {
                $kat_pel_uc = $ucieczka_kat;
              } else {
                $kat_pel_uc = $peleton_kat;
              }
              
              
              
              $sqlkat1 = " SELECT z_Kategorie.Cl, z_Kategorie.Hil, z_Kategorie.Fl, z_Kategorie.Spr, z_Kategorie.Cbl, z_Kategorie.TT "
	               . " FROM z_Kategorie "
                       . " WHERE z_Kategorie.id_kat = '$kat_pel_uc' ";
              $zapkat1 = mysql_query($sqlkat1) or die('mysql_query');
	      $kat1 = mysql_fetch_row($zapkat1);  
	      
	      $sqlkat2 = " SELECT z_Kategorie.Cl, z_Kategorie.Hil, z_Kategorie.Fl, z_Kategorie.Spr, z_Kategorie.Cbl, z_Kategorie.TT "
	               . " FROM z_Kategorie "
                       . " WHERE z_Kategorie.id_kat = '$wyniki[2]' ";
              $zapkat2 = mysql_query($sqlkat2) or die('mysql_query');
	      $kat2 = mysql_fetch_row($zapkat2);  
	      
	      
	      
	      $obl = $punkty[0] * $kat1[0] * $kat2[0];
	      
	      //echo $obl.' // ';
	      
	      $Cli = $Cli + $obl;
	      if ($obl == 0) {
                } else {
		  $CliM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[1] * $kat2[1];
	      $Hil = $Hil + $obl;
	      if ($obl == 0) {
                } else {
		  $HilM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[2] * $kat2[2];
	      $Fl = $Fl + $obl;
	      if ($obl == 0) {
                } else {
		  $FlM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[3] * $kat2[3];
	      $Spr = $Spr + $obl;
	      if ($obl == 0) {
                } else {
		  $SprM++;
		}
	      
	      //echo $obl.' // ';  
	
	      $obl = $punkty[0] * $kat1[4] * $kat2[4];
	      $Cbl = $Cbl + $obl;
	      if ($obl == 0) {
                } else {
		  $CblM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[5] * $kat2[5];
	      $TT = $TT + $obl;
	      if ($obl == 0) {
                } else {
		  $TTM++;
		}
		
	      //echo $obl.' <br/> ';	
	                   
            }
            //echo 'teraz ten sezon';
            $sqlmiejsca = " SELECT Wyniki.miejsce, z_EtapyKat.id_kat, z_EtapyKat.id_kat2, z_EtapyKat.id_co, z_EtapyKat.id_pun, z_EtapyKat.pierwszy_z_pel, YEAR(Wyscigi.dataP), Wyniki.id_wys "
	                . " FROM z_EtapyKat INNER JOIN (Wyscigi INNER JOIN Wyniki ON Wyscigi.id_wys = Wyniki.id_wys) ON (z_EtapyKat.id_co = Wyniki.id_co) AND (z_EtapyKat.id_wys = Wyscigi.id_wys) "
		        . " WHERE ((Wyniki.id_kol = '$kolarz[0]') AND (z_EtapyKat.id_kat <> 0)) ";
	    $zapmiejsca = mysql_query($sqlmiejsca) or die('mysql_query');
	    while ($wyniki = mysql_fetch_row($zapmiejsca)) {
	      //echo $wyniki[1].'----------------';
	      //-------------------------//
	      //    sprawdzam czy była   //
	      //         ucieczka        //
	      //-------------------------//
	      	      
              if ($wyniki[1] >=100) {
                $ucieczka_kat = $wyniki[1];
                $peleton_kat = $wyniki[1]+1;
              } else {
                $ucieczka_kat = $wyniki[1];
                $peleton_kat = $wyniki[1];
              }
	          
	      //-------------------------//
	      //  teraz wyciąga punkty z //
	      //       tych wyników      //
	      //-------------------------//
	      
	      if ($wyniki[3] == 0) {
                $id_pun = $wyniki[4];
              } else {
	        $id_pun = $wyniki[4]+100;
	      }
	  
	      $sqlpunkty = " SELECT z_pun.pun "
	                 . " FROM z_pun "
			 . " WHERE z_pun.id_punktacji = '$id_pun' AND z_pun.miejsce = '$wyniki[0]' ";
              $zappunkty = mysql_query($sqlpunkty) or die('mysql_query');
	      $punkty = mysql_fetch_row($zappunkty);
	      
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //ffff-----------------------------------------------------------------------------------------------------------
	      //echo 'zdobły punktów na '.$wyniki[7].' ('.$wyniki[3].') - '.$punkty[0].' za '.$wyniki[0].' miejsce<br/>';
              
              if ($wyniki[0] < $wyniki[5]) {
                $kat_pel_uc = $ucieczka_kat;
              } else {
                $kat_pel_uc = $peleton_kat;
              }
              
              
              
              $sqlkat1 = " SELECT z_Kategorie.Cl, z_Kategorie.Hil, z_Kategorie.Fl, z_Kategorie.Spr, z_Kategorie.Cbl, z_Kategorie.TT "
	               . " FROM z_Kategorie "
                       . " WHERE z_Kategorie.id_kat = '$kat_pel_uc' ";
              $zapkat1 = mysql_query($sqlkat1) or die('mysql_query');
	      $kat1 = mysql_fetch_row($zapkat1);  
	      
	      $sqlkat2 = " SELECT z_Kategorie.Cl, z_Kategorie.Hil, z_Kategorie.Fl, z_Kategorie.Spr, z_Kategorie.Cbl, z_Kategorie.TT "
	               . " FROM z_Kategorie "
                       . " WHERE z_Kategorie.id_kat = '$wyniki[2]' ";
              $zapkat2 = mysql_query($sqlkat2) or die('mysql_query');
	      $kat2 = mysql_fetch_row($zapkat2);  
	      
	      
	      
	      $obl = $punkty[0] * $kat1[0] * $kat2[0];
	      
	      //echo $obl.' // ';
	      
	      $Cli = $Cli + $obl;
	      if ($obl == 0) {
                } else {
		  $CliM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[1] * $kat2[1];
	      $Hil = $Hil + $obl;
	      if ($obl == 0) {
                } else {
		  $HilM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[2] * $kat2[2];
	      $Fl = $Fl + $obl;
	      if ($obl == 0) {
                } else {
		  $FlM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[3] * $kat2[3];
	      $Spr = $Spr + $obl;
	      if ($obl == 0) {
                } else {
		  $SprM++;
		}
	      
	      //echo $obl.' // ';  
	
	      $obl = $punkty[0] * $kat1[4] * $kat2[4];
	      $Cbl = $Cbl + $obl;
	      if ($obl == 0) {
                } else {
		  $CblM++;
		}
	      
	      //echo $obl.' // ';
	      
	      $obl = $punkty[0] * $kat1[5] * $kat2[5];
	      $TT = $TT + $obl;
	      if ($obl == 0) {
                } else {
		  $TTM++;
		}
		
	      //echo $obl.' <br/> ';	
	                   
            }
            
            $czy_pun = $Cli + $Hil + $Fl + $Spr + $Cbl + $TT;
            if ($czy_pun > 0) {
              
              //-------------------------//
              // Jeżeli jakieś punkty są //
              //-------------------------//
	      
	      //echo '<tr><td>'.$kolarz[0].': </td><td>'.$Cli.' ('.$CliM.')  </td><td> '.$Hil.' ('.$HilM.') </td><td> '.$Fl.' ('.$FlM.') </td><td> '.$Spr.' ('.$SprM.') </td><td> '.$Cbl.' ('.$CblM.') </td><td> '.$TT.' ('.$TTM.') </td></tr>';
	      $sqlwstaw = " INSERT INTO z_ranking VALUES ('$kolarz[0]', '$Cli', '$CliM', '$Hil', '$HilM', '$Fl', '$FlM', '$Spr', '$SprM', '$Cbl', '$CblM', '$TT', '$TTM') ";
	      $zapwstaw = mysql_query($sqlwstaw) or die('mysql_query');
	       
	    }
	      
	    
	    
	    
	    
          }
	  
	  
	  //------------------------------------//
	  // Mamy podliczone punkty za 2007 rok //
	  //                                    //
	  // Teraz liczymy średnią il. etapów   //
	  //    w których kolarze punktowali    //
	  //------------------------------------//
	  
	  $sqladv = " SELECT AVG(z_ranking.CliM) AS avg "
	          . " FROM z_ranking "
	          . " WHERE z_ranking.CliM > 0 "
		  . " LIMIT 0, 300 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $CliAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking.HilM) AS avg "
	          . " FROM z_ranking "
	          . " WHERE z_ranking.HilM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $HilAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking.FlM) AS avg "
	          . " FROM z_ranking "
	          . " WHERE z_ranking.FlM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $FlAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking.SprM) AS avg "
	          . " FROM z_ranking "
	          . " WHERE z_ranking.SprM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $SprAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking.CblM) AS avg "
	          . " FROM z_ranking "
	          . " WHERE z_ranking.CblM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $CblAv = mysql_fetch_row($zapavg);
	  
	  $sqladv = " SELECT AVG(z_ranking.TTM) AS avg "
	          . " FROM z_ranking "
	          . " WHERE z_ranking.TTM > 0 ";
          $zapavg = mysql_query($sqladv) or die('mysql_query'); 
	  $TTAv = mysql_fetch_row($zapavg);
	  
	  if ($CliAv[0] == 0) {$CliAv[0] = 1;}
	  if ($HilAv[0] == 0) {$HilAv[0] = 1;}
	  if ($FlAv[0] == 0) {$FlAv[0] = 1;}
	  if ($SprAv[0] == 0) {$SprAv[0] = 1;}
	  if ($CblAv[0] == 0) {$CblAv[0] = 1;}
	  if ($TTAv[0] == 0) {$TTAv[0] = 1;}
	  
	  echo '<tr><td>avg</td><td>'.$CliAv[0].'</td><td>'.$HilAv[0].'</td><td>'.$FlAv[0].'</td><td>'.$SprAv[0].'</td><td>'.$CblAv[0].'</td><td>'.$TTAv[0].'</td></tr>';
	  
	  echo '</table>';
	  
	  echo 'Przeliczam przez średnie <br/><br/>';
	  
	  echo '<table id="menu2">';
	  echo '<tr><td class="wyscig6">id kol</td><td class="wyscig6">Cli</td><td class="wyscig6">Hil</td><td class="wyscig6">Fl</td><td class="wyscig6">Spr</td><td class="wyscig6">Cbl</td><td class="wyscig6">TT</td></tr>';
	  
	  $sqlwyciagaj = " SELECT id_kol, Cli, CliM, Hil, HilM, Fl, FlM, Spr, SprM, Cbl, CblM, TT, TTM "
	               . " FROM z_ranking ";
          $zapwyciagaj = mysql_query($sqlwyciagaj) or die('mysql_query'); 
	  while ($danekol = mysql_fetch_row($zapwyciagaj)) {
	    if ($danekol[2] > ($CliAv[0] * 10)) {
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
              $Spr = $danekol[7] / sqrt($danekol[8]);
            } else {  
              $Spr = $danekol[7] / sqrt($SprAv[0] * 2);
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
            
            $sqlwstaw = " UPDATE z_ranking SET Cli = '$Cli', Hil = '$Hil', Fl = '$Fl', Spr = '$Spr', Cbl = '$Cbl', TT = '$TT' WHERE id_kol = '$danekol[0]' ";
            $zapwstaw = mysql_query($sqlwstaw) or die('mysql_query');
            //echo '<tr><td class="wyscig6">'.$danekol[0].'</td><td class="wyscig6">'.$Cli.'</td><td class="wyscig6">'.$Hil.'</td><td class="wyscig6">'.$Fl.'</td><td class="wyscig6">'.$Spr.'</td><td class="wyscig6">'.$Cbl.'</td><td class="wyscig6">'.$TT.'</td></tr>';
          }
	  echo '</table>';
	  echo '<h3>GÓRALE</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Cli FROM z_ranking ORDER BY Cli DESC ";
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
            $sqlwrzuc = " UPDATE z_ranking SET CliM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  }   
	  
	  
	  
	  echo '<h3>HILOWCY:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Hil FROM z_ranking ORDER BY Hil DESC ";
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
            $sqlwrzuc = " UPDATE z_ranking SET HilM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  echo '<h3>PŁASZCZAKI:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Fl FROM z_ranking ORDER BY Fl DESC ";
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
            $sqlwrzuc = " UPDATE z_ranking SET FlM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  
	  echo '<h3>SPRINTERZY:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Spr FROM z_ranking ORDER BY Spr DESC ";
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
            $sqlwrzuc = " UPDATE z_ranking SET SprM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  echo '<h3>Brukowcy:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, Cbl FROM z_ranking ORDER BY Cbl DESC ";
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
            $sqlwrzuc = " UPDATE z_ranking SET CblM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  echo '<h3>Czasowcy:</h3>';
	  $j = 1;
	  $sqlost = " SELECT id_kol, TT FROM z_ranking ORDER BY TT DESC ";
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
            $sqlwrzuc = " UPDATE z_ranking SET TTM = '$wklej' WHERE id_kol = '$daneost[0]' ";
            $zapwrzuc = mysql_query($sqlwrzuc) or die('mysql_query');
            $j++;
	  } 
	  
	  
	  
        echo koniec();
?>
