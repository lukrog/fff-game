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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(116, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	   <div id="TRESC">
	   <?php    
           $id_kol = $_GET['id_kol'];
	   $id_rok = $_GET['rok'];
	   $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , z_z_tlumacz_nat.".$jezyk." , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, User.id_user, Kolarze.zdjecie
	            FROM z_z_tlumacz_nat, User, Ekipy, Nat, Kolarze
		    WHERE Kolarze.id_kol = '$id_kol' AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user AND Nat.id_nat = z_z_tlumacz_nat.id_nat
		    ";
           $idzapytania = mysql_query($sql) or die(mysql_error());
          
           $dane = mysql_fetch_row($idzapytania);
           echo '<h1>'.$dane[0].' '.$dane[1].'</h1>
	   <img src="'.$dane[10].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right style="padding-right: 20px;" /><br/>
	   <table class="wyscig" rules="all">
	   <tr><td class="wyscig13"><i>'.zwroc_tekst(33, $jezyk).': </i></td><td class="wyscig9">'.$dane[2].'</td></tr>';
	   
	   $tescik = strtotime($dane[2]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
	   
	   echo '
	   <tr><td><i>'.zwroc_tekst(34, $jezyk).':</i></td><td>'.$tescik2.'
	   <tr><td><i>'.zwroc_tekst(79, $jezyk).': </i></td><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a></td></tr>
	   <tr><td></td><td><a href="kol.php?id_kol='.$id_kol.'">'.zwroc_tekst(97, $jezyk).'</a></td></tr>
	   
	   </table><br/><br/><br/>
	   ';
	  
	  
	  
	  
	  
          $roczek = date('Y');
	  $roczek1 = $roczek -1;
	  
          
          
          //--------------------/
	  //  historia kolarza  /
	  //--------------------/
	  echo '<h2>'.zwroc_tekst(96, $jezyk).':</h2>';
	  
	  echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig6">'.zwroc_tekst(84, $jezyk).'</td><td class="wyscig7">'.zwroc_tekst(56, $jezyk).'</td></tr>';
          $sqlhis = " SELECT id_kol, id_z, id_do, kiedy, YEAR(kiedy), MONTH(kiedy), DAY(kiedy)
	              FROM z_a_historiakol
		      WHERE id_kol = '$id_kol' AND YEAR(kiedy) = '$id_rok'
		      ORDER BY kiedy DESC ";
	  $zaphis = mysql_query($sqlhis) or die('mysql_query');
	  while ($danhis = mysql_fetch_row($zaphis))
	  {
	    	    
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga
	                 FROM z_a_historiaekip, Nat
			 WHERE (z_a_historiaekip.id_ek = '$danhis[2]') AND (z_a_historiaekip.rok = '$danhis[4]') AND (z_a_historiaekip.id_nat = Nat.id_nat) ";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
	    $danhise = mysql_fetch_row($zaphise);
	    
	    
	    if (($danhis[5] > 1) OR ($danhis[6] > 1)) {
	      echo '<tr><td>'.$danhis[3];
	    } else {
              echo '<tr><td>'.$danhis[4];
            }  
	    echo '</td><td>',$danhise[0],' <img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" alt="flaga" /> ('.$danhise[2].') - '.$danhise[3].'</td><td>';
	    
	    
          }
	  echo '
                </table>';
           
	  
	  
	  
	  if (date('Y') == $id_rok) {
	  $pun=0;
          $pocz = 1000 * (date("Y")-2000);
	  $kon = 1000 * (date("Y")+1-2000);
	  //--------------------------/
	  //         WYNIKI           /
	  //--------------------------/
          echo '<h2>'.zwroc_tekst(98, $jezyk).':</h2>';
	  //$sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, Wyniki.miejsce, Wyniki.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), Wyniki.wynik, Co.id_co
	  //         FROM Co INNER JOIN (Nat INNER JOIN (Wyscigi INNER JOIN Wyniki ON Wyscigi.id_wys = Wyniki.id_wys) ON Nat.id_nat = Wyscigi.id_nat) ON Co.id_co = Wyniki.id_co
          // 	     WHERE Wyniki.id_kol='$id_kol' AND Wyniki.id_wys > '$pocz' AND Wyniki.id_wys < '$kon'
	  //	     ORDER BY DATE(Wyscigi.dataP), Co.id_co ";
		   
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, Wyniki.miejsce, Wyniki.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), Wyniki.wynik, Co.id_co
	           FROM Co, Nat, Wyscigi, Wyniki
		   WHERE Wyniki.id_kol='$id_kol' AND Wyniki.id_wys > '$pocz' AND  Wyniki.id_wys < '$kon' AND Wyscigi.id_wys = Wyniki.id_wys AND Co.id_co = Wyniki.id_co AND Nat.id_nat = Wyscigi.id_nat
		   ORDER BY DATE(Wyscigi.dataP), Co.id_co ";	   
		   
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(99, $jezyk).'</td><td class="wyscig11">'.zwroc_tekst(87, $jezyk).'</td></tr>';
          while ($dane = mysql_fetch_row($idzapytania))
          {
           if (($dane[9] == 10)) {
              
           } else { 
            
           $sqliop = " SELECT z_Kategorie.skrot, z_Kategorie.jpg "
	           . " FROM z_Kategorie, z_EtapyKat " 
	           . " WHERE id_wys = '$dane[6]' AND id_co = '$dane[9]' AND z_Kategorie.id_kat=z_EtapyKat.id_kat ";
	   $zapiop = mysql_query($sqliop) or die(mysql_error());
	   if (mysql_num_rows($zapiop)== 0) {
	     $typetapu = "brak.jpg";
	   } else {
	     $daniop = mysql_fetch_row($zapiop);        
	     $typetapu = $daniop[1];
	   }
	   
	   
            
           echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[1].'" alt="flaga" /> <a href="wyscigetap.php?id_wys='.$dane[6].'&id_co='.$dane[9].'">'.$dane[0].'</a> ('.$dane[2].') ';
	   
           //echo ' <font style="color: green;">'.$daniop[0].'</font>';
           
	   echo '</td><td class="wyscig11"><img src="graf/typetapu/'.$typetapu.'" alt="" style="width: 10px; height: 10px;" />';
	   
	   
	   
	   $zmiannapomocnicza = $dane[9] + 10000;
	   echo zwroc_tekst($zmiannapomocnicza, $jezyk).'</td><td>';
	   if ($dane[9] == 10) {
             echo $dane[8];
           } else {
	     echo $dane[4];
	   }
	   
	   echo '</td></tr>
	   ';
	   }
          }
          echo '</table>
	  <br/>';

          } else {


          echo '<h2>'.zwroc_tekst(100, $jezyk).' '.$id_rok.':</h2>';
          $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, WynikiP.miejsce, WynikiP.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), WynikiP.wynik, Co.id_co
	           FROM Co, Nat, Wyscigi, WynikiP
		   WHERE WynikiP.id_kol='$id_kol' AND YEAR(Wyscigi.dataP) = '$id_rok' AND Wyscigi.id_wys = WynikiP.id_wys AND Nat.id_nat = Wyscigi.id_nat AND Co.id_co = WynikiP.id_co
	           ORDER BY DATE(Wyscigi.dataP), Co.id_co";
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(99, $jezyk).'</td><td class="wyscig11">'.zwroc_tekst(87, $jezyk).'</td></tr>';
          while ($dane = mysql_fetch_row($idzapytania))
          {
           if ($dane[9] == 10) {
           } else {
	     
	    
           
           $sqliop = " SELECT z_Kategorie.skrot, z_Kategorie.jpg
	               FROM z_Kategorie, z_EtapyKat 
		       WHERE id_wys = '$dane[6]' AND id_co = '$dane[9]' AND z_Kategorie.id_kat=z_EtapyKat.id_kat ";
	   $zapiop = mysql_query($sqliop) or die(mysql_error());
	   if (mysql_num_rows($zapiop)== 0) {
	     $typetapu = "brak.jpg";
	   } else {
	     $daniop = mysql_fetch_row($zapiop);        
	     $typetapu = $daniop[1];
	   } 
	    
           echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[1].'" alt="flaga" /> <a href="wyscig.php?id_wys='.$dane[6].'">'.$dane[0].'</a> ('.$dane[2].') ';
	   
           //echo ' <font style="color: green;">'.$daniop[0].'</font>';
           
	   echo '</td><td class="wyscig11"><img src="graf/typetapu/'.$typetapu.'" alt="" style="width: 10px; height: 10px;" />';
	   
	   
	   
	   $zmiannapomocnicza = $dane[9] + 10000;
	   echo zwroc_tekst($zmiannapomocnicza, $jezyk).'</td><td>';
	   echo $dane[4];
 
	   echo '</td></tr>
	   ';
	   }
          }
          echo '</table>
	  <br/>';
	   
	  } 
	   
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
