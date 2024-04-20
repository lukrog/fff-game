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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(117, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  <br/> <br/>
	   <?php 
	   
	  
	   
	  $czy_w_tym_roku_istniala = 0;
          $id_rok = $_GET['rok'];
	  $id_team = $_GET['id_team'];
	  
	  echo '<a href="team.php?id_team='.$id_team.'">'.zwroc_tekst(139, $jezyk).'</a><br/><br/>'; 
	  
	  echo '<table class="wyscig" rules="all">';
          echo '<tr><td>'.zwroc_tekst(42, $jezyk).'</td><td>'.zwroc_tekst(17, $jezyk).'</td><td>'.zwroc_tekst(18, $jezyk).'</td><td>'.zwroc_tekst(24, $jezyk).'</td></tr>';
	  
	  
	  $rok_poprzedni = 2000;
	  $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.rok, z_a_historiaekip.id_ek
	               FROM z_a_historiaekip, Nat
		       WHERE z_a_historiaekip.id_ek = '$id_team' AND z_a_historiaekip.id_nat = Nat.id_nat
		       ORDER BY z_a_historiaekip.rok ";
	  $zaphise = mysql_query($sqlhise) or die('mysql_query');
	  while ($danhise = mysql_fetch_row($zaphise))
	  {
	    $rokobecny = $rok_poprzedni + 1;
	    if (($rokobecny <> $danhise[5]) AND ($rokobecny <> 2001)) {
	       if ($rokobecny == $id_rok)  {
	       echo '<tr><td class="wyscig5"><b><a href="teamh.php?id_team='.$id_team.'&rok='.$rokobecny.'">'.$rokobecny.'</a></b></td>
		<td class="wyscig7"><b>'.zwroc_tekst(51, $jezyk).'</b></td>
		<td class="wyscig5"> </td><td class="wyscig5"> </td></tr>
		
		';
	      } else {
                echo '<tr><td class="wyscig5"><a href="teamh.php?id_team='.$id_team.'&rok='.$rokobecny.'">'.$rokobecny.'</a></td>
		<td class="wyscig7">'.zwroc_tekst(51, $jezyk).'</td>
		<td class="wyscig5"> </td><td class="wyscig5"> </td></tr>
		
		';
              }
	    } 
	     if ($danhise[5] == $id_rok) {
	        echo '<tr><td class="wyscig5"><b>'.$danhise[5].'</b></td>
		<td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" alt="flaga" /> <b>';
		
		if ($danhise[6] == 1000) {
                  echo zwroc_tekst(22, $jezyk);
	       } elseif ($danhise[6] == 1001) {
                  echo zwroc_tekst(21, $jezyk);
	       } else {
	          echo $danhise[0];
	       }  
		
		echo '</b></td>
		<td class="wyscig5">'.$danhise[2].'</td><td class="wyscig5">'.$danhise[3].'</td</tr>
		
		';
	        $czy_w_tym_roku_istniala = 1;
	     } else {
                echo '<tr><td class="wyscig5"><a href="teamh.php?id_team='.$id_team.'&rok='.$danhise[5].'">'.$danhise[5].'</a></td>
		<td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" alt="flaga" /> ';
		
		if ($danhise[6] == 1000) {
                  echo zwroc_tekst(22, $jezyk);
	       } elseif ($danhise[6] == 1001) {
                  echo zwroc_tekst(21, $jezyk);
	       } else {
	          echo $danhise[0];
	       }  
		
		echo '</td>
		<td class="wyscig5">'.$danhise[2].'</td><td class="wyscig5">'.$danhise[3].'</td></tr>
		
		';
             }   
	     $rok_poprzedni = $danhise[5];
 
	  }
	  
	  $rokobecny = $rok_poprzedni + 1;
	  if ($rokobecny > date("Y")) {
             $napis = zwroc_tekst(52, $jezyk);
          } else {
             $napis = zwroc_tekst(51, $jezyk);
          }
	    
	       if ($rokobecny == $id_rok) {
	       echo '<tr><td class="wyscig5"><b><a href="teamh.php?id_team='.$id_team.'&rok='.$rokobecny.'">'.$rokobecny.'</a></b></td>
		<td class="wyscig7"><b>'.$napis.'</b></td>
		<td class="wyscig5"> </td><td class="wyscig5"> </td></tr>
		
		';
	      } else {
                echo '<tr><td class="wyscig5"><a href="teamh.php?id_team='.$id_team.'&rok='.$rokobecny.'">'.$rokobecny.'</a></td>
		<td class="wyscig7">'.$napis.'</td>
		<td class="wyscig5"> </td><td class="wyscig5"> </td></tr>
		
		';
              }
	  
	  
	  echo '</table>';
	  
	  
	  
	  echo '
	  
	  <br/><br/>'.zwroc_tekst(43, $jezyk).' '.$id_rok.'.<br/><br/>
	  ';
	  
	  //-------------------------------------/
          //  Kolarze którzy zostali w drużynie  /   
          //-------------------------------------/
             

          if (($id_team == 1000) OR ($id_team == 0)) {} else {
          if ($id_rok > date("Y")) {
            echo '<h2>'.zwroc_tekst(48, $jezyk).'</h2>';
            //$zap = " SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, YEAR(z_a_historiakolprop.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	    //         FROM (z_a_historiakolprop INNER JOIN Kolarze ON z_a_historiakolprop.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat 
	//	     WHERE z_a_historiakolprop.id_do = '$id_team' AND z_a_historiakolprop.id_z = '$id_team' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' 
	//	     ORDER BY Kolarze.nazw, Kolarze.imie ";
	
	    $zap = " SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, YEAR(z_a_historiakolprop.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	             FROM z_a_historiakolprop, Kolarze, Nat
		     WHERE z_a_historiakolprop.id_do = '$id_team' AND z_a_historiakolprop.id_z = '$id_team' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' AND Kolarze.id_nat = Nat.id_nat AND z_a_historiakolprop.id_kol = Kolarze.id_kol
		     ORDER BY Kolarze.nazw, Kolarze.imie ";	     
		     
          } else {
            echo '<h2>'.zwroc_tekst(44, $jezyk).'</h2>';
            //$zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	    //         FROM (z_a_historiakol INNER JOIN Kolarze ON z_a_historiakol.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat 
	//	     WHERE z_a_historiakol.id_do = '$id_team' AND z_a_historiakol.id_z = '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' 
	//	     ORDER BY Kolarze.nazw, Kolarze.imie ";
	    
	    $zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie, Kolarze.nazw, Kolarze.dataU, Nat.nazwa , Nat.flaga 
	             FROM z_a_historiakol, Kolarze, Nat 
		     WHERE z_a_historiakol.id_do = '$id_team' AND  z_a_historiakol.id_z = '$id_team' AND  YEAR(z_a_historiakol.kiedy) = '$id_rok' AND z_a_historiakol.id_kol = Kolarze.id_kol AND Kolarze.id_nat = Nat.id_nat  
		     ORDER BY Kolarze.nazw, Kolarze.imie ";
          }
	  
          $idz = mysql_query($zap) or die('mysql_query');
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig1">'.zwroc_tekst(34, $jezyk).'</td></tr>';
  	  while ($dane = mysql_fetch_row($idz)) {
  	  
	    
  	   $tescik = strtotime($dane[7]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
  	   $tescik2 = $tescik2 + $id_rok - date("Y"); 
  	    
  	       echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[9].'" alt='.$dane[8].'> 
		 <a href="kol.php?id_kol='.$dane[0].'">'.$dane[5].' <b>'.$dane[6].'</a></td>
		 <td>'.$tescik2.'</td></tr>
		 
	    ';
	  }
          echo '</table>
	  
	  <br/><br/>';
          }
          
          
	  //-------------------------------------/
          //      Kolarze którzy przychodzą      /   
          //-------------------------------------/
   
	  if ($id_rok > date("Y")) {
            echo '<h2>'.zwroc_tekst(49, $jezyk).'</h2>';
            //$zap = " SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, YEAR(z_a_historiakolprop.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	    //         FROM (z_a_historiakolprop INNER JOIN Kolarze ON z_a_historiakolprop.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat 
	//	     WHERE z_a_historiakolprop.id_do = '$id_team' AND z_a_historiakolprop.id_z <> '$id_team' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' 
	//	     ORDER BY z_a_historiakolprop.kiedy, Kolarze.nazw, Kolarze.imie ";
		     
	    $zap = " SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, YEAR(z_a_historiakolprop.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	             FROM z_a_historiakolprop, Kolarze, Nat
		     WHERE z_a_historiakolprop.id_do = '$id_team' AND z_a_historiakolprop.id_z <> '$id_team' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' AND Kolarze.id_nat = Nat.id_nat AND z_a_historiakolprop.id_kol = Kolarze.id_kol
		     ORDER BY Kolarze.nazw, Kolarze.imie ";	     
		     
          } else {
            echo '<h2>'.zwroc_tekst(45, $jezyk).'</h2>';  
            //$zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga "
            //   . " FROM (z_a_historiakol INNER JOIN Kolarze ON z_a_historiakol.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat "
	    //   . " WHERE z_a_historiakol.id_do = '$id_team' AND z_a_historiakol.id_z <> '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' "
	    //   . " ORDER BY z_a_historiakol.kiedy, Kolarze.nazw, Kolarze.imie ";
	       
	    $zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga
	             FROM z_a_historiakol, Kolarze, Nat 
		     WHERE z_a_historiakol.id_do = '$id_team' AND z_a_historiakol.id_z <> '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' AND Kolarze.id_nat = Nat.id_nat AND z_a_historiakol.id_kol = Kolarze.id_kol
		     ORDER BY z_a_historiakol.kiedy, Kolarze.nazw, Kolarze.imie ";   
          }     
	       
	  echo '<table class="wyscig" rules="all"> 
	        <tr><td class="wyscig2">'.zwroc_tekst(32, $jezyk).'<td class="wyscig8"> </td></td><td class="wyscig1">'.zwroc_tekst(34, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(53, $jezyk).'</td></tr>';
	       
	  $czybyljuznaglowek = FALSE;
	  $poczatekroku = $id_rok;
	  $poczatekroku .= "-01-01";
	  
	  //echo $zap;
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	   
  	   if (($dane[3] <> $poczatekroku) AND ($czybyljuznaglowek == FALSE))
	   {
	     echo "<tr><td colspan='4' align='center'><br/><h3>".zwroc_tekst(130, $jezyk)."</h3></td></tr>";
	     $czybyljuznaglowek = TRUE;
	     
	   } 
  	   
           $tescik = strtotime($dane[7]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
  	   $tescik2 = $tescik2 + $id_rok - date("Y");
  	    
  	    $dzieńmniej = strtotime($dane[3]) - 365 * 24 * 3600;
  	    $dzieńmniej = date('Y',$dzieńmniej);
  	    
  	    //$zap2 = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, Nat.nazwa, z_a_historiaekip.id_ek "
            //      . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	    //      . " WHERE (z_a_historiaekip.id_ek = '$dane[1]') AND (z_a_historiaekip.rok = '$dzieńmniej') ";
	          
	    $zap2 = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, Nat.nazwa, z_a_historiaekip.id_ek
	              FROM z_a_historiaekip, Nat
		      WHERE z_a_historiaekip.id_ek = '$dane[1]' AND z_a_historiaekip.rok = '$dzieńmniej' AND z_a_historiaekip.id_nat = Nat.id_nat ";      
	          
            $idz2 = mysql_query($zap2) or die('mysql_query');
  	    $dane2 = mysql_fetch_row($idz2);
  	    
  	    
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[9].'" alt='.$dane[8].'> 
	    <a href="kol.php?id_kol='.$dane[0].'">'.$dane[5].' <b>'.$dane[6].'</a></b></td>
	    <td> '.zwroc_tekst(71, $jezyk).' <img src="http://fff.xon.pl/img/flagi/'.$dane2[4].'" alt="'.$dane2[5].'" />
	    <a href="teamh.php?id_team='.$dane[1].'&rok=',$dzieńmniej+1,'">';
	    
	    if ($dane[1] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($dane[1] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($dane[1] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $dane2[0];
	          }  
	    
	    
	    //$dane2[0];
	    
	    
	    echo '</a> </td>
	    <td>'.$tescik2.'</td><td>'.$dane[3].'</td></tr>
	    
	    ';
	  }
          echo '</table>
	  
	  <br/><br/>';
	  $dzienmniej = $dane[4];
          //-------------------------------------/
          //       Kolarze którzy odchodzą       /   
          //-------------------------------------/
             
	  
	       
	  if ($id_rok > date("Y")) {
            echo '<h2>'.zwroc_tekst(50, $jezyk).'</h2>';
            //$zap = " SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, YEAR(z_a_historiakolprop.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	    //         FROM (z_a_historiakolprop INNER JOIN Kolarze ON z_a_historiakolprop.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat 
	//	     WHERE z_a_historiakolprop.id_do <> '$id_team' AND z_a_historiakolprop.id_z = '$id_team' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' 
	//	     ORDER BY z_a_historiakolprop.kiedy, Kolarze.nazw, Kolarze.imie ";
		     
	    $zap = " SELECT z_a_historiakolprop.id_kol, z_a_historiakolprop.id_z, z_a_historiakolprop.id_do, z_a_historiakolprop.kiedy, YEAR(z_a_historiakolprop.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga 
	             FROM z_a_historiakolprop, Kolarze, Nat 
		     WHERE z_a_historiakolprop.id_do <> '$id_team' AND  z_a_historiakolprop.id_z = '$id_team' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' AND z_a_historiakolprop.id_kol = Kolarze.id_kol AND Kolarze.id_nat = Nat.id_nat 
		     ORDER BY z_a_historiakolprop.kiedy, Kolarze.nazw, Kolarze.imie ";	     
		     
          } else {
            echo '<h2>'.zwroc_tekst(46, $jezyk).'</h2>'; 
            //$zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga "
            //   . " FROM (z_a_historiakol INNER JOIN Kolarze ON z_a_historiakol.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat "
	    //   . " WHERE z_a_historiakol.id_do <> '$id_team' AND z_a_historiakol.id_z = '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' "
	    //   . " ORDER BY z_a_historiakol.kiedy, Kolarze.nazw, Kolarze.imie ";
	       
	    $zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga
	             FROM z_a_historiakol, Kolarze, Nat 
		     WHERE z_a_historiakol.id_do <> '$id_team' AND z_a_historiakol.id_z = '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' AND Kolarze.id_nat = Nat.id_nat AND z_a_historiakol.id_kol = Kolarze.id_kol
		     ORDER BY z_a_historiakol.kiedy, Kolarze.nazw, Kolarze.imie ";      
          }          
	  
	  echo '<table class="wyscig" rules="all">
	        <tr><td class="wyscig2">'.zwroc_tekst(32, $jezyk).'<td class="wyscig8"> </td></td><td class="wyscig1">'.zwroc_tekst(34, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(53, $jezyk).'</td></tr>';
	  
	  $czybyljuznaglowek = FALSE;
	  $poczatekroku = $id_rok;
	  $poczatekroku .= "-01-01";
	  
	  
  	      
	       
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    
  	   
  	    
  	   $tescik = strtotime($dane[7]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
  	   $tescik2 = $tescik2 + $id_rok - date("Y");
	      
  	     IF ($czy_w_tym_roku_istniala == 0){
  	        $dzienmniej = $id_rok; }
	       else {
	       $dzienmniej = $dane[4];
              }
              
           if (($dane[3] <> $poczatekroku) AND ($czybyljuznaglowek == FALSE))
	   {
	     echo "<tr><td colspan='4' align='center'><br/><h3>".zwroc_tekst(130, $jezyk)."</h3></td></tr>";
	     $czybyljuznaglowek = TRUE;
	     //$dzienmniej = $id_rok;
	   }    
              
            if ($id_rok > date("Y")) {
            
             $tenrok = date("Y");
             $zap2 = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, Nat.nazwa, z_a_historiaekip.id_ek "
                  . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	          . " WHERE (z_a_historiaekip.id_ek = '$dane[2]') AND (z_a_historiaekip.rok = '$tenrok') ";
          } else {
             
             $zap2 = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, Nat.nazwa, z_a_historiaekip.id_ek "
                  . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	          . " WHERE (z_a_historiaekip.id_ek = '$dane[2]') AND (z_a_historiaekip.rok = '$dane[4]') ";
          }        
  	   
            $idz2 = mysql_query($zap2) or die('mysql_query');
  	    $dane2 = mysql_fetch_row($idz2);
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[9].'" alt='.$dane[8].'> 
	    <a href="kol.php?id_kol='.$dane[0].'">'.$dane[5].' <b>'.$dane[6].'</a></b></td>
	    <td> '.zwroc_tekst(72, $jezyk).' <img src="http://fff.xon.pl/img/flagi/'.$dane2[4].'" alt="'.$dane2[5].'" /> 
	    <a href="teamh.php?id_team='.$dane[2].'&rok=',$dzienmniej,'">';
	    
	    
	    if ($dane[2] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($dane[2] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($dane[2] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $dane2[0];
	          }  
	    
	    
	    
	    echo '</a></td>
	    <td>'.$tescik2.'</td><td>'.$dane[3].'</td></tr>
	    
	    ';
	  }
          echo '</table>
	  
	  <br/><br/>';
	  if (($id_team == 1000) OR ($id_team == 0)) {} else {
	  //-------------------------------------/
          //       Kolarze niezdecydowani        /   
          //-------------------------------------/
          If ($id_rok >= date("Y"))  {
	  
	  echo '<h2>'.zwroc_tekst(47, $jezyk).'</h2>';   
	  echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig1">'.zwroc_tekst(34, $jezyk).'</td></tr>';
	  $zap = " SELECT Kolarze.id_kol, Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga
	           FROM Kolarze INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat
		   WHERE Kolarze.id_team = '$id_team'
		   ORDER BY Kolarze.nazw, Kolarze.imie ";
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    
  	    $tescik = strtotime($dane[3]);
           $tescik = date("Y",$tescik);
           $tescik1 = strtotime(date("Y-m-d"));
           $tescik1 = date("Y",$tescik1);
           $tescik2 = $tescik1 - $tescik;
  	   $tescik2 = $tescik2 + $id_rok - date("Y");
	      
  	    
	  if ($id_rok > date("Y")) {
            $zap2 = " SELECT * "
                  . " FROM z_a_historiakolprop  "
	          . " WHERE z_a_historiakolprop.id_kol = '$dane[0]' AND YEAR(z_a_historiakolprop.kiedy) = '$id_rok' ";
          } else {
            $zap2 = " SELECT * "
                  . " FROM z_a_historiakol  "
	          . " WHERE z_a_historiakol.id_kol = '$dane[0]' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' ";
            
          }   
	      
	      
            $idz2 = mysql_query($zap2) or die('mysql_query');
  	    $dane2 = mysql_num_rows($idz2);
	       
	         if ($dane2 == 0) {
		 echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[5].'" alt='.$dane[4].'> 
		 <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</a></td>
		 <td>'.$tescik2.'</td></tr>
		 
	         ';
	    }
	  }
          echo '</table>
	  
	  <br/><br/>';
          }
	  } 
	   ?>
	   
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
