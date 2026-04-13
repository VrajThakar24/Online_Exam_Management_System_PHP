<?php
session_start();
session_unset();
session_destroy();

// Prevent browser from caching the page after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Pragma: no-cache");

header("Location: index.php");
exit();
?>
