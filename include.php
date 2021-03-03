<?php
//Récupère le chemin d'accès du dossier /php
$url = $_SERVER['REQUEST_URI'];
$pattern = "/^(.*\/php)\/(.*)/";
$replacement = "$1";

$dir = (preg_replace($pattern, $replacement, $url));
?>

<!-- Form validation ressources -->
<link rel="stylesheet" href="<?php echo($dir); ?>/lib/form-validation/form-validation.css">
<script src="<?php echo($dir); ?>/lib/form-validation/form-validation.js"></script>
<!-------------------------------->