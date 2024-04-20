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
   <title>FFF - klasyfikacja kolarzy</title>
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
    
    
                if ($_GET['psort'] == "") {
                    $pocz_S = 0;
                  } else {
                    $pocz_S = $_GET['psort'];
                  }
                  $kon_S = $pocz_S + 50;
                  $poprzed_S = $pocz_S - 50;
                  if ($poprzed_S < 0) {
                    $poprzed_S = 0;
                  }
        if($_SESSION['logowanie'] == 'poprawne') { 
          
          
          if ($_GET['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_GET['sort'];
	          }
             
             echo  '<form action="kolarze.php" method="GET">';

             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>wszyscy razem ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>kolarze fff osobno ';

             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';
          
          
          
            if ($sort1 == 2) {
                  echo '<h4>Zawodnicy zatrudnieni</h4>';
                  //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty AS SumaOfpunkty, Sum(Wyscigi.startowe) AS SumaOfstartowe, Kolarze.id_user, User.login 
		  //          FROM Wyscigi INNER JOIN (((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON (ktopoj.id_wys = Wyscigi.id_wys) AND (Wyscigi.id_wys = Wyniki.id_wys)
		//	    WHERE Kolarze.id_user > 0 
		//	    GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.id_user 
		//	    ORDER BY SumaOfpunkty DESC
		//	    LIMIT $pocz_S, $kon_S ";
			    
		  $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty AS SumaOfpunkty, Kolarze.punkty, Kolarze.id_user, User.login 
		            FROM User, Ekipy, Nat, Kolarze
			    WHERE Kolarze.id_user > 0 AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user 
			    ORDER BY SumaOfpunkty DESC
			    LIMIT $pocz_S, $kon_S ";	    
			    
		  $ttt = $pocz_S + 1;
		  echo '<table class="wyscig">';
		  		  
                  echo '<tr><td class="wyscig1">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
		  echo '<td></td><td></td><td></td><td></td><td></td><td style="text-align: right;">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input class="form2"  type=submit value="NAST" /><input type="hidden" name="sort" value="'.$sort1.'"></form></td></tr>';
		  
		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig9">kolarz</td><td class="wyscig3">wiek</td><td class="wyscig10">pun.</td><td class="wyscig10">tydz.</td><td class="wyscig10">mie.</td>';
		  if($_SESSION['logowanie'] == 'poprawne') {
		    echo '<td class="wyscig6" style="text-align: right;">właściciel</td></tr>';
		  }
		  $zap9 = mysql_query($sql9) or die('mysql_query');
		  while ($dan9 =  mysql_fetch_row($zap9)) {
		    $dzis = strtotime(date("Y-m-d"));
		    $wiek = strtotime($dan9[5]);
		    $wiek = $dzis - $wiek;
		    $wiek = floor($wiek / (3600 * 24 * 365));
		    
		    $dzis=date("Y-m-d");
		    $miesiac_przed = strtotime($dzis) - 30 * 24 * 3600;
                    $miesiac_przed = date('Y-m-d',$miesiac_przed);
                    $tydzien_przed = strtotime($dzis) - 7 * 24 * 3600;
                    $tydzien_przed = date('Y-m-d',$tydzien_przed);
                    
                    //echo $tydzien_przed.' -> '.$dan9[0].'<br/>';
                    $sqlqw = " SELECT Sum(Wyniki.punkty) AS SumaOfpunkty "
                           . " FROM Wyniki, Wyscigi "
                           . " WHERE ((Wyscigi.dataP <= '$tydzien_przed') AND (Wyniki.id_kol = '$dan9[0]')) AND Wyniki.id_wys = Wyscigi.id_wys ";
                    $zapqw = mysql_query($sqlqw) or die('mysql_query');
                    $danqw = mysql_fetch_row($zapqw);
                    
                    $sqlqa = " SELECT Sum(Wyniki.punkty) AS SumaOfpunkty "
                           . " FROM Wyniki, Wyscigi "
                           . " WHERE Wyscigi.dataP <= '$miesiac_przed' AND Wyniki.id_kol = '$dan9[0]' AND Wyniki.id_wys = Wyscigi.id_wys ";
                    $zapqa = mysql_query($sqlqa) or die('mysql_query');
                    $danqa = mysql_fetch_row($zapqa);
                    
		    $string = "";
		    $string = $string.'<tr><td>'.$ttt.'</td><td><a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /><br/> '.$dan9[6].' </td><td>';
		    if ($wiek > 100) {
                      $string = $string.'?</td>';
                    } else {
		      $string = $string.$wiek.'</td>';
		    }
		    
		    $ostatni_tydz = $dan9[11] - $danqw[0];
		    $ostatni_mies = $dan9[11] - $danqa[0];
		    
		    $ttt++;
		    $string = $string.'<td class="wyscig5" style="text-align: right;"><b>'.$dan9[11].'</b></td><td class="wyscig5" style="text-align: right;">'.$ostatni_tydz.'</td><td class="wyscig5" style="text-align: right;">'.$ostatni_mies;
		    $string = $string.'</td>';
		    $string = $string.'<td class="wyscig6" style="text-align: right;"><a href="user.php?id_user='.$dan9[13].'">'.$dan9[14].'</a></td>';
		    $string = $string.'</tr>';
		    echo $string; 
		    
		  }
		  echo '<tr><td class="wyscig1">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
		  echo '<td></td><td></td><td></td><td></td><td></td><td style="text-align: right;">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="NAST" /></form></td></tr>';
                  echo '</table>';
                  echo 'pun. - punkty <br/> tydz. - ostatni tydzień <br/>mie. - ostatni miesiąc';
		    
		    echo '<h4>Zawodnicy niezatrudnieni</h4>';
		   //echo '<table>';
		   
                  //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty, Sum(Wyscigi.startowe) AS SumaOfstartowe, Kolarze.id_user, User.login "
                  //      . " FROM Wyscigi INNER JOIN (((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON (ktopoj.id_wys = Wyscigi.id_wys) AND (Wyscigi.id_wys = Wyniki.id_wys) "
                  //      . " WHERE Kolarze.id_user = 0 "
                  //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.id_user "
                  //      . " ORDER BY SumaOfpunkty DESC "
		  //      . " LIMIT $pocz_S, $kon_S ";
		        
		  $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty AS SumaOfpunkty, Kolarze.punkty, Kolarze.id_user, User.login 
		            FROM User, Ekipy, Nat, Kolarze
			    WHERE Kolarze.id_user = 0 AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user 
			    ORDER BY SumaOfpunkty DESC
			    LIMIT $pocz_S, $kon_S ";
		  
		  $ttt = $pocz_S + 1;
		  echo '<table class="wyscig">';
		  echo '<tr><td class="wyscig1">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
		  echo '<td></td><td></td><td></td><td></td><td style="text-align: right;">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="NAST" /></form></td></tr>';
		  
		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig9">kolarz</td><td class="wyscig3">wiek</td><td class="wyscig10">pun.</td><td class="wyscig10">tydz.</td><td class="wyscig10">mie.</td>';
		  if($_SESSION['logowanie'] == 'poprawne') {
		    echo '</tr>';
		  }
		  $zap9 = mysql_query($sql9) or die('mysql_query');
		  while ($dan9 =  mysql_fetch_row($zap9)) {
		    $dzis = strtotime(date("Y-m-d"));
		    $wiek = strtotime($dan9[5]);
		    $wiek = $dzis - $wiek;
		    $wiek = floor($wiek / (3600 * 24 * 365));
		    $dzis=date("Y-m-d");
		    $miesiac_przed = strtotime($dzis) - 30 * 24 * 3600;
                    $miesiac_przed = date('Y-m-d',$miesiac_przed);
                    $tydzien_przed = strtotime($dzis) - 7 * 24 * 3600;
                    $tydzien_przed = date('Y-m-d',$tydzien_przed);
                    
                    //echo $tydzien_przed.' -> '.$dan9[0].'<br/>';
                    $sqlqw = " SELECT Sum(Wyniki.punkty) AS SumaOfpunkty "
                           . " FROM Wyniki, Wyscigi "
                           . " WHERE ((Wyscigi.dataP <= '$tydzien_przed') AND (Wyniki.id_kol = '$dan9[0]')) AND Wyniki.id_wys = Wyscigi.id_wys ";
                    $zapqw = mysql_query($sqlqw) or die('mysql_query');
                    $danqw = mysql_fetch_row($zapqw);
                    
                    $sqlqa = " SELECT Sum(Wyniki.punkty) AS SumaOfpunkty "
                           . " FROM Wyniki, Wyscigi "
                           . " WHERE Wyscigi.dataP <= '$miesiac_przed' AND Wyniki.id_kol = '$dan9[0]' AND Wyniki.id_wys = Wyscigi.id_wys ";
                    $zapqa = mysql_query($sqlqa) or die('mysql_query');
                    $danqa = mysql_fetch_row($zapqa);
                    
		    $string = "";
		    $string = $string.'<tr><td>'.$ttt.'</td><td><a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /><br/> '.$dan9[6].' </td><td>';
		    if ($wiek > 100) {
                      $string = $string.'?</td>';
                    } else {
		      $string = $string.$wiek.'</td>';
		    }
		    
		    $ostatni_tydz = $dan9[11] - $danqw[0];
		    $ostatni_mies = $dan9[11] - $danqa[0];
		    
		    $ttt++;
		    $string = $string.'<td class="wyscig5" style="text-align: right;"><b>'.$dan9[11].'</b></td><td class="wyscig5" style="text-align: right;">'.$ostatni_tydz.'</td><td class="wyscig5" style="text-align: right;">'.$ostatni_mies;
		    $string = $string.'</td>';
		    $string = $string.'</tr>';
		    echo $string; 
		    
                  }
                  
                  
                  echo '<tr><td class="wyscig1">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
		  echo '<td></td><td></td><td></td><td></td><td style="text-align: right;">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="NAST" /></form></td></tr>';
		  echo '</table>';
		  echo 'p. - punkty <br/> t. - ostatni tydzień <br/>m. - ostatni miesiąc';
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
       
       
       
       
               
            } else {
          
          
          
                  
                  
                  
          
                  //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty, Sum(Wyscigi.startowe) AS SumaOfstartowe, Kolarze.id_user, User.login "
                  //      . " FROM Wyscigi INNER JOIN (((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON (ktopoj.id_wys = Wyscigi.id_wys) AND (Wyscigi.id_wys = Wyniki.id_wys) "
                  //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.id_user "
                  //      . " ORDER BY SumaOfpunkty DESC "
		  //      . " LIMIT $pocz_S, $kon_S ";
		        
		  $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty AS SumaOfpunkty, Kolarze.punkty, Kolarze.id_user, User.login 
		            FROM User, Ekipy, Nat, Kolarze
			    WHERE Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user 
			    ORDER BY SumaOfpunkty DESC
			    LIMIT $pocz_S, $kon_S ";      
		        
		  $ttt = $pocz_S + 1;
		  echo '<table class="wyscig">';
		  echo '<tr><td class="wyscig1">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
		  echo '<td></td><td></td><td></td><td></td><td></td><td style="text-align: right;">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="NAST" /></form></td></tr>';
		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig9">kolarz</td><td class="wyscig3">wiek</td><td class="wyscig10">pun.</td><td class="wyscig10">tydz.</td><td class="wyscig10">mie.</td>';
		  if($_SESSION['logowanie'] == 'poprawne') {
		    echo '<td class="wyscig6" style="text-align: right;">właściciel</td></tr>';
		  }
		  $zap9 = mysql_query($sql9) or die('mysql_query');
		  while ($dan9 =  mysql_fetch_row($zap9)) {
		    $dzis = strtotime(date("Y-m-d"));
		    $wiek = strtotime($dan9[5]);
		    $wiek = $dzis - $wiek;
		    $wiek = floor($wiek / (3600 * 24 * 365));
		    $dzis=date("Y-m-d");
		    $miesiac_przed = strtotime($dzis) - 30 * 24 * 3600;
                    $miesiac_przed = date('Y-m-d',$miesiac_przed);
                    $tydzien_przed = strtotime($dzis) - 7 * 24 * 3600;
                    $tydzien_przed = date('Y-m-d',$tydzien_przed);
                    
                    //echo $tydzien_przed.' -> '.$dan9[0].'<br/>';
                    $sqlqw = " SELECT Sum(Wyniki.punkty) AS SumaOfpunkty "
                           . " FROM Wyniki, Wyscigi "
                           . " WHERE ((Wyscigi.dataP <= '$tydzien_przed') AND (Wyniki.id_kol = '$dan9[0]')) AND Wyniki.id_wys = Wyscigi.id_wys ";
                    $zapqw = mysql_query($sqlqw) or die('mysql_query');
                    $danqw = mysql_fetch_row($zapqw);
                    
                    $sqlqa = " SELECT Sum(Wyniki.punkty) AS SumaOfpunkty "
                           . " FROM Wyniki, Wyscigi "
                           . " WHERE Wyscigi.dataP <= '$miesiac_przed' AND Wyniki.id_kol = '$dan9[0]' AND Wyniki.id_wys = Wyscigi.id_wys  ";
                    $zapqa = mysql_query($sqlqa) or die('mysql_query');
                    $danqa = mysql_fetch_row($zapqa);
                    
		    $string = "";
		    $string = $string.'<tr><td>'.$ttt.'</td><td><a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /><br/> '.$dan9[6].' </td><td>';
		    if ($wiek > 100) {
                      $string = $string.'?</td>';
                    } else {
		      $string = $string.$wiek.'</td>';
		    }
		    
		    $ostatni_tydz = $dan9[11] - $danqw[0];
		    $ostatni_mies = $dan9[11] - $danqa[0];
		    
		    $ttt++;
		    $string = $string.'<td class="wyscig5" style="text-align: right;"><b>'.$dan9[11].'</b></td><td class="wyscig5" style="text-align: right;">'.$ostatni_tydz.'</td><td class="wyscig5" style="text-align: right;">'.$ostatni_mies;
		    $string = $string.'</td>';
		    $string = $string.'<td class="wyscig6" style="text-align: right;">';
		    if ($dan9[13] > 0) {
		      $string = $string.'<a href="user.php?id_user='.$dan9[13].'">';
		    }
		    $string = $string.$dan9[14];
		    if ($dan9[13] > 0) {
		      $string = $string.'</a>';
		    }
		    $string = $string.'</td>';
		    $string = $string.'</tr>';
		    echo $string; 

                    }
                    echo '<tr><td class="wyscig1">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
		  echo '<td></td><td></td><td></td><td></td><td></td><td style="text-align: right;">';
		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="NAST" /></form></td></tr>';
                  echo '</table>';
	      }
              } else {
                 
                  
                
		  //$sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Sum(Wyniki.punkty) AS SumaOfpunkty, Sum(Wyscigi.startowe) AS SumaOfstartowe, Kolarze.id_user, User.login "
                  //      . " FROM Wyscigi INNER JOIN (((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON (ktopoj.id_wys = Wyscigi.id_wys) AND (Wyscigi.id_wys = Wyniki.id_wys) "
                  //      . " GROUP BY Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.id_user "
                  //      . " ORDER BY SumaOfpunkty DESC "
		  //      . " LIMIT $pocz_S, $kon_S ";
		        
//		  $sql9 = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Kolarze.dataU, Ekipy.nazwa, Kolarze.cena, Kolarze.dataU, Kolarze.przed, Kolarze.pts_poprz, Kolarze.punkty AS SumaOfpunkty, Kolarze.punkty, Kolarze.id_user, User.login 
//		            FROM User, Ekipy, Nat, Kolarze
//			    WHERE Kolarze.id_user = 0 AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user 
//			    ORDER BY SumaOfpunkty DESC
//			    LIMIT $pocz_S, $kon_S ";      
//		  
//		  $ttt = $pocz_S + 1;
//		  echo '<table class="wyscig">';
//		  echo '<tr><td class="wyscig1">';
//		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="POPRZ" /></form></td>';
//		  echo '<td class="wyscig7"></td><td class="wyscig3"></td><td class="wyscig10">';
//		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input type="hidden" name="sort" value="'.$sort1.'"><input class="form2"  type=submit value="NAST" /></form></td></tr>';
//		  
//		  
//		  echo '<tr><td class="wyscig1">lp</td><td class="wyscig7">kolarz</td><td class="wyscig3">wiek</td><td class="wyscig10">p.</td>';
//		  if($_SESSION['logowanie'] == 'poprawne') {
//		    echo '<td class="wyscig6" style="text-align: right;">właściciel</td></tr>';
//		  }
//		  $zap9 = mysql_query($sql9) or die('mysql_query');
//		  while ($dan9 =  mysql_fetch_row($zap9)) {
//		    $dzis = strtotime(date("Y-m-d"));
//		    $wiek = strtotime($dan9[5]);
//		    $wiek = $dzis - $wiek;
//		    $wiek = floor($wiek / (3600 * 24 * 365));
//		    
//
//		    
//
//		    echo '<tr><td>'.$ttt.'</td><td><a href="kol.php?id_kol='.$dan9[0].'">'.$dan9[1].' <b>'.$dan9[2].'</b></a> <img src=img/flagi/'.$dan9[3].' alt='.$dan9[4].' /><br/> '.$dan9[6].' </td><td>';
//		    
//		    if ($wiek > 100) {
//                      echo '?</td>';
  //                  } else {
//		      echo $wiek.'</td>';
//		    }
//		    
//		    $ttt++;
//		    
//		    echo '<td class="wyscig5" style="text-align: right;">'.$dan9[11];
//		    
//	
//
//
//		    
//		    echo '</td>';
//		    if($_SESSION['logowanie'] == 'poprawne') { 
//		      echo '<td class="wyscig6" style="text-align: right;"><a href="user.php?id_user='.$dan9[13].'">'.$dan9[14].'</a></td>';
//		    }
//		    echo '</tr>';
//                  }
  //                		  echo '<tr><td class="wyscig1">';
//		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$poprzed_S.'" /><input class="form2"  type=submit value="POPRZ" /></form></td>';
//		  echo '<td class="wyscig7"></td><td class="wyscig3"></td><td class="wyscig10">';
//		  echo '<form action="kolarze.php" method="GET"><input type="hidden" name="psort" value="'.$kon_S.'" /><input class="form2"  type=submit value="NAST" /></form></td></tr>';
//		  echo '</table>';
//		  echo 'p. - punkty';
//		  
		
          }
	  echo '<h3>osttanie 3 podsumowane wyścigi:</h3>';
	  $sql = " SELECT Wyscigi.nazwa, Wyscigi.id_wys, DATE(Wyscigi.dataP) FROM Wyscigi INNER JOIN Wyniki ON Wyscigi.id_wys = Wyniki.id_wys GROUP BY Wyscigi.nazwa ORDER BY Wyscigi.dataP DESC LIMIT 0, 3 ";
	  $zap = mysql_query($sql) or die(mysql_error());
	  while ($dan = mysql_fetch_row($zap)) {
            echo '<a href="wyscig.php?id_wys='.$dan[1].'"><b>'.$dan[0].'</b></a> ('.$dan[2].') a w tym podliczone:<br/>';
            
            $sql1 = " SELECT Co.nazwa FROM Co INNER JOIN Wyniki ON Co.id_co = Wyniki.id_co WHERE Wyniki.id_wys = '$dan[1]' GROUP BY Co.nazwa ORDER BY Co.id_co ";
            $zap1 = mysql_query($sql1) or die(mysql_error());
	    while ($dan1 = mysql_fetch_row($zap1)) {
	      echo ' - '.$dan1[0].'<br/>';
	    }
            
          }
	  
	  
	  
	  
	  
	  echo koniec();
	  
        ?>
         
   
