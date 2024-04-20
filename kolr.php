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
   <title>FFF - kolarz - szczegóły</title>
</head>
<body>
<div>

<?php
  echo google();

  $zapyt = "SELECT id_user, login, haslo, ekipa, boss FROM User WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapyt = mysql_query($zapyt) or die('mysql_query');
  while ($wiersza = mysql_fetch_row($idzapyt)) 
   {
      $logi=$wiersza[1];
      $idek=$wiersza[0];
      $ekipa = $wiersza[3];
      $_SESSION['boss']=$wiersza[4];
   }
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
    
          //echo $idek.'fffffffffffffffffffffff';
    
	  $id_kol = $_GET['id_kol'];
	  
	  $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, User.id_user, Kolarze.zdjecie "
               . " FROM User INNER JOIN ( Ekipy INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) ON User.id_user = Kolarze.id_user "
               . " WHERE ( ( ( Kolarze.id_kol ) = '$id_kol' ) ) ";
          $idzapytania = mysql_query($sql) or die(mysql_error());
          
          $dane = mysql_fetch_row($idzapytania);
          echo '<img src="'.$dane[10].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right /><br/>';
          echo '<table id="menu2">';
          echo '<tr><td><i>id kolarza: </i></td><td>'.$id_kol.'</td></tr>';
          echo '<tr><td><i>kolarz: </i></td><td>'.$dane[0].' '.$dane[1].'</td></tr>';
          echo '<tr><td></td></tr>';
          echo '<tr><td><i>data urodzenia: </i></td><td>'.$dane[2].'</td></tr>';
          echo '<tr><td><i>narodowość: </i></td><td><a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a> <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>';
          echo '<tr><td><i>ekipa: </i></td><td><a href="team.php?id_team='.$dane[7].'">'.$dane[5].'</a></td></tr>';
          if($_SESSION['logowanie'] == 'poprawne') 
	  {
            echo '<tr><td></td></tr>';
	    echo '<tr><td><i>drużyna fff:</i></td><td><a href="user.php?id_user='.$dane[9].'">'.$dane[6].'</a></td></tr>';
	  } else {}
          $pun=0;
          $pocz = 1000 * (date("Y")-2000);
	        $kon = 1000 * (date("Y")+1-2000);
          $sqla = " SELECT punkty FROM Wyniki WHERE id_kol = '$id_kol' AND id_wys > '$pocz' AND id_wys < '$kon'";
          $idz = mysql_query($sqla) or die(mysql_error());   
          while ($dan = mysql_fetch_row($idz)) {
            $pun=$pun+$dan[0];
          }
          echo '<tr><td><i>punkty: </i></td><td>'.$pun.'</td></tr>';
 
	  echo '</table><br/><br/><br/>';
	  echo '<a href=\'kol.php?id_kol='.$id_kol.'\'>kliknij by zwinąć listę wyników kolarza</a> ';
	  echo '<br/><br/><br/>';
	  
	  
	  
	  
	  
          $roczek = date('Y');
	  $roczek1 = $roczek -1;
	  echo '<table class="szaretlo"> ';
	  echo '<tr><td>ranking kroczący</td><td class="wyscig3">  </td><td>ranking 3 letni</td></tr> ';
	  echo '<tr><td>';
          
	  $sqlMAX = " SELECT MAX(Cli), MAX(Hil), MAX(Fl), MAX(Spr), MAX(Cbl), MAX(TT) "
	           . " FROM z_ranking ";
	  $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	  $danMAX = mysql_fetch_row($zapMAX);
	  
	  $sql2007 = " SELECT id_kol, Cli, CliM, Hil, HilM, Fl, FlM, Spr, SprM, Cbl, CblM, TT, TTM "
	           . " FROM z_ranking "
	           . " WHERE id_kol = '$id_kol' ";
	  $zap2007 = mysql_query($sql2007) or die('mysql_query');
	  $dan2007 = mysql_fetch_row($zap2007);
	  
	  for ($j=0; $j<6; $j++) {
	    if ($danMAX[$j] == 0) {$danMAX[$j]=1;}
	  }
	  $clipr = $dan2007[1] / $danMAX[0] * 100;
	  $hilpr = $dan2007[3] / $danMAX[1] * 100;
	  $flpr = $dan2007[5] / $danMAX[2] * 100;
	  $sprpr = $dan2007[7] / $danMAX[3] * 100;
	  $cblpr = $dan2007[9] / $danMAX[4] * 100;
	  $TTpr = $dan2007[11] / $danMAX[5] * 100;

	  echo '<table> ';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi2007.php?sort=1&limit1='.($dan2007[2]-5).'&limit2='.($dan2007[2]+5).'&zazn='.$dan2007[2].'>Cli</a></td><td class="rankingd" background="img/ranking/cliT.jpg"><img src="img/ranking/cli.jpg" style="width: '.round(2*$clipr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[2].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi2007.php?sort=2&limit1='.($dan2007[4]-5).'&limit2='.($dan2007[4]+5).'&zazn='.$dan2007[4].'>Hil</a></td><td class="rankingd" background="img/ranking/hilT.jpg"><img src="img/ranking/hil.jpg" style="width: '.round(2*$hilpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[4].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi2007.php?sort=3&limit1='.($dan2007[6]-5).'&limit2='.($dan2007[6]+5).'&zazn='.$dan2007[6].'>Fl</a></td><td class="rankingd" background="img/ranking/flT.jpg"><img src="img/ranking/fl.jpg" style="width: '.round(2*$flpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[6].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi2007.php?sort=4&limit1='.($dan2007[8]-5).'&limit2='.($dan2007[8]+5).'&zazn='.$dan2007[8].'>Spr</a></td><td class="rankingd" background="img/ranking/sprT.jpg"><img src="img/ranking/spr.jpg" style="width: '.round(2*$sprpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[8].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi2007.php?sort=5&limit1='.($dan2007[10]-5).'&limit2='.($dan2007[10]+5).'&zazn='.$dan2007[10].'>Cbl</a></td><td class="rankingd" background="img/ranking/cblT.jpg"><img src="img/ranking/cbl.jpg" style="width: '.round(2*$cblpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[10].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi2007.php?sort=6&limit1='.($dan2007[12]-5).'&limit2='.($dan2007[12]+5).'&zazn='.$dan2007[12].'>TT</a></td><td class="rankingd" background="img/ranking/ttT.jpg"><img src="img/ranking/tt.jpg" style="width: '.round(2*$TTpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[12].'</td></tr>';
	  echo '</table> ';


          echo '</td><td>  </td><td>';
          
          
          $sqlMAX = " SELECT MAX(Cli), MAX(Hil), MAX(Fl), MAX(Spr), MAX(Cbl), MAX(TT) "
	           . " FROM z_ranking2 ";
	  $zapMAX = mysql_query($sqlMAX) or die('mysql_query');
	  $danMAX = mysql_fetch_row($zapMAX);
	  
	  $sql2007 = " SELECT id_kol, Cli, CliM, Hil, HilM, Fl, FlM, Spr, SprM, Cbl, CblM, TT, TTM "
	           . " FROM z_ranking2 "
	           . " WHERE id_kol = '$id_kol' ";
	  $zap2007 = mysql_query($sql2007) or die('mysql_query');
	  $dan2007 = mysql_fetch_row($zap2007);
	  
	  for ($j=0; $j<6; $j++) {
	    if ($danMAX[$j] == 0) {$danMAX[$j]=1;}
	  }
	  $clipr = $dan2007[1] / $danMAX[0] * 100;
	  $hilpr = $dan2007[3] / $danMAX[1] * 100;
	  $flpr = $dan2007[5] / $danMAX[2] * 100;
	  $sprpr = $dan2007[7] / $danMAX[3] * 100;
	  $cblpr = $dan2007[9] / $danMAX[4] * 100;
	  $TTpr = $dan2007[11] / $danMAX[5] * 100;
	  
	  
	  
	  echo '<table> ';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi.php?sort=1&limit1='.($dan2007[2]-5).'&limit2='.($dan2007[2]+5).'&zazn='.$dan2007[2].'>Cli</a></td><td class="rankingd" background="img/ranking/cliT.jpg"><img src="img/ranking/cli.jpg" style="width: '.round(2*$clipr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[2].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi.php?sort=2&limit1='.($dan2007[4]-5).'&limit2='.($dan2007[4]+5).'&zazn='.$dan2007[4].'>Hil</a></td><td class="rankingd" background="img/ranking/hilT.jpg"><img src="img/ranking/hil.jpg" style="width: '.round(2*$hilpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[4].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi.php?sort=3&limit1='.($dan2007[6]-5).'&limit2='.($dan2007[6]+5).'&zazn='.$dan2007[6].'>Fl</a></td><td class="rankingd" background="img/ranking/flT.jpg"><img src="img/ranking/fl.jpg" style="width: '.round(2*$flpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[6].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi.php?sort=4&limit1='.($dan2007[8]-5).'&limit2='.($dan2007[8]+5).'&zazn='.$dan2007[8].'>Spr</a></td><td class="rankingd" background="img/ranking/sprT.jpg"><img src="img/ranking/spr.jpg" style="width: '.round(2*$sprpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[8].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi.php?sort=5&limit1='.($dan2007[10]-5).'&limit2='.($dan2007[10]+5).'&zazn='.$dan2007[10].'>Cbl</a></td><td class="rankingd" background="img/ranking/cblT.jpg"><img src="img/ranking/cbl.jpg" style="width: '.round(2*$cblpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[10].'</td></tr>';
	  echo '<tr class="rankingr"><td class="rankingo"><a href=rankingi.php?sort=6&limit1='.($dan2007[12]-5).'&limit2='.($dan2007[12]+5).'&zazn='.$dan2007[12].'>TT</a></td><td class="rankingd" background="img/ranking/ttT.jpg"><img src="img/ranking/tt.jpg" style="width: '.round(2*$TTpr).'px; height: 14px;"/> </td><td class="rankingo3">'.$dan2007[12].'</td></tr>';
	  echo '</table> ';




          echo '</td></tr>';
          echo '</table>';


	  echo '
	        <br/><br/>
	       ';
	  echo '<table id="menu3">';
          echo '<tr><td class="wyscig7">ekipa</td><td class="wyscig6">od kiedy</td></tr>';
          
          
          //--------------------/
	  //  historia kolarza  /
	  //--------------------/
	  echo '<a name="Hist"></a> 
	        <h2>historia kolarza</h2>';
	  $sqlhis = " SELECT id_kol, id_z, id_do, kiedy, YEAR(kiedy), MONTH(kiedy), DAY(kiedy) "
                  . " FROM z_a_historiakol "
	          . " WHERE id_kol = '$id_kol' "
		  . " ORDER BY kiedy DESC ";
	  $zaphis = mysql_query($sqlhis) or die('mysql_query');
	  while ($danhis = mysql_fetch_row($zaphis))
	  {
	    	    
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga "
                     . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	             . " WHERE (z_a_historiaekip.id_ek = '$danhis[2]') AND (z_a_historiaekip.rok = '$danhis[4]') ";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
	    $danhise = mysql_fetch_row($zaphise);
	    
	    
	    echo '<tr><td>',$danhise[0],' <img src="img/flagi/'.$danhise[4].'" alt="flaga" /> ('.$danhise[2].') - '.$danhise[3].'</td><td>';
	    //echo 'aaaaaaa'.$danhis[5].'aaaam   <br/>';
	    //echo 'aaaaaaa'.$danhis[6].'aaaam   <br/>';
	    if (($danhis[5] > 1) OR ($danhis[6] > 1)) {
	      echo $danhis[3].'</td></tr>';
	    } else {
              echo $danhis[4];
            }  
	    
	    
          }
	  echo '
                </table>';
          if (($_SESSION['boss'] >= 1) OR ($dane[9] == $idek)) { 
             
            echo '<a href=\'kol_edyt.php?id_kol='.$id_kol.'\'>DODAJ TRANSFER</a>
      
            ';
      
          }    
	  
	  
	  //--------------------------/
	  //         WYNIKI           /
	  //--------------------------/
          echo '<h2>wyniki w obecnym sezonie</h2>';
	  $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, Wyniki.miejsce, Wyniki.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), Wyniki.wynik, Co.id_co "
               . " FROM Co INNER JOIN (Nat INNER JOIN (Wyscigi INNER JOIN Wyniki ON Wyscigi.id_wys = Wyniki.id_wys) ON Nat.id_nat = Wyscigi.id_nat) ON Co.id_co = Wyniki.id_co "
               . " WHERE Wyniki.id_kol='$id_kol' AND Wyniki.id_wys > '$pocz' AND Wyniki.id_wys < '$kon' "
	             . " ORDER BY DATE(Wyscigi.dataP) DESC, Co.id_co DESC";
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          echo '<table id="menu3">';
          echo '<tr><td class="wyscig7">Nazwa</td><td class="wyscig6">w czym</td><td class="wyscig6">miejsce</td><td class="wyscig6">punkty</td></tr>';
          while ($dane = mysql_fetch_row($idzapytania))
          {
           $sqliop = " SELECT z_Kategorie.skrot "
	           . " FROM z_Kategorie INNER JOIN z_EtapyKat ON z_Kategorie.id_kat=z_EtapyKat.id_kat " 
	           . " WHERE id_wys = '$dane[6]' AND id_co = '$dane[9]' ";
	   $zapiop = mysql_query($sqliop) or die(mysql_error());
	   $daniop = mysql_fetch_row($zapiop);        
            
           echo '<tr><td><a href="wyscig.php?id_wys='.$dane[6].'">'.$dane[0].'</a> <img src="img/flagi/'.$dane[1].'" alt="flaga" /> ('.$dane[2].') ['.$dane[7].']';
	   if ($_SESSION['boss'] >= 1) {
             echo ' <font style="color: green;">'.$daniop[0].'</font>';
           }
	   echo '</td><td>'.$dane[3].'</td><td>';
	   if ($dane[9] == 10) {
             echo $dane[8];
           } else {
	     echo $dane[4];
	   }
	   $sqlpoi = " SELECT id_zgl FROM zgloszenia WHERE id_kol = '$id_kol' AND id_wys = '$dane[6]' ";
	   $zappoi = mysql_query($sqlpoi) or die(mysql_error());   
	   echo '</td><td style="text-align: right;">'.$dane[5];
	   if (mysql_num_rows($zappoi) == 0) 
	   {
	     echo ' <img src=img/wyscig/NZ.jpg alt="NZ" />';
	   } else {
	     echo ' <img src=img/wyscig/ustaw.jpg alt="ZG" />';
	   }
	   echo '</td></tr>';
          }
          echo '</table>';



if ($_SESSION['boss'] >= 5) {
          echo '<h2>wyniki w poprzednich sezonach</h2>';
          $sql = " SELECT Wyscigi.nazwa, Nat.flaga, Wyscigi.klaUCI, Co.nazwa, WynikiP.miejsce, WynikiP.punkty, Wyscigi.id_wys, DATE(Wyscigi.dataP), WynikiP.wynik, Co.id_co "
               . " FROM Co INNER JOIN (Nat INNER JOIN (Wyscigi INNER JOIN WynikiP ON Wyscigi.id_wys = WynikiP.id_wys) ON Nat.id_nat = Wyscigi.id_nat) ON Co.id_co = WynikiP.id_co "
               . " WHERE WynikiP.id_kol='$id_kol'"
	              . " ORDER BY DATE(Wyscigi.dataP) DESC, Co.id_co DESC";
          $idzapytania = mysql_query($sql) or die(mysql_error());          
          echo '<table id="menu3">';
          echo '<tr><td class="wyscig7">Nazwa</td><td class="wyscig6">w czym</td><td class="wyscig6">miejsce</td><td class="wyscig6">punkty</td></tr>';
          while ($dane = mysql_fetch_row($idzapytania))
          {
           $sqliop = " SELECT z_Kategorie.skrot "
	           . " FROM z_Kategorie INNER JOIN z_EtapyKat ON z_Kategorie.id_kat=z_EtapyKat.id_kat " 
	           . " WHERE id_wys = '$dane[6]' AND id_co = '$dane[9]' ";
	   $zapiop = mysql_query($sqliop) or die(mysql_error());
	   $daniop = mysql_fetch_row($zapiop);   
	    
           echo '<tr><td><a href="wyscig.php?id_wys='.$dane[6].'">'.$dane[0].'</a> <img src="img/flagi/'.$dane[1].'" alt="flaga" /> ('.$dane[2].') ['.$dane[7].']';
	   if ($_SESSION['boss'] >= 1) {
             echo ' <font style="color: green;">'.$daniop[0].'</font>';
           }
	   echo '</td><td>'.$dane[3].'</td><td>';if ($dane[9] == 10) {
             echo $dane[8];
           } else {
	     echo $dane[4];
	   }
	   //$sqlpoi = " SELECT id_zgl FROM zgloszenia WHERE id_kol = '$id_kol' AND id_wys = '$dane[6]' ";
	   //$zappoi = mysql_query($sqlpoi) or die(mysql_error());   
	   echo '</td><td style="text-align: right;">'.$dane[5];
	   //if (mysql_num_rows($zappoi) == 0) 
	   //{
	   //  echo ' <img src=img/wyscig/NZ.jpg alt="NZ" />';
	   //} else {
	   //  echo ' <img src=img/wyscig/ustaw.jpg alt="ZG" />';
	   //}
	   echo '</td></tr>';
          }
          echo '</table>';

}




echo koniec();
        ?>
        
         
    


   
