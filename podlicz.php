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
   <title>FFF - podlicz licytację</title>
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
    
    
    echo 'test<br/><br/>';
        $DUDI = "NIE";
        if($_SESSION['logowanie'] == 'poprawne') {
        if ($_SESSION['boss'] >= 1) {
        $dzis = date ("Y-m-d");
        $sql0 = " SELECT licytacje.id_kol "
              . " FROM licytacje "
              . " GROUP BY licytacje.id_kol "
              . " ORDER BY licytacje.id_kol ";
        $zap0 = mysql_query($sql0) or die('mysql_query');
        
	echo $zap0.'<br/><br/>';
	
	while ($dan0 = mysql_fetch_row($zap0)) {
          $id_kol = $dan0[0];

            //---------------------------------------------------------------------
            //|       Sprawdzamy ilość licytacji na danego zawodnika              -
            //---------------------------------------------------------------------

          echo 'Kolarz: [b]'.$id_kol.'[/b]: ';
          
          $sql8 = " SELECT cena, imie, nazw "
                  . " FROM Kolarze "
                  . " WHERE id_kol = '$id_kol' ";
          $zap8 = mysql_query($sql8) or die('mysql_query');
          $dan8 = mysql_fetch_row($zap8);
          
          $sql2 = " SELECT licytacje.ile, licytacje.id_user "
                . " FROM licytacje "
                . " WHERE licytacje.id_kol = '$id_kol' ";
	  $zap2 = mysql_query($sql2) or die('mysql_query');
	  echo 'licytowało osób: '.mysql_num_rows($zap2).'.  <br/>';
          if (mysql_num_rows($zap2) == 1) {
            $dan2 = mysql_fetch_row($zap2);
              
            
            
                        
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane kolarza                        -
            //---------------------------------------------------------------------
            
            
            $sql4 = " UPDATE Kolarze " 
                  . " SET id_user = '$dan2[1]', cena = '$dan2[0]'"
                  . " WHERE id_kol = '$id_kol' ";
            $zap4 = mysql_query($sql4) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|                     Sprawdzamy dane ekipy                         -
            //---------------------------------------------------------------------   
            
            $sql5 = " SELECT kasa, ekipa, login " 
                  . " FROM User "
                  . " WHERE id_user = '$dan2[1]' ";
            $zap5 = mysql_query($sql5) or die('mysql_query');
            $dan5 = mysql_fetch_row($zap5);
                      
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane ekipy                          -
            //---------------------------------------------------------------------

            $kasa = $dan5[0] - $dan2[0];
            $sql6 = " UPDATE User " 
                  . " SET kasa = '$kasa'"
                  . " WHERE id_user = '$dan2[1]' ";
            $zap6 = mysql_query($sql6) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|              dopisujemy całą akcję do transferów                  -
            //---------------------------------------------------------------------            
            
            $sql7 = " SELECT id_tpZ "
                  . " FROM transzaak "
                  . " ORDER BY id_tpZ DESC "
                  . " LIMIT 0, 1 ";
            $zap7 = mysql_query($sql7) or die('mysql_query');
            $dan7 = mysql_fetch_row($zap7);
            $id_tp1 = $dan7[0] + 1;
            
    
            
            
            $sql9 = " INSERT INTO transzaak "
	          . " VALUES ('$id_tp1', '$dzis', '$id_kol', '$dan2[1]', 0, '$dan2[0]', '$dan8[0]', 2) ";
            $zap9 = mysql_query($sql9) or die('mysql_query');
            
            echo 'Kolarz <b>[b]'.$dan8[1].' '.$dan8[2].'[/b]</b> ('.$id_kol.') warty '.$dan8[0].' przechodzi do <b>[b]'.$dan5[1].'[/b]</b> ('.$dan2[1].') ['.$dan5[2].'] na zasadzie jednego bida za '.$dan2[0].'C <br/><br/>';
            
            $sql500 = " DELETE FROM licytacje "
	            . " WHERE id_kol = '$id_kol' ";
            $zap500 = mysql_query($sql500) or die('mysql_query');
            
            
          } elseif (mysql_num_rows($zap2) == 2) {
            $dan2 = mysql_fetch_row($zap2);
            
            
            //---------------------------------------------------------------------
            //|                     gdy są 2 zgłoszenia                           -
            //---------------------------------------------------------------------              
            
            $sql10 = " SELECT licytacje.ile, licytacje.id_user "
                   . " FROM licytacje "
                   . " WHERE licytacje.id_kol = '$id_kol' "
		   . " ORDER BY licytacje.ile DESC ";
            $zap10 = mysql_query($sql10) or die('mysql_query');
            
            //---------------------------------------------------------------------
            //|                     sprawdzam ich wartość                         -
            //--------------------------------------------------------------------- 
            
            $dan10 = mysql_fetch_row($zap10);
              $kasa1 = $dan10[0];
              $user1 = $dan10[1];
            $dan10 = mysql_fetch_row($zap10);
              $kasa2 = $dan10[0];
              $user2 = $dan10[1];
            $kasa3 = $kasa1 - $kasa2;
            echo 'Różnica w propozycjach obu ekip to: '.$kasa3.' = '.$kasa1.'('.$user1.') - '.$kasa2.'('.$user2.') <br/> ';
            
            $sql11 = " SELECT Kolarze.imie, Kolarze.nazw "
                   . " FROM Kolarze "
                   . " WHERE id_kol = '$id_kol' ";
            $zap11 = mysql_query($sql11) or die('mysql_query');
            $dan11 = mysql_fetch_row($zap11);  
	    
	    $sql12 = " SELECT ekipa "
                   . " FROM User "
                   . " WHERE id_user = '$user1' ";
            $zap12 = mysql_query($sql12) or die('mysql_query');
            $dan12 = mysql_fetch_row($zap12);   
            
            $sql13 = " SELECT ekipa "
                   . " FROM User "
                   . " WHERE id_user = '$user2' ";
            $zap13 = mysql_query($sql13) or die('mysql_query');
            $dan13 = mysql_fetch_row($zap13); 
            
            if ($kasa3 < 30) {
              echo 'Kolarz <b>[b]'.$dan11[0].' '.$dan11[1].'[/b]</b> pozostaje w licytacji pomiędzy: <br/>'.$dan12[0].' ('.$user1.') {[i]'.$kasa1.'C[/i]} a <br/>'.$dan13[0].' ('.$user2.') {[i]'.$kasa2.'C[/i]} //różica mniejsza od 30//<br/><br/>';
            } else {
                $kasa22 = 2 * $kasa2;
                if ($kasa1 > $kasa22 ) {
                  
                  

                        
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane kolarza                        -
            //---------------------------------------------------------------------
            
                  $sql4 = " UPDATE Kolarze " 
                        . " SET id_user = '$user1', cena = '$kasa1'"
                        . " WHERE id_kol = '$id_kol' ";
                  $zap4 = mysql_query($sql4) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|                     Sprawdzamy dane ekipy                         -
            //---------------------------------------------------------------------   
             
                  $sql5 = " SELECT kasa, ekipa, login " 
                        . " FROM User "
                        . " WHERE id_user = '$user1' ";
                  $zap5 = mysql_query($sql5) or die('mysql_query');
                  $dan5 = mysql_fetch_row($zap5);
                      
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane ekipy                          -
            //---------------------------------------------------------------------

                  $kasa = $dan5[0] - $kasa1;
                  $sql6 = " UPDATE User " 
                        . " SET kasa = '$kasa'"
                        . " WHERE id_user = '$user1' ";
                  $zap6 = mysql_query($sql6) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|              dopisujemy całą akcję do transferów                  -
            //---------------------------------------------------------------------            
            
                $sql7 = " SELECT id_tpZ "
                      . " FROM transzaak "
                      . " ORDER BY id_tpZ DESC "
                      . " LIMIT 0, 1 ";
                $zap7 = mysql_query($sql7) or die('mysql_query');
                $dan7 = mysql_fetch_row($zap7);
                $id_tp1 = $dan311[0] + 1;
            
                $sql9 = " INSERT INTO transzaak "
   	              . " VALUES ('$id_tp1', '$dzis', '$id_kol', '$user1', 0, '$kasa1', '$dan8[0]', 2) ";
                  $zap9 = mysql_query($sql9) or die('mysql_query');
            
                echo 'Kolarz <b>[b]'.$dan8[1].' '.$dan8[2].'[/b]</b> ('.$id_kol.') przechodzi do <b>[b]'.$dan5[1].'[/b]</b> ('.$user1.') ['.$dan5[2].']<br/> na zasadzie reguły DUDIEGO dla 2 kolarzy za [b]'.$kasa1.'C[/b] <br/><br/>';
                
                $sql500 = " DELETE FROM licytacje "
	                . " WHERE id_kol = '$id_kol' ";
                $zap500 = mysql_query($sql500) or die('mysql_query');
          
              } else {
                echo 'Kolarz <b>[b]'.$dan11[0].' '.$dan11[1].'[/b]</b> pozostaje w licytacji pomiędzy: <br/>'.$dan12[0].' ('.$user1.') {[i]'.$kasa1.'C[/i]} a <br/>'.$dan13[0].' ('.$user2.') {[i]'.$kasa2.'C[/i]} //pierwsza wartość nie większa od 2* druga//<br/><br/>';
              }
              
              
              
            }
            
          } else {
            
            $dan2 = mysql_fetch_row($zap2);
            
            
            
            //---------------------------------------------------------------------
            //-               gdy są ponad 3 zgłoszenia                           -
            //---------------------------------------------------------------------              
            
            
            $sql11 = " SELECT Kolarze.imie, Kolarze.nazw "
                   . " FROM Kolarze "
                   . " WHERE id_kol = '$id_kol' ";
            $zap11 = mysql_query($sql11) or die('mysql_query');
            $dan11 = mysql_fetch_row($zap11); 
            
            $sql10 = " SELECT licytacje.ile, licytacje.id_user "
                   . " FROM licytacje "
                   . " WHERE licytacje.id_kol = '$id_kol' "
		   . " ORDER BY licytacje.ile DESC ";
            $zap10 = mysql_query($sql10) or die('mysql_query');
            
            //---------------------------------------------------------------------
            //-                     sprawdzam ich wartość                         -
            //--------------------------------------------------------------------- 
            
            $dan10 = mysql_fetch_row($zap10);
              $kasa1 = $dan10[0];
              $user1 = $dan10[1];
            $dan10 = mysql_fetch_row($zap10);
              $kasa2 = $dan10[0];
              $user2 = $dan10[1];
            $dan10 = mysql_fetch_row($zap10);
              $kasa3 = $dan10[0];
              $user3 = $dan10[1];
	    
	    $kasaR = $kasa1 - $kasa2;
	    echo 'Różnica pomiędzy pierwszym a drugim bidem: '.$KasaR.' = '.$kasa1.'('.$user1.') - '.$kasa2.'('.$user2.') <br/> ';
	    
	    
	    $kasaK = $kasa2 + $kasa3;
            echo 'Obliczanie zasady DUDIEGO dla trzech kolarzy: '.$kasa1.' ? '.$kasaK.' = '.$kasa2.' + '.$kasa3.'<br/> ';
            
            if (($kasa1 > $kasaK) AND ($kasaR >= 30)) {
              
            //---------------------------------------------------------------------
            //-                     gdy zasada Dudiego działa                     -
            //---------------------------------------------------------------------             
	          
	               
                        
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane kolarza                        -
            //---------------------------------------------------------------------
            
                  $sql4 = " UPDATE Kolarze " 
                        . " SET id_user = '$user1', cena = '$kasa1'"
                        . " WHERE id_kol = '$id_kol' ";
                  $zap4 = mysql_query($sql4) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|                     Sprawdzamy dane ekipy                         -
            //---------------------------------------------------------------------   
             
                  $sql5 = " SELECT kasa, ekipa, login " 
                        . " FROM User "
                        . " WHERE id_user = '$user1' ";
                  $zap5 = mysql_query($sql5) or die('mysql_query');
                  $dan5 = mysql_fetch_row($zap5);
                      
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane ekipy                          -
            //---------------------------------------------------------------------

                  $kasa = $dan5[0] - $kasa1;
                  $sql6 = " UPDATE User " 
                        . " SET kasa = '$kasa'"
                        . " WHERE id_user = '$user1' ";
                  $zap6 = mysql_query($sql6) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|              dopisujemy całą akcję do transferów                  -
            //---------------------------------------------------------------------            
            
                $sql7 = " SELECT id_tpZ "
                      . " FROM transzaak "
                      . " ORDER BY id_tpZ DESC "
                      . " LIMIT 0, 1 ";
                $zap7 = mysql_query($sql7) or die('mysql_query');
                $dan7 = mysql_fetch_row($zap7);
                $id_tp1 = $dan311[0] + 1;
                     
                $sql9 = " INSERT INTO transzaak "
   	              . " VALUES ('$id_tp1', '$dzis', '$id_kol', '$user1', 0, '$kasa1', '$dan8[0]', 2) ";
                $zap9 = mysql_query($sql9) or die('mysql_query');
            
                echo '<b>[b]'.$dan8[1].' '.$dan8[2].'[/b]</b> ('.$id_kol.') przechodzi do <b>[b]'.$dan5[1].'[/b]</b> ('.$user1.') ['.$dan5[2].']<br/> na zasadzie reguły DUDIEGO dla 2 kolarzy za [b]'.$kasa1.'C[/b] <br/><br/>';
                
                $sql500 = " DELETE FROM licytacje "
	                . " WHERE id_kol = '$id_kol' ";
                $zap500 = mysql_query($sql500) or die('mysql_query');
          
              	    
	    
	    } else {
              
            //---------------------------------------------------------------------
            //-                   gdy zasada Dudiego nie działa                   -
            //--------------------------------------------------------------------- 
            
            if ($kasaR < 30) {
                echo 'Zbyt mała różnica pomiędzy pierwszym a drugim bidem '.$kasaR.' < 30<br/>';
            }
            echo 'Kolarz <b>[b]'.$dan11[0].' '.$dan11[1].'[/b]</b> pozostaje w licytacji pomiędzy: <br/>';
            
            
            $sql25 = " SELECT User.ekipa , licytacje.ile, User.login"
                   . " FROM licytacje INNER JOIN User ON licytacje.id_user = User.id_user "
                   . " WHERE licytacje.id_kol = '$id_kol' ";
            $zap25 = mysql_query($sql25) or die('mysql_query');
            while ( $dan25 = mysql_fetch_row($zap25) ) {
              echo ' - '.$dan25[0].' ['.$dan25[2].'] - '.$dan25[1].'C <br/>';
            }
            echo '<br/>';
            
	    }
            
            
            
          } 
	  



          
          
          
          
	} 
	} else { 
        echo 'Nie masz wystarczających uprawnień';
      }
    } else {
      echo 'Musisz się zalogować';
    }    
    
    
    
    
    
    
    
    echo koniec();
       ?>
    
    
    
    
    
