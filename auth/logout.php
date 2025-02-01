<?php 
session_start(); 
// Hapus semua sesi 
$_SESSION = array(); 
 
// Jika menggunakan cookie, hapus cookie juga 
if (ini_get("session.use_cookies")) { 
  $params = session_get_cookie_params(); 
  setcookie( 
    session_name(), 
    '', 
    time() - 42000, 
    $params["path"], 
    $params["domain"], 
    $params["secure"], 
    $params["httponly"] 
  ); 
} 
 
// Hancurkan sesi 
session_destroy(); 
 
 
header("Location: ../index.php");