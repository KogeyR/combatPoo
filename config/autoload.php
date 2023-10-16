<?php
// Strict
declare(strict_types=1);

// Activer les erreurs PHP
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Erreurs formatées
ini_set("html_errors", "1");
ini_set("error_prepend_string", "<pre style='color: #333; font-face: monospace; white-space: pre-wrap; font-size: 17px; color: #880808'>");
ini_set("error_append_string", "</pre>");

// Chargement automatique des classes
function chargerClasse($classname)
{
    require __DIR__ . '/../class/' . $classname . '.php';
}
spl_autoload_register('chargerClasse');

// Démarrage de la session
session_start();
