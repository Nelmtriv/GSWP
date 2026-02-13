<?php
session_start();
session_destroy();

header("Location: /GSWP/controller/AuthController.php");
exit;
