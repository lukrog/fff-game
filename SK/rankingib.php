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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - <?php echo zwroc_tekst(14, $jezyk).' '.date("Y"); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php
	  
	  echo '<h1>'.zwroc_tekst(78, $jezyk).'</h1>';
	  
	   
	   


    $sort1 = $_GET['sort'];
    if ($sort1 == "") {$sort1 = 1;}

    echo  '<form action="rankingib.php" method="GET">';
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>Cli ';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
    
	     echo  '>Hil ';
	     echo  '<input class="form" type=radio name=sort value=3 ';
	     if ($sort1 == 3) {
               echo 'checked="checked"';
             }
	     echo  '>Fl ';
	     echo  '<input class="form" type=radio name=sort value=4 ';
	     if ($sort1 == 4) {
               echo 'checked="checked"';
             }
	     echo  '>Spr ';
	     echo  '<input class="form" type=radio name=sort value=5 ';
	     if ($sort1 == 5) {
               echo 'checked="checked"';
             }
	     echo  '>Cbl ';
	     echo  '<input class="form" type=radio name=sort value=6 ';
	     if ($sort1 == 6) {
               echo 'checked="checked"';
             }
	     echo  '>TT ';
    $limitd = $_GET['limit1'];	     
    if ($limitd == "") {$limitd = 1;}
    if ($limitd <= 0) {$limitd = 1;}
    $limitg = $_GET['limit2'];
    if ($limitg == "") {$limitg = 50;}
    
	     echo  '&nbsp;&nbsp; '.zwroc_tekst(73, $jezyk).':<input class="forma" type="input" value='.$limitd.' name="limit1">';
	     echo  ' '.zwroc_tekst(72, $jezyk).':<input class="forma" type="input" value='.$limitg.' name="limit2">';
             echo  '<input class="form2" type="submit" value="'.zwroc_tekst(74, $jezyk).'" />'; 
             echo  '</form>
             
	     <a href="#skr"><font style="font-size: 10px;">* - '.zwroc_tekst(75, $jezyk).'</font></a>
	     
	     <br/><br/>';

    $limitd--;
    $limitg = $limitg - $limitd;
    
    
    
    if ($sort1 == 2) 
    
		  {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking2.Cli, z_ranking2.Hil, z_ranking2.Fl, z_ranking2.Spr, z_ranking2.Cbl, z_ranking2.TT, Ekipy.nazwa, Kolarze.id_user, Kolarze.id_team "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking2 ON Kolarze.id_kol = z_ranking2.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking2.Hil DESC "
			 . " LIMIT $limitd, $limitg ";
		  } elseif ($sort1 == 3) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking2.Cli, z_ranking2.Hil, z_ranking2.Fl, z_ranking2.Spr, z_ranking2.Cbl, z_ranking2.TT, Ekipy.nazwa, Kolarze.id_user, Kolarze.id_team "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking2 ON Kolarze.id_kol = z_ranking2.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking2.Fl DESC "
			 . " LIMIT $limitd, $limitg ";
                  } elseif ($sort1 == 4) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking2.Cli, z_ranking2.Hil, z_ranking2.Fl, z_ranking2.Spr, z_ranking2.Cbl, z_ranking2.TT, Ekipy.nazwa, Kolarze.id_user, Kolarze.id_team "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking2 ON Kolarze.id_kol = z_ranking2.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking2.Spr DESC "
			 . " LIMIT $limitd, $limitg ";
                  } elseif ($sort1 == 5) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking2.Cli, z_ranking2.Hil, z_ranking2.Fl, z_ranking2.Spr, z_ranking2.Cbl, z_ranking2.TT, Ekipy.nazwa, Kolarze.id_user, Kolarze.id_team "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking2 ON Kolarze.id_kol = z_ranking2.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking2.Cbl DESC "
			 . " LIMIT $limitd, $limitg ";
		  } elseif ($sort1 == 6) {
		    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking2.Cli, z_ranking2.Hil, z_ranking2.Fl, z_ranking2.Spr, z_ranking2.Cbl, z_ranking2.TT, Ekipy.nazwa, Kolarze.id_user, Kolarze.id_team "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking2 ON Kolarze.id_kol = z_ranking2.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking2.TT DESC " 
			 . " LIMIT $limitd, $limitg ";
		  } else {
                    $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Nat.nazwa, z_ranking2.Cli, z_ranking2.Hil, z_ranking2.Fl, z_ranking2.Spr, z_ranking2.Cbl, z_ranking2.TT, Ekipy.nazwa, Kolarze.id_user, Kolarze.id_team "
                         . " FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN z_ranking2 ON Kolarze.id_kol = z_ranking2.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team "
	                 . " ORDER BY z_ranking2.Cli DESC "
			 . " LIMIT $limitd, $limitg ";
                  }
                  
    
      
    $runsql = mysql_query($sql) or die('mysql_query');
    $i=$limitd+1;
    echo '<table class="wyscig" rules="all">
    <tr><td class="wyscig1">'.zwroc_tekst(66, $jezyk).'</td><td class="wyscig7">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig12">'.zwroc_tekst(14, $jezyk).'</td></tr>
    ';
		  
    $podaj = 4 + $sort1; 		  
    
    while ($dane = mysql_fetch_row($runsql)) {
    if ($i == $_GET['zazn'])  {
      echo '<tr><td class="wyscig1"><b>'.$i.'</b></td>
      <td class="wyscig7"><b><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt='.$dane[4].' /> 
      <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' '.$dane[2].'</a><br/>';
      
      if ($dane[13] == 1000) {
         echo zwroc_tekst(22, $jezyk);
      } elseif ($dane[13] == 1001) {
         echo zwroc_tekst(21, $jezyk);
      } elseif ($dane[13] == 0) {
         echo zwroc_tekst(57, $jezyk);
      } else {
	 echo $dane[11];
      }  
      
      echo ' 
      </b></td><td class="wyscig12"><b>'.$dane[$podaj].'</b></td></tr>';
      $i++;
      
      
    } else {
      
    echo '<tr><td class="wyscig1">'.$i.'</td>
    <td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt='.$dane[4].' /> 
    <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</b></a><br/>';
      
      if ($dane[13] == 1000) {
         echo zwroc_tekst(22, $jezyk);
      } elseif ($dane[13] == 1001) {
         echo zwroc_tekst(21, $jezyk);
      } elseif ($dane[13] == 0) {
         echo zwroc_tekst(57, $jezyk);
      } else {
	 echo $dane[11];
      }  
      
      echo ' 
    </td><td class="wyscig12">'.$dane[$podaj].'</td></tr>
    
    ';
      $i++;
      
      }
    }
    

    echo '</table>
    
    <br/><br/>
    
    <a  name="skr"> </a>
          
    <b>'.zwroc_tekst(76, $jezyk).'</b> <br/>
    <font style="font-size: 7px; font-family: Courier, \'Courier New\', monospace; padding-right: 15px;">
    
    '.zwroc_tekst(77, $jezyk).'
    
    </font>';
    ?>
	  
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
