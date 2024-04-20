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
   <title>FFF - edycja kolarza</title>
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
    
    //sprawdzamy jakiego kolarza edytujemy
         
    $id_kol = $_GET["id_kol"];
    $zap_kol = "SELECT id_kol, imie, nazw, dataU, id_nat, id_team, id_user, cena, przed, pts_poprz, punkty, zdjecie 
                FROM `Kolarze` 
                WHERE id_kol= '$id_kol' ";
    $idz_kol = mysql_query($zap_kol) or die('mysql_query');
    $dane_kol = mysql_fetch_row($idz_kol);     
     
    //już wiemy co wiemy o kolarzu.
    
    //robimy więc formularz.
    echo '<form action="kol_EDIT_EXE.php" method="POST"> 
	 <input class="form5" type="hidden" name="id_kol" value="'.$id_kol.'"/>';
    echo '<table id="menu2"> 
	    <tr><td><i>id kolarza: </i></td><td class="wyscig7">'.$id_kol.'</td></tr> 
	    <tr><td><i>imię: </i></td><td><input class="form5" type="input" name="imie" value="'.$dane_kol[1].'" /></td></tr>
	    <tr><td><i>nazwisko: </i></td><td><input class="form5" type="input" name="nazw" value="'.$dane_kol[2].'" /></td></tr>
	    <tr><td><i>data urodzenia: </i></td><td><input class="form5" type="input" name="dataU" value="'.$dane_kol[3].'" /></td></tr>
	    <tr><td></td><td></td></tr>';
	    //teraz kraj wyścigu a aby to zrobić zapytanie:
    $sql_narodowosci = "SELECT id_nat, skr, flaga, nazwa FROM Nat WHERE id_nat >0 ORDER BY nazwa ";
    $zap_narodowosci = mysql_query($sql_narodowosci) or die('mysql_query'); 
    echo ' <tr><td><i>Kraj ekipy</i></td><td><select class="form4"  name="id_nat">';
    while ($dane_narodowosci = mysql_fetch_row($zap_narodowosci)) {
		echo '<option value="'.$dane_narodowosci[0].'" ';
                if ($dane_narodowosci[0] == $dane_kol[4]) {
		   echo ' selected="selected" ';
		}
                echo ' style="background-image: url(http://fff.xon.pl/img/flagi/'.$dane_narodowosci[2].'); background-repeat:no-repeat; padding-left: 21px;" >'.$dane_narodowosci[1].' - '.$dane_narodowosci[0].'</option>
		';  
    }
    echo '</select>
         ';
      	    
	    
	    echo '<tr><td><i>zdjecie:<br/>(link do zdjęcia w postaci:) </i></td><td><input class="form5" type="input" name="zdjecie" value="'.$dane_kol[11].'" /><br/>http://xxx.xxx.xxx/xx...</td></tr>
	          <tr><td><i>.</i></td><td></td></tr>
	          <tr><td><i>.</i></td><td></td></tr>
		  <tr><td><i>--------</i></td><td>-------------------------------</td></tr>
	          <tr><td><i>--------</i></td><td>   tego nie wolno edytować ;) </td></tr>
	          <tr><td><i>--------</i></td><td>-------------------------------</td></tr>
	          <tr><td><i>id_team: </i></td><td>"'.$dane_kol[5].'" To można edytować w innym miesjcu</td></tr>
	          <tr><td><i>id_user: </i></td><td>"'.$dane_kol[6].'"</td></tr> 
		  <tr><td><i>cena: </i></td><td>"'.$dane_kol[7].'"</td></tr> 
		  <tr><td><i>przed: </i></td><td>"'.$dane_kol[8].'"</td></tr> 
		  <tr><td><i>pts_poprz: </i></td><td>"'.$dane_kol[9].'"</td></tr> 
		  <tr><td><i>punkty: </i></td><td>"'.$dane_kol[10].'"</td></tr> 
		  
		  ';
	    
	    

	    
	    
	    
	    
    echo '</table>
          <input class="form2" type=submit value="Edytuj" />
          </form>'; 
    } else {
      echo 'nie masz do tego uprawnień';
    }              
          
    echo koniec(); 
    ?>

    
