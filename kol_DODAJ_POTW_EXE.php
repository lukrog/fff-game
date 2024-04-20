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
   <?php
   //$id_kol = $_POST["id_kol"]; 
   //echo '<meta http-equiv="Refresh" content="5; URL=kol.php?id_kol='.$id_kol.'">';
   ?>
   <link rel="stylesheet" href="style.css" type="text/css"/>

   <title>FFF - edycja kolarza EXE</title>
</head>
<body>
<div>

<?php
  echo google();

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
    $zapyt = "SELECT id_user, login, haslo, ekipa, boss FROM User WHERE login=\"".$_SESSION['uzytkownik']."\"";
    $idzapyt = mysql_query($zapyt) or die('mysql_query');
    while ($wiersza = mysql_fetch_row($idzapyt)) 
    {
      $idek=$wiersza[0];
      $_SESSION['boss']=$wiersza[4];
    }
    if ($_SESSION['boss'] >= 1) {
    
    //Chcemy dodać kolarza więc trzeba sprawdzić czy może w bazie istnieje taki kolarz
    //Dla porządku trzeba sprawdzić czy może są kolarze z tą samą datą urodzenia.
    
    
         
    
    $imie = $_POST["imie"];
    $nazw = $_POST["nazw"];
    $dataU = $_POST["dataU"];
    $id_nat = $_POST["id_nat"];
    $zdjecie = $_POST["zdjecie"];

    //Trzeba dodać kolarza, a aby to zrobić trzeba znaleźć ich ostatnie id.
    
    $sql_id_kol = "SELECT id_kol FROM Kolarze ORDER BY id_kol DESC LIMIT 0, 1";
    echo $sql_id_kol.' <br/><br/>';
    $zap_id_kol = mysql_query($sql_id_kol) or die('mysql_query');
    $kolarze_id_kol = mysql_fetch_row($zap_id_kol);

    $ostatnie_id = $kolarze_id_kol[0] + 1;	  
    
    $nazw = mb_convert_case($nazw,MB_CASE_TITLE,"UTF-8");
    
    $jest = $id_kol.'|'.$imie.'|'.$nazw.'|'.$dataU.'|'.$id_nat.'|'.$zdjecie;
    $bylo = '----NOWY KOLARZ-----';	  
    
    
    // Dodajemy kolarza.
    $sql_Dodaj_Kolarza = "INSERT INTO `Kolarze`
                   (`id_kol`, `imie`, `nazw`, `dataU`, `id_nat`, `id_team`, `id_user`, `cena`, `przed`, `pts_poprz`, `punkty`, `zdjecie`) 
            VALUES ('$ostatnie_id', '$imie', '$nazw', '$dataU', '$id_nat', 0, 0, 0, 0, 0, 0,'$zdjecie')";
    echo 'Dodaję kolarza za pomocą zapytania: <br/>'.$sql_Dodaj_Kolarza.'<br/><br/>
         ';
    $zap_Dodaj_Kolarza = mysql_query($sql_Dodaj_Kolarza) or die('mysql_query');
    
    
    //kolarze_nazw ostatnie id.
    $sql_kolarze_nazw_id = "SELECT idkol FROM Kolarze_nazw GROUP BY idkol DESC LIMIT 0, 1";
    echo $sql_kolarze_nazw_id.' <br/><br/>';
    $zap_kolarze_nazw_id = mysql_query($sql_kolarze_nazw_id) or die('mysql_query');
    $kolarze_kolarze_nazw_id = mysql_fetch_row($zap_kolarze_nazw_id);
    
    //skrót narodowości
    $sql_nat_id = "SELECT skr FROM Nat WHERE id_nat='$id_nat'";
    echo $sql_nat_id.' <br/><br/>';
    $zap_nat_id = mysql_query($sql_nat_id) or die('mysql_query');
    $kolarze_nat_id = mysql_fetch_row($zap_nat_id);
    $id_kol_nazw = $kolarze_kolarze_nazw_id[0] + 1;
    //teraz trzeba dodać do kolarze nazw
    $nazw_i_imie = $nazw.' '.$imie;
    $sql_Dodaj_Kolarzan = "INSERT INTO `Kolarze_nazw`(`idkol`, `nazw`, `nat`) 
                           VALUES ('$id_kol_nazw','$nazw_i_imie','$kolarze_nat_id[0]')";
    echo 'Dodaję kolarza_nazw za pomocą zapytania: <br/>'.$sql_Dodaj_Kolarzan.'<br/><br/>
         ';
    $zap_Dodaj_Kolarzan = mysql_query($sql_Dodaj_Kolarzan) or die('mysql_query');
    
    //i czas dodać kto co zmienił :D
      $a_edyt_OST_sql = "SELECT `id_edyt` FROM `a_edycje` ORDER BY `id_edyt` DESC LIMIT 0 , 1";
      $a_edyt_OST = mysql_query($a_edyt_OST_sql) or die('mysql_query');
      $dane_a_edyt_OST = mysql_fetch_row($a_edyt_OST); 
      
      $dzis = date("Y-m-d H:i:s");
      $id = $dane_a_edyt_OST[0] + 1;
      $a_edyt_sql = "INSERT INTO `a_edycje`(`id_edyt`, `było`, `jest`, `kto`, `kiedy`, `co`, `id`) VALUES (".$id.",'".$bylo."','".$jest."',".$idek.",'".$dzis."', \"KO\", ".$ostatnie_id.")";
      echo '<br/><br/>'.$a_edyt_sql; 
      $a_edyt = mysql_query($a_edyt_sql) or die('mysql_query');  
    
    
    echo '<BR/><BR/>teraz możesz przejść do strony kolarza, którego stworzyłeś: <a href="kol.php?id_kol='.$ostatnie_id.'"><b>'.$nazw.'</b> '.$imie.'</a><br/>';
    
    } else {
      echo 'nie masz do tego uprawnień';
    } 
    echo koniec(); 
    ?>
