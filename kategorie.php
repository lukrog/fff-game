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
   <title>FFF - panel zarządzający</title>
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
    if($_SESSION['logowanie'] == 'poprawne') {
    if ($_SESSION['boss'] >= 1) {
      
      $id_wys = $_POST['id_wys'];
      $sql = " SELECT nazwa, klaPC, DATE(dataP), dataK, klaUCI FROM Wyscigi WHERE id_wys = '$id_wys' ";
      $zap = mysql_query($sql) or die('mysql_query');
      $dan = mysql_fetch_row($zap);
      echo '<h4>Wybrałeś do podliczenia wyścig: '.$dan[0].' ('.$dan[1].'-'.$dan[4].')</h4>';
      echo 'data pocz.: '.$dan[2].'<br/>';
      echo 'data końca: '.$dan[3].'<br/>';
      $ile_dni_różnicy = strtotime($dan[3]) - strtotime($dan[2]);
      $ile_dni_różnicy = date('d',$ile_dni_różnicy);
      
      if ($_POST['dod'] == "on") {
          $ile_dni_różnicywyslane = $ile_dni_różnicy + 1;
      } else {
        $ile_dni_różnicywyslane = $ile_dni_różnicy;
      }
      
      echo 'wyścig ten trwa '.$ile_dni_różnicy.' dni<br/><br/>';
      echo '<form action="kategorieEXE.php" method="POST">';
      echo '<input type="hidden" name="id_wys" value="'.$id_wys.'" />';
      echo '<input type="hidden" name="iledni" value="'.$ile_dni_różnicywyslane.'" />';
      echo $POST['pro'];
      $data = strtotime($dan[2]) - 24*3600;
      $data = date('Y-m-d',$data);
      if ($ile_dni_różnicy == 1) {
        echo 'klasyk';
        $data = strtotime($data) + 24*3600;
        $data = date('Y-m-d',$data);
        
        echo ' '.$data.'<br/>';
        echo 'Kategoria wyścigu: 
	';
        
        $sqlmk = " SELECT id_kat2, id_pun, data, id_kat, pierwszy_z_pel FROM z_EtapyKat WHERE id_wys = '$id_wys'";
        $zapmk = mysql_query($sqlmk) or die('mysql_query');
        if (mysql_num_rows($zapmk) == 0 ) {
	  $brakwklepanych = "OK";
	} else {
	  $brakwklepanych = "NIE";
	}
        
        $danmk = mysql_fetch_row($zapmk);
        
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
        echo '</select><br/>';
        
        
        

        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        
        
        echo 'Punktacja Wyścigu: 
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
        
        echo '</select><br/><br/>';
        
        
        echo '<table class="wyscig">
	<tr><td>Co?</td><td>kiedy</td><td>Pel.</td><td>
	<tr><td>Klasyfikacja generalna (0): </td><td> 
	';
        
        
        
        if (mysql_num_rows($zapmk) > 0) {
          echo '<input type="text" class="form" name="data0" value="'.$danmk[2].'" /></td><td>
	  ';
        } else {
          echo '<input type="text" class="form" name="data0" value="'.$dan[3].'" /></td><td>
	  ';
        }
        
        
        
        echo '<input type="text" class="form4" name="peleton_0" value="'.$danmk[4].'" /></td></tr>
	';
        
        echo '<tr><td colspan="3">
	<select name="kat1_0" class="form3">
	';
     
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ORDER BY id_kat ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<option value=0>---</option>';
        
	while ($danop = mysql_fetch_row($zapop)) {
          echo '<option';
	  if ($brakwklepanych == "OK") {
	    
	    if ($danop[0] == 'cośtam z wczytania') {
	      echo ' SELECTED';
	    }
	  
	  } else {
	    if ($danop[0] == $danmk[3]) {
              echo ' SELECTED';
            }
          }
          
	  echo ' value='.$danop[0].'>'.$danop[2].'</option>
	  ';
        }
        echo '</select>
	
	</td></tr>';
        
        
        echo '</table>
	';
        
        
        
        
        
        
        
        
        
        
        
        
        
        
      } else {
        
        
        if ($_POST['dod'] == "on") {
          $ile_dni_różnicy = $ile_dni_różnicy +1;
        }
        $sqlmk9 = " SELECT id_kat2 FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = 0 ";
        $zapmk9 = mysql_query($sqlmk9) or die('mysql_query');
        $danmk9 = mysql_fetch_row($zapmk9);
        
        echo 'Kategoria wyścigu: ';
        echo '<select name="kat" class="form3">';
        echo '<option value=0>---</option>';
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat = -1 OR id_kat = -3";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        while ($danop = mysql_fetch_row($zapop)) {
          echo '<option ';
          if ($danmk9[0] == $danop[0]) 
	  { 
	    echo 'SELECTED ';
	  }
	  echo 'value='.$danop[0].'>'.$danop[1].'</option>
	  ';
        }
        echo '</select><br/>
	';
        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        
        echo 'Punktacja Wyścigu: 
	<select name="pun" class="form3">
	<option value=0>---</option>
	';
        while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option value = '.$dankm[0].'>'.$dankm[1].'</option>
	  ';
        }
        echo '</select><br/><br/>';
        echo '<table class="wyscig">';
        $string = '<tr><td>Co?</td><td>kiedy</td><td>punktacja <br/>jeśli inna niż wyścig</td><td>Pel.</td><td>
	';
      if ($_POST['pro'] == "on") {
        $ile = 1*($ile_dni_różnicy - 1);
        echo 'bez prologu '.$ile.'<br/>';
	echo $string;
	echo '<tr><td>prolog (1000) </td><td>
	
	<input type="hidden" class="form4" name="etap1000" value="1000" />
	
	';
	$data = strtotime($data) + 24*3600;
        $data = date('Y-m-d',$data);
        $i = 1000;
        $sqlmk8 = " SELECT data, id_kat, id_pun, pierwszy_z_pel FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i'" ;
        $zapmk8 = mysql_query($sqlmk8) or die('mysql_query');
        $danmk8 = mysql_fetch_row($zapmk8);
        if (mysql_num_rows($zapmk8) > 0) {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$danmk8[0].'" /></td><td>
	  ';
        } else {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$data.'" /></td><td>
	  ';
        }
        
        
        
        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        echo '<select name="pun_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option';
	  if ($dankm[0] == $danmk8[2]) {
            echo ' SELECTED';
          }
	  echo ' value = '.$dankm[0].'>'.$dankm[1].'</option>';
        }
        echo '</select>';
        echo '</td><td>';
        
        
        echo '<input type="text" class="form4" name="peleton_100" value="'.$danmk8[3].'" /></td></tr>';
        echo '<tr><td></td><td colspan="3">';
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<select name="kat1_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($danop = mysql_fetch_row($zapop)) {
          echo '<option';
	  if ($danop[0] == $danmk8[1]) {
            echo ' SELECTED';
          }
	  echo ' value='.$danop[0].'>'.$danop[2].'</option>';
        }
        echo '</select>';
        echo '</td></tr><tr><td colspan="4">----------------------------------------------------------------------------------------------------------------------------------------</td></tr>';
        
        echo '<input type="hidden" class="form4" name="pro" value="on" />';
      } else {
        $ile = (1 * $ile_dni_różnicy);
        echo 'bez prologu '.$ile.'<br/>';
        echo $string;
        echo '<input type="hidden" class="form4" name="pro" value="off" />';
      }
      
      
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ORDER BY id_kat ";
        for ($ii=1; $ii <= $ile; $ii++)
        {
          $i= ($ii + 100)*10;
          
	  $data = strtotime($data) + 24*3600;
          $data = date('Y-m-d',$data);
          
          echo '<tr><td>Etap '.$ii.':  </td><td>';
          $ij = $ii - 1;
          $sqlmk8 = " SELECT data, id_kat, id_pun, pierwszy_z_pel, id_co FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co > 1000 ORDER BY id_co LIMIT $ij, 1" ;
          $zapmk8 = mysql_query($sqlmk8) or die('mysql_query');
          $danmk8 = mysql_fetch_row($zapmk8);
        if (mysql_num_rows($zapmk8) > 0) {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$danmk8[0].'" /></td><td>';
        } else {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$data.'" /></td><td>';
        }
        
        
        
        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        echo '<select name="pun_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option';
	  if ($dankm[0] == $danmk8[2]) {
            echo ' SELECTED';
          }
	  echo ' value='.$dankm[0].'>'.$dankm[1].'</option>';
        }
        echo '</select>';
        echo '</td><td>';
        echo '<input type="text" class="form4" name="peleton_'.$i.'" value="'.$danmk8[3].'" /></td></tr>';
        
        echo '<tr><td>';
        
        if ($danmk8[4] <> "") {
	  $coijak = $danmk8[4];
	} else {
	  $coijak = ($ii +100) * 10;
	}
        
        echo '<input type="text" class="form" name="etap'.$i.'" value="'.$coijak.'" />';
        
	echo '</td><td colspan="3">';
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ORDER BY id_kat ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<select name="kat1_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($danop = mysql_fetch_row($zapop)) {
          echo '<option';
	  if ($danop[0] == $danmk8[1]) {
            echo ' SELECTED';
          }
	  echo ' value='.$danop[0].'>'.$danop[2].'</option>';
        }
        echo '</select>';
        echo '</td></tr><tr><td colspan="4">----------------------------------------------------------------------------------------------------------------------------------------</td></tr>';
        
        
        
        }
        
        
        
        echo '<tr><td>Klasyfikacja generalna (0): </td><td> ';
	

        $i = 0;
        $sqlmk8 = " SELECT data, id_kat, id_pun, pierwszy_z_pel FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i'" ;
        $zapmk8 = mysql_query($sqlmk8) or die('mysql_query');
        $danmk8 = mysql_fetch_row($zapmk8);
        if (mysql_num_rows($zapmk8) > 0) {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$danmk8[0].'" /></td><td>';
        } else {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$data.'" /></td><td>';
        }
        
        
        
        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        echo '<select name="pun_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option';
	  if ($dankm[0] == $danmk8[2]) {
            echo ' SELECTED';
          }
	  echo ' value = '.$dankm[0].'>'.$dankm[1].'</option>';
        }
        echo '</select>';
        echo '</td><td>';
        echo '<input type="text" class="form4" name="peleton_100" value="'.$danmk8[3].'" /></td></tr>';
        
        echo '<tr><td></td><td colspan="3">';
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<select name="kat1_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($danop = mysql_fetch_row($zapop)) {
          echo '<option';
	  if ($danop[0] == $danmk8[1]) {
            echo ' SELECTED';
          }
	  echo ' value='.$danop[0].'>'.$danop[2].'</option>';
        }
        echo '</select>';
        echo '</td></tr><tr><td colspan="4">----------------------------------------------------------------------------------------------------------------------------------------</td></tr>';
        
        
        
        
        echo '<tr><td>Klasyfikacja punktowa (1): </td><td> ';
	

        $i = 1;
        $sqlmk8 = " SELECT data, id_kat, id_pun, pierwszy_z_pel FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i'" ;
        $zapmk8 = mysql_query($sqlmk8) or die('mysql_query');
        $danmk8 = mysql_fetch_row($zapmk8);
        if (mysql_num_rows($zapmk8) > 0) {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$danmk8[0].'" /></td><td>';
        } else {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$data.'" /></td><td>';
        }
        
        
        
        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        echo '<select name="pun_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option';
	  if ($dankm[0] == $danmk8[2]) {
            echo ' SELECTED';
          }
	  echo ' value = '.$dankm[0].'>'.$dankm[1].'</option>';
        }
        echo '</select>';
        echo '</td><td>';
        echo '<input type="text" class="form4" name="peleton_100" value="'.$danmk8[3].'" /></td></tr>';
        
        echo '<tr><td></td><td colspan="3">';
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<select name="kat1_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($danop = mysql_fetch_row($zapop)) {
          echo '<option';
	  if ($danop[0] == $danmk8[1]) {
            echo ' SELECTED';
          }
	  echo ' value='.$danop[0].'>'.$danop[2].'</option>';
        }
        echo '</select>';
        echo '</td></tr><tr><td colspan="4">----------------------------------------------------------------------------------------------------------------------------------------</td></tr>';
        
        
        
        
        
        
        echo '<tr><td>Klasyfikacja górska (2): </td><td> ';

        $i = 2;
        $sqlmk8 = " SELECT data, id_kat, id_pun, pierwszy_z_pel FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i'" ;
        $zapmk8 = mysql_query($sqlmk8) or die('mysql_query');
        $danmk8 = mysql_fetch_row($zapmk8);
        if (mysql_num_rows($zapmk8) > 0) {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$danmk8[0].'" /></td><td>';
        } else {
          echo '<input type="text" class="form" name="data'.$i.'" value="'.$data.'" /></td><td>';
        }
        
        
        
        
        $sqlkm = " SELECT id_pun, tresc FROM z_punkty ";
        $zapkm = mysql_query($sqlkm) or die('mysql_query');
        echo '<select name="pun_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($dankm = mysql_fetch_row($zapkm)) {
          echo '<option';
	  if ($dankm[0] == $danmk8[2]) {
            echo ' SELECTED';
          }
	  echo ' value = '.$dankm[0].'>'.$dankm[1].'</option>';
        }
        echo '</select>';
        echo '</td><td>';
        echo '<input type="text" class="form4" name="peleton_100" value="'.$danmk8[3].'" /></td></tr>';
        
        echo '<tr><td></td><td colspan="3">';
        $sqlop = "SELECT id_kat, skrot, kategoria FROM z_Kategorie WHERE id_kat > 0 AND kategoria > \"\" ";
        $zapop = mysql_query($sqlop) or die('mysql_query');
        echo '<select name="kat1_'.$i.'" class="form3">';
        echo '<option value=0>---</option>';
        while ($danop = mysql_fetch_row($zapop)) {
          echo '<option';
	  if ($danop[0] == $danmk8[1]) {
            echo ' SELECTED';
          }
	  echo ' value='.$danop[0].'>'.$danop[2].'</option>';
        }
        echo '</select>';
        echo '</td></tr>';
        
        
        echo '</table>';
      }
    echo '<input class="form2" type="submit" name="zatwierdz" value="zatwierdź" />';
    echo '</form>';
    
    
    
    
    
    
    
    
    } else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
    }
    } else {
      echo 'Musisz się zalogować';
    }
    
    
    
    echo koniec();
    ?>
    
