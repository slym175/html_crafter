<?php
global $ver;
$ver = '1.0.0';

function isResourceLocal($url)
{
    if (empty($url)) {
        return false;
    }
    $urlParsed = parse_url($url);
    $host = $urlParsed['host'];
    if (empty($host)) {
        /* maybe we have a relative link like: /wp-content/uploads/image.jpg */
        /* add absolute path to begin and check if file exists */
        $doc_root = $_SERVER['DOCUMENT_ROOT'];
        $maybefile = $doc_root . $url;
        /* Check if file exists */
        $fileexists = file_exists($maybefile);
        if ($fileexists) {
            /* maybe you want to convert to full url? */
            return true;
        }
    }
    /* strip www. if exists */
    $host = str_replace('www.', '', $host);
    $thishost = $_SERVER['HTTP_HOST'];
    /* strip www. if exists */
    $thishost = str_replace('www.', '', $thishost);
    if ($host == $thishost) {
        return true;
    }
    return false;
}

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

function loadAssets($options = [])
{
    $default_options = [
        'include' => [],
        'exclude' => [],
        'scripts_async' => [],
        'scripts_defer' => [],
        'scripts_preload' => [],
        'fonts_preload' => [],
    ];

    $options = array_merge($default_options, $options);

    $assets = getConfig('assets');
    global $ver;
    $ver = $assets['versions'];
    $styles = $assets['styles'];
    $scripts = $assets['scripts'];
    $fonts = $assets['fonts'];

    $header = [];
    $footer = [];

    foreach ($fonts as $key => $font) {
        $header[] = genStyleTag($key, $font);
    }

    foreach ($styles as $key => $style) {
        if (isset($style['position']))
            switch ($style['position']) {
                case 'footer':
                    $footer[] = genStylesTag($key, $style);
                    break;
                default:
                    $header[] = genStyleTag($key, $style);
            }
    }

    foreach ($scripts as $key => $script) {
        if (isset($script['position']))
            switch ($script['position']) {
                case 'footer':
                    $footer[] = genScriptTag($key, $script);
                    break;
                default:
                    $header[] = genScriptTag($key, $script);
            }
    }

    return array(
        'header' => $header,
        'footer' => $footer
    );
}

function loadHeaderAssets($options = [])
{
    echo "<pre>";
    print_r(loadAssets($options));
}

function loadFooterAssets($options = [])
{

}

function genStyleTag($key, $style = [])
{
    global $ver;
    if (!isset($style) || !is_array($style) || !count($style) || isset($style['src']) || $style['src']) return;
    $s = '';
    if(!isResourceLocal($style['src'])) {
        $s.= '';
    }
    return $s.'<link id="' . 'k_' . $key . '_css' . '" src="' . (isset($style['src']) && $style['src'] ? $style['src'] . '/v=' . $ver : '') . '" media="all">';
}

function genScriptTag($key, $script = [])
{
    global $ver;
    if (!isset($script) || !is_array($script) || !count($script) || !isset($script['src']) || !$script['src']) return;
    $s = '';
    if(!isResourceLocal($script['src'])) {
        $s.= '';
    }
    return $s.'<script id="' . 'k_' . $key . '_js' . '" src="' . (isset($script['src']) && $script['src'] ? $script['src'] . '/v=' . $ver : '') . '"></script>';
}

function getFontTag($key, $font)
{
    if (!isset($font) || !$font || $font == '') return;
    $s = '';
    if(!isResourceLocal($font)) {
        $s.= '';
    }
    return $s.'<link rel="preload" href="' . $font . '" as="font" type="font/woff2">';
}