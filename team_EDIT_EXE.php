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
   $id_team = $_POST["id_team"]; 
   echo '<meta http-equiv="Refresh" content="5; URL=team.php?id_team='.$id_team.'">';
   ?>
   <link rel="stylesheet" href="style.css" type="text/css"/>

   <title>FFF - edycja ekip EXE</title>
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
    
    
    //sprawdzamy jakę ekipę edytujemy id_team, nazwa, id_kraj, skr, liga, pts
         
    $id_team = $_POST["id_team"];
    $nazwa = $_POST["nazwa"];
    $id_kraj = $_POST["nat"];
    $skr = $_POST["skr"];
    $liga = $_POST["liga"];
    $pts = $_POST["pts"];
    
   
    
    //Sprawdzam jak jest w bazie.
    $zap_team1 = "SELECT id_team, nazwa, id_kraj, skr, liga, pts  
	         FROM Ekipy 
	         WHERE id_team= '$id_team' ";
    $idz_team1 = mysql_query($zap_team1) or die('mysql_query');
    $dane_team1 = mysql_fetch_row($idz_team1);    
     
    $jest = $id_team.'|'.$nazwa.'|'.$id_kraj.'|'.$skr.'|'.$liga.'|'.$pts;
    $bylo = $dane_team1[0].'|'.$dane_team1[1].'|'.$dane_team1[2].'|'.$dane_team1[3].'|'.$dane_team1[4].'|'.$dane_team1[5];
    
    $czy_zmienione = 1;
    
    if ($dane_team1[0] <> $id_team) {$czy_zmienione = 0;}
    if ($dane_team1[1] <> $nazwa) {$czy_zmienione = 0;}
    if ($dane_team1[2] <> $id_kraj) {$czy_zmienione = 0;}
    if ($dane_team1[3] <> $skr) {$czy_zmienione = 0;}
    if ($dane_team1[4] <> $liga) {$czy_zmienione = 0;}
    if ($dane_team1[5] <> $pts) {$czy_zmienione = 0;}
    
    echo '<table id="menu2">
            <tr><td class="wyscig6"></td><td class="wyscig2">W bazie jest:</td><td class="wyscig2">Ty podałeś</td></tr>
	    <tr><td>id_team</td><td>'.$dane_team1[0].'</td><td>'.$id_team.'</td></tr>
	    <tr><td>nazwa</td><td>'.$dane_team1[1].'</td><td>'.$nazwa.'</td></tr>
	    <tr><td>id_kraj</td><td>'.$dane_team1[2].'</td><td>'.$id_kraj.'</td></tr>
	    <tr><td>skr</td><td>'.$dane_team1[3].'</td><td>'.$skr.'</td></tr>
	    <tr><td>liga</td><td>'.$dane_team1[4].'</td><td>'.$liga.'</td></tr>
	    <tr><td>rok</td><td>'.$dane_team1[5].'</td><td>'.$pts.'</td></tr>
	  </table>';
    if ($czy_zmienione == 1) {
      echo '<font color="red">Nie zmieniłeś nic!</font>';
    } else {
      //teraz mamy już jakieś zmiany, więc muzimy zmienić dane w Ekipy, z_a_historiaekip a potem dodać do tabeli a_edycje kto co kiedy
      
      //Zaczynamy od Ekipy
      
      $edyt_Ekipy_sql = "UPDATE `Ekipy` SET `id_team`=".$id_team.",`nazwa`='".$nazwa."',`id_kraj`=".$id_kraj.",`skr`='".$skr."',`liga`='".$liga."',`pts`=".$pts." WHERE id_team=".$id_team." ";
      echo '<br/><br/>'.$edyt_Ekipy_sql.'<br/>';
      $edyt_ekipy = mysql_query($edyt_Ekipy_sql) or die('mysql_query');
      
      //historia Ekipy
      $edyt_hisEkipy_sql = "UPDATE `z_a_historiaekip` SET `id_ek`=".$id_team.",`nazwa`='".$nazwa."',`id_nat`=".$id_kraj.",`skr`='".$skr."',`dyw`='".$liga."',`rok`=".$pts." WHERE id_ek=".$id_team." AND rok=".$pts." ";
      echo '<br/><br/>'.$edyt_hisEkipy_sql.'<br/><br/><br/>';
      $edyt_hisekipy = mysql_query($edyt_hisEkipy_sql) or die('mysql_query');      
      
      //i czas dodać kto co zmienił :D
      $a_edyt_OST_sql = "SELECT `id_edyt` FROM `a_edycje` ORDER BY `id_edyt` DESC LIMIT 0 , 1";
      $a_edyt_OST = mysql_query($a_edyt_OST_sql) or die('mysql_query');
      $dane_a_edyt_OST = mysql_fetch_row($a_edyt_OST); 
      
      $dzis = date("Y-m-d H:i:s");
      $id = $dane_a_edyt_OST[0] + 1;
      $a_edyt_sql = "INSERT INTO `a_edycje`(`id_edyt`, `było`, `jest`, `kto`, `kiedy`, `co`, `id`) VALUES (".$id.",'".$bylo."','".$jest."',".$idek.",'".$dzis."', \"EK\", ".$id_team.")";
      echo $a_edyt_sql; 
      $a_edyt = mysql_query($a_edyt_sql) or die('mysql_query');  

    }
    
    
    echo koniec(); 
    ?>

    
