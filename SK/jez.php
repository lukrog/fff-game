<?php 

if($_COOKIE['skarb_kibica_jezyk_pro-cycling'])
  {
    $jezyk = $_COOKIE['skarb_kibica_jezyk_pro-cycling'];
  } else {
  //tu trzebaby sprawdzić po id jaki jest język z id.
  $jezyk = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
  //w ostateczności niech będzie angielski.
  $jezyk = "PL";
  
  $pos = strpos($lang, 'pl');
  //echo $pos.' <- miejsce<br/>';
  if ($pos === false) {
    //nic się nie dzieje
  } else {
    $jezyk = "PL";
  }
  
}

function zwroc_tekst($kod, $jezykwybrany) {
  
  $sqljezyk = " SELECT kod, ".$jezykwybrany." FROM z_z_tlumacz WHERE kod = ".$kod." ";
  $zapjezyk = mysql_query($sqljezyk) or die(mysql_error());
  $rek_jezyk = mysql_fetch_row($zapjezyk);
  return $rek_jezyk[1];

}

function zwroc_tekst_nat($kod1, $jezykwybrany) {
  
  $sqljezyk1 = " SELECT id_nat, ".$jezykwybrany." FROM z_z_tlumacz_nat WHERE id_nat = ".$kod1." ";
  $zapjezyk1 = mysql_query($sqljezyk1) or die(mysql_error());
  $rek_jezyk1 = mysql_fetch_row($zapjezyk1);
  return $rek_jezyk1[1];

}

?>
