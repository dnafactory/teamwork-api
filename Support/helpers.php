<?php

function array_get_by_path(array $arr, string $path, $default = null)
{
    $cur = $arr;
    $pathPieces = explode('.', $path);
    foreach ($pathPieces as $piece) {
        if (is_null($cur) || !is_array($cur)) {
            $cur = null;
            break;
        }
        $cur = $cur[$piece] ?? null;
    }
    return $cur ?? $default;
}

