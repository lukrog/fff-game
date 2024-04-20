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
	  $czysaetapy = false;
          $id_hiswys = $_GET['id_hiswys'];
          
          $zaphis = " SELECT id_wys  
	              FROM z_a_historiawyscig
                      WHERE (((id_hiswys)= '$id_hiswys' ))
		      ORDER BY id_wys DESC ";
	  $idzhis = mysql_query($zaphis) or die('mysql_query');
  	  $danehis = mysql_fetch_row($idzhis);
  	  
  	  $zap = " SELECT Wyscigi.nazwa
	           FROM Wyscigi 
	           WHERE (Wyscigi.id_wys)= '$danehis[0]' ";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  
  	  echo '<h1>'.$dane[0].'</h1>
	    <table  class="wyscig" rules="all">
	    <tr><td class="wyscig1">'.zwroc_tekst(42, $jezyk).'</td><td class="wyscig15">'.zwroc_tekst(17, $jezyk).'</td>
	    <td class="wyscig3">'.zwroc_tekst(63, $jezyk).'</td><td class="wyscig14">'.zwroc_tekst(154, $jezyk).'</td></tr>
  	      
	    ';
          //----------------------------------------------------------

	  $zaphis = " SELECT id_wys, info 
	              FROM z_a_historiawyscig
                      WHERE id_hiswys= '$id_hiswys'
		      ORDER BY id_wys DESC ";
	  $idzhis = mysql_query($zaphis) or die('mysql_query');
  	  while ($danehis = mysql_fetch_row($idzhis)) {
	      // tu się pojawi wyświetlanie poszczególnych lat.
	               
	      $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP, YEAR(Wyscigi.dataP)  
	               FROM z_z_tlumacz_nat, Wyscigi, Nat
	               WHERE Wyscigi.id_wys= '$danehis[0]' AND Wyscigi.id_nat = Nat.id_nat AND Nat.id_nat = z_z_tlumacz_nat.id_nat 
		       ";                       
	      $idz = mysql_query($zap) or die('mysql_query');
  	      $dane = mysql_fetch_row($idz);
  	      
  	      
  	      
  	      $dzien_pocz = date("d", strtotime($dane[10]));
  	      $miesiac_pocz = date("m", strtotime($dane[10]));
  	      $dzien_kon = date("j", strtotime($dane[11]));
  	      $miesiac_kon = date("m", strtotime($dane[11]));
  	      
  	      echo '<tr><td class="wyscig1">'.$dane[14].'</td>
		<td class="wyscig15"><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt=""/> <a href="wyscig.php?id_wys='.$danehis[0].'">'.$dane[1].'</a></td>
		   <td class="wyscig3">&nbsp;'.$dane[5].'</td>
		   <td class="wyscig14">
	           &nbsp;'.$dzien_pocz.'-'.$miesiac_pocz.'';
	      if ($dzien_pocz <> $dzien_kon) {
	        echo ' --- '.$dzien_kon.'-'.$miesiac_kon.' </td></tr>';
	      }   
		   
  	      $poi = "SELECT id_co FROM Wyniki WHERE (id_co > 20 AND id_wys = '$danehis[0]')";
	      $poiu = mysql_query($poi) or die('mysql_query');
	      $poik = mysql_num_rows($poiu);
	      if ($poik > 0) {$czysaetapy=true;}
              $poi = "SELECT id_co FROM WynikiP WHERE (id_co > 20 AND id_wys = '$danehis[0]')";
	      $poiu = mysql_query($poi) or die('mysql_query');
	      $poik = mysql_num_rows($poiu);
	      if ($poik > 0) {$czysaetapy=true;}
  	      
	  }
          
          echo '</table><br/><br/>
	  ';
	  
	  
	  
	  
          echo ' <table  class="wyscig" rules="all">
	         <tr><td class="wyscig1">'.zwroc_tekst(42, $jezyk).'</td>
		 <td class="wyscig8">'.zwroc_tekst(124, $jezyk).'</td>
		 <td class="wyscig8">'.zwroc_tekst(155, $jezyk).'</td>
	         <td class="wyscig8">'.zwroc_tekst(156, $jezyk).'</td></tr>
  	      
	    ';
	  $zaphis = " SELECT id_wys, info 
	              FROM z_a_historiawyscig
                      WHERE (((id_hiswys)= '$id_hiswys' ))
		      ORDER BY id_wys DESC ";
	  $idzhis = mysql_query($zaphis) or die('mysql_query');
	  
  	  while ($danehis = mysql_fetch_row($idzhis)) {
	      //------------------------------------------------------
	      //     tu się pojawią miejca z poszczególnych lat.
	      //            w klasyfikacji generalnej
	      //------------------------------------------------------
	      
	      $roktrwania = ($danehis[0] / 1000) + 2000;
	      $roktrwania = (int)$roktrwania;
              //------------------------------------------------------	      
	      //        Zamieniamy id_wys na rok rozgrywania:
	      //        np.: 11001; 11001/1000 = 11,001 ~~ 11
	      //------------------------------------------------------
	      
	      
	      if ($roktrwania == date('Y')) {        
                 $zapmie = " SELECT id_wys, miejsce, id_kol
	                     FROM Wyniki 
		             WHERE ((id_wys = '$danehis[0]') AND (id_co = 0))
		             ORDER BY miejsce 
		             LIMIT 0 , 3";
              } else {
	         $zapmie = " SELECT id_wys, miejsce, id_kol
	                     FROM WynikiP 
		             WHERE ((id_wys = '$danehis[0]') AND (id_co = 0))
		             ORDER BY miejsce 
		             LIMIT 0 , 3";       
              } 
	    $idzmie = mysql_query($zapmie) or die('mysql_query');
  	    $danemie = mysql_fetch_row($idzmie);
  	     
            $zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	                 FROM Nat, Kolarze
	                 WHERE Kolarze.id_kol= '$danemie[2]' AND Nat.id_nat = Kolarze.id_nat "; 
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
  	    $dane_opi = mysql_fetch_row($idz_opi);
	    
	    //------------------------------------------------------
	    //              wyciągamy zwycięzcę
	    //------------------------------------------------------		   	      
  	     	      
  	    echo '<tr><td class="wyscig1"><a href="wyscig.php?id_wys='.$danehis[0].'">'.(int)$roktrwania.'</a></td><td class="wyscig8"><img src="http://fff.xon.pl/img/flagi/'.$dane_opi[3].'" alt=""/> <a href="kol.php?id_kol='.$danemie[2].'">'.$dane_opi[1].' <b>'.$dane_opi[2].'</b></td><td class="wyscig8">';
  	     
	    $danemie = mysql_fetch_row($idzmie);  
	    $zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	                 FROM Nat, Kolarze 
	                 WHERE Kolarze.id_kol= '$danemie[2]' AND Nat.id_nat = Kolarze.id_nat "; 	      
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
  	    $dane_opi = mysql_fetch_row($idz_opi);
	    
	    //------------------------------------------------------
	    //           II miejsce
	    //------------------------------------------------------
	    	      
  	    echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_opi[3].'" alt=""/> <a href="kol.php?id_kol='.$danemie[2].'">'.$dane_opi[1].' <b>'.$dane_opi[2].'</b></td><td class="wyscig8">';
  	     
	    $danemie = mysql_fetch_row($idzmie);
	    $zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	                 FROM Nat, Kolarze
	                 WHERE Kolarze.id_kol= '$danemie[2]' AND Nat.id_nat = Kolarze.id_nat "; 		      
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
  	    $dane_opi = mysql_fetch_row($idz_opi);
	    
	    //------------------------------------------------------
	    //         III miejsce
	    //------------------------------------------------------
	    	   	           
  	    echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_opi[3].'" alt=""/> <a href="kol.php?id_kol='.$danemie[2].'">'.$dane_opi[1].' <b>'.$dane_opi[2].'</b></td></tr>';
  	    
	  }
          
          echo '</table>
	  <br/><br/>';
          
          //test statysyki wyścigu
	  //if ($_SESSION['boss'] >= 1) {
	    
	    
	    echo 'Statystyki  TEST TEST TEST Alfa version:
	         <br/> najpierw wg osób na podium wyścigu na razie główne';
	         

	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT WynikiALL.id_kol, COUNT(WynikiALL.id_wys), Kolarze.imie, Kolarze.nazw, Nat.flaga
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=1 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co=0 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_kol
			 HAVING COUNT(WynikiALL.id_wys) > 1
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    //echo $sql_stat.'<br/>';		 
			 
	    $idz_stat = mysql_query($sql_stat) or die('coś nie działa');
	    //echo 'pl <br/>'.mysql_num_rows($idz_stat);
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotni zwycięzcy:</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[4].'" /> '.$dane_stat[2].' '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	    
	    //wielokrotne podium
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT WynikiALL.id_kol, COUNT(WynikiALL.id_wys), Kolarze.imie, Kolarze.nazw, Nat.flaga
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=3 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co=0 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_kol
			 HAVING COUNT(WynikiALL.id_wys) > 1
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie na podium</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[4].'" /> '.$dane_stat[2].' '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	  
	    //wielokrotne zw etap
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT WynikiALL.id_kol, COUNT(WynikiALL.id_wys), Kolarze.imie, Kolarze.nazw, Nat.flaga
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=1 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co>100 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_kol
			 HAVING COUNT(WynikiALL.id_wys) > 2
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie zwycięstwo etap</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[4].'" /> '.$dane_stat[2].' '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	  
	    //wielokrotne 3 etap
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT WynikiALL.id_kol, COUNT(WynikiALL.id_wys), Kolarze.imie, Kolarze.nazw, Nat.flaga
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=3 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co>100 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_kol
			 HAVING COUNT(WynikiALL.id_wys) > 4
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie podium etap</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[4].'" /> '.$dane_stat[2].' '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	  
	  echo '<h3>Narodowości</h3>';
	  //wielokrotne 1 narodowość
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT Nat.id_nat, COUNT(WynikiALL.id_wys),  flaga, Nat.nazwa
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=1 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co=0 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_nat
			 HAVING COUNT(WynikiALL.id_wys) > 1
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie zwycięstwo</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[2].'" /> '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	  
	  //wielokrotne 3 narodowość
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT Nat.id_nat, COUNT(WynikiALL.id_wys),  flaga, Nat.nazwa
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=3 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co=0 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_nat
			 HAVING COUNT(WynikiALL.id_wys) > 2
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie na podium</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[2].'" /> '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	  
	  
	  //wielokrotne 1 narodowość etap
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT Nat.id_nat, COUNT(WynikiALL.id_wys),  flaga, Nat.nazwa
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=1 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co>100 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_nat
			 HAVING COUNT(WynikiALL.id_wys) > 2
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie zwycięstwo etapowe</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[2].'" /> '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	 
	 
	 //wielokrotne 1 narodowość etap
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT Nat.id_nat, COUNT(WynikiALL.id_wys),  flaga, Nat.nazwa
                         FROM WynikiALL, z_a_historiawyscig, Kolarze, Nat
			 WHERE WynikiALL.miejsce<=3 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co>100 AND Kolarze.id_kol = WynikiALL.id_kol 
			 AND Nat.id_nat=Kolarze.id_nat
			 GROUP BY Kolarze.id_nat
			 HAVING COUNT(WynikiALL.id_wys) > 10
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>wielokrotnie podium etapowe</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_stat[2].'" /> '.$dane_stat[3].' - '.$dane_stat[1].' razy <br/>';
	      }	      
            }
	 
	    //wielokrotne 1 ekipy 
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT COUNT(WynikiALL.id_wys), WynikiALL.ekipaW
                         FROM WynikiALL, z_a_historiawyscig
			 WHERE WynikiALL.miejsce<=1 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co=0			 
			 GROUP BY WynikiALL.ekipaW
			 HAVING COUNT(WynikiALL.id_wys) > 1
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>zwycięstwa ekip</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
	        //trzeba wyciągnąć flagę i nazwę oraz pierwszy i ostatni rok działalności ekipy
	        //                              0                              1                2
	        $sql_ekiphis = "SELECT `z_a_historiaekip`.`nazwa`, `z_a_historiaekip`.`rok`, Nat.flaga
		                FROM `z_a_historiaekip`, `Nat` 
				WHERE `id_ek`='$dane_stat[1]' AND z_a_historiaekip.id_nat = Nat.id_nat
				ORDER BY `rok` DESC";
	        $idz_ekiphis = mysql_query($sql_ekiphis) or die('mysql_query');
	        $dane_ekiphis = mysql_fetch_row($idz_ekiphis);
	        $rok_ostatni = $dane_ekiphis[1];
	        $nazwa = $dane_ekiphis[0];
	        $flaga = $dane_ekiphis[2];
	        
		if ($rok_ostatni == date("Y")) {
		  
		  $lata = 'istnieje do dziś';
		} else {
		  $lata = 'istniała do '.$rok_ostatni;
		}
	        
	        //echo $dane_stat[1].' - '.$dane_stat[0].' razy <br/>';
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$flaga.'" /> '.$nazwa.' (<i>'.$lata.'</i>) - '.$dane_stat[0].' razy <br/>';
	      }	      
            }
	 
	 //wielokrotne 3 ekipy 
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT COUNT(WynikiALL.id_wys), WynikiALL.ekipaW
                         FROM WynikiALL, z_a_historiawyscig
			 WHERE WynikiALL.miejsce<=3 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co=0			 
			 GROUP BY WynikiALL.ekipaW
			 HAVING COUNT(WynikiALL.id_wys) > 1
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>podium ekip</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
	        //trzeba wyciągnąć flagę i nazwę oraz pierwszy i ostatni rok działalności ekipy
	        //                              0                              1                2
	        $sql_ekiphis = "SELECT `z_a_historiaekip`.`nazwa`, `z_a_historiaekip`.`rok`, Nat.flaga
		                FROM `z_a_historiaekip`, `Nat` 
				WHERE `id_ek`='$dane_stat[1]' AND z_a_historiaekip.id_nat = Nat.id_nat
				ORDER BY `rok` DESC";
	        $idz_ekiphis = mysql_query($sql_ekiphis) or die('mysql_query');
	        $dane_ekiphis = mysql_fetch_row($idz_ekiphis);
	        $rok_ostatni = $dane_ekiphis[1];
	        $nazwa = $dane_ekiphis[0];
	        $flaga = $dane_ekiphis[2];
	        
		if ($rok_ostatni == date("Y")) {
		  
		  $lata = 'istnieje do dziś';
		} else {
		  $lata = 'istniała do '.$rok_ostatni;
		}
	        
	        //echo $dane_stat[1].' - '.$dane_stat[0].' razy <br/>';
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$flaga.'" /> '.$nazwa.' (<i>'.$lata.'</i>) - '.$dane_stat[0].' razy <br/>';
	      }	      
            }
	 
	 //wielokrotne 1 ekipy etap
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT COUNT(WynikiALL.id_wys), WynikiALL.ekipaW
                         FROM WynikiALL, z_a_historiawyscig
			 WHERE WynikiALL.miejsce<=1 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co>100			 
			 GROUP BY WynikiALL.ekipaW
			 HAVING COUNT(WynikiALL.id_wys) > 5
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>zwycięstwa etapowe ekip</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
	        //trzeba wyciągnąć flagę i nazwę oraz pierwszy i ostatni rok działalności ekipy
	        //                              0                              1                2
	        $sql_ekiphis = "SELECT `z_a_historiaekip`.`nazwa`, `z_a_historiaekip`.`rok`, Nat.flaga
		                FROM `z_a_historiaekip`, `Nat` 
				WHERE `id_ek`='$dane_stat[1]' AND z_a_historiaekip.id_nat = Nat.id_nat
				ORDER BY `rok` DESC";
	        $idz_ekiphis = mysql_query($sql_ekiphis) or die('mysql_query');
	        $dane_ekiphis = mysql_fetch_row($idz_ekiphis);
	        $rok_ostatni = $dane_ekiphis[1];
	        $nazwa = $dane_ekiphis[0];
	        $flaga = $dane_ekiphis[2];
	        
		if ($rok_ostatni == date("Y")) {
		  
		  $lata = 'istnieje do dziś';
		} else {
		  $lata = 'istniała do '.$rok_ostatni;
		}
	        
	        //echo $dane_stat[1].' - '.$dane_stat[0].' razy <br/>';
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$flaga.'" /> '.$nazwa.' (<i>'.$lata.'</i>) - '.$dane_stat[0].' razy <br/>';
	      }	      
            }
            
            
	 //wielokrotne 3 ekipy etap
	    //                         0                   1                    2              3          4
	    $sql_stat = "SELECT COUNT(WynikiALL.id_wys), WynikiALL.ekipaW
                         FROM WynikiALL, z_a_historiawyscig
			 WHERE WynikiALL.miejsce<=3 AND WynikiALL.id_wys=z_a_historiawyscig.id_wys 
			 AND id_hiswys='$id_hiswys' AND WynikiALL.id_co>100			 
			 GROUP BY WynikiALL.ekipaW
			 HAVING COUNT(WynikiALL.id_wys) > 10
			 ORDER BY COUNT(WynikiALL.id_wys) DESC, WynikiALL.id_wys DESC";
	    $idz_stat = mysql_query($sql_stat) or die('mysql_query');
  	    if (mysql_num_rows($idz_stat) > 0) {
  	      
  	      echo '<h4>podia etapowe ekip</h4>';
  	      
	      while ($dane_stat = mysql_fetch_row($idz_stat))	{
	        //trzeba wyciągnąć flagę i nazwę oraz pierwszy i ostatni rok działalności ekipy
	        //                              0                              1                2
	        $sql_ekiphis = "SELECT `z_a_historiaekip`.`nazwa`, `z_a_historiaekip`.`rok`, Nat.flaga
		                FROM `z_a_historiaekip`, `Nat` 
				WHERE `id_ek`='$dane_stat[1]' AND z_a_historiaekip.id_nat = Nat.id_nat
				ORDER BY `rok` DESC";
	        $idz_ekiphis = mysql_query($sql_ekiphis) or die('mysql_query');
	        $dane_ekiphis = mysql_fetch_row($idz_ekiphis);
	        $rok_ostatni = $dane_ekiphis[1];
	        $nazwa = $dane_ekiphis[0];
	        $flaga = $dane_ekiphis[2];
	        
		if ($rok_ostatni == date("Y")) {
		  
		  $lata = 'istnieje do dziś';
		} else {
		  $lata = 'istniała do '.$rok_ostatni;
		}
	        
	        //echo $dane_stat[1].' - '.$dane_stat[0].' razy <br/>';
  	        echo '<img src="http://fff.xon.pl/img/flagi/'.$flaga.'" /> '.$nazwa.' (<i>'.$lata.'</i>) - '.$dane_stat[0].' razy <br/>';
	      }	      
            }
	 
	 
	 
	 
	 // } //boss
          
	  
	  ?>
	   <br/> <br/>
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
