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
   <title>FFF - dane wyścigu</title>
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
	  $id_wys = $_GET['id_wys'];
	  $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP  FROM Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat WHERE (((Wyscigi.id_wys)= '$id_wys' )) ";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
	  echo '<table id="menu2">
	  <tr><td><i>id wyścigu: </i></td><td>'.$id_wys.'</td></tr>
	  <tr><td><i>nazwa wyścigu: </i></td><td>'.$dane[1].'</td></tr>
	  <tr><td><i>kraj rozgrywania: </i></td><td>'.$dane[3].' <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>
          <tr><td><i>klasyfikacja UCI: </i></td><td>'.$dane[5].'</td></tr>
	  <tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr>
	  <tr><td><i>data początku: </i></td><td>'.$dane[10].'</td></tr>
	  <tr><td><i>data końca: </i></td><td>'.$dane[11].'</td></tr>
	  ';
          if($_SESSION['logowanie'] == 'poprawne') {
            echo '<tr><td><i>ostateczna godzna zgłaszania kolarzy: </i></td><td>'.$dane[12].'</td></tr>
	    <tr><td><i>Startowe od kolarza: </i></td><td>'.$dane[7].'</td></tr>
	    <tr><td><i>Mnożnik priorytetu: </i></td><td>'.$dane[9].'</td></tr>
	    ';
	    $asdf = $dane[8] -4;
	    echo '<tr><td><i>Ilu kolarzy można zgłosić: </i></td><td>'.$dane[8].' + '.$asdf.'</td></tr>
	    ';
	  }
	  IF ($idek == 20) {
            echo '<tr><td><i>zgloś kolarzy: </i></td><td> <a href="zglosBB.php?id_wys='.$id_wys.'">KLIKNIJ TU</a> </td></tr>
	    ';
	    
          } 
          if ($_SESSION['boss'] >= 2) {
            echo '<tr><td><i>zgloś wszystkich: </i></td><td> <a href="zglosALL.php?id_wys='.$id_wys.'">KLIKNIJ TU i ZGŁOŚ WSZYSTKICH</a> </td></tr>
	    <tr><td><i>.</i></td><td> </td></tr>
	    <tr><td><i>.</i></td><td> </td></tr>';
	  }
          
          echo '
	  
	  <tr><td><i>link do skarbu kibica: </i></td><td><a href="http://fff.xon.pl/SK/wyscig.php?id_wys='.$id_wys.'">Przejdź do skarbu</a></td></tr>';
          
	  $data_zgloszen = $dane[13];
	  $ilu_kol=$dane[8];
	  
	  if ($_SESSION['boss'] >= 1) {
	    echo '<tr><td><i>.</i></td><td> </td></tr>
	         <tr><td><i>.</i></td><td> </td></tr>
		 <tr><td><i>Edycja wyścigu</i></td><td><a href="wyscig_EDIT.php?id_wys='.$id_wys.'">EDYTUJ TEN WYŚCIG</a></td></tr>';
	  
	    echo '<tr><td>.</td><td></td></tr>
	          <tr><td>Zmieniano</td><td>';
	    // teraz możnaby wyświetlić ostatnie zmiany wykonane w tym wyścigu :D
	    $sql_a_edyt = "SELECT  id_edyt, było, jest, kto, kiedy, co, id FROM a_edycje WHERE co=\"WY\" AND id=".$id_wys." ORDER BY kiedy DESC LIMIT 0, 5 ";
	    $idz_a_edyt = mysql_query($sql_a_edyt) or die('mysql_query');
  	    while ($dane_a_edyt = mysql_fetch_row($idz_a_edyt)) {
	      echo 'użytkownik: '.$dane_a_edyt[3].', dnia: '.$dane_a_edyt[4].' <br/>zmienił z '.$dane_a_edyt[1].'<br/>na '.$dane_a_edyt[2].'<br/><br/>';
	      }
	    echo '</td></tr>';  
	  
	  }
	  
          echo '</table>
	  ';
          $pocz = 1000 * (date("Y")-2000);
	  
	  if ($id_wys > $pocz) {
	  
	  
	  
	  echo '<br/><br/>';
          
          
          
          $zapy = "SELECT Co.id_co, Co.nazwa_pełna FROM Co ORDER BY id_co";
	  $idzz = mysql_query($zapy) or die('mysql_query');
  	  while ($da = mysql_fetch_row($idzz)) {
            $teraz_omawiane = $da[0];
                        
            $zap = " SELECT Wyniki.id_wyn, Wyniki.miejsce, Kolarze.imie, Kolarze.nazw, Nat.nazwa , Nat.flaga , Ekipy.nazwa , User.login, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_kol, Wyniki.punkty, User.id_user, Wyniki.wynik "
	         . " FROM User, Ekipy, Nat, Kolarze,Wyniki "
	         . " WHERE Kolarze.id_kol = Wyniki.id_kol AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user AND Wyniki.id_co = '$teraz_omawiane' AND Wyniki.id_wys= '$id_wys' AND Wyniki.punkty > 0 "
		 . " ORDER BY Wyniki.miejsce, Wyniki.wynik ";
	    $idz = mysql_query($zap) or die('mysql_query');
	    $num_rows = mysql_num_rows($idz); 

            
            if ($num_rows > 0) {
              $zapty = " SELECT z_EtapyKat.data, z_Kategorie.kategoria, z_Kategorie2.skrot "
                     . " FROM z_Kategorie AS z_Kategorie2 INNER JOIN (z_EtapyKat INNER JOIN z_Kategorie ON z_EtapyKat.id_kat = z_Kategorie.id_kat) ON z_EtapyKat.id_kat2 = z_Kategorie2.id_kat "
                     . " WHERE z_EtapyKat.id_wys = '$id_wys' AND id_co = '$teraz_omawiane' ";
              $idzty = mysql_query($zapty) or die('mysql_query');
              $danety = mysql_fetch_row($idzty);
	      
	      echo '<h3>'.$da[1];
	      
	      if ($_SESSION['boss'] >= 0) {
	        echo ' ('.$danety[0].')</h3> - '.$danety[1].' ['.$danety[2].']<br/><br/>';
	      }
	      
	      echo ' ';
              echo '<table class="wyscig">
	      <tr><td class="wyscig11">Lp.</td><td class="wyscig2">Kolarz</td><td class="wyscig3">Kraj</td><td class="wyscig4">Ekipa</td><td class="wyscig5">czas/strata</td><td class="wyscig5">Punkty';
	      if($_SESSION['logowanie'] == 'poprawne') {
                   echo '<td class="wyscig6">właściciel</td></tr>
		   ';
                 } else {
                   echo '</td></tr>
		   ';
                 }
	      
              
	      while ($dane = mysql_fetch_row($idz)) {
                 echo '<tr><td>'.$dane[1].'</td><td><a href="kol.php?id_kol='.$dane[10].'">'.$dane[2].' <b>'.$dane[3].'</b></a></td><td><a href="nat.php?id_nat='.$dane[9].'"><img src="img/flagi/'.$dane[5].'" border=0 /></a></td><td><a href="team.php?id_team='.$dane[8].'">'.$dane[6].'</a></td><td style="text-align: right;">'.$dane[13].'</td><td style="text-align: right;">'.$dane[11];
		 
		 if($_SESSION['logowanie'] == 'poprawne') {
                  
		  $sql25 = " SELECT id_zgl, id_user, kolej "
		         . " FROM zgloszenia "
		         . " WHERE id_wys = '$id_wys' AND id_kol='$dane[10]'  ";
                  $zap25 = mysql_query($sql25) or die('mysql_query');
                  if (mysql_num_rows($zap25) > 0  ) {
                    $dane25 = mysql_fetch_row($zap25);
                    $dane56 = $dane25[1];
                    
                    $sql55 = " SELECT zgloszenia.id_zgl, zgloszenia.id_kol, zgloszenia.kolej "
                           . " FROM zgloszenia INNER JOIN ktopoj ON ( zgloszenia.id_kol = ktopoj.id_kol AND zgloszenia.id_wys = ktopoj.id_wys ) "
                           . " WHERE zgloszenia.id_wys = '$id_wys' AND zgloszenia.id_user='$dane56' "
                           . " ORDER BY kolej "
                           . " LIMIT 0, $ilu_kol ";
                    $zap55 = mysql_query($sql55) or die('mysql_query');
                    $czyZG = "NIE";
                    $numerek = 0;
                    while ($dane55 = mysql_fetch_row($zap55)) {
                      if ($dane55[1] == $dane[10]) {
                        $czyZG = "OK";
                        
                        
                      }
                    }
		    $rezerwowa = $dane25[2] - $ilu_kol;
		    if ( $czyZG == "OK" ) {
		      
		      if ($rezerwowa <= 0 ) {
                        echo '</td><td><a href="user.php?id_user='.$dane[12].'">'.$dane[7].'</a>
			';
                      } else {
                        echo '</td><td><a href="user.php?id_user='.$dane[12].'">'.$dane[7].' (R-'.$rezerwowa.')</a>
			';
	              }
                      
		    } else {
                      echo '</td><td><a href="user.php?id_user='.$dane[12].'"><font style="color: #909090;">'.$dane[7].' (R-'.$rezerwowa.')</font></a>
		      ';  
                    }
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                  } else {
                    echo '
		    </td><td>'.$dane[7];
                  }
		  
                 } else {}
		 echo '
		 </td></tr>';
 	       }

              echo '
	      </table>';
            }

            
            
          }

          if($_SESSION['logowanie'] == 'poprawne') {
          echo '<h4>Wyniki drużyn fff</h4>';
          echo '<table class="wyscig">';
          echo '<tr><td class="wyscig2">Nazwa Ekipy</td><td class="wyscig1" style="text-align: right;">Liga</td><td class="wyscig6" style="text-align: right;">Punkty</td><td class="wyscig6" style="text-align: right;">Wydane</td><td class="wyscig6" style="text-align: right;">Zarobek</td></tr>';
          $sql = " SELECT User.id_user , User.ekipa , User.liga , wynikidru.punkty, User.login, wynikidru.wydat, wynikidru.kasaw "
               . " FROM wynikidru INNER JOIN User ON wynikidru.id_user = User.id_user "
               . " WHERE ( ( ( wynikidru.id_wys ) = '$id_wys' ) ) "
               . " ORDER BY wynikidru.punkty DESC, wynikidru.wydat ";  
          $idzb = mysql_query($sql) or die('mysql_query');
  	  while ($dan = mysql_fetch_row($idzb)) {
  	    $zarobek = $dan[6] - $dan[5];
  	    if ($dan[2] == 1) {
              $liga = "I";
            } elseif ($dan[2] == 2) {
              $liga = "II";
            } else {
              $liga = "III";
            }
            echo '
	    <tr><td><a href="user.php?id_user='.$dan[0].'">'.$dan[1].'</a> - '.$dan[4].'</td><td style="text-align: right;">'.$liga.'</td><td style="text-align: right;">';
	    if ($dan[3] == $dan[6]) {} else {
	      echo '
	      <img src="img/wyscig/prio.jpg" alt="priorytet" border=1 />
	      ';
	    }
	    echo $dan[3].'</td><td style="text-align: right;">'.$dan[5].'C</td><td style="text-align: right;">'.$zarobek.'C</td></tr>';
          }
          echo '
	  </table>
	  ';
          
          
          
          
          echo '<a name="ZGL"></a>
	  ';
          echo '
	  <h4>Zgłoszenia drużyn fff</h4>
	  ';

	  
	  if ($_POST['sort'] == "") 
		  {
		    $sort1=1;
		  } else {
	            $sort1=$_POST['sort'];
	          }
	  
	  
	  echo  '
	  <form action="wyscig.php?id_wys='.$id_wys.'" method="POST">';
             
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>wg zgłaszających ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>wg nazwisk ';
	     echo  '<input class="form" type=radio name=sort value=3 ';
	     if ($sort1 == 3) {
               echo 'checked="checked"';
             }
	     echo  '>wg ekip ';
	     echo  '<input class="form" type=radio name=sort value=4 ';
	     if ($sort1 == 4) {
               echo 'checked="checked"';
             }
	     echo  '>wg narodowości ';
             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';


          
          
          if ($sort1 == 4) {          
	  $sql = " SELECT zgloszenia.id_wys , Kolarze.imie , Kolarze.nazw , Nat.flaga , Ekipy.nazwa , User.login, zgloszenia.kolej, zgloszenia.pri, Kolarze.id_kol, Nat.nazwa "
               . " FROM ( Ekipy INNER JOIN ( Nat INNER JOIN ( zgloszenia INNER JOIN Kolarze ON zgloszenia.id_kol = Kolarze.id_kol ) ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) INNER JOIN User ON zgloszenia.id_user = User.id_user "
               . " WHERE zgloszenia.id_wys = '$id_wys' "
               . " ORDER BY Nat.nazwa, Kolarze.nazw";
          } elseif ($sort1 == 2) {          
	  $sql = " SELECT zgloszenia.id_wys , Kolarze.imie , Kolarze.nazw , Nat.flaga , Ekipy.nazwa , User.login, zgloszenia.kolej, zgloszenia.pri, Kolarze.id_kol "
               . " FROM ( Ekipy INNER JOIN ( Nat INNER JOIN ( zgloszenia INNER JOIN Kolarze ON zgloszenia.id_kol = Kolarze.id_kol ) ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) INNER JOIN User ON zgloszenia.id_user = User.id_user "
               . " WHERE zgloszenia.id_wys = '$id_wys' "
               . " ORDER BY Kolarze.nazw, Kolarze.imie";
          } elseif ($sort1 == 3) {          
	  $sql = " SELECT zgloszenia.id_wys , Kolarze.imie , Kolarze.nazw , Nat.flaga , Ekipy.nazwa , User.login, zgloszenia.kolej, zgloszenia.pri, Kolarze.id_kol "
               . " FROM ( Ekipy INNER JOIN ( Nat INNER JOIN ( zgloszenia INNER JOIN Kolarze ON zgloszenia.id_kol = Kolarze.id_kol ) ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) INNER JOIN User ON zgloszenia.id_user = User.id_user "
               . " WHERE zgloszenia.id_wys = '$id_wys' "
               . " ORDER BY Ekipy.nazwa, Kolarze.nazw";
          } else {          
	  $sql = " SELECT zgloszenia.id_wys , Kolarze.imie , Kolarze.nazw , Nat.flaga , Ekipy.nazwa , User.login, zgloszenia.kolej, zgloszenia.pri, Kolarze.id_kol "
               . " FROM ( Ekipy INNER JOIN ( Nat INNER JOIN ( zgloszenia INNER JOIN Kolarze ON zgloszenia.id_kol = Kolarze.id_kol ) ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) INNER JOIN User ON zgloszenia.id_user = User.id_user "
               . " WHERE zgloszenia.id_wys = '$id_wys' "
               . " ORDER BY User.login, zgloszenia.kolej";
          }
	  
	  
	  $idzb = mysql_query($sql) or die('mysql_query');
          echo '
	  <table class="wyscig">';
          echo '
	  <tr><td class="wyscig7">Kolarz</td><td class="wyscig7">Ekipa</td><td class="wyscig6">Zgłaszający</td></tr>';
	  while ($dan = mysql_fetch_row($idzb)) {
	    $sqlqwe = " SELECT id_kol FROM ktopoj WHERE id_wys = '$id_wys' AND id_kol = '$dan[8]' ";
	    $idzqwe = mysql_query($sqlqwe) or die('mysql_query');
	    if(mysql_num_rows($idzqwe) > 0) {
              $tekst1 = "";
            } else {
              if ($data_zgloszen <= date("Y-m-d H:m:s")) {              
                $tekst1 = "text-decoration: line-through;";
              }
            }
	    
	    
            echo '<tr><td>';
            $kolej = $dan[6];

	    if ($kolej > $ilu_kol) 
	    { 
	      $color = "#909090";
	      $tekst = "(R)";
	    }
	    else
	    { 
	      $color = "black";
	      $tekst = "";
	    } 

	    echo '
	    <font style="'.$tekst1.' color: '.$color.';"><img src="img/flagi/'.$dan[3].'" alt="flaga" /> '.$dan[1].' <b>'.$dan[2].'</b> '.$tekst.' </font></td><td><font style="'.$tekst1.' color: '.$color.'">'.$dan[4].'</font></td><td><font style="'.$tekst1.' color: '.$color.'">'.$dan[5].'</font>';
	    
	    if ($dan[7] == 1) 
	        {
		  echo '
		   <img src="img/wyscig/prio.jpg" alt="priorytet" border=1 />';
		} 
	    echo '
	    </td></tr>';
	    
	    
          }
          echo '
	  </table>
	  ';
          
          echo '<h5>Niezgłoszeni kolarze:</h5>
	  ';
          
	  
	  if ($sort1 == 4) { 
	  $sql = " SELECT Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy.nazwa, User.login, zgloszenia.id_zgl "
	       . " FROM zgloszenia RIGHT JOIN ((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON zgloszenia.id_kol = ktopoj.id_kol  AND zgloszenia.id_wys = ktopoj.id_wys"
	       . " WHERE ktopoj.id_wys= '$id_wys' AND zgloszenia.id_zgl IS Null  "
	       . " ORDER BY Nat.nazwa ";
	  } elseif ($sort1 == 3) { 
	  $sql = " SELECT Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy.nazwa, User.login, zgloszenia.id_zgl "
	       . " FROM zgloszenia RIGHT JOIN ((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON zgloszenia.id_kol = ktopoj.id_kol AND zgloszenia.id_wys = ktopoj.id_wys "
	       . " WHERE ktopoj.id_wys='$id_wys' AND zgloszenia.id_zgl IS Null  "
	       . " ORDER BY Ekipy.nazwa ";
	  } elseif ($sort1 == 2) { 
	  $sql = " SELECT Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy.nazwa, User.login, zgloszenia.id_zgl "
	       . " FROM zgloszenia RIGHT JOIN ((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON zgloszenia.id_kol = ktopoj.id_kol AND zgloszenia.id_wys = ktopoj.id_wys "
	       . " WHERE ktopoj.id_wys='$id_wys' AND zgloszenia.id_zgl IS Null  "
	       . " ORDER BY Kolarze.nazw ";
	  } else { 
	  $sql = " SELECT Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy.nazwa, User.login, zgloszenia.id_zgl "
	       . " FROM zgloszenia RIGHT JOIN ((User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user) INNER JOIN ktopoj ON Kolarze.id_kol = ktopoj.id_kol) ON zgloszenia.id_kol = ktopoj.id_kol AND zgloszenia.id_wys = ktopoj.id_wys "
	       . " WHERE ktopoj.id_wys='$id_wys' AND zgloszenia.id_zgl IS Null  "
	       . " ORDER BY User.login, Kolarze.nazw ";
	  }
	  
	  
	  
	  $idzb = mysql_query($sql) or die('mysql_query');
	  echo '<table class="wyscig">
	  <tr><td class="wyscig7">Kolarz</td><td class="wyscig7">Ekipa</td><td class="wyscig6">Zgłaszający</td></tr>
	  ';
	  while ($dan = mysql_fetch_row($idzb)) {
	    echo '<tr><td><img src="img/flagi/'.$dan[2].'" alt="flaga"/> '.$dan[0].' <b>'.$dan[1].'</b></td><td>'.$dan[3].'</td><td class="wyscig6">'.$dan[4].'</td></tr>
	    ';
	    
	    }     
          echo '</table>
	  ';
          
          
          
          echo '<h5>Zgłoszenia drużyn</h5>';
          $sql = " SELECT User.id_user, User.login, User.ekipa, User.liga
	           FROM User
		   WHERE User.liga < 4 
		   ORDER BY liga, ekipa
		   ";

          $idzb = mysql_query($sql) or die('mysql_query');
          echo '<table class="wyscig">
	  <tr><td class="wyscig7">Ekipa</td><td class="wyscig7">czy zgłosiła kolarzy</td></tr>
	  ';
	  while ($dan = mysql_fetch_row($idzb)) {
	    if ($dan[0] == 0) {} else {
	    
	    $sqlaa = " SELECT id_zgl FROM zgloszenia WHERE id_wys = '$id_wys' AND id_user = '$dan[0]' ";
	    $idzaa = mysql_query($sqlaa) or die('mysql_query');
	    if ($dan[3] == 1) 
	    {$cos = "PT";}
	    elseif ($dan[3] == 2) 
	    {$cos = "PR";}
	    else {$cos = "CT";}
	    echo '<tr><td>'.$dan[2].' - <i>'.$dan[1].'</i> ('.$cos.')</td><td>
	    ';
	    if (mysql_num_rows($idzaa) == 0) {
              echo '<font style="color: #ff0000;">BRAK ZGLOSZENIA</font>';
            } else {
              echo 'Zgloszenie wysłane';
            }
            }
          }
          echo '
	  </table>';



}	 

} else {
  
  
	  
	  
	  echo '
	  
	  <br/><br/>
	  
	  ';
          
          
          
          $zapy = "SELECT Co.id_co, Co.nazwa_pełna FROM Co";
	  $idzz = mysql_query($zapy) or die('mysql_query');
  	  while ($da = mysql_fetch_row($idzz)) {
            $teraz_omawiane = $da[0];
                        
            $zap = " SELECT WynikiP.id_wyn, WynikiP.miejsce, Kolarze.imie, Kolarze.nazw, Nat.nazwa , Nat.flaga , Ekipy.nazwa , User.login, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_kol, WynikiP.punkty, User.id_user, WynikiP.wynik "
	         . " FROM User INNER JOIN (Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN WynikiP ON Kolarze.id_kol = WynikiP.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team) ON User.id_user = Kolarze.id_user WHERE ((((WynikiP.id_co) = '$teraz_omawiane' )) AND (((WynikiP.id_wys)= '$id_wys' )))"
		 . " ORDER BY WynikiP.miejsce, WynikiP.wynik ";
	    $idz = mysql_query($zap) or die('mysql_query');
	    $num_rows = mysql_num_rows($idz); 

            
            if ($num_rows > 0) {
              $zapty = " SELECT z_EtapyKat.data, z_Kategorie.kategoria, z_Kategorie2.skrot "
                     . " FROM z_Kategorie AS z_Kategorie2 INNER JOIN (z_EtapyKat INNER JOIN z_Kategorie ON z_EtapyKat.id_kat = z_Kategorie.id_kat) ON z_EtapyKat.id_kat2 = z_Kategorie2.id_kat "
                     . " WHERE z_EtapyKat.id_wys = '$id_wys' AND id_co = '$teraz_omawiane' ";
              $idzty = mysql_query($zapty) or die('mysql_query');
              $danety = mysql_fetch_row($idzty);
	      
	      echo '<h3>'.$da[1];
	      
	      if ($_SESSION['boss'] >= 1) {
	        echo ' ('.$danety[0].')</h3> - '.$danety[1].' ['.$danety[2].']<br/><br/>';
	      }
	      
	      echo '
	      
	      <table class="wyscig">
	      <tr><td class="wyscig11">Lp.</td><td class="wyscig2">Kolarz</td><td class="wyscig3">Kraj</td><td class="wyscig4">Ekipa</td><td class="wyscig5">czas/strata</td><td class="wyscig5">Punkty';
	      if($_SESSION['logowanie'] == 'poprawne') {
                   echo '<td class="wyscig6">właściciel</td></tr>
		   ';
                 } else {
                   echo '</td></tr>
		   ';
                 }
	      
              
	      while ($dane = mysql_fetch_row($idz)) {
                 echo '
		 <tr><td>'.$dane[1].'</td><td><a href="kol.php?id_kol='.$dane[10].'">'.$dane[2].' <b>'.$dane[3].'</b></a></td><td><a href="nat.php?id_nat='.$dane[9].'"><img src="img/flagi/'.$dane[5].'" border=0 /></a></td><td><a href="team.php?id_team='.$dane[8].'">'.$dane[6].'</a></td><td style="text-align: right;">'.$dane[13].'</td><td style="text-align: right;">'.$dane[11];
		 
		 if($_SESSION['logowanie'] == 'poprawne') {
                  
		  //$sql25 = " SELECT id_zgl "
		  //       . " FROM zgloszenia "
		  //       . " WHERE id_wys = '$id_wys' AND id_kol='$dane[10]'  ";
                  //$zap25 = mysql_query($sql25) or die('mysql_query');
                  //if (mysql_num_rows($zap25) > 0  ) {
                  //  echo '</td><td><a href="user.php?id_user='.$dane[12].'">'.$dane[7].'</a>';
                  //} else {
                    echo '</td><td>'.$dane[7];
                  //}
		  
                 } else {}
		 echo '
		 </td></tr>
		 ';
 	       }

              echo '</table>
	      ';
            }

            
            
          }
  
}

	echo koniec(); 
        ?>
         
    


    
