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
    
    
    //Chcemy dodać kolarza więc trzeba sprawdzić czy może w bazie istnieje taki kolarz
    //Dla porządku trzeba sprawdzić czy może są kolarze z tą samą datą urodzenia.
    if ($_SESSION['boss'] >= 1) {
    
         
    //$id_kol = $_POST["id_kol"];
    $imie = $_POST["imie"];
    $nazw = $_POST["nazw"];
    $dataU = $_POST["dataU"];
    $id_nat = $_POST["id_nat"];
    $zdjecie = $_POST["zdjecie"];
    
    $nazw = mb_convert_case($nazw,MB_CASE_TITLE,"UTF-8");


    echo 'Chcesz dodać kolarza którego data urodzenia to: '.$dataU.'<br/>';
    
    $sql_zawodnicy_z_data = "SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, Ekipy.skr, Ekipy.nazwa
                             FROM Kolarze, Nat, Ekipy
                             WHERE Kolarze.id_nat=Nat.id_nat AND Kolarze.id_team=Ekipy.id_team AND Kolarze.dataU='".$dataU."'";
    $zap_zawodnicy_z_data = mysql_query($sql_zawodnicy_z_data) or die('mysql_query');
    $ile_z_data = mysql_num_rows($zap_zawodnicy_z_data);
    echo 'W bazie jest już '.$ile_z_data.' kolarzy z taką samą bazą';
    
    if ($ile_z_data > 0) {
      echo ' a są to: <br/>';
      while ($kolarze_z_ta_data = mysql_fetch_row($zap_zawodnicy_z_data)) 
      {
        echo $kolarze_z_ta_data[0].' - <a href=kol.php?id_kol='.$kolarze_z_ta_data[0].'>'.$kolarze_z_ta_data[1].' <b>'.$kolarze_z_ta_data[2].'</b></a> <img alt="'.$kolarze_z_ta_data[4].'" src="http://fff.xon.pl/img/flagi/'.$kolarze_z_ta_data[3].'" /> - '.$kolarze_z_ta_data[6].' ('.$kolarze_z_ta_data[5].') <br/>
             ';
      }
      echo '<br/><br/>';
    }
    
    $imie_i_nazw = $nazw.' '.$imie;
    
    $sql_zawodnicy_z_data1 = "SELECT Kolarze_nazw.idkol, Kolarze_nazw.nazw, Nat.flaga, Nat.nazwa 
                             FROM Kolarze_nazw, Nat 
			     WHERE Kolarze_nazw.nat = Nat.skr AND Kolarze_nazw.nazw = '".$imie_i_nazw."' ";
    $zap_zawodnicy_z_data1 = mysql_query($sql_zawodnicy_z_data1) or die('mysql_query');
    $ile_z_data1 = mysql_num_rows($zap_zawodnicy_z_data1);
    echo 'W bazie jest już '.$ile_z_data1.' kolarzy z taką nazwą';
    
    if ($ile_z_data1 > 0) {
      echo ' a są to: <br/>';
      while ($kolarze_z_ta_data1 = mysql_fetch_row($zap_zawodnicy_z_data)) 
      {
        echo $kolarze_z_ta_data1[0].' - <a href=kol.php?id_kol='.$kolarze_z_ta_data[0].'>'.$kolarze_z_ta_data1[1].'<a/>  <img alt="'.$kolarze_z_ta_data1[3].'" src="http://fff.xon.pl/img/flagi/'.$kolarze_z_ta_data1[2].'" /> <br/>
             ';
      }
      }
      echo '<br/>
      
      <br/><br/>
      Jeśli jesteś pewien że to żaden z powyższych i że nie ma takiego kolarza w bazie to kliknij na dodaj poniżej';
    

     
     
     
    $jest = $id_kol.'|'.$imie.'|'.$nazw.'|'.$dataU.'|'.$id_nat.'|'.$zdjecie;
    $bylo = '----NOWY KOLARZ-----';
    
        
    
    echo '<table id="menu2">
            <tr><td class="wyscig6"></td><td class="wyscig2">Ty podałeś</td></tr>
	    <tr><td>id_kol</td><td><i>zostanie dodane</i></td></tr>
	    <tr><td>imię</td><td>'.$imie.'</td></tr>
	    <tr><td>nazwiska</td><td>'.$nazw.'</td></tr>
	    <tr><td>data urodzenia</td><td>'.$dataU.'</td></tr>
	    <tr><td>id_nat</td><td>'.$id_nat.'</td></tr>
	    <tr><td>zdjęcie</td><td>'.$zdjecie.'</td></tr>
	    
	  </table>';
	  
    $czy_zmienione = 1;	  
    if ($czy_zmienione == 1) {
      echo '<font color="red">Po kilknięciu DALEJ nie będzie odwrotu</font><br/><br/>
           
	   ';
      // teraz robimy ukryty formularz.
      echo '<form action="kol_DODAJ_POTW_EXE.php" method="POST">
               <input type="hidden" name="imie" value="'.$imie.'" />
               <input type="hidden" name="nazw" value="'.$nazw.'" />
               <input type="hidden" name="dataU" value="'.$dataU.'" />
               <input type="hidden" name="id_nat" value="'.$id_nat.'" />
               <input type="hidden" name="zdjecie" value="'.$zdjecie.'" />
               <input class="form2" type=submit value="DODAJ KOLARZA" />
            </form>';
           
    } else {
      //teraz mamy już jakieś zmiany, więc muzimy zmienić dane w wyścigi a potem dodać do tabeli a_edycje kto co kiedy
      
      //Zaczynamy od Ekipy
      
      $edyt_sql = "UPDATE `Kolarze` SET `id_kol`=".$id_kol.",`imie`='".$imie."',`nazw`='".$nazw."',`dataU`='".$dataU."',`id_nat`='".$id_nat."',`zdjecie`='".$zdjecie."' 
                   WHERE id_kol='".$id_kol."' ";
      echo '<br/><br/>'.$edyt_sql.'<br/>';
      $edyt_ekipy = mysql_query($edyt_sql) or die('mysql_query');  
      
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
