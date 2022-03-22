<?php

namespace Read175\HtmlCrafter\Classes;

use Closure;

class HtmlCrafter extends HtmlCrafterSingleton
{

    protected function __construct()
    {
        parent::__construct();
    }

    public static function init()
    {
        self::loadConfigs();
        self::loadHelpers();
        self::loadViews();
    }

    protected static function loadViews()
    {
        $request = $_SERVER['REQUEST_URI'];
        $view_dir_path = ROOT_FOLDER . '/src/pages';
        $file = '';
        if ($request == '/') {
            $view_path = glob($view_dir_path . '/index.php');
            if (isset($view_path[0]) && file_exists($view_path[0]) && is_file($view_path[0])) {
                $file = $view_path[0];
            } else {
                $view_path = glob($view_dir_path . '/home.php');
                if (isset($view_path[0]) && file_exists($view_path[0]) && is_file($view_path[0])) {
                    $file = $view_path[0];
                }
            }
        } else {
            $view_path = glob($view_dir_path . $request . '.php');
            if (isset($view_path[0]) && file_exists($view_path[0]) && is_file($view_path[0])) {
                $file = $view_path[0];
            }
        }

        self::loadRouteView($request, function () use ($file){
            ob_start();
            include_once ROOT_FOLDER . "/src/partials/header.php";
            echo "<main class='app-main'>";
            if (!isset($file) || $file == '') {
                echo "<div>Page Not Found - 404</div>";
            } else {
                include_once $file;
            }
            echo "</main>";
            include_once ROOT_FOLDER . "/src/partials/footer.php";
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        });

        self::dispatchRoute($request);
    }

    /**
     * Register a new route
     *
     * @param $action string
     * @param $callback
     */
    protected static function loadRouteView($action, $callback)
    {
        global $routes;
        $action = trim($action, '/');
        $routes[$action] = $callback;
    }

    /**
     * Dispatch the router
     *
     * @param $action string
     */
    protected static function dispatchRoute($action)
    {
        global $routes;
        $action = trim($action, '/');
        $callback = $routes[$action];

        echo call_user_func($callback);
    }
}