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
  
  
      
  
  echo '   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - podliczanie rankingu</title>
</head>
<body>
<div>';


  echo google();
    echo poczatek();
     //settype($_GET['gdzie'], 'integer');  
      $gdzie = $_GET['gdzie'];
      
      if ($gdzie == "") {
         $gdzie = 0;
      }
      $gdzie2 = $gdzie + 100;
      $sqlaa = " SELECT id_kol FROM Kolarze ORDER BY id_kol DESC LIMIT 0, 1 ";
      $zapaa = mysql_query($sqlaa) or die('mysql_query');
      $kolaa = mysql_fetch_row($zapaa);
      
      //$kolaa[0] = 6000;
      
      
      if ($gdzie2 <= $kolaa[0]) {
         //echo '<meta http-equiv="Refresh" content="5; URL=rankingpodlicza.php?gdzie='.$gdzie2.'">
	 //';
      } else {
         //echo '<meta http-equiv="Refresh" content="5; URL=rankingpodliczb.php">
       //';
      }
      
      
    $qq = $kolaa[0]-$gdzie2;
    echo $gdzie.'  -> '.$gdzie2.'  i jeszcze '.$qq.'  =  '.$kolaa[0].'(wszystkich)<br/><br/>';
    

    
    if ($gdzie2 > $kolaa[0]) {
         echo '$gdzie2 > $kolaa[0]';
      } elseif ($gdzie2 == $kolaa[0]) {
        echo 'niestety $gdzie2 = $kolaa[0]';
      } elseif ($gdzie2 < $kolaa[0]) {
        echo '$gdzie2 < $kolaa[0]';
      } else {
        echo ' jeszcze inaczej';
      }
    echo '<br/><br/>';
    
    //echo $gdzie.'  >>  '.$gdzie2.'<BR/><br/>';
	  //----------------------------------------//
	  // Najpierw czyścimy tabele z poprzednich //
	  //               wyników                  //
	  //----------------------------------------//
	  
	  if ($gdzie == 0) {
             $sql = " TRUNCATE TABLE z_ranking2 ";
	     $zap = mysql_query($sql) or die('mysql_query'); 
	     echo 'kasuję tabelę<br/><br/>';
	  }   
	  
 
	  
	  
	  //echo '<table id="menu2">';
	  //echo '<tr><td class="wyscig6">id kol</td><td class="wyscig6">Cli</td><td class="wyscig6">Hil</td><td class="wyscig6">Fl</td><td class="wyscig6">Spr</td><td class="wyscig6">Cbl</td><td class="wyscig6">TT</td></tr>';
	  echo 'Podliczam kolarzy z numerami od '.$gdzie.' do '.$gdzie2.' z '.$kolaa[0].' kolarzy.<br/><br/>';
	  
	  
	  $sql = " SELECT id_kol FROM Kolarze WHERE ((id_kol >= '$gdzie') AND (id_kol < '$gdzie2')) ORDER BY id_kol ";
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
	      $sqlwstaw = " INSERT INTO z_ranking2 VALUES ('$kolarz[0]', '$Cli', '$CliM', '$Hil', '$HilM', '$Fl', '$FlM', '$Spr', '$SprM', '$Cbl', '$CblM', '$TT', '$TTM') ";
	      $zapwstaw = mysql_query($sqlwstaw) or die('mysql_query');
	       
	    }
	      
	    
	    
	    
	    
          }
	  
	  
	  
	  
	  echo '<a href="rankingpodlicz.php?gdzie='.$gdzie2.'">Ciąg dalszy</a><br/><br/>';
	  
	  echo '<a href="rankingpodliczb.php">KONIEC PODLICZANIA</a><br/><br/>';
	  
        echo koniec();
?>
