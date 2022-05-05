<?php require_once './../DB/login/check_login.php'; ?>
<?php require_once dirname(__FILE__).'/../layout/main.php'; ?>

<?php
     $logout = new login();
     $logout->user_logout();
?>
