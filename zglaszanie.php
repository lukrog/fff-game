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
   <title>FFF - zglaszanie kolarzy</title>
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
    $id_wys = $_GET['id_wys'];
    $sql1= " SELECT ilu_kol, dataP, nazwa "
         . " FROM Wyscigi "
         . " WHERE ( ( id_wys = '$id_wys'))";
    $runsql1 = mysql_query($sql1) or die('mysql_query');
    $dan = mysql_fetch_row($runsql1);
    
    echo 'Zgłaszasz kolarzy do wyścigu '.$dan[2].' Zgłoszenia są przyjmowane do '.$dan[1].'<br/><br/><br/>';
    
    $sqlb = " SELECT id_kol, id_zgl, pri  "
          . " FROM zgloszenia "
          . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$id_wys')  "
	  . " ORDER BY kolej " ;
    $runsql2 = mysql_query($sqlb) or die(mysql_error());
    $k=0;
    while ($dan1 = mysql_fetch_row($runsql2)) {
      $k++;
      $zglo[$k] = $dan1[0];
      $prio=$dan1[2];
    }
    
    if ($k > 0) {
      $wyslij = "Modyfikuj zgloszenie";
    } else {
      $wyslij = "Wyślij zgloszenie";
    }
    
    echo 'Pamiętaj by zgłaszać wszystkich kolarzy po kolei puste zgłoszenia zstawiaj na końcu (jak kolarz nie pojedzie to i tak nie potrąci Ci nikt startowego)<br/><br/>';
    

    $ilu=$dan[0];
    $rez=$ilu-4;
    echo $ilu.' można zgłosić kolarzy, '.$rez.' rezerwowych.<br/><br/>';
    
    echo '<form action="zglaszanieP.php?id_wys='.$id_wys.'" method="POST">';
    echo '';
    
    if ($dan[1] > date("Y-m-d H:i:s")) {    
      $sql="SELECT id_kol , imie , nazw, id_team FROM Kolarze WHERE id_user = '$idek' ORDER BY nazw";
      
      for ($i=1 ; $i <= $ilu ; $i++) {
        echo 'zgłoszenie '.$i.' ';
        echo '<SELECT class="form3"  NAME="W'.$i.'">';
        echo '<OPTION VALUE="0">---</option> ';
        $runsql = mysql_query($sql) or die('mysql_query');
        while ($dane = mysql_fetch_row($runsql)) {
          echo '<OPTION VALUE="'.$dane[0];
	  if ($zglo[$i] == $dane[0]) {
            echo '" SELECTED';
          } else {
            echo '"';
          }
          
          $sqlek="SELECT nazwa, skr FROM Ekipy WHERE id_team = '$dane[3]' ";
          $runsqlek = mysql_query($sqlek) or die('mysql_query');
          $daneek = mysql_fetch_row($runsqlek);
          
          
	  echo '><pre>'.$dane[1].' '.$dane[2].' ';
	  
	  //$ile_spacji= strlen($dane[1]) + strlen($dane[2]);
	  //while ($ile_spacji <= 30) {
	    echo '&nbsp&nbsp&nbsp&nbsp';
	    //$ile_spacji = $ile_spacji+1;
	  //}
	  
	  echo '- '.$daneek[0].' ('.$daneek[1].')</pre></option>';
        }
      
        echo '</SELECT><br/><br/>';
      }
      for ($i=1 ; $i <= $ilu - 4 ; $i++) {
        echo 'rezerwowy '.$i.' ';
        $j = $i+$ilu ;
        echo '<SELECT class="form3" NAME="W'.$j.'">';
        echo '<OPTION VALUE="0">---</option>';
        $runsql = mysql_query($sql) or die('mysql_query');
        while ($dane = mysql_fetch_row($runsql)) {
          echo '<OPTION VALUE="'.$dane[0];
	  if ($zglo[$j] == $dane[0]) {
            echo '" SELECTED';
          } else {
            echo '"';
          }
	  $sqlek="SELECT nazwa, skr FROM Ekipy WHERE id_team = '$dane[3]' ";
          $runsqlek = mysql_query($sqlek) or die('mysql_query');
          $daneek = mysql_fetch_row($runsqlek);
          
          
	  echo '><pre>'.$dane[1].' '.$dane[2].' ';
	  
	  //$ile_spacji= strlen($dane[1]) + strlen($dane[2]);
	  //while ($ile_spacji <= 30) {
	    echo '&nbsp&nbsp&nbsp&nbsp';
	    //$ile_spacji = $ile_spacji+1;
	  //}
	  
	  echo '- '.$daneek[0].' ('.$daneek[1].')</pre></option>';
        }
        echo '</SELECT><br/><br/>';
      }

      echo ' <input';

        if ($prio == 1) {
           echo ' checked="checked" ';
        }
      echo ' class="form1" type="checkbox" name="pri" /> priorytet?<br/>';
      echo ' <input class="form2" type=submit value="'.$wyslij.'" />';
      echo '</form>';


  



  } else {
    echo '<h3>Wyścig już został rozegrany, albo jest w trakcie rozgrywania</h3>';
  }
  
  } else {
    echo '<h3>Nie jesteś zalogowany</h3>';
    
  }
  
  
  
  
  
  
  echo koniec();
?>
