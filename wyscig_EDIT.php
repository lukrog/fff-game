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
   <title>FFF - edycja wyścigu</title>
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
    
    if ($_SESSION['boss'] >= 1) {
    
    //sprawdzamy jakę ekipę edytujemy
         
    $id_wys = $_GET["id_wys"];
    $zap_wys = "SELECT id_wys, nazwa, id_nat, klaUCI, klaPC, dataP, dataK, startowe, ilu_kol, pri 
                 FROM `Wyscigi` 
                 WHERE id_wys= '$id_wys' ";
    $idz_wys = mysql_query($zap_wys) or die('mysql_query');
    $dane_wys = mysql_fetch_row($idz_wys);     
     
    //już wiemy co wiemy o wyścigu.
    
    //robimy więc formularz.
    echo '<form action="wyscig_EDIT_EXE.php" method="POST"> 
	 <input class="form5" type="hidden" name="id_wys" value="'.$id_wys.'"/>';
    echo '<table id="menu2"> 
	    <tr><td><i>id wyścigu: </i></td><td class="wyscig7">'.$id_wys.'</td></tr> 
	    <tr><td><i>nazwa: </i></td><td><input class="form5" type="input" name="nazwa" value="'.$dane_wys[1].'" /></td></tr>
	    <tr><td></td><td></td></tr>';
	    //teraz kraj wyścigu a aby to zrobić zapytanie:
    $sql_narodowosci = "SELECT id_nat, skr, flaga, nazwa FROM Nat WHERE id_nat >0 ORDER BY nazwa ";
    $zap_narodowosci = mysql_query($sql_narodowosci) or die('mysql_query'); 
    echo ' <tr><td><i>Kraj ekipy</i></td><td><select class="form4"  name="nat">';
    while ($dane_narodowosci = mysql_fetch_row($zap_narodowosci)) {
		echo '<option value="'.$dane_narodowosci[0].'" ';
                if ($dane_narodowosci[0] == $dane_wys[2]) {
		   echo ' selected="selected" ';
		}
                echo ' style="background-image: url(http://fff.xon.pl/img/flagi/'.$dane_narodowosci[2].'); background-repeat:no-repeat; padding-left: 21px;" >'.$dane_narodowosci[1].' - '.$dane_narodowosci[0].'</option>
		';  
    }
    echo '</select>
         ';
      	    
	    
	    echo '<tr><td><i>klaUCI: </i></td><td><input class="form5" type="input" name="klaUCI" value="'.$dane_wys[3].'" /></td></tr>
	          <tr><td><i>klaPC: </i></td><td><input class="form5" type="input" name="klaPC" value="'.$dane_wys[4].'" /></td></tr> 
		  <tr><td><i>data początku (z godziną): </i></td><td><input class="form5" type="input" name="dataP" value="'.$dane_wys[5].'" /></td></tr> 
		  <tr><td><i>data końca: </i></td><td><input class="form5" type="input" name="dataK" value="'.$dane_wys[6].'" /></td></tr> 
		  <tr><td><i>startowe: </i></td><td><input class="form5" type="input" name="startowe" value="'.$dane_wys[7].'" /></td></tr> 
		  <tr><td><i>ilu kolarzy: </i></td><td><input class="form5" type="input" name="ilu_kol" value="'.$dane_wys[8].'" /></td></tr> 
		  <tr><td><i>priorytet: </i></td><td><input class="form5" type="input" name="pri" value="'.$dane_wys[9].'" /></td></tr>
		  ';
	    
	    
	    
	    
	    
	    
	    
    echo '</table>
          <input class="form2" type=submit value="Edytuj" />
          </form>'; 
    
    } else {
      echo 'nie masz do tego uprawnień';
    } 
    
    echo koniec(); 
    ?>

    
