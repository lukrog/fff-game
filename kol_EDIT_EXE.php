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
   $id_kol = $_POST["id_kol"]; 
   echo '<meta http-equiv="Refresh" content="5; URL=kol.php?id_kol='.$id_kol.'">';
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
    
    
    //sprawdzamy jaki wyścig edytujemy id_wys, nazwa, id_nat, klaUCI, klaPC, dataP, dataK, startowe, ilu_kol, pri
    if ($_SESSION['boss'] >= 1) {  
    
         
    $id_kol = $_POST["id_kol"];
    $imie = $_POST["imie"];
    $nazw = $_POST["nazw"];
    $dataU = $_POST["dataU"];
    $id_nat = $_POST["id_nat"];
    $zdjecie = $_POST["zdjecie"];

    
    //Sprawdzam jak jest w bazie.
    $zap_kol = "SELECT id_kol, imie, nazw, dataU, id_nat, zdjecie
                FROM `Kolarze` 
                WHERE id_kol= '$id_kol' ";
    $idz_kol = mysql_query($zap_kol) or die('mysql_query');
    $dane_kol = mysql_fetch_row($idz_kol);    
     
    $jest = $id_kol.'|'.$imie.'|'.$nazw.'|'.$dataU.'|'.$id_nat.'|'.$zdjecie;
    $bylo = $dane_kol[0].'|'.$dane_kol[1].'|'.$dane_kol[2].'|'.$dane_kol[3].'|'.$dane_kol[4].'|'.$dane_kol[5];
    
    $czy_zmienione = 1;
    
    if ($dane_kol[1] <> $imie) {$czy_zmienione = 0;}
    if ($dane_kol[2] <> $nazw) {$czy_zmienione = 0;}
    if ($dane_kol[3] <> $dataU) {$czy_zmienione = 0;}
    if ($dane_kol[4] <> $id_nat) {$czy_zmienione = 0;}
    if ($dane_kol[5] <> $zdjecie) {$czy_zmienione = 0;}
        
    
    echo '<table id="menu2">
            <tr><td class="wyscig6"></td><td class="wyscig2">W bazie jest:</td><td class="wyscig2">Ty podałeś</td></tr>
	    <tr><td>id_kol</td><td>'.$dane_kol[0].'</td><td>'.$id_kol.'</td></tr>
	    <tr><td>imię</td><td>'.$dane_kol[1].'</td><td>'.$imie.'</td></tr>
	    <tr><td>nazwiska</td><td>'.$dane_kol[2].'</td><td>'.$nazw.'</td></tr>
	    <tr><td>data urodzenia</td><td>'.$dane_kol[3].'</td><td>'.$dataU.'</td></tr>
	    <tr><td>id_nat</td><td>'.$dane_kol[4].'</td><td>'.$id_nat.'</td></tr>
	    <tr><td>zdjęcie</td><td>'.$dane_kol[5].'</td><td>'.$zdjecie.'</td></tr>
	    
	  </table>';
    if ($czy_zmienione == 1) {
      echo '<font color="red">Nie zmieniłeś nic!</font>';
    } else {
      //teraz mamy już jakieś zmiany, więc muzimy zmienić dane w wyścigi a potem dodać do tabeli a_edycje kto co kiedy
      
      //Zaczynamy od Ekipy
      
      $edyt_sql = "UPDATE `Kolarze` SET `id_kol`=".$id_kol.",`imie`='".$imie."',`nazw`='".$nazw."',`dataU`='".$dataU."',`id_nat`='".$id_nat."',`zdjecie`='".$zdjecie."' 
                   WHERE id_kol='".$id_kol."' ";
      echo '<br/><br/>'.$edyt_sql.'<br/>';
      $edyt_ekipy = mysql_query($edyt_sql) or die('mysql_query');  
      
      $nazw_kolarze = $nazw.' '.$imie;
      
      //narodowość:
      $sql_narodowosc = "SELECT skr FROM `Nat` WHERE id_nat='$id_nat' ";
      $idz_narodowosc = mysql_query($sql_narodowosc) or die('mysql_query');
      $dane_narodowosc = mysql_fetch_row($idz_narodowosc);   
      
      $skrot_nat = $dane_narodowosc[0].' ';
            
      //kolarze_nazw
      $sql_dodaj = 'INSERT INTO `Kolarze_nazw`(`idkol`, `nazw`, `nat`) VALUES ('.$id_kol.',"'.$nazw_kolarze.'","'.$skrot_nat.'")';
      echo $sql_dodaj;     
      $zap_dodaj = mysql_query($sql_dodaj) or die('mysql_query'); 
      
      //i czas dodać kto co zmienił :D
      $a_edyt_OST_sql = "SELECT `id_edyt` FROM `a_edycje` ORDER BY `id_edyt` DESC LIMIT 0 , 1";
      $a_edyt_OST = mysql_query($a_edyt_OST_sql) or die('mysql_query');
      $dane_a_edyt_OST = mysql_fetch_row($a_edyt_OST); 
      
      $dzis = date("Y-m-d H:i:s");
      $id = $dane_a_edyt_OST[0] + 1;
      $a_edyt_sql = "INSERT INTO `a_edycje`(`id_edyt`, `było`, `jest`, `kto`, `kiedy`, `co`, `id`) VALUES (".$id.",'".$bylo."','".$jest."',".$idek.",'".$dzis."', \"KO\", ".$id_kol.")";
      echo '<br/><br/>'.$a_edyt_sql; 
      $a_edyt = mysql_query($a_edyt_sql) or die('mysql_query');  

    }
    } else {
      echo 'nie masz do tego uprawnień';
    }    
    
    echo koniec(); 
    ?>

    
