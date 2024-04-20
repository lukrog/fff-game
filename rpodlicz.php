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
  
  
      //settype($_GET['id'], 'integer');  
      $id = $_GET['id'];
      
      //$id = 0;
      
      if ($id == "") {
         $id = 0;
      }
      $id2 = $id + 250;
      $sqlaa = " SELECT id_kol FROM Kolarze ORDER BY id_kol DESC LIMIT 0, 1 ";
      $zapaa = mysql_query($sqlaa) or die('mysql_query');
      $kolaa = mysql_fetch_row($zapaa);
      
      //$kolaa[0] = 6000;
      
      
      if ($id2 <= $kolaa[0]) {
         echo '<meta http-equiv="Refresh" content="1; URL=rpodlicz.php?id='.$id2.'">
	 ';
      } else {
        echo '<meta http-equiv="Refresh" content="1; URL=rankingpodliczb.php">
      ';
      }

      
  
  echo '   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - podliczanie rankingu</title>
</head>
<body>
<div>';


  echo google();
    echo poczatek();
     
      
      
    $qq = $kolaa[0]-$id2;
    echo 'Przeliczam od '.$id.' do '.$id2.', więc zostało jeszcze '.$qq.' do końca (z'.$kolaa[0].' wszystkich)<br/><br/>';
    

    
    if ($id2 > $kolaa[0]) {
         echo '$gdzie2 > $kolaa[0] ('.$gdzie2.' > '.$kolaa[0].')';
      } elseif ($id2 == $kolaa[0]) {
        echo 'niestety $gdzie2 = $kolaa[0] ('.$gdzie2.' = '.$kolaa[0].')';
      } elseif ($id2 < $kolaa[0]) {
        echo '$gdzie2 < $kolaa[0] ('.$gdzie2.' < '.$kolaa[0].')';
      } else {
        echo ' jeszcze inaczej';
      }
    echo '<br/><br/>';
    
    //echo $gdzie.'  >>  '.$gdzie2.'<BR/><br/>';
	  //----------------------------------------//
	  // Najpierw czyścimy tabele z poprzednich //
	  //               wyników                  //
	  //----------------------------------------//
	  
	  if ($id == 0) {
             $sql = " TRUNCATE TABLE z_ranking2 ";
	     $zap = mysql_query($sql) or die('mysql_query'); 
	     echo 'kasuję tabelę<br/><br/>';
	  }   
	  
 
	  
	  
	  echo 'Podliczam kolarzy z numerami od '.$id.' do '.$id2.' z '.$kolaa[0].' kolarzy.<br/><br/>';
	  
	  
	  $sql = " SELECT id_kol FROM Kolarze WHERE ((id_kol >= '$id') AND (id_kol < '$id2')) ORDER BY id_kol ";
	  //$sql = " SELECT id_kol FROM Kolarze WHERE ((id_kol >= 0) AND (id_kol < 500)) ORDER BY id_kol ";
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
            
	    $rokwstecz = date("y-m-d");
	    $rokwstecz = strtotime($rokwstecz) - 366 * 24 * 3600;
            $rokwstecz = date('Y-m-d',$rokwstecz);
            
            $dwawstecz = date("y-m-d");
	    $dwawstecz = strtotime($dwawstecz) - 2*366 * 24 * 3600;
            $dwawstecz = date('Y-m-d',$dwawstecz);
            
            $trzywstecz = date("y-m-d");
	    $trzywstecz = strtotime($trzywstecz) - 3*366 * 24 * 3600;
            $trzywstecz = date('Y-m-d',$trzywstecz);
            
	    
	    //-------------------------//
	    // zaczynamy z tym sezonem //
	    //-------------------------//
	    
	    $sqlmiejsca = " SELECT Wyniki.miejsce, z_EtapyKat.id_kat, z_EtapyKat.id_kat2, z_EtapyKat.id_co, z_EtapyKat.id_pun, z_EtapyKat.pierwszy_z_pel, YEAR(Wyscigi.dataP), Wyniki.id_wys "
	                . " FROM z_EtapyKat INNER JOIN (Wyscigi INNER JOIN Wyniki ON Wyscigi.id_wys = Wyniki.id_wys) ON (z_EtapyKat.id_co = Wyniki.id_co) AND (z_EtapyKat.id_wys = Wyscigi.id_wys) "
		        . " WHERE Wyniki.id_kol = '$kolarz[0]' AND z_EtapyKat.id_kat <> 0";
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
	      
	      
	      
	      $obl = $punkty[0] * $kat1[0] * $kat2[0] * 3;
	      $Cli = $Cli + $obl;
	      if ($obl == 0) {
                } else {
		  $CliM++;
		}
	      
	      $obl = $punkty[0] * $kat1[1] * $kat2[1] * 3;
	      $Hil = $Hil + $obl;
	      if ($obl == 0) {
                } else {
		  $HilM++;
		}
	      
	      $obl = $punkty[0] * $kat1[2] * $kat2[2] * 3;
	      $Fl = $Fl + $obl;
	      if ($obl == 0) {
                } else {
		  $FlM++;
		}
	      
	      $obl = $punkty[0] * $kat1[3] * $kat2[3] * 3;
	      $Spr = $Spr + $obl;
	      if ($obl == 0) {
                } else {
		  $SprM++;
		}
	      
	      $obl = $punkty[0] * $kat1[4] * $kat2[4] * 3;
	      $Cbl = $Cbl + $obl;
	      if ($obl == 0) {
                } else {
		  $CblM++;
		}
	      
	      $obl = $punkty[0] * $kat1[5] * $kat2[5] * 3;
	      $TT = $TT + $obl;
	      if ($obl == 0) {
                } else {
		  $TTM++;
		}
            }
            
            //------------------------------//
            // wyniki z poprzedniego sezonu //
            //  ale nie starsze niż rok     //
            //------------------------------//
            
            $sqlmiejsca = " SELECT WynikiP.miejsce, z_EtapyKat.id_kat, z_EtapyKat.id_kat2, z_EtapyKat.id_co, z_EtapyKat.id_pun, z_EtapyKat.pierwszy_z_pel, YEAR(Wyscigi.dataP), WynikiP.id_wys
                            FROM z_EtapyKat INNER JOIN (Wyscigi INNER JOIN WynikiP ON Wyscigi.id_wys = WynikiP.id_wys) ON (z_EtapyKat.id_co = WynikiP.id_co) AND (z_EtapyKat.id_wys = Wyscigi.id_wys) 
                            WHERE ((WynikiP.id_kol = '$kolarz[0]') AND (z_EtapyKat.id_kat <> 0) AND (z_EtapyKat.data >= '$rokwstecz')) ";


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
	      
	      
	      
	      $obl = $punkty[0] * $kat1[0] * $kat2[0] * 3;
	      $Cli = $Cli + $obl;
	      if ($obl == 0) {
                } else {
		  $CliM++;
		}
	      
	      $obl = $punkty[0] * $kat1[1] * $kat2[1] * 3;
	      $Hil = $Hil + $obl;
	      if ($obl == 0) {
                } else {
		  $HilM++;
		}
	      
	      $obl = $punkty[0] * $kat1[2] * $kat2[2] * 3;
	      $Fl = $Fl + $obl;
	      if ($obl == 0) {
                } else {
		  $FlM++;
		}
	      
	      $obl = $punkty[0] * $kat1[3] * $kat2[3] * 3;
	      $Spr = $Spr + $obl;
	      if ($obl == 0) {
                } else {
		  $SprM++;
		}
	      
	      $obl = $punkty[0] * $kat1[4] * $kat2[4] * 3;
	      $Cbl = $Cbl + $obl;
	      if ($obl == 0) {
                } else {
		  $CblM++;
		}
	      
	      $obl = $punkty[0] * $kat1[5] * $kat2[5] * 3;
	      $TT = $TT + $obl;
	      if ($obl == 0) {
                } else {
		  $TTM++;
		}
	   }
            
            //------------------------------//
            //     wyniki sprzed 2 lat      //
            //------------------------------//
            
            $sqlmiejsca = " SELECT WynikiP.miejsce, z_EtapyKat.id_kat, z_EtapyKat.id_kat2, z_EtapyKat.id_co, z_EtapyKat.id_pun, z_EtapyKat.pierwszy_z_pel, YEAR(Wyscigi.dataP), WynikiP.id_wys
                            FROM z_EtapyKat INNER JOIN (Wyscigi INNER JOIN WynikiP ON Wyscigi.id_wys = WynikiP.id_wys) ON (z_EtapyKat.id_co = WynikiP.id_co) AND (z_EtapyKat.id_wys = Wyscigi.id_wys) 
                            WHERE ((WynikiP.id_kol = '$kolarz[0]') AND (z_EtapyKat.id_kat <> 0) AND (z_EtapyKat.data < '$rokwstecz') AND (z_EtapyKat.data >= '$dwawstecz')) ";


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
	      
	      
	      
	      $obl = $punkty[0] * $kat1[0] * $kat2[0] * 2;
	      $Cli = $Cli + $obl;
	      if ($obl == 0) {
                } else {
		  $CliM++;
		}
	      
	      $obl = $punkty[0] * $kat1[1] * $kat2[1] * 2;
	      $Hil = $Hil + $obl;
	      if ($obl == 0) {
                } else {
		  $HilM++;
		}
	      
	      $obl = $punkty[0] * $kat1[2] * $kat2[2] * 2;
	      $Fl = $Fl + $obl;
	      if ($obl == 0) {
                } else {
		  $FlM++;
		}
	      
	      $obl = $punkty[0] * $kat1[3] * $kat2[3] * 2;
	      $Spr = $Spr + $obl;
	      if ($obl == 0) {
                } else {
		  $SprM++;
		}
	      
	      $obl = $punkty[0] * $kat1[4] * $kat2[4] * 2;
	      $Cbl = $Cbl + $obl;
	      if ($obl == 0) {
                } else {
		  $CblM++;
		}
	      
	      $obl = $punkty[0] * $kat1[5] * $kat2[5] * 2;
	      $TT = $TT + $obl;
	      if ($obl == 0) {
                } else {
		  $TTM++;
		}
	   }
	   
	    //------------------------------//
            //      wyniki sprzed 3 lat     //
            //------------------------------//
            
            $sqlmiejsca = " SELECT WynikiP.miejsce, z_EtapyKat.id_kat, z_EtapyKat.id_kat2, z_EtapyKat.id_co, z_EtapyKat.id_pun, z_EtapyKat.pierwszy_z_pel, YEAR(Wyscigi.dataP), WynikiP.id_wys
                            FROM z_EtapyKat INNER JOIN (Wyscigi INNER JOIN WynikiP ON Wyscigi.id_wys = WynikiP.id_wys) ON (z_EtapyKat.id_co = WynikiP.id_co) AND (z_EtapyKat.id_wys = Wyscigi.id_wys) 
                            WHERE ((WynikiP.id_kol = '$kolarz[0]') AND (z_EtapyKat.id_kat <> 0) AND (z_EtapyKat.data < '$dwawstecz') AND (z_EtapyKat.data >= '$trzywstecz')) ";


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
	      $Cli = $Cli + $obl;
	      if ($obl == 0) {
                } else {
		  $CliM++;
		}
	      
	      $obl = $punkty[0] * $kat1[1] * $kat2[1];
	      $Hil = $Hil + $obl;
	      if ($obl == 0) {
                } else {
		  $HilM++;
		}
	      
	      $obl = $punkty[0] * $kat1[2] * $kat2[2];
	      $Fl = $Fl + $obl;
	      if ($obl == 0) {
                } else {
		  $FlM++;
		}
	      
	      $obl = $punkty[0] * $kat1[3] * $kat2[3];
	      $Spr = $Spr + $obl;
	      if ($obl == 0) {
                } else {
		  $SprM++;
		}
	      
	      $obl = $punkty[0] * $kat1[4] * $kat2[4];
	      $Cbl = $Cbl + $obl;
	      if ($obl == 0) {
                } else {
		  $CblM++;
		}
	      
	      $obl = $punkty[0] * $kat1[5] * $kat2[5];
	      $TT = $TT + $obl;
	      if ($obl == 0) {
                } else {
		  $TTM++;
		}
	   }
            
            
            
            
            $czy_pun = $Cli + $Hil + $Fl + $Spr + $Cbl + $TT;
            if ($czy_pun > 0) {  
              //-------------------------//
              // Jeżeli jakieś punkty są //
              //-------------------------//
	      
	      echo ''.$kolarz[0].': '.$Cli.' ('.$CliM.') |'.$Hil.' ('.$HilM.') |'.$Fl.' ('.$FlM.') |'.$Spr.' ('.$SprM.') |'.$Cbl.' ('.$CblM.') |'.$TT.' ('.$TTM.') |<br/>';
	      $sqlwstaw = " INSERT INTO z_ranking2 VALUES ('$kolarz[0]', '$Cli', '$CliM', '$Hil', '$HilM', '$Fl', '$FlM', '$Spr', '$SprM', '$Cbl', '$CblM', '$TT', '$TTM') ";
	      $zapwstaw = mysql_query($sqlwstaw) or die('mysql_query');
              //ECHO $kolarz[0].'<br/>';
	       
	    }
	  
	      
	    
	    
	    
	    
          }
	  
	  
	  
	  
	  //echo '<a href="rpodlicz.php?id='.$id2.'">Ciąg dalszy</a><br/><br/>';
	  
	  //echo '<a href="rankingpodliczb.php">KONIEC PODLICZANIA</a><br/><br/>';
	  
        echo koniec();
?>
