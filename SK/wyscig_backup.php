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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(118, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC"><br/>
	  <?php    
          $id_wys = $_GET['id_wys'];
	  $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP, YEAR(Wyscigi.dataP)  
	  FROM z_z_tlumacz_nat INNER JOIN (Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat) ON Nat.id_nat = z_z_tlumacz_nat.id_nat 
	  WHERE (((Wyscigi.id_wys)= '$id_wys' )) ";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  
  	  echo '<h1>'.$dane[1].'</h1>';
  	  
	  echo '<table class="wyscig" rules="all">
	  <tr><td><i>'.zwroc_tekst(23, $jezyk).': </i></td><td>'.$dane[3].' <img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>
          <tr><td><i>'.zwroc_tekst(63, $jezyk).': </i></td><td>'.$dane[5].'</td></tr>
	  <!-- <tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr> -->
	  <tr><td><i>'.zwroc_tekst(64, $jezyk).': </i></td><td>'.$dane[10].'</td></tr>
	  <tr><td><i>'.zwroc_tekst(65, $jezyk).': </i></td><td>'.$dane[11].'</td></tr>
	  </table>
	  '; 
	  $czas_wyscigu = $dane[10];
	  echo '
	  
	  <br/><br/>
	  
	  ';
          
          $rok_wyscigu = $dane[14];
          
          $zapy = "SELECT Co.id_co, Co.nazwa_pełna FROM Co ORDER BY Co.id_co";
	  $idzz = mysql_query($zapy) or die('mysql_query');
  	  while ($da = mysql_fetch_row($idzz)) {
  	    if ($da[0] <> 10) {
  	    
            $teraz_omawiane = $da[0];
            
            //echo $dane[14].' OOOooooOOO '.date('Y');
	         
	    if ($rok_wyscigu == date('Y')) {        
              $zap = " SELECT Wyniki.id_wyn, Wyniki.miejsce, Kolarze.imie, Kolarze.nazw, Nat.nazwa , Nat.flaga , Ekipy.nazwa , Ekipy.nazwa, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_kol, Wyniki.punkty, Ekipy.nazwa, Wyniki.wynik 
	         FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team 
		 WHERE ((((Wyniki.id_co) = '$teraz_omawiane' )) AND (((Wyniki.id_wys)= '$id_wys' )))
		 ORDER BY Wyniki.miejsce, Wyniki.wynik ";
            } else {
              $zap = " SELECT WynikiP.id_wyn, WynikiP.miejsce, Kolarze.imie, Kolarze.nazw, Nat.nazwa , Nat.flaga , Ekipy.nazwa , Ekipy.nazwa, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_kol, WynikiP.punkty, Ekipy.nazwa, WynikiP.wynik 
	         FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN WynikiP ON Kolarze.id_kol = WynikiP.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team 
		 WHERE ((((WynikiP.id_co) = '$teraz_omawiane' )) AND (((WynikiP.id_wys)= '$id_wys' )))
		 ORDER BY WynikiP.miejsce, WynikiP.wynik ";      
            }
		 
		 
		 
	    $idz = mysql_query($zap) or die('mysql_query');
	    $num_rows = mysql_num_rows($idz); 

            //echo $da[0].'<br/>'.$num_rows.' <- <br/>';
            
            if ($num_rows > 0) {
              $zapty = " SELECT z_EtapyKat.data, z_Kategorie.kategoria, z_Kategorie2.skrot, z_Kategorie.jpg "
                     . " FROM z_Kategorie AS z_Kategorie2 INNER JOIN (z_EtapyKat INNER JOIN z_Kategorie ON z_EtapyKat.id_kat = z_Kategorie.id_kat) ON z_EtapyKat.id_kat2 = z_Kategorie2.id_kat "
                     . " WHERE z_EtapyKat.id_wys = '$id_wys' AND id_co = '$teraz_omawiane' ";
              $idzty = mysql_query($zapty) or die('mysql_query');
              if (mysql_num_rows($idzty) == 0) {
	        
                echo '<a name="'.$teraz_omawiane.'"/>
	        ';
	        $zmiannapomocnicza = $teraz_omawiane + 20000;
	        echo '<h3>'.zwroc_tekst($zmiannapomocnicza, $jezyk).'
	        </h3>';
	        
	      } else {
              
                $danety = mysql_fetch_row($idzty);
                echo '<a name="'.$teraz_omawiane.'"/>
	        ';
	        $zmiannapomocnicza = $teraz_omawiane + 20000;
	        echo '<h3><a href="wyjskr.php" style="color: #ffffff;"><img src="graf/typetapu/'.$danety[3].'" /></a>'.zwroc_tekst($zmiannapomocnicza, $jezyk).'
	        ('.$danety[0].')</h3>';
	       
	       //echo ' - '.$danety[1].' <br/><br/>';
	      }
	      
	      echo '
	      
	      <table class="wyscig" rules="all">
	      <tr><td class="wyscig11">'.zwroc_tekst(66, $jezyk).'</td>
	      <td class="wyscig2">'.zwroc_tekst(32, $jezyk).'</td>
	      <td class="wyscig3">'.zwroc_tekst(23, $jezyk).'</td>
	      <td class="wyscig4">'.zwroc_tekst(56, $jezyk).'</td>
	      <td class="wyscig5">'.zwroc_tekst(67, $jezyk).'</td></tr>
		   ';
                 
	      
              $poprzedniemiejsce = 0;
	      while ($dane = mysql_fetch_row($idz)) {
	         $poprzedniemiejsce++;
                 if ($poprzedniemiejsce <> $dane[1]) {
                    while ($poprzedniemiejsce < $dane[1]) {
	              echo '<tr><td>'.$poprzedniemiejsce.'</td><td>'.zwroc_tekst(68, $jezyk).'</td><td> </td><td>('.zwroc_tekst(69, $jezyk).')</td><td> </td></tr>';
	              $poprzedniemiejsce++;
	            }
                 }
                 
		 echo '
		 <tr><td>'.$dane[1].'</td>
		 <td><a href="kol.php?id_kol='.$dane[10].'">'.$dane[2].' <b>'.$dane[3].'</b></a></td>
		 <td><a href="nat.php?id_nat='.$dane[9].'"><img src="http://fff.xon.pl/img/flagi/'.$dane[5].'" border=0 /></a></td>';
		 
		 
		 //echo '<td><a href="team.php?id_team='.$dane[8].'">'.$dane[6].'</a></td>';
		 echo '<td>';
		 $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		  FROM z_a_historiakol
		  WHERE (id_kol = '$dane[10]') AND (kiedy <= '$czas_wyscigu')
		  ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 
		 //echo $dane[10].') AND (kiedy <= '.$czas_wyscigu.'  '.$danhis[0].' '.$danhis[1].''.$danhis[2];
		 
		 $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.id_ek 
		  FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat
		  WHERE (z_a_historiaekip.id_ek = '$danhis[0]') AND (z_a_historiaekip.rok = '$danhis[2]') ";
	         $zaphise = mysql_query($sqlhise) or die('mysql_query');
	         $danhise = mysql_fetch_row($zaphise);
		 
		 echo '<a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		 
		 //$danhise[0]
		 if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		 
		 echo '</td>
		 <td style="text-align: right;">'.$dane[13].'</td></tr>
		 
		 ';
		 $poprzedniemiejsce = $dane[1];
 	       }

              echo '</table>
	      ';
            }

            
            }
          }
	     
	     
	       
	  ?>
	   <br/> <br/>
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
