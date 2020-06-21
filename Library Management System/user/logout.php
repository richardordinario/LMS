<?php

session_start();
$logout = md5($_SESSION['user']);
$user_md5 = md5($logout);
unset($_SESSION['$user_md5']);

session_unset();
session_destroy();

echo "Logging out ... Please wait ...";
echo "<script>window.location.href='index?logout=$logout&v_1=$user_md5';</script>"
?>