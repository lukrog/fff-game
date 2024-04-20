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


<?php  
  for ($i = 1; $i < 7249 ; $i++) {
  
  $sql = " SELECT * FROM zgloszenia WHERE id_zgl = '$i' ";
  $zap = mysql_query($sql) or die('mysql_query');
  
  
  if(mysql_num_rows($zap) > 0) {
  echo $i.'<br/>';
    
  } else {
    echo '<b>'.$i.'</b><br/>';
    $j = $i -1;
    $sql1 = " SELECT * FROM zgloszenia WHERE id_zgl = '$j' ";
    $zap1 = mysql_query($sql1) or die('mysql_query');
    $dan1 = mysql_fetch_row($zap1);
    
    
    
    $kolej = $dan1[1] + 1;
    $sql2 = " INSERT INTO zgloszenia VALUES ('$i', '$kolej', 0, '$dan1[3]', '$dan1[4]', '$dan1[5]') ";
    $zap2 = mysql_query($sql2) or die('mysql_query');
  }
  
  }


?>
