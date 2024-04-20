<?php 
  session_start();

  //ł±czenie się z bazą php
  
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
   <title>FFF - przedłużanie kontraktów</title>
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
	          $id_user = $idek;
	    
	          
	      $data = date("Y-m-d"); 
              //$koniecp = "2017-11-18";
              
              $zapytka_o_date="SELECT datak FROM wydarzenia WHERE typ=4 ORDER BY datak DESC";
              $idzapytka_o_date=mysql_query($zapytka_o_date) or die('mysql_query');
              $wiersz_zapytka_o_date = mysql_fetch_row($idzapytka_o_date);
              echo $wiersz_zapytka_o_date[0]." to data końca przedłużeń najnowszych więc ";
              $koniecp=$wiersz_zapytka_o_date[0];
              
              
              if ($data <= $koniecp) {
                echo "jeszcze można przedłużać kontrakty<br/><br/><Br/>";
                

	
		  
		  $zap = "SELECT User.login, User.ekipa, User.kasa, User.liga, User.ost_log FROM User WHERE (((User.id_user)= '$id_user' ))";
		  $idz = mysql_query($zap) or die('mysql_query');
	  	  $dane = mysql_fetch_row($idz);
	  	  
	  	  
	  	  echo '<center><h1>'.$dane[1].'</h1>'; 
		  echo '</center>';
	  	  
	          
	          
	          

		  echo '<table id="menu2">';
	          echo '<tr><td class="wyscig2"><i>id usera: </i></td><td class="wyscig2">'.$id_user.'</td></tr>';
	          echo '<tr><td><i>login: </i></td><td>'.$dane[0].'</td></tr>';
	          echo '<tr><td><i>nazwa ekipy: </i></td><td>'.$dane[1].'</td></tr>';
	          echo '<tr><td><i>pieniądze: </i></td><td>'.$dane[2].'</td></tr>';
		  echo '<tr><td><i>ostatnie logowanie: </i></td><td>'.$dane[4].'</td></tr>';
		  
		  $zapy = "SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.flaga, Nat.nazwa, wynikidru.punkty, DATE(Wyscigi.dataP), wynikidru.wydat, wynikidru.kasaw FROM Nat INNER JOIN (wynikidru INNER JOIN Wyscigi ON wynikidru.id_wys = Wyscigi.id_wys) ON Nat.id_nat = Wyscigi.id_nat WHERE (((wynikidru.id_user)= '$id_user' )) ORDER BY Wyscigi.dataP";
		  $idza = mysql_query($zapy) or die('mysql_query');
		  $i = 0;
		  $punkty = 0;
		  $wydane = 0;
	  	  while ($dan = mysql_fetch_row($idza)) {
	  	    
	  	    if ($dan[0] > 7999) {
	  	      $jop = $dan[5] - $dan[7];
	              $string[$i] = '<tr><td><img src="img/flagi/'.$dan[3].'" alt="flaga"> <a href="wyscig.php?id_wys='.$dan[0].'">'.$dan[1].'</a></td><td>'.$dan[6].'</td><td style="text-align: right;">'.$dan[5].'C</td><td style="text-align: right;">'.$dan[7].'C</td><td style="text-align: right;">'.$jop.'C</td></tr>';
	            } else {
                      $string[$i] = '<tr><td><img src="img/flagi/'.$dan[3].'" alt="flaga"> '.$dan[1].'</td><td>'.$dan[6].'</td><td style="text-align: right;"></td><td style="text-align: right;"></td><td style="text-align: right;">'.$dan[8].'C</td></tr>';
                    }
		    
		    $i++;
	            $punkty=$punkty+$dan[5];
	            $wydane=$wydane+$dan[7];
		  }
		  
		  if ($dane[3] == 1) {
                    $mnoz = 1;
                   } elseif ($dane[3] == 2) {
                    $mnoz = 0.75;
                   } else {
                    $mnoz = 0.50;
                   }
                   
		  echo '<tr><td><i>mnożnik startowego: </i></td><td>'.$mnoz.'</td></tr>';
		  echo '<tr><td><i>punkty: </i></td><td>'.$punkty.'</td></tr>';
		  echo '<tr><td><i>wydana kasa (startowe): </i></td><td>'.$wydane.'</td></tr>';
	          echo '</table>';

	          
	          echo '<br/><br/>';
	          
	          if ($_POST['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_POST['sort'];
	          }
             
                  $kosztprzed = 0;
	          
	          echo '<form action="przedp.php" method="post">';
	          $ttt = 1;
		  //tu wrzucić tabelę z kolarzami.
		  echo '<table class="wyscig">';
		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig9">kolarz</td><td class="wyscig3">id</td><td class="wyscig3">wiek</td><td class="wyscig10">p.</td><td class="wyscig10">s.</td><td class="wyscig10">c.</td><td class="wyscig5" style="text-align: right;">koszt</td><td class="wyscig5" style="text-align: right;">przed.</td></tr>';
		    
		    
                    //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty "
                    //      . " FROM User INNER JOIN (Nat INNER JOIN ((Ekipy INNER JOIN Kolarze ON Ekipy.id_team = Kolarze.id_team) LEFT JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON User.id_user = Kolarze.id_user "
                    //      . " WHERE Kolarze.id_user= '$id_user' "
                    //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz "
                    //      . " ORDER BY Kolarze.nazw, Kolarze.imie ";
                  
		    $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty
		              FROM User, Nat, Ekipy, Kolarze
			      WHERE Kolarze.id_user= '$id_user' AND User.id_user = Kolarze.id_user AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team
			      ORDER BY Kolarze.nazw, Kolarze.imie ";
		  
		  $zap9 = mysql_query($sql9) or die('mysql_query');
		  while ($dan9 =  mysql_fetch_row($zap9)) {
		    
		    
		    
		    $sqlpoi = " SELECT ktopoj.id_kol, Sum(Wyscigi.startowe) AS SumaOfstartowe "
		            . " FROM ktopoj INNER JOIN Wyscigi ON ktopoj.id_wys = Wyscigi.id_wys "
		            . " GROUP BY ktopoj.id_kol "
		            . " HAVING ktopoj.id_kol = '$dan9[0]' ";
                    $zappoi = mysql_query($sqlpoi) or die('mysql_query');
		    $danpoi =  mysql_fetch_row($zappoi);
		    
		    
		    
		    
		    $rodzaj = "";
		    //$dan9[8] - data urodzenia
		    //$dan9[9] - przedłużenie
		    //$dan9[10]- punkty 2007
		    $tescik = strtotime($dan9[8]);
                    $tescik = date("Y",$tescik);
                    //echo $tescik;
                    $tescik1 = strtotime(date("Y-m-d"));
                    $tescik1 = date("Y",$tescik1);
                    $tescik2 = $tescik1 - $tescik;
                    //echo $tescik2.'  ';
		    if ($tescik2 <= 22) {
		      //mniej niż 23 lata
		      if ($dan9[10] > 100){
		        //zdobył ponad 100pts;
                        $rodzaj = "Rut";
                        $ilerut++;
	              } else {
	                //Zdobył poniżej 100pts;
                        $rodzaj = "U-23";
                        $ileu23++;
	              }      
                      
                    } else {
                      //powyżej 23 lat
                      if ($dan9[9] == 1) {
                        //przdłużał kontrakt;
                        $rodzaj = "Rut";
                        $ilerut++;
	              } else {
                        //Nie przedłużał;
                        if ($dan9[10] > 100){
		          //zdobył ponad 100pts;
                          $rodzaj = "Rut";
                          $ilerut++;
	                } else {
  	                  //Zdobył poniżej 100pts;
                          $rodzaj = "Dor";
                          $iledor++;
	                }      
	              }
                      
	          
	          
                    }
		    
		    //$dzis = strtotime(date("Y-m-d"));
		    //$wiek = strtotime($dan9[5]);
		    //$wiek = $dzis - $wiek;
		    $wiek = $tescik2;//floor($wiek / (3600 * 24 * 365));

		    
                    $ilu_kolarzy++;
	            $wartość_kolarzy = $dan9[7] + $wartość_kolarzy ;
	            $srednia_wieku = $srednia_wieku + $wiek ;
		    
		    
		    echo '<tr><td>'.$ttt.'</td><td><img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /> <a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <i>'.$rodzaj.'</i><br/> '.$dan9[6].' </td><td><i>'.$dan9[0].'</i></td><td>'.$wiek.'</td><td class="wyscig5" style="text-align: right;">';
		    $ttt++;
		    
                    $sqlpioi = "SELECT Sum(Wyniki.punkty) AS SumaOfpunkty FROM Wyscigi INNER JOIN (zgloszenia INNER JOIN Wyniki ON Wyniki.id_kol = zgloszenia.id_kol) ON Wyniki.id_wys = Wyscigi.id_wys AND zgloszenia.id_wys = Wyscigi.id_wys  WHERE zgloszenia.id_kol='$dan9[0]'";
	            $zappioi = mysql_query($sqlpioi) or die(mysql_error());   
                    $danpioi =  mysql_fetch_row($zappioi);
                    
                    $sqlploi = "SELECT Sum(Wyscigi.startowe) AS SumaOfStart FROM ktopoj INNER JOIN (zgloszenia INNER JOIN  Wyscigi ON Wyscigi.id_wys = zgloszenia.id_wys) ON Wyscigi.id_wys = ktopoj.id_wys AND zgloszenia.id_kol = ktopoj.id_kol WHERE zgloszenia.id_kol='$dan9[0]'";
	            $zapploi = mysql_query($sqlploi) or die(mysql_error());   
                    $danploi =  mysql_fetch_row($zapploi);
                    
                    if ($danpioi[0] == "") {
		      $punpoi = 0;
		    } else {
		      $punpoi = $danpioi[0];
		    }
                    
                    if ($dan9[11] == 0 OR $dan9[11] == "") {} else {
                      if ($dan9[11] == $punpoi) 
		      { 
		        echo $dan9[11];
		      } else {
		        echo $dan9[11];
		      }
		    }
	            echo '</td><td class="wyscig5" style="text-align: right;">';
		    
		     
		    $cos1 = $danpoi[1] * $mnoz;
		    $cos2 = $danploi[0] * $mnoz;
		    
		    if ($cos1 == 0) { } else {
                      //echo $cos1;
                      if ($cos1 == $cos2) 
		      { 
		        echo sprintf("%.1f", $cos1);
		      } else {
                        echo sprintf("%.1f", $cos1);
                      }
                    }
                    if ($dan9[7] == 0 ) {
                      $cenka = 1;
                    } else {
                     $cenka = $dan9[7];
                    }
                    
                    //tu wyliczamy kwotę przedłużenia
                    $obn=0;
		    //na początku trzeba sprawdzić czy ostatnią tranzakcją tego kolarza było przedłużenie.
		    //w tranzakcjach sprawdzam jaka była ostatnia z nich:
		    $sql_czy_przed = " SELECT typ FROM transzaak WHERE id_kol= '$dan9[0]' ORDER BY kiedy DESC, id_tpZ DESC";
		    $zap_czy_przed = mysql_query($sql_czy_przed) or die('mysql_query');
		    
		    //echo mysql_num_rows($zap_czy_przed);
		    
		    if (mysql_num_rows($zap_czy_przed) == 0) {
                      //nie ma nowych tranzakcji
                      //sprawdzamy ostatnią ze starych
                      $sql_czy_przed2 = " SELECT typ FROM transzaakST WHERE id_kol= '$dan9[0]' ORDER BY kiedy DESC, id_tpZ DESC limit 0, 1";
		      $zap_czy_przed2 = mysql_query($sql_czy_przed2) or die('mysql_query');
		      $dan_czy_przed2 =  mysql_fetch_row($zap_czy_przed2);
		      //echo $dan_czy_przed2[0];
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
		    }
		    
		    //tu wyliczamy kwotę przedłużenia
                    
                    
                    $wsp2 = ($dan9[7] * (100 - $obn)) / 100;
                    $wsp = round(((($dan9[7] * (100 - $obn)) / 100 )+$dan9[11])/2);
		    
		    
		    echo '</td><td class="wyscig5" style="text-align: right;">'.$dan9[7];
		    
		    //wypisana obniżka
		    if ($obn > 0) {
		      echo '<br/><font size=1 color=green>-'.$obn.'%=</font><font size=2 color=red>'.$wsp2.'</font>';
		    }
		    //wracamy do wyliczeń
		    
		    
		    
		    echo '</td><td class="wyscig5" style="text-align: right;">';
		    if ($wsp < 1) {
                    $wsp = 1;
		      } else {}
		      
		    //sprawdzamy ligę
		    if ($dane[3]==1) {
		      if ($wsp < 25) {
		          $wsp3 = $wsp;
			  $wsp=25;
		          echo "<font color=red>".$wsp."</font> <br/>[".sprintf("%.0f", $wsp3)."]";
			} else {
			  echo sprintf("%.0f", $wsp);
			}
		    } elseif ($dane[3]==2) {
		      if ($wsp < 10) {
		        $wsp3 = $wsp;
			$wsp=10;
		        echo "<font color=red>".$wsp."</font> <br/>[".sprintf("%.0f", $wsp3)."]";
                      } else {
			  echo sprintf("%.0f", $wsp);
			}
		    } else {
		      echo sprintf("%.0f", $wsp);
		    }  
		      
		      
		    
		    
                    $sqlprz = " SELECT * "
		            . " FROM przed "
		            . " WHERE id_kol = '$dan9[0]' ";
                    $zapprz = mysql_query($sqlprz) or die('mysql_query');
                    


		    echo '</td><td>'.mysql_num_rows($zapprz).'<input type="checkbox" name="przed'.$ttt.'" value="'.$dan9[0].'"';
                    if (mysql_num_rows($zapprz) > 0) { 
                      echo ' checked="checked" ';
		      $kosztprzed = $kosztprzed + sprintf("%.0f", $wsp);
                    }

                    echo '">';


                  



		    echo '</td></tr>';
                  }
                  
                     


		  echo '</table>';
		  echo '<b>koszt przedłużeń:</b> '.$kosztprzed.'<br/>';
                  echo '<b>pieniądze teraz:</b> '.$dane[2].'<br/>';
                  $pieniadzepo = $dane[2] - $kosztprzed;
                  echo '<b>pieniądze po przedłużeniu:</b> '.$pieniadzepo.'<br/><br/>';
		  
                  echo '<input type=hidden name="ile" value="'.$ttt.'" >';
		  echo '<input type="submit" value=" zatwierdź przedłużenia ">';
		  echo '</form>';

		  echo 'p. - punkty<br/>s. - startowe zapłacone<br/>c. - cena zakupu';
		  
		  //tu koniec
		  
		  
		  
		}
              else 
              { 
                echo "czas na przedłużanie kontraktów minął.";
              }   
		  
	          
	         
 
	} else {
   	  echo '<h3>Ta strona dostępna tylko po zalogowaniu</h3>';
   
        }


	  
	  
	  
	  
	  
	  echo koniec();

        ?>
         
    


    
