<?php
// on your own, create a logout link to a logout page. This can then redirect back to login
    session_start();
    session_destroy();
    header("Location:login.php");
?>