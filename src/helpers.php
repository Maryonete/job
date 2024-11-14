<?php
// Dans src/helpers.php

/**
 * @var AltoRouter|null
 */
global $router;

/**
 * Génère une URL à partir du nom de la route
 */
function generateUrl(string $routeName, array $params = []): string
{
    global $router;
    if ($router === null) {
        throw new Exception("Router is not initialized");
    }
    return $router->generate($routeName, $params);
}

/**
 * Redirige vers une route nommée
 */
function redirectTo(string $routeName, array $params = []): void
{
    global $router;
    header("Location: " . $router->generate($routeName, $params));
    exit;
}
