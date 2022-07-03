<?php
include_once "config.php";
include_once "entidades/usuario.php";

$usuario = new Usuario();
$usuario -> usuario ="fedebertarelli";
$usuario -> clave = $usuario ->encriptarClave("admin123");
$usuario->nombre = "Federico";
$usuario->apellido = "Bertarelli";
$usuario->correo = "fedebertarelli@gmail.com";
$usuario->insertar();


?>