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
   <title>FFF - obliczanie wyścigu</title>
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
         $id_wys =  $_POST['id_wys'];
         if ($_SESSION['boss'] >= 1) {
	 $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, DATE(Wyscigi.dataP), Wyscigi.dataK FROM Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat WHERE (((Wyscigi.id_wys)= '$id_wys' ))";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  echo '<form action="WKLEP_WYNIKI_POTW.php" method="post">';
  	  
	  echo '<table id="menu2">';
          echo '<tr><td><i>id wyścigu: </i></td><td>'.$id_wys.'</td></tr>';
          echo '<tr><td><i>nazwa wyścigu: </i></td><td>[size=20]'.$dane[1].'[/size]</td></tr>';
          echo '<tr><td><i>kraj rozgrywania: </i></td><td>'.$dane[3].' <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>';
          echo '<tr><td><i>klasyfikacja UCI: </i></td><td>'.$dane[5].'</td></tr>';
          echo '<tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr>';
          echo '<tr><td><i>Data początku: </i></td><td>'.$dane[7].'</td></tr>';
          echo '<tr><td><i>Data końca: </i></td><td>'.$dane[8].'</td></tr>';
          //Sprawdzamy ile dni trwa wyścig.
          $ile_dni_różnicy = strtotime($dane[8]) - strtotime($dane[7]);
          $ile_dni_różnicy = date('d',$ile_dni_różnicy);
          echo '<tr><td><i>w związku z tym trwa dni: </i></td><td>'.$ile_dni_różnicy.'</td></tr>';
          //czy to jedno czy wieloetapowy.
          if ($ile_dni_różnicy == 1) {
            $jaki_wyscig = "jednodniowy";
          } else {
            $jaki_wyscig = "wielodniowy";
          }
          echo '<tr><td><i>i jest to wyścig:</i></td><td>'.$jaki_wyscig.'</td></tr>';
          
          //sprawdzamy, czy był dodatkowy etap:
          echo '<input type="hidden" name="dod" value="'.$_POST['dod'].'" />';
          if ($_POST['dod'] == "on") {
             $ile_dni_różnicywyslane = $ile_dni_różnicy + 1;
          } else {
             $ile_dni_różnicywyslane = $ile_dni_różnicy;
          }
          echo '<tr><td><i>a to będzie etapów: </i></td><td>'.$ile_dni_różnicywyslane.'</td></tr>';
          
          echo '<tr><td><i>podaj kategorię wyścigu: </i></td><td>';
          
          //sprawdzamy czy było już wklepywane kategorie
	  $sqlmk = " SELECT id_kat2, id_pun, data, id_kat, pierwszy_z_pel FROM z_EtapyKat WHERE id_wys = '$id_wys' ORDER BY id_co";
          $zapmk = mysql_query($sqlmk) or die('mysql_query');
          if (mysql_num_rows($zapmk) == 0 ) {
	    $brakwklepanych = "OK";
 	  } else {
	    $brakwklepanych = "NIE";
	  }
         
          $danmk = mysql_fetch_row($zapmk);
          
	  //jeśli jest to jednodniowy to
	  if ($ile_dni_różnicywyslane == 1) {
	  
        
          echo '<select name="kat" class="form3">';
          echo '<option value=0>---</option>';
        
          $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat < -4";
          $zapop = mysql_query($sqlop) or die('mysql_query');
          while ($danop = mysql_fetch_row($zapop)) {
            echo '<option ';
	      if ($danop[0] == $danmk[0]) {
                echo 'SELECTED ';
              }
	    echo  ' value='.$danop[0].'>'.$danop[1].'</option>';
          }
          
          } else {
	    // a jeśli jest to etapówka:
	    echo '<select name="kat" class="form3">';
            echo '<option value=0>---</option>';
            $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat = -1 OR id_kat = -3";
            $zapop = mysql_query($sqlop) or die('mysql_query');
            while ($danop = mysql_fetch_row($zapop)) {
              echo '<option ';
              if ($danmk[0] == $danop[0]) 
	     { 
	        echo 'SELECTED ';
	     }
	     echo 'value='.$danop[0].'>'.$danop[1].'</option>
	     ';
           }
          
	  }
	  echo '</select></td></tr>';
	  
	  //punktacja wyścigu
	  echo '<tr><td><i>podaj punktację wyścigu: </i></td><td>';
	  $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
          $zapkm = mysql_query($sqlkm) or die('mysql_query');
        
        
          echo ' 
	  <select name="pun" class="form3">
	  <option value=0>---</option>';
          while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option ';
          if ($dankm[0] == $danmk[1]) {
            echo 'SELECTED ';
          }
          echo ' value = '.$dankm[0].'>'.$dankm[1].'</option>
	  ';
        }
        
        echo '</select></td><td>';
	  
          //koniec tabeli
	  echo '</table>';
	  
	 //teraz już mamy informację, czy to klasyk czy etapówka i właściwie to trochę nam podzieli.
	 //ale tak czy inaczej trzeba dodać klasyfik generalną i tych co nie dojechali do mety.
	 	
	 // TU MAMY WKLEPYWANIE WYNIKÓW POSZCZEGÓLNEGO ETAPU!!
         //echo '<input type="hidden" name="idwys1" value="" />';
         
         echo '<h5><font color=green> Podaj wyniki końcowe:</font></h5>
	       <i>(wrzucamy z generalki wszystkie wyniki a z etapów 20 [w ważniejszych wyścigach dajemy więcej w etapach])</i>';
         
         //tu sprawdzamy i dla jednodniowego dajemy kategorię
          
	  
	  echo '<table class="wyscig">';
	  if ($ile_dni_różnicywyslane == 1) {
	  echo '
          <tr><td>Co?</td><td>kiedy</td><td>Pel.</td><td>
	  <tr><td>Klasyfikacja generalna (0): </td><td> 
	  ';
	 
          echo '<input type="text" class="form" name="data00" value="'.$dane[8].'" /></td><td>
	  ';
        
        
        if ($danmk[4] == "") {
	  $danmk[4] = 0;
	}
        
        echo '<input type="text" class="form4" name="peleton_00" value="'.$danmk[4].'" /></td></tr>
	';
        
        echo '<tr><td colspan="3">
	<select name="kat1_00" class="form3">
	';
     
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ORDER BY id_kat ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<option value=0>---</option>';
        
	while ($danop = mysql_fetch_row($zapop)) {
          echo '<option value='.$danop[0].'>'.$danop[2].'</option>
	  ';
        }
        echo '</select>
	
	</td></tr>
	';
	
	} else {
	  echo '<input type="hidden" class="form" name="data00" value="'.$dane[8].'" /></td><td>
	  ';
	}
	echo '
	<tr><td colspan="3">';
        
        
        
	//po kategorii
         
         echo '<input type="hidden" name="idwys" value="'.$id_wys.'" />';
	 echo '<TEXTAREA name="wynikiKON" rows="5" cols="50">Tu wklej dane z excela</TEXTAREA><br/><br/>';
	 
	 echo '<font color=green><b>Podaj kolarzy którzy nie ukończyli</b></font><br/>';
	 echo '<TEXTAREA name="wynikiDNE" rows="5" cols="50"></TEXTAREA>';
	 
	 echo '</td></tr>';
         echo '</table>
	';
         
         //i teraz jeśli  etapowy to tu pojawią się etapy.
         if ($ile_dni_różnicywyslane == 1) {} else {
           //podajemy wszystkich liderów :D
           echo '<font color=green><b>Podaj liderów poszczególnych etapów (w kolejności od pierwszego do ostatniego)</b></font>
	         <TEXTAREA name="wyniki_10lider" rows="5" cols="50"></TEXTAREA>';
           
           
	   //na początek czy był prolog?
	    if ($_POST['pro'] == "on") {
	      echo '<br/><br/>był prolog więc zaczynamy od etapu 0 (1000)<br/><br/>';
	      $poczatek = 0;
	      echo '<input type="hidden" name="pro" value=on />';
	    } else {
	      echo '<br/><br/>prologu nie było więc zaczynamy od etapu 1 (1010) [bo np etap 1a to 1011 a 4b to 1042]<br/><br/>';
	      $poczatek = 1;
	      echo '<input type="hidden" name="pro" value=off />';
	    }
	    //echo $poczatek;
	    
	    //sprawdzamy czy jest kategoria dla tego etapu 
	      $sql_kat = "SELECT id_kat, id_kat2, id_wys, id_co, pierwszy_z_pel, data FROM z_EtapyKat WHERE id_wys='$id_wys' AND id_co > 10 ORDER BY id_co";
	      $zapyt_kat = mysql_query($sql_kat) or die('mysql_query');
	      //jeżeli coś dodane to 
	      if (mysql_num_rows($zapyt_kat) > 0) {
	        //będzie można dodawać wyniki
	        $czy_cos_dodane = 1;
	      } else {
	        //wszystko od 0
	        $czy_cos_dodane = 0;
	      }
 
	    for ($i=$poczatek; $i <= $ile_dni_różnicywyslane+$poczatek+1; $i++) {
	      echo '<table class="wyscig">';  
	      echo '
                  <tr><td>Co?</td><td>kiedy</td><td>Pel.</td><td>
	          ';
	      $numer_etapu = ($i *10)+1000;    
	      if ($czy_cos_dodane == 1) {
	        $dane_kat = mysql_fetch_row($zapyt_kat);
	        $numer_etapu = $dane_kat[3];
	        $kategoria = $dane_kat[0];
	        $peleton = $dane_kat[4];
	        $data_kat = $dane_kat[5];
	      } else {
	        $kategoria = 0;
	        $peleton = 0;
	        $data_kat = strtotime($dane[7]) + ($i-$poczatek)*24*3600;
                $data_kat = date('Y-m-d',$data_kat);
	      }
	      
	      echo '<tr><td><b>Etap '.$i.'</b></td><td>';
	      //data etapu
	      echo '<input type="text" class="form" name="data'.$i.'" value="'.$data_kat.'" /></td><td>
	            <input type="text" class="form4" name="peleton_'.$i.'" value="'.$peleton.'" /></td></tr>
		    ';
	      echo '<tr><td>
	            <input type="text" class="form" name="etap'.$i.'" value="'.$numer_etapu.'" /> 
		    </td><td colspan=2>';
	      $sql_kat2 = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ORDER BY id_kat ";
              $zap_kat2 = mysql_query($sql_kat2) or die('mysql_query');
              echo '<select name="kat1_'.$i.'" class="form3"> 
	      <option value=0>---</option>';
              while ($dan_kat2 = mysql_fetch_row($zap_kat2)) {
                echo '<option';
	        if ($dan_kat2[0] == $kategoria) {
                 echo ' SELECTED';
                }
	        echo ' value='.$dan_kat2[0].'>'.$dan_kat2[2].'</option>';
             }
             echo '</select>';
	      
	      echo '</td></tr>
	            <tr><td colspan=4>';
		    echo '<TEXTAREA name="wyniki_'.$i.'" rows="5" cols="50"></TEXTAREA>';
		    
		    echo '
	            </table><br/>';
	    }
	    
	 }
         
         
         //Zatwierdź cały forumularz.
         echo '<input class="form2" type=submit value="Zatwierdź" />';
         echo '</form>';
         
         
         
         
         
         
         } else {
           // jeśli nie masz uprawnień
	   echo '<h4>Nie masz uprawnień do tej strony</h4>';
         }
         
         
         
         
         echo koniec();
      ?>
  
    
    
    
   
