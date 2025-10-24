<?php
/**
 * Partial para el favicon de VECOPO - Versión Completa
 * Incluye múltiples formatos y tamaños para todos los dispositivos
 */

$faviconPath = base_url('img/caplogo.ico');
?>

<!-- Favicon VECOPO - Compatibilidad máxima -->
<link rel="icon" href="<?= $faviconPath ?>" type="image/x-icon">
<link rel="shortcut icon" href="<?= $faviconPath ?>" type="image/x-icon">
<link rel="apple-touch-icon" href="<?= $faviconPath ?>">
<link rel="icon" type="image/png" href="<?= $faviconPath ?>">

<!-- Meta tags para dispositivos móviles -->
<meta name="theme-color" content="#00f2fe">
<meta name="msapplication-TileColor" content="#00f2fe">
<meta name="msapplication-TileImage" content="<?= $faviconPath ?>">

<!-- Preload para mejor performance -->
<link rel="preload" href="<?= $faviconPath ?>" as="image" type="image/x-icon">