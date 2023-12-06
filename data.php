<?php
// REMEMBER: This will be stored in a non-web folder. In our case, /data/
$username_good = "gmaan1";
$yourpassword = "gur@1303";

$pw_enc = password_hash($yourpassword, PASSWORD_DEFAULT);
?>