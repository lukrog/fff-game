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
   <title>FFF - zglaszanie kolarzy potwierdzenie</title>
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
    $sql1= " SELECT ilu_kol, dataP, nazwa "
         . " FROM Wyscigi "
         . " WHERE ( ( id_wys = '$id_wys'))";
    $runsql1 = mysql_query($sql1) or die('mysql_query');
    $dan = mysql_fetch_row($runsql1);
    
    echo 'Zgłaszasz kolarzy do wyścigu '.$dan[2].' Zgłoszenia są przyjmowane do '.$dan[1].'<br/><br/><br/>';
    
    
    $sqlb = " SELECT id_kol, id_zgl  "
          . " FROM zgloszenia "
          . " WHERE (zgloszenia.id_user = '$idek') AND (zgloszenia.id_wys = '$id_wys')  "; 
    $runsql2 = mysql_query($sqlb) or die(mysql_error());
   
    if (mysql_num_rows($runsql2) > 0) {
      $wyslij = "Wyślij poprawione zgloszenie";
    } else {
      $wyslij = "Wyślij zgloszenie";
    }
    $ilu=$dan[0];   
    
    $zglosz[1] = $_POST["W1"];
    $zglosz[2] = $_POST["W2"];
    $zglosz[3] = $_POST["W3"];
    $zglosz[4] = $_POST["W4"];
    $zglosz[5] = $_POST["W5"];
    $zglosz[6] = $_POST["W6"];
    $zglosz[7] = $_POST["W7"];
    $zglosz[8] = $_POST["W8"];
    $zglosz[9] = $_POST["W9"];
    $zglosz[10] = $_POST["W10"];
    $zglosz[11] = $_POST["W11"];
    $zglosz[12] = $_POST["W12"];
    $zglosz[13] = $_POST["W13"];
    $zglosz[14] = $_POST["W14"];
    $zglosz[15] = $_POST["W15"];
    $zglosz[16] = $_POST["W16"];    
    
       
    
    $test = "OK";
    $wiersz[0] = "";
    if ($dan[1] > date("Y-m-d H:i:s")) { 
      echo '<h4>Zgłoszeni przez Ciebie kolarze</h4>';   
      $sql="SELECT id_kol , imie , nazw FROM Kolarze WHERE id_user = '$idek' ORDER BY id_kol";

      $z=1;
      for ($q=1 ; $q < 2 * $ilu - 3; $q++) {
        $runsql = mysql_query($sql) or die('mysql_query');
        while ($wiersz = mysql_fetch_row($runsql)) {
           if ($wiersz[0] == $zglosz[$q]) {
              $zgloszt[$z] = $wiersz[0];
           
           }
      	  }
	  $z++;
      }
      //$test =0;
      $tests = "OK";
      for ($o=1; $o <= 2 * $ilu - 4 ; $o++) {
        for ($p=$o ; $p <= 2 * $ilu - 4; $p++) {
          if ($zgloszt[$o] == 0) {
            } else {
              if ($o == $p) {
            } else {
	      if ($zgloszt[$o] == $zgloszt[$p]) {
                $tests = "NIE"; 
              }
            }
          }
        }
      }
      

          


        
      if ($tests == "NIE") { 
        echo '<h2>Wybrałeś kilka razy tego samego kolarza</h2>';
        echo '<h2>Lub nie wybrałeś żadnego kolarza</h2>';
        echo '<h2>Cofnij i popraw zgłoszenie</h2>';  
	     
      } else {
        
        echo '<form action="zglaszanieK.php?id_wys='.$id_wys.'" method="POST">';
        echo '';
        $sql="SELECT id_kol , imie , nazw FROM Kolarze WHERE id_user = '$idek' ORDER BY nazw";
 
        for ($i=1 ; $i <= $ilu ; $i++) {
          echo 'zgłoszenie '.$i.' ';
          $runsql = mysql_query($sql) or die('mysql_query');
          while ($dane = mysql_fetch_row($runsql)) {
            
	    if ($zglosz[$i] == $dane[0]) {
	      echo '<input type="hidden" name="K'.$i.'" value="';
              echo $zglosz[$i];
              echo '" /> ';
              echo ' '.$dane[1].' '.$dane[2];
            } else {
          } 
          }
        echo ' <br/>'; 
        }
        echo '-------------------------------------<br/>';
          for ($i=1 ; $i <= $ilu - 4 ; $i++) {
            echo 'rezerwowy '.$i.' ';
            $j = $i+$ilu ;
            $runsql = mysql_query($sql) or die('mysql_query');
            while ($dane = mysql_fetch_row($runsql)) {
              
              if ($zglosz[$j] == $dane[0]) {
                echo '<input type="hidden" name="K'.$j.'" value="';
                echo $zglosz[$j];
                echo '" /> ';
                echo ' '.$dane[1].' '.$dane[2];
            } else {
            }
             
            }
          echo ' <br/>'; 
          }
          $sqlb = " SELECT Avg(zgloszenia.pri) AS pri, zgloszenia.id_wys  "
                . " FROM zgloszenia "
                . " GROUP BY zgloszenia.id_wys, zgloszenia.id_user, zgloszenia.pri "
                . " HAVING (zgloszenia.id_user=20 AND zgloszenia.pri=1) AND id_wys <> '$id_wys' "; 
          $zapb = mysql_query($sqlb) or die('mysql_query');
          if ($wyslij == "Wyślij poprawione zgloszenie")
	  {
	     $ile = mysql_num_rows($zapb);
	  } else {
	     $ile = mysql_num_rows($zapb)+1;
	  }
	  if ($_POST['pri'] == "on") {
            echo '<input type="hidden" name="pri" value="on" />';
            if ($ile <= 3) {
              echo 'To twój '.$ile.' priorytet wzięty w tym sezonie<br/>';
            } else { 
              echo '<font style="color: red;">W tym sezonie wybrałeś już 3 priorytety ten byłby '.$ile.'<br/> Pamiętaj jeśli będziesz miał więcej priorytetów niż 3 możesz spodziewać się kary finansowej. <br/>Usuń priorytet z innego/innych wyścigów</font> <br/>';
            }
	    
          }


          
 
       echo ' <input class="form2"  type=submit value="'.$wyslij.'" />';
       echo '</form>';
      }
      
        
      
      



  } else {
    echo '<h3>Wyścig już został rozegrany, albo jest w trakcie rozgrywania</h3>';
  }
  
  
  
  
  
  
  
  
  
  
  echo koniec();
?>

    
  
