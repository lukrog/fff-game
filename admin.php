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
   <title>FFF - panel zarządzający</title>
</head>
<body>
<div>

<?php
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
    
    
    if($_SESSION['logowanie'] == 'poprawne') {
    if ($_SESSION['boss'] >= 1) {
      echo ' <h4>Podlicz lub przelicz wyniki wyścigu:</h4>';
      if ($_SESSION['boss'] >= 2) {  
        echo ' <form action="obliczwys.php" method="POST">';
        echo ' <input class="form" type="input" name="idwys" /> Podaj id wyścigu do zatwierdzenia';
        echo ' <input class="form2" type=submit value="Zatwierdź" />';
        echo ' </form>';
      } else { 
        echo 'Nie masz wystarczających uprawnień do podliczania wyścigów<br/>';
      }
      if ($_SESSION['boss'] >= 2) {  
        echo ' <a href="podliczpunkty.php">Podlicz punkty kolarzy na dziś</a> <i>(po każdym podliczaniu wyścigów)</i><br/><br/>';
      } else { 
        echo 'Nie masz wystarczających uprawnień do podliczania punktów kolarzy';
      }      
      echo ' <h4>Zwolnij kolarza z ekipy fff:</h4> <i>potem wyedytujesz za ile i przez co</i>';
      if ($_SESSION['boss'] >= 2) {  
        echo ' <form action="kolZADM.php" method="POST">';
        echo ' <input class="form" type="input" name="idkol" /> Podaj id kolarza do zwolnienia';
        echo ' <input class="form2" type=submit value="Zatwierdź" />';
        echo ' </form><br/>';
      } else { 
        echo '<br/>Nie masz wystarczających uprawnień do zwalniania kolarzy';
      }
      
	echo ' <h4>wprowadź wyniki i kategorie wyścigów:</h4>';    
      if ($_SESSION['boss'] >= 1) {  
        echo ' <form action="WKLEP_WYNIKI.php" method="POST">';
        echo ' <input class="form" type="input" name="id_wys" /> Podaj id wyścigu do wprowadzenia<br/>';
        echo ' <input class="form1" type="checkbox" name="pro" /> czy był prolog?<br/>';
        echo '  <input class="form1" type="checkbox" name="dod" /> czy był dodatkowy etap?<br/>';
        echo ' <input class="form2" type=submit value="Zatwierdź" />';
        echo ' </form><br/>';        
	
      } else { 
        echo 'Nie masz wystarczających uprawnień do dodania wyników';
      }
      
	echo ' <h4>Dodaj nowego kolarza:</h4>';   
    if ($_SESSION['boss'] >= 1) {  

        echo ' <a href="kol_DODAJ.php">link do stworzenia kolarza</a><br/><br/>';        
	
      } else { 
        echo 'Nie masz wystarczających uprawnień do stworzenia kolarza';
      }
      
      
      echo ' <h4>przeglądanie proponowanych transferów:</h4>';
      echo '<a href="transPADM.php?sort=1">Przejdź do listy transferów</a>';
      
      echo ' <h4>Zakończ I rundę licytacji</h4>';
      if ($_SESSION['boss'] >= 2) {  
        $sql1 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 2 ";
        $zap1  = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) > 0) {
	  echo 'UWAGA LICYTACJA JESZCZE TRWA NIE WOLNO CI JEJ PODSUMOWYWAĆ';
	}   
        $sql1 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 3 ";
        $zap1  = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) > 0) {
          echo 'rozpoczęło się już okienko licytacji, przed jego uruchomieniem podsumuj je :)';
        }  
        echo '<a href="podlicz.php">Podsumuj licytację</a> <br/>(UWAGA NIE RÓB TEGO PRZED KOŃCEM PIERWSZEJ RUNDY)<br/>sprawdza zasadę Dudiego i inne rzeczy...<br/>albo lepiej zostaw to dla BIGIBRDA';
        
        
        
        
      } else { 
        echo 'Nie masz wystarczających uprawnień';
      }
      
      echo ' <h4>sprawdzanie 24-g w licytacjach:</h4>';
      echo '<a href="licytSPRAW.php">przelicz i sprawdź licytacje na aktualny czas</a>';
    
        
	
	echo ' <h4>wprowadź kategorie wyścigów:</h4>';
        echo ' <form action="kategorie.php" method="POST">';
        echo ' <input class="form" type="input" name="id_wys" /> Podaj id wyścigu do zatwierdzenia<br/>';
        echo ' <input class="form1" type="checkbox" name="pro" /> prolog?';
        echo '  <input class="form1" type="checkbox" name="dod" /> dodatkowy etap???<br/>';
        echo ' <input class="form2" type=submit value="Zatwierdź" />';
        echo ' </form>';
    
    echo '<br/>';
    
    if ($_SESSION['boss'] >= 3) {
      echo '<a href="rpodlicz.php?id=0">podlicz ranking na obecny sezon</a> <i>UWAGA trwa bardzo długo</i> ';
      echo '<br/><br/>';
      echo '<br/>';
      echo '<a href="rpodliczkro.php?id=0">podlicz ranking na poprzedni sezon</a> <i>UWAGA trwa bardzo długo</i>';
    }
    echo '<br/><br/>
    <h4>przeprowadzenie transferów klubów w rzeczywistości:</h4>
    ';
    if ($_SESSION['boss'] >= 1) {  
        echo ' 
	<a href="transferyEXE.php">PRZEPROWADZENIE TRANSFERÓW</a>
	';
      } else { 
        echo 'Nie masz wystarczających uprawnień';
      }
    
    
    
    
    } else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
    }
    
    
    } else {
      echo 'Musisz się zalogować';
    }
    
    
    
    
    
    echo koniec();
    ?>
    


    
    
    
