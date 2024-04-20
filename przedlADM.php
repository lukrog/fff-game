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
   <title>FFF - dane drużyn fff</title>
</head>
<body>
<div>

<?php

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
  
								// tu =0 dla kolarzy bez ekipy a potem >0 dla tych co mają ekipy.
	  $zap0 = "SELECT login, id_user, kasa, liga FROM User WHERE id_user=0 ORDER BY id_user ";

          $idzap0 = mysql_query($zap0) or die('mysql_query');
          while ($dan0 = mysql_fetch_row($idzap0)) 
           {
            $wydanenaprzed = 0;

            echo "<br/><br/><br/>[size=18]Kolarze z ekipy usera - ".$dan0[0]."[/size]<br/>";

            $zap1 = "SELECT id_kol, imie, nazw, cena FROM Kolarze WHERE id_user = '$dan0[1]' ORDER BY id_kol ";

	    
  	//  $zap1 "SELECT id_kol, imie, nazw, cena FROM Kolarze WHERE id_user = '$dan0[1]' AND id_kol>0 ORDER BY id_kol";
		


            $idzap1 = mysql_query($zap1) or die('mysql_query');
            while ($dan1 = mysql_fetch_row($idzap1)) 
                  {
                    echo "<br/>Kolarz nr:".$dan1[0]." - <i>[i]".$dan1[1]." <b>[b]".$dan1[2]."[/b]</b>[/i]</i>";
                    $zap2 = "SELECT SUM(punkty) FROM `Wyniki` WHERE id_kol = '$dan1[0]'";
                    $idzap2 = mysql_query($zap2) or die('mysql_query');
                    $dan2 = mysql_fetch_row($idzap2);

                    if ($dan2[0] == "") {$dan2[0]=0;}

                    echo " zdobył: <b>[b]".$dan2[0]."[/b]</b> ptk.";
                         
                    
  
                    $zap3 = "SELECT * FROM przed WHERE id_kol = '$dan1[0]'";
                    $idzap3 = mysql_query($zap3) or die('mysql_query');
                    $dan3 = mysql_num_rows($idzap3); 

                    if ($dan3 > 0)
                    {
                      
                      //tu wyliczamy kwotę przedłużenia
                      $obn=0;
		      //na początku trzeba sprawdzić czy ostatnią tranzakcją tego kolarza było przedłużenie.
		      //w tranzakcjach sprawdzam jaka była ostatnia z nich:
		      $sql_czy_przed = " SELECT typ FROM transzaak WHERE id_kol= '$dan1[0]' ORDER BY kiedy DESC, id_tpZ DESC";
		      $zap_czy_przed = mysql_query($sql_czy_przed) or die('mysql_query');
		      
		      if (mysql_num_rows($zap_czy_przed) == 0) {
                        //nie ma nowych tranzakcji
                        //sprawdzamy ostatnią ze starych
                        $sql_czy_przed2 = " SELECT typ FROM transzaakST WHERE id_kol= '$dan1[0]' ORDER BY kiedy DESC, id_tpZ DESC limit 0, 1";
		        $zap_czy_przed2 = mysql_query($sql_czy_przed2) or die('mysql_query');
		        $dan_czy_przed2 =  mysql_fetch_row($zap_czy_przed2);
		        //echo 'typ ostatniej trST - '.$dan_czy_przed2[0];
		        if ($dan_czy_przed2[0] == 4) {
		          //jeśli ostatnie było przedłużenie
		          $obn=30;
		        } else {
		          //jeśli coś innego
		          $obn=0;
		        }
                      } else {
      		        $dan_czy_przed =  mysql_fetch_row($zap_czy_przed);
		        if ($dan_czy_przed[0] == 4) {
		          //jeśli ostatnie było przedłużenie
		          $obn=30;
		        } else {
		          //jeśli coś innego
		          $obn=0;
		        }
		        //echo 'typ ostatniej tr - '.$dan_czy_przed[0];
		      }
		      //tu wyliczamy kwotę przedłużenia
                       $kwota_kontraktu_po_obnizce = ($dan1[3] * (100 - $obn)) / 100; 
                       $nowe = round(($dan2[0] + $kwota_kontraktu_po_obnizce) / 2);
                       if ($nowe == 0) {
		         $nowe = 1;
   		       }
   		       
   		       //TU PATRZYMY NA LIGE I MINIMALNE KWOTY PRZEDŁUŻENIA
   		       if ($dan0[3]==1) {
			    $minim = 25;
			  } elseif ($dan0[3]==2) {
			    $minim = 10;
			  } else {
			    $minim = 0;
			  }
   		       $tekst_minim ="";
   		       if ($nowe < $minim) {
			    $nowe = $minim;
			    $tekst_minim = "{minimalnie za ".$minim."}";
			  }
   		       
   		       
   		       
                       echo " ".$dan0[0]." <b>przedłuża</b> za ".$nowe." [obn: ".$obn."% ] ".$tekst_minim;
                       $przedl = 1;
                       $user = $dan0[1];
                       $wydanenaprzed = $wydanenaprzed + $nowe;
                    } else {
                       $nowe = $dan2[0];
                       echo " nie przedłużony (cena: ".$nowe.")";
                       $przedl = 0;
                       $user = 0;
                    }
                    
                    //echo "<br/>".$dan1[0]." - U:".$user." ".$dan2[0]."p ".$przedl." ".$nowe."C ";
                    
                    $zapu1 = "UPDATE Kolarze SET id_user='".$user."', przed='".$przedl."', pts_poprz='".$dan2[0]."', cena='".$nowe."'  WHERE id_kol='".$dan1[0]."' ";

                    //echo "<br/>".$zapu1;
                    $idzapu1 = mysql_query($zapu1) or die('mysql_query');

                    $dzis = date("Y-m-d");
                    $obnizki = date("Y-m-d, H:i", mktime (0,0,0,11,1,date("Y")));
                
                    $zapu4 = " SELECT id_tpZ FROM transzaak ORDER BY id_tpZ DESC LIMIT 0, 1 ";
                    $idzapu4 = mysql_query($zapu4) or die('mysql_query');
                    $danu4 = mysql_fetch_row($idzapu4);
                    $poczat = $danu4[0] + 1;
                    If ($przedl == 1) {
                      $typ = 4;
                    } else {
                      if ($dan0[1] == 0 AND $user == 0) {
                        $typ = 6;
		      } else {
		        $typ = 1;
		      }
                      
                    }
                
                
                //do historii transferów dodaję obniżkę ceny jeżli ta obniżka była oraz przedłużano kontrakt
                if (($obn > 0) AND ($typ == 4)) {
                  //jeśli była obniżka
                   $zapu5 = " INSERT INTO transzaak (id_tpZ, kiedy, id_kol, id_userK, id_userS, ile, poprzednia_cena, typ) 
		              VALUES ('".$poczat."', '".$obnizki."', '".$dan1[0]."', '".$dan0[1]."', '".$dan0[1]."', '".$kwota_kontraktu_po_obnizce."', '".$dan1[3]."', '5') ";
                   //echo "<br/>".$zapu5;
                   $idzapu5 = mysql_query($zapu5) or die('mysql_query');
                   $poczat = $poczat +1;
                               
                   $zapu5 = " INSERT INTO transzaak (id_tpZ, kiedy, id_kol, id_userK, id_userS, ile, poprzednia_cena, typ) 
		              VALUES ('".$poczat."', '".$dzis."', '".$dan1[0]."', '".$user."', '".$dan0[1]."', '".$nowe."', '".$kwota_kontraktu_po_obnizce."', '".$typ."') ";
                   //echo "<br/>".$zapu5;
                   $idzapu5 = mysql_query($zapu5) or die('mysql_query');
                } else {
                   //jeśli obniżki nie było
                   $zapu5 = " INSERT INTO transzaak (id_tpZ, kiedy, id_kol, id_userK, id_userS, ile, poprzednia_cena, typ) VALUES ('".$poczat."', '".$dzis."', '".$dan1[0]."', '".$user."', '".$dan0[1]."', '".$nowe."', '".$dan1[3]."', '".$typ."') ";
                   //echo "<br/>".$zapu5;
                   $idzapu5 = mysql_query($zapu5) or die('mysql_query');
                }

                }        

                echo "<br/><br/>Pieniądze posiadane:".$dan0[2]."<br/> WYDANE NA PRZEDŁUŻENIA: ".$wydanenaprzed;
                $nowakasa = $dan0[2] - $wydanenaprzed;
                echo "<br/><b>ŁĄCZNIE PO PRZEDŁUŻENIACH: ".$nowakasa."</b>";

                $zapu2 = "UPDATE User SET kasa='".$nowakasa."'  WHERE id_user='".$dan0[1]."' ";

                //echo "<br/>".$zapu2;
                $idzapu2 = mysql_query($zapu2) or die('mysql_query');
   
                $zapu4 = " SELECT id_wdr FROM wynikidru WHERE id_wdr<9000 ORDER BY id_wdr DESC ";
                $idzapu4 = mysql_query($zapu4) or die('mysql_query');
                $danu4 = mysql_fetch_row($idzapu4);
                $id_wdr = $danu4[0] + 1;
                $kasaw = $wydanenaprzed * (-1);

                $zapu3 = " INSERT INTO wynikidru (id_wdr, id_user, id_wys, punkty, wydat, pri, kasaw) VALUES ('".$id_wdr."', '".$dan0[1]."', '7', '0', '0', '0', '".$kasaw."') ";
                //echo "<br/>".$zapu3;
                $idzapu3 = mysql_query($zapu3) or die('mysql_query');
                
                
                
                
                
                }
                    
                

	         
 
	


	  
	  
	  
	  
	  
	  echo koniec();
        ?>
         
    


    
