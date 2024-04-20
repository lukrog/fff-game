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
   <title>FFF - dane drużyn fff</title>
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
	          $id_user = $_GET['id_user'];
	    
	          if ($id_user <> 0) {
	          

	
		  
		  $zap = "SELECT User.login, User.ekipa, User.kasa, User.liga, User.ost_log FROM User WHERE (((User.id_user)= '$id_user' ))";
		  $idz = mysql_query($zap) or die('mysql_query');
	  	  $dane = mysql_fetch_row($idz);
	  	
      
                  $obecnyrok = date("Y");
		  //echo "!!!!!!!!!!!!!!!!!!!!!!!!!".$obecnyrok."<br/><br/><br/>";
		  $obecnyrok = (($obecnyrok - 2000) * 1000 );
		  //echo "!!!!!!!!!!!!!!!!!!!!!!!!!".$obecnyrok."<br/><br/><br/>"; 
	  	  
	  	  echo '<center><h1>'.$dane[1].'</h1>'; 
		  echo '</center>';
	  	  $sqlas = "SELECT kosz, reka, boki, spon, opis FROM User Where id_user = '$id_user' ";
	          $zapas = mysql_query($sqlas) or die('mysql_query');
	  	  $daneas = mysql_fetch_row($zapas);
	          
                  $koszulka = $daneas[0];
                  $rekawki = $daneas[1];
                  $boki = $daneas[2];
                  $logo = $daneas[3];
                  $opis = $daneas[4];
                  //echo $koszulka.' -> '.$rekawki.' -> '.$boki.' ['.$idek.'] ';
                  echo ' <table style="text-align: justify;"><tr><td>';
                  
	          echo ' <table ALIGN="left"  width="220" height="220" cellpadding="0" cellspacing="0">';
		  echo ' <tr align="center" valign="middle"><td>';
		  
		  echo ' <table background="img/koszulki/koszulka_0'.$koszulka.'.gif" width="220" height="220" cellpadding="0" cellspacing="0"> ';
	          echo ' <tr style="vertical-align: middle; align: center;"> ';
	          echo ' <td background="img/koszulki/rekawki_0'.$rekawki.'.gif" margin-left="10"> ';
	          
	          echo ' <table background="img/koszulki/boki_0'.$boki.'.gif" width="220" height="220" cellpadding="0" cellspacing="0" style="vertical-align: middle; align: center;">';
		  echo ' <tr style="vertical-align: middle; text-align: center;">';
		  echo ' <td>';
		  
		  echo ' <img src="'.$logo.'" /> ';
		  
		  echo ' </td></tr></table>';
		  		  
		  echo ' </td></tr> ';
	          echo ' </table> ';
	          
	          echo ' </td></tr>';
		  echo ' </table> ';
		  
	          echo $opis.'</td></tr></table><br/><br/>';
	          
	          
	          
		  echo '<table id="menu2">';
	          echo '<tr><td class="wyscig2"><i>id usera: </i></td><td class="wyscig2">'.$id_user.'</td></tr>';
	          echo '<tr><td><i>login: </i></td><td>'.$dane[0].'</td></tr>';
	          echo '<tr><td><i>nazwa ekipy: </i></td><td>'.$dane[1].'</td></tr>';
	          echo '<tr><td><i>pieniądze: </i></td><td>'.$dane[2].'</td></tr>';
		  echo '<tr><td><i>ostatnie logowanie: </i></td><td>'.$dane[4].'</td></tr>';
		  
		  $zapy = "SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.flaga, Nat.nazwa, wynikidru.punkty, DATE(Wyscigi.dataP), wynikidru.wydat, wynikidru.kasaw 
		           FROM Nat, wynikidru, Wyscigi
			   WHERE wynikidru.id_user= '$id_user' AND  Nat.id_nat = Wyscigi.id_nat AND wynikidru.id_wys = Wyscigi.id_wys
			   ORDER BY Wyscigi.dataP DESC";
		  $idza = mysql_query($zapy) or die('mysql_query');
		  $i = 0;
		  $punkty = 0;
		  $wydane = 0;
		  
	  	  while ($dan = mysql_fetch_row($idza)) {
	  	    
	  	    if ($dan[0] >= $obecnyrok) {
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
                    $mnoz = 1.25;
                   } elseif ($dane[3] == 2) {
                    $mnoz = 0.75;
                   } else {
                    $mnoz = 0.25;
                   }
                   
		  echo '<tr><td><i>mnożnik startowego: </i></td><td>'.$mnoz.'</td></tr>';
		  echo '<tr><td><i>punkty: </i></td><td>'.$punkty.'</td></tr>';
		  echo '<tr><td><i>wydana kasa (startowe): </i></td><td>'.$wydane.'</td></tr>';
	          echo '</table>';

	          if ($id_user == $idek) {
                    echo '<font style="size: 10px;"><a href="usered.php">Edytuj dane ekipy</a></font>';
                  }  
	          echo '<br/><br/>';
	          
	          if ($_POST['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_POST['sort'];
	          }
             
             echo  '<form action="user.php?id_user='.$id_user.'" method="POST">';
             //echo  '<input type="hidden" name="id_user" value="'.$id_user.'">'
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>wg nazwisk ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>wg ekip ';
	     echo  '<input class="form" type=radio name=sort value=3 ';
	     if ($sort1 == 3) {
               echo 'checked="checked"';
             }
	     echo  '>wg narodowości ';
	     echo  '<input class="form" type=radio name=sort value=4 ';
	     if ($sort1 == 4) {
               echo 'checked="checked"';
             }
	     echo  '>wg ceny ';
	     echo  '<input class="form" type=radio name=sort value=5 ';
	     if ($sort1 == 5) {
               echo 'checked="checked"';
             }
	     echo  '>wg punktów ';
             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';
	          
	          $ilu_kolarzy = 0 ;
	          $wartość_kolarzy = 0 ;
	          $srednia_wieku = 0 ;
	          $ilerut = 0;
	          $iledor = 0;
	          $ileu23 = 0;
	          $ttt = 1;
		  //tu wrzucić tabelę z kolarzami.
		  echo '<table class="wyscig">';
		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig9">kolarz</td><td class="wyscig3">id</td><td class="wyscig3">wiek</td><td class="wyscig10">p.</td><td class="wyscig10">s.</td><td class="wyscig10">c.</td><td class="wyscig6" style="text-align: right;">wsp.</td></tr>';
		  if ($sort1 == 2) 
		  {
		    //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty "
                    //      . " FROM User INNER JOIN (Nat INNER JOIN ((Ekipy INNER JOIN Kolarze ON Ekipy.id_team = Kolarze.id_team) LEFT JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON User.id_user = Kolarze.id_user "
                    //      . " WHERE Kolarze.id_user= '$id_user' "
                    //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz "
                    //      . " ORDER BY Ekipy.nazwa ";
                    
		    
		    $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty 
		              FROM User, Nat, Ekipy, Kolarze
			      WHERE Kolarze.id_user= '$id_user' AND User.id_user = Kolarze.id_user AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team
			      ORDER BY Ekipy.nazwa ";      
                          
                          
		  } elseif ($sort1 == 3) {
		    //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty "
                    //      . " FROM User INNER JOIN (Nat INNER JOIN ((Ekipy INNER JOIN Kolarze ON Ekipy.id_team = Kolarze.id_team) LEFT JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON User.id_user = Kolarze.id_user "
                    //      . " WHERE Kolarze.id_user= '$id_user' "
                    //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz "
                    //      . " ORDER BY Nat.nazwa, Kolarze.nazw ";
                    
                   $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty 
		              FROM User, Nat, Ekipy, Kolarze
			      WHERE Kolarze.id_user= '$id_user' AND User.id_user = Kolarze.id_user AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team
			      ORDER BY Nat.nazwa, Kolarze.nazw ";   
                    
                  } elseif ($sort1 == 4) {
		    //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty "
                    //      . " FROM User INNER JOIN (Nat INNER JOIN ((Ekipy INNER JOIN Kolarze ON Ekipy.id_team = Kolarze.id_team) LEFT JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON User.id_user = Kolarze.id_user "
                    //      . " WHERE Kolarze.id_user= '$id_user' "
                    //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz "
                    //      . " ORDER BY Kolarze.cena DESC, Kolarze.nazw ";
                    
                    $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty 
		              FROM User, Nat, Ekipy, Kolarze
			      WHERE Kolarze.id_user= '$id_user' AND User.id_user = Kolarze.id_user AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team
			      ORDER BY Kolarze.cena DESC, Kolarze.nazw ";
                    
                  } elseif ($sort1 == 5) {
		    //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty "
                    //      . " FROM User INNER JOIN (Nat INNER JOIN ((Ekipy INNER JOIN Kolarze ON Ekipy.id_team = Kolarze.id_team) LEFT JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON User.id_user = Kolarze.id_user "
                    //      . " WHERE Kolarze.id_user= '$id_user' "
                    //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz "
                    //      . " ORDER BY SumaOfpunkty DESC ";
                          
                    $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty 
		              FROM User, Nat, Ekipy, Kolarze
			      WHERE Kolarze.id_user= '$id_user' AND User.id_user = Kolarze.id_user AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team
			      ORDER BY Kolarze.punkty DESC, Kolarze.nazw ";      
                          
		  } else {
                    //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty "
                    //      . " FROM User INNER JOIN (Nat INNER JOIN ((Ekipy INNER JOIN Kolarze ON Ekipy.id_team = Kolarze.id_team) LEFT JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON User.id_user = Kolarze.id_user "
                    //      . " WHERE Kolarze.id_user= '$id_user' "
                    //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz "
                    //      . " ORDER BY Kolarze.nazw, Kolarze.imie ";
                    
                    $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty 
		              FROM User, Nat, Ekipy, Kolarze
			      WHERE Kolarze.id_user= '$id_user' AND User.id_user = Kolarze.id_user AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team
			      ORDER BY Kolarze.nazw, Kolarze.imie ";
                  }
		  
		  
		  $zap9 = mysql_query($sql9) or die('mysql_query');
		  while ($dan9 =  mysql_fetch_row($zap9)) {
		    
		    
		    
		    $sqlpoi = " SELECT ktopoj.id_kol, Sum(Wyscigi.startowe) AS SumaOfstartowe
		                FROM ktopoj, Wyscigi
		                WHERE ktopoj.id_wys = Wyscigi.id_wys AND ktopoj.id_kol = '$dan9[0]'
				GROUP BY ktopoj.id_kol
				
				";
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
		    
		    
		    echo '<tr><td>'.$ttt.'</td><td><img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /> ';

                      $sqlprz = " SELECT * "
   		              . " FROM przed "
		              . " WHERE id_kol = '$dan9[0]' ";
                      $zapprz = mysql_query($sqlprz) or die('mysql_query');
                        

		    $sql_przedl = "SELECT * FROM `wydarzenia` WHERE `typ`=4 AND `dataK`>=\"".date("Y-m-d")."\" ";
		    $zap_przedl = mysql_query($sql_przedl) or die(mysql_error()); 
		    //echo  $sql_przedl." || ".mysql_num_rows($zap_przedl);
                      if ((mysql_num_rows($zapprz) > 0) AND (mysql_num_rows($zap_przedl) == 0)) { 
                        echo ' <font color=green>';
                      }


                    echo '<a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <i>'.$rodzaj.'</i><br/> '.$dan9[6].' </td><td><i>'.$dan9[0].'</i></td><td>'.$wiek.'</td><td class="wyscig5" style="text-align: right;">';
		    $ttt++;
		    
                    $sqlpioi = "SELECT Sum(Wyniki.punkty) AS SumaOfpunkty 
		                FROM Wyscigi, zgloszenia, Wyniki  
				WHERE zgloszenia.id_kol='$dan9[0]' AND Wyniki.id_wys = Wyscigi.id_wys AND Wyniki.id_kol = zgloszenia.id_kol AND zgloszenia.id_wys = Wyscigi.id_wys ";
	            $zappioi = mysql_query($sqlpioi) or die(mysql_error());   
                    $danpioi =  mysql_fetch_row($zappioi);
                    
                    $sqlploi = "SELECT Sum(Wyscigi.startowe) AS SumaOfStart 
		                FROM ktopoj, zgloszenia, Wyscigi
				WHERE zgloszenia.id_kol='$dan9[0]' AND Wyscigi.id_wys = zgloszenia.id_wys AND Wyscigi.id_wys = ktopoj.id_wys AND zgloszenia.id_kol = ktopoj.id_kol";
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
		        //echo $punpoi;
		      } else {
		        echo $dan9[11].' <br/>('.$punpoi.')';
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
                        echo sprintf("%.1f", $cos1).' <br/>('.sprintf("%.1f", $cos2).')';
                      }
                    }
                    if ($dan9[7] == 0 ) {
                      $cenka = 1;
                    } else {
                     $cenka = $dan9[7];
                    }
                    
                    
                    //$wsp = 100 * (($dan9[11] - $cos1 ) / $cenka);
                    $wsp = 100 * (($punpoi - $cos2 ) / $cenka);
		    //$wsp = round($wsp)/1000;
		    
		    echo '</td><td class="wyscig5" style="text-align: right;">'.$dan9[7].'</td><td class="wyscig6" style="text-align: right;">';
		    if ($wsp == 0) {
		      } else {
		    //echo $wsp.'%';
		    echo sprintf("%.3f", $wsp).'%';
		    }
		    echo '</td></tr>';
                  }
                  
		  echo '</table>';
		  echo 'p. - punkty<br/>s. - startowe zapłacone<br/>c. - cena zakupu';
		  
		  //tu koniec
		  echo '<h5>Skład ekipy</h5>';
		  $ilukol = $ilerut + $iledor + $ileu23;
		  if ($dane[3] == 1 ) {
                    $ilukolarzy = 36;
                    $ilurutyniarzy = 25;
                    $ilurutyniarzyidorob = 33;
                  } elseif ($dane[3] == 2) {
                    $ilukolarzy = 30;
                    $ilurutyniarzy = 23;
                    $ilurutyniarzyidorob = 28;
                  } else {
                    $ilukolarzy = 24;
                    $ilurutyniarzy = "Brak ogr.";
                    $ilurutyniarzyidorob = "Brak ogr.";
                  }
		  
		  
		  
		  echo '<table class="wyscig">';
                  echo '<tr><td class="wyscig2"> </td><td class="wyscig6" >Obecnie</td><td class="wyscig6">max dopuszczalne </td></tr>';
		  echo '<tr><td class="wyscig2">ilu kolarzy w ekipie:</td><td class="wyscig6" >'.$ilukol.'</td><td class="wyscig6">';

                  if ($ilukol > $ilukolarzy) {
                    echo '<font color=red><b>'.$ilukolarzy.'</b></font>';
                  } else {
                    echo $ilukolarzy;
                  }

                  echo '</td></tr>';


		  $ileorl = $ilerut + $iledor;
		  echo '<tr><td class="wyscig2">ilu nie orlików:</td><td class="wyscig6" >';
		  if ($ilurutyniarzyidorob < $ileorl AND $ilurutyniarzyidorob <> "Brak ogr.") {
                    echo '<font style="color: red;"><b>';
                  }
		  echo $ileorl;
		  if ($ilurutyniarzyidorob < $ileorl AND $ilurutyniarzyidorob <> "Brak ogr.") {
                    echo '</b></font>';
                  }
                  echo '</td><td>'.$ilurutyniarzyidorob.'</td></tr>';
		  echo '<tr><td class="wyscig2">ilu rutyniarzy w ekipie:</td><td class="wyscig6" >';
		  if ($ilurutyniarzy < $ilerut AND $ilurutyniarzy <> "Brak ogr.") {
                    echo '<font style="color: red;"><b>';
                  }
		  echo $ilerut;
		  if ($ilurutyniarzy < $ilerut AND $ilurutyniarzy <> "Brak ogr.") {
                    echo '</b></font>';
                  }
                  echo '</td><td>'.$ilurutyniarzy.'</td></tr>';
		  
		  echo '<tr><td class="wyscig2">ilu kolarzy na dorobku w ekipie:</td><td class="wyscig6" >'.$iledor.'</td></tr>';
		  echo '<tr><td class="wyscig2">ilu orlików w ekipie:</td><td class="wyscig6" >'.$ileu23.'</td></tr>';
		  
                  $wartość_kolarzy = round ($wartość_kolarzy / $ilu_kolarzy , 3);
	          $srednia_wieku = round ($srednia_wieku / $ilu_kolarzy , 3);
		  echo '<tr><td class="wyscig2">średnia wieku zawodników:</td><td class="wyscig6" >'.$srednia_wieku.'</td></tr>';
		  echo '<tr><td class="wyscig2">średnia wartość kolarza:</td><td class="wyscig6" >'.$wartość_kolarzy.'</td></tr>';
		  
		  echo '</table>';
		  
		  
		  
		  // -----------------PRIORYTETY-----------
		  
		  echo '<h5>Prioytety wzięte:</h5>';
		          		  
		  echo '<table class="wyscig">';
	          echo '<tr><td class="wyscig9">wyścig</td><td class="wyscig6">klasyfikacja</td></tr>';
	          
		  $sqlabc = " SELECT wynikidru.id_user, Wyscigi.nazwa, Wyscigi.klaPC "
                          . " FROM wynikidru, Wyscigi "
                          . " WHERE wynikidru.pri = 1 AND wynikidru.id_user = '$id_user' AND wynikidru.id_wys = Wyscigi.id_wys "
                          . " ORDER BY Wyscigi.dataP ";
		  $zapabc = mysql_query($sqlabc) or die('mysql_query');
		  $count=0;
		  while ($danabc =  mysql_fetch_row($zapabc)) {
		    $count++;
                    echo '<tr><td>'.$danabc[1].'</td><td>'.$danabc[2].'</td></tr>';
		  }
		  echo '</table>';  
		  
		  
		  
		  // -----------------PRIORYTETY-----------
		  if ($id_user == $idek) {
		  echo '<h5>Prioytety proponowane:</h5>';
		  echo '<table class="wyscig">';
		  echo '<tr><td class="wyscig9">wyścig</td><td class="wyscig6">klasyfikacja</td></tr>';
		  $dzis = date("Y-m-d");
		  $sqlcba = " SELECT Wyscigi.nazwa, Wyscigi.klaPC, Wyscigi.dataP "
                          . " FROM zgloszenia, Wyscigi "
                          . " WHERE (zgloszenia.pri=1) AND zgloszenia.id_wys = Wyscigi.id_wys "
                          . " GROUP BY Wyscigi.nazwa, Wyscigi.klaPC, zgloszenia.id_user, Wyscigi.dataP "
                          . " HAVING (zgloszenia.id_user = '$idek' AND Wyscigi.dataP > '$dzis') "
                          . " ORDER BY Wyscigi.dataP ";
                          
                                 
		  $zapcba = mysql_query($sqlcba) or die('mysql_query');
		  while ($danabc =  mysql_fetch_row($zapcba)) {
		    if ($daneabc < '2008-05-01') {
		      echo '<tr><td>'.$danabc[0].'</td><td>'.$danabc[1].'</td></tr>';
		    }
		  }
                  echo '</table>';  
		  }
		  
		  
		  
		  echo '<h5>wyniki drużyny w wyścigach</h5>';
		  
	          		  
		  echo '<table class="wyscig">';
	          echo '<tr><td class="wyscig9">wyścig</td><td class="wyscig6">data startu</td><td class="wyscig6" style="text-align: right;">punkty</td><td class="wyscig6" style="text-align: right;">startowe</td><td class="wyscig6" style="text-align: right;">pieniądze +/-</td></tr>';
	          
	           for ($j=0; $j<=$i; $j++) {
                    echo $string[$j];
                  }
                  
                  
	          $wydane = 0;
	          $zarobione = 0;
	          echo '</table>';
	          echo '<br/><br/>';
	          echo '<h5>historia transferów drużyny</h5>';
	          
		  //                  0               1                2                3               4              5           6                  7              8              9                 10                      11       
		  $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, Kolarze.cena, User_1.id_user , User.id_user, transzaak.poprzednia_cena, transzaak.typ "
                       .  " FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS" 
                       .  " WHERE (User_1.id_user = '$id_user' OR User.id_user = '$id_user') "
                       .  " ORDER BY transzaak.kiedy DESC, transzaak.id_tpZ "  ;
                  $zap3 = mysql_query($sql3) or die('mysql_query');
                  echo '<table class="wyscig">';
                  echo '<tr><td class="wyscig9"> Kolarz </td><td class="wyscig6" style="text-align: middle;"> kiedy zapr. </td><td class="wyscig6" style="text-align: middle;"> Sprzedający </td><td class="wyscig6" style="text-align: middle;"> Kupujący </td><td class="wyscig1" style="text-align: right;"> za ile </td><td class="wyscig6" style="text-align: middle;"> ile kosztował poprzednio </td></tr>';
                  while ($dan3 = mysql_fetch_row($zap3)) 
                  {
                    if ($dan3[11] == 3) {
                        $idkol = ($dan3[3] * (-1));
                        $sqlp4 = " SELECT imie, nazw, id_kol FROM Kolarze WHERE id_kol = '$idkol' ";
                        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
                        $danp4 = mysql_fetch_row($zapp4);
                        echo '<tr><td class="wyscig9">'.$dan3[0].' <b>'.$dan3[1].'</b></td><<td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;">';
	                echo 'Wym. </td><td>';
			
			echo $danp4[0].' <b>'.$danp4[1].'</b>';
			 
			echo '</td></tr>';
                        
                        
                      } else {
		   
		   
		   
		    echo '<tr><td class="wyscig9">'.$dan3[0].' <b>'.$dan3[1].'</b></td><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> ';
		   
		    
		    
	            if ($dan3[8] == $id_user) {
	              // jeżeli typ to 1 (zwolnienie) to nie zarobiłeś tylko straciłeś
		      if ($dan3[11] == 1) {
		        $wydane = $wydane + $dan3[3];
		      } else {
		        $zarobione = $zarobione + $dan3[3];
		      }
	              
                      
                      echo $dan3[4];
                    } else {
                      echo '<a href="user.php?id_user='.$dan3[8].'">'.$dan3[4].'</a>';
                    }
	            		    
		    
		    
		    echo '</td><td class="wyscig6" style="text-align: middle;"> ';
                    
		    if ($dan3[9] == $id_user) {
		      
                      $wydane = $wydane + $dan3[3];
                      echo $dan3[5]; 
                    } else {
                      echo '<a href="user.php?id_user='.$dan3[9].'">'.$dan3[5].'</a>';
                    }		    
		    
		    
		    
		    echo '</td><td class="wyscig1" style="text-align: right;"> <b>';
	        
	            
	            
		    echo $dan3[3].'C </b></td><td class="wyscig6" style="text-align: right;">'.$dan3[10];
	           
	            echo 'C </td></tr>';
	            }
                  }
                  echo '</table>';
                  $roznica = $zarobione - $wydane;
                  echo 'Zarobione na transferach '.$zarobione.'<br/>';
                  echo 'Wydane na transfery: '.$wydane.'<br/>';
                  echo 'Różnica: '.$roznica;
	          
	         
         } else {
             // id_user = 0 wolni stzrelcy
             
              
          
	  
	  $alfabet = array('A' , 'B' , 'C' , 'D' , 'E' , 'F' , 'G' , 'H' , 'I' , 'J' , 'K' , 'L' , 'M' , 'N' , 'O' , 'O' , 'Ö' , 'P' , 'Q' , 'R' , 'S' , 'S' , 'Š' , 'T' , 'U' , 'V' , 'W' , 'X' , 'Y' , 'Z');
	   
	  
	  echo '<br/><br/>
	  
	  <form action="user.php" method="GET">
	  <select name="litera">';
	  if ($_GET['litera'] <> "") {
                      $druk = '';
                   } else { 
		      $druk = 'selected="selected"';
		   }
          echo '
	  <option '.$druk.'>wybierz literę:</option>
	  ';
	        for ($i=0, $b=count($alfabet); $i<$b; $i++) {
                   if ($litera == $alfabet[$i]) {
                      $druk = 'selected="selected"';
                   } else { 
		      $druk = '';
		   }
		   echo '<option '.$druk.'>'.$alfabet[$i].'</option> 
		   ';
	        
		}
              echo '
	
	  </select>
          <input  class="form2" type=hidden name="id_user" value="0" /> 
	  <input  class="form2" type=submit value="OK" />
	  
	  </form><br/><br/>';  
             $literapierwsza = $_GET['litera'];
             //echo $literapierwsza.'<--> ';
             $literapierwsza = $literapierwsza.'%';
             //echo $literapierwsza;
             if ($_GET['litera']) {
               echo '<table class="wyscig">';
		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig9">kolarz</td><td class="wyscig3">id</td><td class="wyscig3">wiek</td><td class="wyscig10">p.</td><td class="wyscig10">s.</td><td class="wyscig10">c.</td><td class="wyscig6" style="text-align: right;">wsp.</td></tr>';

	         //gdy podana litera;
	         $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz
                           FROM User, Nat, Ekipy, Kolarze
                           WHERE Kolarze.id_user=0 AND Kolarze.nazw LIKE '$literapierwsza' AND Ekipy.id_team = Kolarze.id_team AND Nat.id_nat = Kolarze.id_nat AND User.id_user = Kolarze.id_user
                           ORDER BY Kolarze.nazw, Kolarze.imie 
		           ";
		           
		  //echo $sql9; 
		           
                  $zap9 = mysql_query($sql9) or die('mysql_query');
		  while ($dan9 =  mysql_fetch_row($zap9)) {
		    

		    $tescik = strtotime($dan9[8]);
                    $tescik = date("Y",$tescik);
                    
                    $tescik1 = strtotime(date("Y-m-d"));
                    $tescik1 = date("Y",$tescik1);
                    $tescik2 = $tescik1 - $tescik;
                    
		    $wiek = $tescik2;
		    
		    
		    echo '<tr><td>'.$ttt.'</td><td><img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /> ';

		    
                      


                    echo '<a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <i>'.$rodzaj.'</i><br/> '.$dan9[6].' </td><td><i>'.$dan9[0].'</i></td><td>'.$wiek.'</td><td class="wyscig5" style="text-align: right;">';
		    $ttt++;
		    
                    
	            echo '</td><td class="wyscig5" style="text-align: right;">';
		    
		     
		    
		    
		    echo '</td><td class="wyscig5" style="text-align: right;">'.$dan9[7].'</td><td class="wyscig6" style="text-align: right;">';
		    
		    echo '</td></tr>';
                  }
                  
		  echo '</table>';
		  echo 'p. - punkty<br/>s. - startowe zapłacone<br/>c. - cena zakupu';
		          
                 
	         
	         
	      } else {
                 //gdy litery brak;
              }
	    
	 
	 
	 }
 
 
 
 
 
	} else {
   	  echo '<h3>Ta strona dostępna tylko po zalogowaniu</h3>';
   
        }


	  
	  
	  
	  
	  
	  echo koniec();
        ?>
