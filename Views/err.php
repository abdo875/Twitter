<?php 
include "includes/header.php";
session_start();

echo "<div class='err'><i class='fa-solid fa-triangle-exclamation class err_icon'></i>".$_SESSION['errMsg']."</div>";
$url= $_SERVER['HTTP_REFERER'];
header( "refresh:3;url=$url" );

include "includes/footer.php";