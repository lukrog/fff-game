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
   $id_wys = $_POST["id_wys"]; 
   echo '<meta http-equiv="Refresh" content="5; URL=wyscig.php?id_wys='.$id_wys.'">';
   ?>
   <link rel="stylesheet" href="style.css" type="text/css"/>

   <title>FFF - edycja wyścigu EXE</title>
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
         
    $id_wys = $_POST["id_wys"];
    $nazwa = $_POST["nazwa"];
    $id_nat = $_POST["nat"];
    $klaUCI = $_POST["klaUCI"];
    $klaPC = $_POST["klaPC"];
    $dataP = $_POST["dataP"];
    $dataK = $_POST["dataK"];
    $startowe = $_POST["startowe"];
    $ilu_kol = $_POST["ilu_kol"];
    $pri = $_POST["pri"];
    
    //Sprawdzam jak jest w bazie.
    $zap_wys = "SELECT id_wys, nazwa, id_nat, klaUCI, klaPC, dataP, dataK, startowe, ilu_kol, pri 
                 FROM `Wyscigi` 
                 WHERE id_wys= '$id_wys' ";
    $idz_wys = mysql_query($zap_wys) or die('mysql_query');
    $dane_wys = mysql_fetch_row($idz_wys);    
     
    $jest = $id_wys.'|'.$nazwa.'|'.$id_nat.'|'.$klaUCI.'|'.$klaPC.'|'.$dataP.'|'.$dataK.'|'.$startowe.'|'.$ilu_kol.'|'.$pri;
    $bylo = $dane_wys[0].'|'.$dane_wys[1].'|'.$dane_wys[2].'|'.$dane_wys[3].'|'.$dane_wys[4].'|'.$dane_wys[5].'|'.$dane_wys[6].'|'.$dane_wys[7].'|'.$dane_wys[8].'|'.$dane_wys[9];
    
    $czy_zmienione = 1;
    
    if ($dane_wys[1] <> $nazwa) {$czy_zmienione = 0;}
    if ($dane_wys[2] <> $id_nat) {$czy_zmienione = 0;}
    if ($dane_wys[3] <> $klaUCI) {$czy_zmienione = 0;}
    if ($dane_wys[4] <> $klaPC) {$czy_zmienione = 0;}
    if ($dane_wys[5] <> $dataP) {$czy_zmienione = 0;}
    if ($dane_wys[6] <> $dataK) {$czy_zmienione = 0;}
    if ($dane_wys[7] <> $startowe) {$czy_zmienione = 0;}
    if ($dane_wys[8] <> $ilu_kol) {$czy_zmienione = 0;}
    if ($dane_wys[9] <> $pri) {$czy_zmienione = 0;}
    
    
    echo '<table id="menu2">
            <tr><td class="wyscig6"></td><td class="wyscig2">W bazie jest:</td><td class="wyscig2">Ty podałeś</td></tr>
	    <tr><td>id_wys</td><td>'.$dane_wys[0].'</td><td>'.$id_wys.'</td></tr>
	    <tr><td>nazwa</td><td>'.$dane_wys[1].'</td><td>'.$nazwa.'</td></tr>
	    <tr><td>id_nat</td><td>'.$dane_wys[2].'</td><td>'.$id_nat.'</td></tr>
	    <tr><td>klaUCI</td><td>'.$dane_wys[3].'</td><td>'.$klaUCI.'</td></tr>
	    <tr><td>klaPC</td><td>'.$dane_wys[4].'</td><td>'.$klaPC.'</td></tr>
	    <tr><td>dataP</td><td>'.$dane_wys[5].'</td><td>'.$dataP.'</td></tr>
	    <tr><td>dataK</td><td>'.$dane_wys[6].'</td><td>'.$dataK.'</td></tr>
	    <tr><td>startowe</td><td>'.$dane_wys[7].'</td><td>'.$startowe.'</td></tr>
	    <tr><td>ilu_kol</td><td>'.$dane_wys[8].'</td><td>'.$ilu_kol.'</td></tr>
	    <tr><td>pri</td><td>'.$dane_wys[9].'</td><td>'.$pri.'</td></tr>
	  </table>';
    if ($czy_zmienione == 1) {
      echo '<font color="red">Nie zmieniłeś nic!</font>';
    } else {
      //teraz mamy już jakieś zmiany, więc muzimy zmienić dane w wyścigi a potem dodać do tabeli a_edycje kto co kiedy
      
      //Zaczynamy od Ekipy
      
      $edyt_sql = "UPDATE `Wyscigi` SET `id_wys`=".$id_wys.",`nazwa`='".$nazwa."',`id_nat`=".$id_nat.",`klaUCI`='".$klaUCI."',`klaPC`='".$klaPC."',`dataP`='".$dataP."',`dataK`='".$dataK."',`startowe`='".$startowe."',`ilu_kol`='".$ilu_kol."',`pri`='".$pri."' WHERE id_wys='".$id_wys."' ";
      echo '<br/><br/>'.$edyt_sql.'<br/>';
      $edyt_ekipy = mysql_query($edyt_sql) or die('mysql_query');  
      
      //i czas dodać kto co zmienił :D
      $a_edyt_OST_sql = "SELECT `id_edyt` FROM `a_edycje` ORDER BY `id_edyt` DESC LIMIT 0 , 1";
      $a_edyt_OST = mysql_query($a_edyt_OST_sql) or die('mysql_query');
      $dane_a_edyt_OST = mysql_fetch_row($a_edyt_OST); 
      
      $dzis = date("Y-m-d H:i:s");
      $id = $dane_a_edyt_OST[0] + 1;
      $a_edyt_sql = "INSERT INTO `a_edycje`(`id_edyt`, `było`, `jest`, `kto`, `kiedy`, `co`, `id`) VALUES (".$id.",'".$bylo."','".$jest."',".$idek.",'".$dzis."', \"WY\", ".$id_wys.")";
      echo $a_edyt_sql; 
      $a_edyt = mysql_query($a_edyt_sql) or die('mysql_query');  

    }
    
    
    echo koniec(); 
    ?>

    
