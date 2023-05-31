<?php
  $hostname = 'localhost';
  $dbuserid = 'happyna97';
  $dbpasswd = 'tpqmsxls13!';
  $dbname = 'happyna97';

  $mysqli = new mysqli($hostname,$dbuserid, $dbpasswd,$dbname);
  if($mysqli -> connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
  } 
?>