<?php
global $ver;
use Read175\HtmlCrafter\Classes\HtmlCrafter;
$ver = '1.0.0';

function getConfig($name)
{
    global $appConfig;
    $value = null;
    $pattern = explode('.', $name);
    if ($pattern && count($pattern) && count($pattern)) {
        $value = $appConfig[reset($pattern)];
        foreach ($pattern as $p) {
            if ($p == reset($pattern)) continue;
            $value = isset($value[$p]) && $value[$p] !== false ? $value[$p] : null;
        }
    }
    return $value;
}

function reloadAppConfigs() {
    global $session;
    $session->destroy();
    HtmlCrafter::getInstance()->loadConfigs();
}