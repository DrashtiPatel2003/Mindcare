<?php
session_start();
session_destroy();
header("Location: ../admin/index2.php");
exit;
?>
