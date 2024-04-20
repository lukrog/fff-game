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
   <title>FFF - obliczanie wyścigu</title>
</head>
<body>
<div>

<?php
  echo google();

  $zapyt = "SELECT id_user, login, haslo, ekipa, boss FROM User WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapyt = mysql_query($zapyt) or die('mysql_query_pyt');
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
  $idzapytania = mysql_query($zapytanie) or die('mysql_query_zapytania');
  while ($wiersz = mysql_fetch_row($idzapytania)) 
   {
      $logi=$wiersz[1];
      $idek=$wiersz[0];
      $ekipa = $wiersz[3];
      $_SESSION['boss']=$wiersz[4];
   }
  } else {}
    echo poczatek();
    
    
    
         if ($_SESSION['boss'] > 1) {
            $mnoznikprio = 1;
            $id_wys =  $_POST['idwys'];
            echo '<h4>Nie odświeżaj tej strony. Jak na dole pojawi się: SKOŃCZONE to przejdź na jakąkolwiek inną stronę</h4>'; 
            
                      //      1  2  3  4  5  6  7  8  9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31 32 33 34 35 36 37 38 39 40 41 42 43 44 45 46 47 48 49 50 51 52 53 54 55 56 57 58 59 60 61 62 63 64 65 66 67 68 69 70 71 72 73 74 75 76 77 78 79 80 81 82 83 84 85 86 87 88 89 90 91 92 93 94 95 96 97 98 99100101102103104105106107108109110111112113114115116117118119120
            $punktyD = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            
            $sql10 = " SELECT id_wdr FROM wynikidru ORDER BY id_wdr DESC LIMIT 0, 1 ";
            $zap10 = mysql_query($sql10) or die('mysql_query10');
            $wyn10 = mysql_fetch_row($zap10);
            $kolejne_id = $wyn10[0]+1;
            echo 'w bazie wyników drużyn jest: '.$kolejne_id.'<br/><br/>';
            echo 'Sprawdzam czy w bazie są podliczone wyniki drużyn z tego wyścigu: <br/>';
            
            
            $sql11 = " SELECT id_user, ekipa FROM User WHERE liga <= 3 ORDER BY id_user  ";
            $zap11 = mysql_query($sql11) or die('mysql_query11');
	    while ($wyn11 = mysql_fetch_row($zap11)) {
	      
	      
              echo ' Sprawdzam: ('.$wyn11[0].') '.$wyn11[1].' - ';
              
              
              $sql12 = " SELECT id_user, id_wdr FROM wynikidru  "
	             . " WHERE ((id_user='$wyn11[0]') AND (id_wys = '$id_wys'))  ";
              $zap12 = mysql_query($sql12) or die('mysql_query12');
              if (mysql_num_rows($zap12) == 0) {
                $tworz = "TAK";
                
                
                echo ' <font color=darkred>brak</font> <br/>';
                
                
                  $sql13 = " INSERT INTO wynikidru "
                         . " VALUES ('$kolejne_id', '$wyn11[0]', '$id_wys', 0, 0, 0, 0) ";
                         
                  echo $sql13.'//<br/>';   
                  $zap13 = mysql_query($sql13) or die('mysql_query13');
                  
                  $kolejne_id++;
              } else {
                $tworz = "NIE";
                echo ' <font color=green>OK</font> <br/>';
              }
            }
            echo '<br/><br/>';
            $sql01 = " SELECT Wyscigi.ilu_kol, nazwa "
	           . " FROM Wyscigi "
                   . " WHERE id_wys='$id_wys' ";
                   
            echo $sql101.' ‹ wybieramy kolarzy <br/>'; 
            $zap01 = mysql_query($sql01) or die('mysql_query101');
            $wyn01 = mysql_fetch_row($zap01);
            
            
            
            echo '[size=20]'.$wyn01[1].'[/size]<br/><br/>
	    
	    W wyścigu mogło wystartować tylko '.$wyn01[0].' kolarzy zgłoszonych';
            $ilustartuje = $wyn01[0];
            echo '<br/>[quote]';
            $sql1 = " SELECT ktopoj.id_kol, Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, User.login, User.ekipa, User.id_user "
                  . " FROM User INNER JOIN (ktopoj INNER JOIN Kolarze ON ktopoj.id_kol = Kolarze.id_kol) ON User.id_user = Kolarze.id_user "
                  . " WHERE ( ( ( ktopoj.id_wys ) = '$id_wys' ) AND ( User.liga <= 3 ) ) "
		  . " ORDER BY Kolarze.id_user, Kolarze.nazw ";
	    $zap1 = mysql_query($sql1) or die('mysql_query1a');
	    $userzmina=0;
	    while ($wyn1 = mysql_fetch_row($zap1)) 
            {
	     if ($ekipaP == $wyn1[4]) {
               $userzmina=1;
             } else {
               $userzmina=0;
             }
	     
	     
	     if ($userzmina == 0) {
               echo '<h3><font style="color: green;">[color=red][size=16][b]wyniki ekipy '.$wyn1[5].' ([i]'.$wyn1[4].'[/i])[/b] ('.$wyn1[6].')[/size][/color]</font></h3>';
               $ekipaP = $wyn1[4];
             }
             
             
             echo 'id: '.$wyn1[0].' -> <b>[b]'.$wyn1[1].' '.$wyn1[2].'[/b]</b> -> ';
             
	     
	     //kto zgłosił kolarza;
	     $sqlpoi = " SELECT zgloszenia.id_user, User.login FROM zgloszenia INNER JOIN User ON zgloszenia.id_user = User.id_user WHERE zgloszenia.id_kol = '$wyn1[0]' AND zgloszenia.id_wys = '$id_wys' ";
	     $zappoi = mysql_query($sqlpoi) or die('mysql_query');     
	     $wynpoi = mysql_fetch_row($zappoi);
		  
		   
                   
             // - tu sprawdzamy czy kolarz był zgłoszony i czy załapał się jako rezerwowy.
	           
             $sql2 = " SELECT zgloszenia.id_kol , zgloszenia.id_wys , zgloszenia.id_user , Kolarze.imie , Kolarze.nazw , zgloszenia.kolej , Wyscigi.startowe , User.liga , zgloszenia.pri "
		   . " FROM ktopoj INNER JOIN (User INNER JOIN ( ( zgloszenia INNER JOIN Kolarze ON zgloszenia.id_kol = Kolarze.id_kol ) INNER JOIN Wyscigi ON zgloszenia.id_wys = Wyscigi.id_wys ) ON User.id_user = Kolarze.id_user ) ON ktopoj.id_kol = zgloszenia.id_kol "
		   . " WHERE zgloszenia.id_wys = '$id_wys' AND ktopoj.id_wys = '$id_wys' AND zgloszenia.id_user = '$wynpoi[0]'"
		   . " ORDER BY zgloszenia.kolej "
		   . " LIMIT 0,$ilustartuje ";
             $zap2 = mysql_query($sql2) or die('mysql_query');
             $test1 = "NIE";
             
             
             
             
	     while ($wyn2 = mysql_fetch_row($zap2)) 
             { 
                        
               
               
               
               
               if ($wyn2[0] == $wyn1[0]) 
	       {
	         
	               
	         
	         
                 // - gdy kolarz został zgłoszony --------------------------------
                 $test1 = "OK";
                 //echo 'kolarz zgłoszony $test1 = '.$test1.'<br/>'; 

                 
                 
                 // - wyciągamy punkty kolarzy ---------------------
                 $sql3 = " SELECT Wyniki.miejsce , Wyniki.punkty , Wyniki.id_kol , Wyniki.id_wys , User.id_user , User.ekipa , Co.nazwa , Wyscigi.startowe, Wyscigi.pri "
                       . " FROM Wyscigi INNER JOIN ( ( User INNER JOIN Kolarze ON User.id_user = Kolarze.id_user ) INNER JOIN ( Co INNER JOIN Wyniki ON Co.id_co = Wyniki.id_co ) ON Kolarze.id_kol = Wyniki.id_kol ) ON Wyscigi.id_wys = Wyniki.id_wys  "
		       . " WHERE ( ( Wyniki.id_kol = '$wyn1[0]' ) AND ( Wyniki.id_wys = '$id_wys' ) ) ";
                       
                 $zap3 = mysql_query($sql3) or die('mysql_query3');
                 $kol = 0;
                 
                 $czy_zdobyl_punkty = "NIE";
	         while ($wyn3 = mysql_fetch_row($zap3)) {

	         
		 
		 // - zaznaczamy czy był priorytet----------------------------------
		 if ($kol == 0) {
                   if ($wyn2[8] == 1) {
	             $prio_user[$wyn2[2]] = $wyn3[8];
	             $prio_userZ[$wyn2[2]] = 1;
	             echo '<font color=blue> PRIORYTET </font>';
	             
                   } else {
	             $prio_user[$wyn2[2]] = 1;
	             $prio_userZ[$wyn2[2]] = 0;
	             echo ' brak priorytetu ';
	             
	           }
	         }
		 
		 
		 
		 
		   if ($wyn2[7] == 1) {
                    $mnoz = 1.50;
                   } elseif ($wyn2[7] == 2) {
                    $mnoz = 1.00;
                   } else {
                    $mnoz = 0.50;
                   }
		   if ($kol == 0) {
		     echo ' -> mnożnik opłat: '.$mnoz.' <br/>' ;
                   }
                   
	           $startowe = $mnoz * $wyn3[7];
	           $punzdob = $wyn3[1] * $prio_user[$wyn2[2]];
	           
	           if ($kol == 0) {
		     //echo '<font style="color: green;">[color=green]'.$wyn3[5].'[/color]</font>';
		     $kol++;
		   }
		   if ($punzdob > 0) {
		     echo 'Miejsce: '.$wyn3[0].' ('.$wyn3[6].') -> Pts: '.$punzdob.'=('.$wyn3[1].'*'.$prio_user[$wyn2[2]].')'.' start: -'.$startowe.'=('.$wyn3[7].'*'.$mnoz.') (bez prio zdobyte pieniądze: '.$punkty_zdobyte_bez_prio.')<br/>';
	             $czy_zdobyl_punkty = "TAK";
	             //echo $czy_zdobyl_punkty.' 8 ';
	           } 
		   if ($punzdob == 0) {
		     //echo 'Miejsce: '.$wyn3[0].' ('.$wyn3[6].') -> Pts: '.$punzdob.'=('.$wyn3[1].'*'.$prio_user[$wyn2[2]].')'.' start: -'.$startowe.'=('.$wyn3[7].'*'.$mnoz.') (bez prio zdobyte pieniądze: '.$punkty_zdobyte_bez_prio.')<br/>';
                     //echo $czy_zdobyl_punkty.' 7 ';
                   }
		   
		   $punktyD[$wyn2[2]] = $punktyD[$wyn2[2]] + $startowe;
	           $punktyZ[$wyn2[2]] = $punktyZ[$wyn2[2]] + $punzdob;
	           $punktyZBP[$wyn2[2]] = $punktyZBP[$wyn2[2]] + $wyn3[1];
	           if ($wynpoi[0] <> $wyn1[6]) {
                    echo '<font style="color: blue;">[color=blue]Kolarza zgłosił '.$wynpoi[1].' [/color]</font>więc to on ponosi koszty startu i to on zdobywa jego punkty <br/>';
                   }
	         }
	         
	         
	         $zap3 = mysql_query($sql3) or die('mysql_query3a');
	         
	         

	         if (mysql_num_rows($zap3) == 0) {
	          
	            if ($wyn2[7] == 1) {
                       $mnoz = 1.25;
                     } elseif ($wyn2[7] == 2) {
                       $mnoz = 0.75;
                     } else {
                       $mnoz = 0.25;
                     }
		   $sql20 = " SELECT startowe   "
		          . " FROM Wyscigi "
		          . " WHERE ( id_wys = '$id_wys') ";
		   $zap20 = mysql_query($sql20) or die('mysql_query20');
                   while ($wyn20 = mysql_fetch_row($zap20)) {
                     $startowe = $mnoz * $wyn20[0];
                     echo ' startowe = '.$startowe.'=('.$mnoz.'*'.$wyn20[0].')';
		     $punktyD[$wyn2[2]] = $punktyD[$wyn2[2]] + $startowe;
	             
		   }

		   
		   echo '<br/>punktów: 0,  ale został zgłoszony i płaci startowe. ('.$startowe.')<br>';
	           if ($wynpoi[0] <> $wyn1[6]) {
                    echo '<font style="color: blue;">[color=blue]Kolarza zgłosił '.$wynpoi[1].' [/color]</font>więc to on ponosi koszty startu <br/>';
                   }
                 
                 
	         } else {
	           $aaaa1 = mysql_num_rows($zap3) - 1;
	           $aaaa2 = $startowe * $aaaa1;
	           $punktyD[$wyn2[2]] = $punktyD[$wyn2[2]] - $aaaa2;
	           if ($czy_zdobyl_punkty == "NIE") { 
		     echo 'punktów: 0,  ale został zgłoszony i płaci startowe.<br>';
		   if ($wynpoi[0] <> $wyn1[6]) {
                    echo '<font style="color: blue;">[color=blue]Kolarza zgłosił '.$wynpoi[1].' [/color]</font>więc to on ponosi koszty startu <br/>';
                   }
	           } else {
                     //echo 'Startowe kolarza było liczone '.mysql_num_rows($zap3).' razy więc zostaje zmniejszone o '.$aaaa1.' * '.$startowe.' = '.$aaaa2.'<br/>';
                  } 
                 }
                 
                 
                 
                
	         
	         
                 
     
                 
                 
                 
                 
               } else { 
	       }
             }
             if ($test1 == "NIE") {
               $sql02 = " SELECT id_zgl FROM zgloszenia WHERE id_kol = '$wyn1[0]' AND id_wys = '$id_wys' ";
               $zap02 = mysql_query($sql02) or die('mysql_query');
               if (mysql_num_rows($zap02) == 0) {
                 echo '<font color=red>Kolarz niezgłoszony</font>';
               } else {
                 echo '<font color=red>Kolarz rezerwowy (nie załapał się)</font>';
	       }
             }
             echo '<br/>';  
           }
           
           
           
           
           
           
           
           
        echo '[/quote]<br/>';
        echo '[color=red][size=18][b]PODSUMOWANIE EKIP[/b][/size][/color]<br/>'; 
	echo '[quote][size=10]]';
        for ($i=1; $i <= 150; $i++) {
        
           if ($punktyD[$i] > 0 OR $punktyZ[$i] > 0) {
               $startowe_zaokr[$i] = round ($punktyD[$i]);
               if ($startowe_zaokr[$i] == 0) { 
                 
                 $rokteraz = date("Y");
                 $poczatek = 1000 * ($rokteraz - 2000) + 800;
	         
                 
                 
                 if ($id_wys >= $poczatek) 
                 {
                   $startowe_zaokr[$i] = 0;
                 } else {
	           $startowe_zaokr[$i] = 1;
	         }
	       }
               if ($id_wys >= $poczatek) {$startowe_zaokr[$i] == 0;}
               echo 'id ekipy: › '.$i.' startowe: '.$startowe_zaokr[$i].' (dok='.$punktyD[$i].') zdobyte punkty:'.$punktyZ[$i].' ['.$punktyZBP[$i].' bez prio.]<br/>';
             }
        }
        $k=21*0.75;
        $l=round($k);
        //echo ' <br/><br/><br/>';
        
        $sqlas = " SELECT pri FROM Wyscigi WHERE id_wys = '$id_wys' ";
        //echo $sqlas.' // </br>';
        
        
        $zapas = mysql_query($sqlas) or die('mysql_query_as');
        $wynas = mysql_fetch_row($zapas);
        
        $mnoznikprio = $wynas[0];
        
        echo '[/size][/quote]</br>';
	echo '[color=red][size=18][b]WPROWADZANIE DANYCH EKIP[/b][/size][/color]<br/>'; 
	echo '[quote]';
	 $sql12 = " SELECT id_user, ekipa FROM User WHERE liga <= 3 ORDER BY id_user";
	 
	 //echo $sql12.'//<br/>';
	 
	 
         $zap12 = mysql_query($sql12) or die('mysql_query_12aa');
         while ($wyn12 = mysql_fetch_row($zap12)) {
           $a1 = round($punktyZ[$wyn12[0]]);
           $a2 = $startowe_zaokr[$wyn12[0]];
           $a3 = $prio_userZ[$wyn12[0]];
           if ($punktyZBP[$wyn12[0]] == "") {
             $a4 = 0;
           } else {
             $a4 = $punktyZBP[$wyn12[0]];
           }
           if ($a1>0) {$a1=$a1;} else {$a1=0;}
           if ($a2>0) {$a2=$a2;} else {$a2=0;}
           if ($a3>0) {$a3=$a3;} else {$a3=0;}
           if ($a4>0) {$a4=$a4;} else {$a4=0;}
           
           $sql20 = " SELECT punkty, wydat, pri, kasaw, id_wys "
                  . " FROM wynikidru "
		  . " WHERE id_user = '$wyn12[0]' AND id_wys = '$id_wys'";  
	   //echo $sql20.'//</br>';	     
	   $zap20 = mysql_query($sql20) or die('mysql_query_20');
	   while ($wyn20 = mysql_fetch_row($zap20)) {
             $b1 = $wyn20[0];
             $b2 = $wyn20[1];
             $b3 = $wyn20[2];
             $zdobytakasapoprzednio = $wyn20[3];
             if (($b1 == 0 AND $b2 == 0) AND ($a1 == 0 AND $a2 ==0) ) {
             $wyswietl = "NIE";
             } else {
              $wyswietl = "OK";
             }
           }
           //echo '<br/>Tu dotarliśmy<br/>'.$wyn12[0].' :D '.$wyswietl.'</br>';
           
           
             
           if ($wyn12[0] > 0) {
             
             
             $osas = $a4 - $a2;
             
	     
	     if ($wyswietl == "OK") {
             echo '<br/><br/>('.$wyn12[0].') <b>[b]'.$wyn12[1].'[/b]</b> <br/>punktów--> było: '.$b1.'   jest:'.$a1;
             echo '<br/>startowe----> było: '.$b2.'C   jest:'.$a2.'C';             
             echo '<br/>kasy zarobiono: '.$a4.'C - '.$a2.'C = '.$osas.'C (poprzednio: '.$zdobytakasapoprzednio.')';
             echo '<br/>  Punkty zdobyte: '.$a1. '  ---  pieniądze wydane: '.$a2.'C <br/>';
             }
            
           
             $sql15 = " UPDATE wynikidru "
                    . " SET punkty = '$a1', wydat = '$a2', pri = '$a3', kasaw = '$a4'  "
		    . " WHERE id_user = '$wyn12[0]' AND id_wys = '$id_wys'";     
		    
		    //echo $sql15.'</br>';
		    
	     $zap15 = mysql_query($sql15) or die('mysql_query');

	   
	     $sql17 = " SELECT punkty, kasa "
                    . " FROM User "
		    . " WHERE id_user = '$wyn12[0]'";     
	     $zap17 = mysql_query($sql17) or die('mysql_query');
	     while ($wyn17 = mysql_fetch_row($zap17)) {
	       if ($wyswietl == "OK") {
               echo ' --- Wyszukuję punkty: '.$wyn17[0];
               echo ' Sprawdzam kasę ekipy: '.$wyn17[1].'C <br/>';
               }
	       
	       
	     
	       $a2 = $wyn17[1] - $a2 + $a4 + $b2 - $zdobytakasapoprzednio;
	       $a1 = $a1 - $b1 + $wyn17[0];

	   }
	   if ($wyswietl == "OK") {
	   echo 'edytuję rekordy';
	   }
           $a3 = $a1 - $a2;
	   $sql18 = " UPDATE User "
                  . " SET punkty = '$a1', kasa = '$a2' "
		  . " WHERE id_user = '$wyn12[0]' ";     
	   $zap18 = mysql_query($sql18) or die('mysql_query'); 
	   if ($wyswietl == "OK") {   
	   echo ' nowe punkty '.$a1. '  --- nowa kasa '.$a2.'C <br/>';
	   }
           }
           
           
           
	 } 
	 
	 $sql17 = " SELECT id_wdr, id_wys "
                . " FROM wynikidru "
		. " WHERE (id_wys = '$id_wys' AND wydat = 0 AND punkty = 0) ";     
	 $zap17 = mysql_query($sql17) or die('mysql_query');
	 while ($wyn17 = mysql_fetch_row($zap17)) {
	 
	 
	 
	          $sql19 = " DELETE FROM wynikidru "
	  	         . " WHERE id_wdr = '$wyn17[0]'";     
                  $zap19 = mysql_query($sql19) or die('mysql_query');  
	 
	 }
	 
	 echo '[/quote]';
	 echo '<h4>SKOŃCZONE</h4> 
	 <a href="podliczpunkty.php">Podlicz punkty kolarzy</a>
           ';
           
             
	            
         } else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
         }
         
         
         
         
         
         
         
         
         
         
         echo koniec();
      ?>
  
    
    
    
    
