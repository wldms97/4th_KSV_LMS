<?php
  $hostname = 'localhost';
  $dbuserid = 'pyj940313';
  $dbpasswd = 'ejaejajekfa1!';
  $dbname = 'pyj940313';

  $mysqli = new mysqli($hostname,$dbuserid, $dbpasswd,$dbname);
  if($mysqli -> connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
  } 
?>