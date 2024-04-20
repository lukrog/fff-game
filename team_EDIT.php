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
   <title>FFF - edycja ekip </title>
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
    
    //sprawdzamy jakę ekipę edytujemy
         
    $id_team = $_GET["id_team"];
    $zap_team = "SELECT id_team, nazwa, id_kraj, skr, liga, pts  
	          FROM Ekipy 
	          WHERE id_team= '$id_team' ";
    $idz_team = mysql_query($zap_team) or die('mysql_query');
    $dane_team = mysql_fetch_row($idz_team);     
     
    //już wiemy co wiemy o ekipie.
    
    //robimy więc formularz.
    echo '<form action="team_EDIT_EXE.php" method="POST"> 
	 <input class="form" type="hidden" name="id_team" value="'.$id_team.'"/>';
    echo '<table id="menu2"> 
	    <tr><td><i>id ekipy: </i></td><td>'.$id_team.'</td></tr> 
	    <tr><td><i>nazwa: </i></td><td><input class="form" type="input" name="nazwa" value="'.$dane_team[1].'" /></td></tr>
	    <tr><td><i>skrót: </i></td><td><input class="form" type="input" name="skr" value="'.$dane_team[3].'" /></td></tr>
	    <tr><td></td><td></td></tr>';
	    //teraz kraj ekipy a aby to zrobić zapytanie:
    $sql_narodowosci = "SELECT id_nat, skr, flaga, nazwa FROM Nat WHERE id_nat >0 ORDER BY nazwa ";
    $zap_narodowosci = mysql_query($sql_narodowosci) or die('mysql_query'); 
    echo ' <tr><td><i>Kraj ekipy</i></td><td><select class="form4"  name="nat">';
    while ($dane_narodowosci = mysql_fetch_row($zap_narodowosci)) {
		echo '<option value="'.$dane_narodowosci[0].'" ';
                if ($dane_narodowosci[0] == $dane_team[2]) {
		   echo ' selected="selected" ';
		}
                echo ' style="background-image: url(http://fff.xon.pl/img/flagi/'.$dane_narodowosci[2].'); background-repeat:no-repeat; padding-left: 21px;" >'.$dane_narodowosci[1].' - '.$dane_narodowosci[0].'</option>
		';  
    }
    echo '</select>
         ';
      	    
	    
	    echo '<tr><td><i>liga: <br/> PT - Pro Tour<br/> PR - Profesjonal<br/> CT - Continental<br/> AM - Amatorska</i></td><td>';
	    echo '<input class="form" type="input" name="liga" value="'.$dane_team[4].'" />';
	    
	    
	    
	    echo '</td></tr>
	    <tr><td><i>Rok który omawiamy: </i></td><td><input class="form" type="hidden" name="pts" value="'.$dane_team[5].'" />'.$dane_team[5].'</td></tr>
          '; 
    echo '</table>
          <input class="form2" type=submit value="Edytuj" />
          </form>'; 
    echo koniec(); 
    ?>

    
