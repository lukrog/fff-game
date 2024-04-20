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
      $sql = " SELECT nazwa, klaPC, DATE(dataP), dataK FROM Wyscigi WHERE id_wys = '$id_wys' ";
      $zap = mysql_query($sql) or die('mysql_query');
      $dan = mysql_fetch_row($zap);
      echo '<h4>Wybrałeś do podliczenia wyścig: '.$dan[0].' ('.$dan[1].')</h4>';
      echo 'data pocz.: '.$dan[2].'<br/>';
      echo 'data końca: '.$dan[3].'<br/>';
      $ile_dni_różnicy = strtotime($dan[3]) - strtotime($dan[2]);
      $ile_dni_różnicy = date('d',$ile_dni_różnicy);
      echo 'wyścig ten trwa '.$ile_dni_różnicy.' dni<br/><br/>';
      if ($ile_dni_różnicy == 1) 
      {
        echo 'klasyk';
        echo '<br/> wybrałeś datę etapu: '.$_POST['data0'];
        echo '<br/> wybrałeś kategorię etapu:   '.$_POST['kat1_0'];
        echo '<br/> wybrałeś kategorę  wyścigu: '.$_POST['kat'];
        echo '<br/> wybrałeś wyścig:            '.$id_wys;
        echo '<br/> wybrałeś klasyfikacje (0)   ';
        echo '<br/> wybrałeś punktacje wyścigu: '.$_POST['pun'];
        echo '<br/> wybrałeś peleton na miejscu:'.$_POST['peleton_0'];
        
        echo '<br/><br/> sprawdzam, czy już są dane o tym etapie --> ';
        
        $sql1 = "SELECT * FROM z_EtapyKat WHERE id_wys = '$id_wys' ";
        $zap1 = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) == 0) {
          echo 'BRAK -> Tworzę nową pozycję:';
          $sql3 = " SELECT id_ek FROM z_EtapyKat ORDER BY id_ek DESC LIMIT 0, 1 ";
          $zap3 = mysql_query($sql3) or die('mysql_query');
          $dan3 = mysql_fetch_row($zap3);
          $numer = $dan3[0] + 1;
          echo ' nr.: '.$numer.';1900-01-01;0;0;'.$id_wys.';0;0';
          
          $zapytanie = " INSERT INTO z_EtapyKat VALUES ('$numer', 1900-01-01, 0, 0, '$id_wys', 0, 0, 0) ";
          $idzapytania = mysql_query($zapytanie);
          
        } else { echo 'Jest';}
        
        echo '<br/><br/>';
        
        $sql4 = "SELECT id_ek FROM z_EtapyKat WHERE id_wys = '$id_wys' ";
        $zap4 = mysql_query($sql4) or die('mysql_query');
        $dan4 = mysql_fetch_row($zap4);
        
        
        $data = $_POST['data0'];
        $kat1 = $_POST['kat1_0'];
        $kat = $_POST['kat'];
        $pun = $_POST['pun'];
        $pel = $_POST['peleton_0'];
        
        echo $dan4[0].';'.$data.';'.$kat1.';'.$kat.';'.$id_wys.';0;'.$pun.';'.$pel.'<br/><br/>';
        
        $zapytanie1 = " UPDATE z_EtapyKat SET data = '$data', id_kat = '$kat1', id_kat2 = '$kat', id_pun = '$pun', pierwszy_z_pel = '$pel' WHERE id_ek = '$dan4[0]'";
        $idzapytania1 = mysql_query($zapytanie1);
        
        
      } else {
        echo 'etapowy';
        
        echo '<br/>wybrałeś kategorię wyścigu: '.$_POST['kat'];
        echo '<br/>wybraleś punktację wyścigu: '.$_POST['pun'].'<br/><br/>';
        $katW = $_POST['kat']-1;
        $punW = $_POST['pun'];
        
        $ile= 1 * $_POST['iledni'];
        
        if ($_POST['pro'] == "on") {
          $zacznij = 0;
        } else {
          $zacznij = 1;
        }
        
        
        
        for ($ii = $zacznij; $ii <= $ile; $ii++) {
	  $i = ($ii + 100)*10;
	  $data = $_POST['data'.$i];
	  $etap = $_POST['etap'.$i];
	  $kat1 = $_POST['kat1_'.$i];
	  $pun = $_POST['pun_'.$i];
	  $peleton = $_POST['peleton_'.$i];
          echo 'etap'.$ii.' ('.$i.' - '.$etap.'): '.$data.' '.$kat1.' '.$pun.' '.$peleton.'<br/>';
          
          $sql2 = " SELECT * FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$etap' ";
          $zap2 = mysql_query($sql2) or die('mysql_query');
          if(mysql_num_rows($zap2) == 0) {
            echo 'brak tego etapu w bazie <br/>';
            $sql3 = " SELECT id_ek FROM z_EtapyKat ORDER BY id_ek DESC LIMIT 0, 1 ";
            $zap3 = mysql_query($sql3) or die('mysql_query');
            $dan3 = mysql_fetch_row($zap3);
            $numer = $dan3[0] + 1;

            $zapytanie2 = " INSERT INTO z_EtapyKat VALUES ('$numer', 1900-01-01, 0, 0, '$id_wys', '$etap', 0, 0) ";
            $idzapytania2 = mysql_query($zapytanie2);
          } else {
            echo 'etap jest w bazie<br/>';
          }
          
          $sql4 = "SELECT id_ek FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$etap' ";
          $zap4 = mysql_query($sql4) or die('mysql_query');
          $dan4 = mysql_fetch_row($zap4);
          
          if ($pun == 0) 
	  { 
	    $pun = $punW;
	  }
          
          $zapytanie3 = " UPDATE z_EtapyKat SET data = '$data', id_kat = '$kat1', id_kat2 = '$katW', id_pun = '$pun', pierwszy_z_pel = '$peleton' WHERE id_ek = '$dan4[0]'";
          $idzapytania3 = mysql_query($zapytanie3);
          
          
        }
        $katW = $_POST['kat'];
        $i = 0;
	  $data = $_POST['data'.$i];
	  $kat1 = $_POST['kat1_'.$i];
	  $pun = $_POST['pun_'.$i];
	  $peleton = $_POST['peleton_'.$i];
          echo 'generalka: '.$data.' '.$kat1.' '.$pun.' '.$peleton.'<br/>';
          
          $sql2 = " SELECT * FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i' ";
          $zap2 = mysql_query($sql2) or die('mysql_query');
          if(mysql_num_rows($zap2) == 0) {
            echo 'brak tego etapu w bazie <br/>';
            $sql3 = " SELECT id_ek FROM z_EtapyKat ORDER BY id_ek DESC LIMIT 0, 1 ";
            $zap3 = mysql_query($sql3) or die('mysql_query');
            $dan3 = mysql_fetch_row($zap3);
            $numer = $dan3[0] + 1;

            $zapytanie2 = " INSERT INTO z_EtapyKat VALUES ('$numer', 1900-01-01, 0, 0, '$id_wys', '$i', 0, 0) ";
            $idzapytania2 = mysql_query($zapytanie2);
          } else {
            echo 'etap jest w bazie<br/>';
          }
          
          $sql4 = "SELECT id_ek FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i' ";
          $zap4 = mysql_query($sql4) or die('mysql_query');
          $dan4 = mysql_fetch_row($zap4);
          
          if ($pun == 0) 
	  { 
	    $pun = $punW;
	  }
          
          $zapytanie3 = " UPDATE z_EtapyKat SET data = '$data', id_kat = '$kat1', id_kat2 = '$katW', id_pun = '$pun', pierwszy_z_pel = '$pel' WHERE id_ek = '$dan4[0]'";
          $idzapytania3 = mysql_query($zapytanie3);
          $katW = $_POST['kat']-1;
          $i = 1;
	  $data = $_POST['data'.$i];
	  $kat1 = $_POST['kat1_'.$i];
	  $pun = $_POST['pun_'.$i];
	  $peleton = $_POST['peleton_'.$i];
          echo 'punktowa: '.$data.' '.$kat1.' '.$pun.' '.$peleton.'<br/>';
          
          $sql2 = " SELECT * FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i' ";
          $zap2 = mysql_query($sql2) or die('mysql_query');
          if(mysql_num_rows($zap2) == 0) {
            echo 'brak tego etapu w bazie <br/>';
            $sql3 = " SELECT id_ek FROM z_EtapyKat ORDER BY id_ek DESC LIMIT 0, 1 ";
            $zap3 = mysql_query($sql3) or die('mysql_query');
            $dan3 = mysql_fetch_row($zap3);
            $numer = $dan3[0] + 1;

            $zapytanie2 = " INSERT INTO z_EtapyKat VALUES ('$numer', 1900-01-01, 0, 0, '$id_wys', '$i', 0, 0) ";
            $idzapytania2 = mysql_query($zapytanie2);
          } else {
            echo 'etap jest w bazie<br/>';
          }
          
          $sql4 = "SELECT id_ek FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i' ";
          $zap4 = mysql_query($sql4) or die('mysql_query');
          $dan4 = mysql_fetch_row($zap4);
          
          if ($pun == 0) 
	  { 
	    $pun = $punW;
	  }
          
          $zapytanie3 = " UPDATE z_EtapyKat SET data = '$data', id_kat = '$kat1', id_kat2 = '$katW', id_pun = '$pun', pierwszy_z_pel = '$pel' WHERE id_ek = '$dan4[0]'";
          $idzapytania3 = mysql_query($zapytanie3);  
        
        
        
        $i = 2;
	  $data = $_POST['data'.$i];
	  $kat1 = $_POST['kat1_'.$i];
	  $pun = $_POST['pun_'.$i];
	  $peleton = $_POST['peleton_'.$i];
          echo 'górska: '.$data.' '.$kat1.' '.$pun.' '.$peleton.'<br/>';
          
          $sql2 = " SELECT * FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i' ";
          $zap2 = mysql_query($sql2) or die('mysql_query');
          if(mysql_num_rows($zap2) == 0) {
            echo 'brak tego etapu w bazie <br/>';
            $sql3 = " SELECT id_ek FROM z_EtapyKat ORDER BY id_ek DESC LIMIT 0, 1 ";
            $zap3 = mysql_query($sql3) or die('mysql_query');
            $dan3 = mysql_fetch_row($zap3);
            $numer = $dan3[0] + 1;

            $zapytanie2 = " INSERT INTO z_EtapyKat VALUES ('$numer', 1900-01-01, 0, 0, '$id_wys', '$i', 0, 0) ";
            $idzapytania2 = mysql_query($zapytanie2);
          } else {
            echo 'etap jest w bazie<br/>';
          }
          
          $sql4 = "SELECT id_ek FROM z_EtapyKat WHERE id_wys = '$id_wys' AND id_co = '$i' ";
          $zap4 = mysql_query($sql4) or die('mysql_query');
          $dan4 = mysql_fetch_row($zap4);
          
          if ($pun == 0) 
	  { 
	    $pun = $punW;
	  }
          
          $zapytanie3 = " UPDATE z_EtapyKat SET data = '$data', id_kat = '$kat1', id_kat2 = '$katW', id_pun = '$pun', pierwszy_z_pel = '$pel' WHERE id_ek = '$dan4[0]'";
          $idzapytania3 = mysql_query($zapytanie3);
        
        
        
        
        
        
      }
      
      
    
    } else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
    }
    } else {
      echo 'Musisz się zalogować';
    }
    
    
    
    echo koniec();
?>
