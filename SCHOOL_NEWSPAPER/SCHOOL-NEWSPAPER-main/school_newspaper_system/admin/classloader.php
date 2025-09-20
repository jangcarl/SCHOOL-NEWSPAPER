<?php require_once __DIR__ . '/../includes/config.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($path))
        require_once $path;
});
?>