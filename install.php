<?php

$copy = copy("./JWT.php","./vendor/firebase/php-jwt/src/JWT.php");

$copy = copy("./KeycloakGuard.php","./vendor/robsontenorio/laravel-keycloak-guard/src/KeycloakGuard.php");
$copy = copy("./ThrottlesLogins.php","./vendor/laravel/framework/src/Illuminate/Auth/ThrottlesLogins.php");

?>