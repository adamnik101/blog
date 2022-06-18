<?php
    ob_start();
session_start();
if(isset($_SESSION['korisnik'])){
    $korisnik = $_SESSION['korisnik'];
}
?><!DOCTYPE html>
<html lang="eng">
<head>
<meta charset="UTF-8">
<meta name="description" content="HVAC Car Store">
<meta name="keywords" content="HVAC, car, blog, post">
<meta name="author" content="Adam Nikolic">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>HVAC | Car Blog </title>
<link rel="icon" type="image/png" href="img/favicon.png">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
<link rel="stylesheet" href="css/nice-select.css" type="text/css">
<link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
<link rel="stylesheet" href="sass/style.css" type="text/css">
<?php if(isset($korisnik) && $korisnik->id_uloga == 1 && strpos($_SERVER['PHP_SELF'], 'admin') !== false):?>
<link href="css/adminpanel.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
<link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="admin/theme-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="admin/theme-assets/css/app-lite.css">
<link rel="stylesheet" type="text/css" href="admin/theme-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="admin/theme-assets/css/core/colors/palette-gradient.css">
<?php endif;?>
</head>
