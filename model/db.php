<?php

function getConnection()
{
  $serverName="localhost";
  $userName="root";
  $password="";
  $dbName="librarydb";
  $con=new mysqli( $serverName,$userName,$password,$dbName);
  return $con;
}
  function closeCon($conn) {
    mysqli_close($conn);
}



?>