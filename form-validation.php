<?php
    function getRelativePath($from, $to)
    {
        // some compatibility fixes for Windows paths
        $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
        $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
        $from = str_replace('\\', '/', $from);
        $to   = str_replace('\\', '/', $to);

        $from     = explode('/', $from);
        $to       = explode('/', $to);
        $relPath  = $to;

        foreach($from as $depth => $dir) {
            // find first non-matching dir
            if($dir === $to[$depth]) {
                // ignore this directory
                array_shift($relPath);
            } else {
                // get number of remaining dirs to $from
                $remaining = count($from) - $depth;
                if($remaining > 1) {
                    // add traversals up to first matching dir
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath = array_pad($relPath, $padLength, '..');
                    break;
                } else {
                    $relPath[0] = './' . $relPath[0];
                }
            }
        }
        return implode('/', $relPath);
    }

    //Récupère le chemin d'accès du dossier /php
    $url = $_SERVER['REQUEST_URI'];
    $pattern = "/^(.*\/php)\/(.*)/";
    $replacement = "$1";

    $dir = (preg_replace($pattern, $replacement, $url));
    
    require(getRelativePath($url, $dir. '/lib/form-validation/classes/AllowedValueType.php'));
    require(getRelativePath($url, $dir. '/lib/form-validation/classes/FormSubmitMethod.php'));
    require(getRelativePath($url, $dir. '/lib/form-validation/.env.php'));
    require(getRelativePath($url, $dir. '/lib/form-validation/classes/FormParam.php'));
    require(getRelativePath($url, $dir. '/lib/form-validation/classes/Form.php'));
    require(getRelativePath($url, $dir. '/lib/form-validation/classes/FormValidator.php'));
?>