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
        $view_dir_path = ROOT_FOLDER . '/src/sites/site1/pages';
        $file = '';
        switch ($request) {
            case '/';
                if (file_exists($view_dir_path . '/index.php')) {
                    $view_path = glob($view_dir_path . '/index.php');
                }
                if(file_exists($view_dir_path . '/home.php')) {
                    $view_path = glob($view_dir_path . '/home.php');
                }
                break;
            case '/app-settings':
                $view_path = glob(ROOT_FOLDER . '/src/sites/app-settings.php');
                break;
            default:
                $view_path = glob($view_dir_path . $request . '.php');
        }

        if(isset($view_path[0]) && file_exists($view_path[0])) {
            $file = $view_path[0];
        }

        self::loadRouteView($request, function () use ($file, $request){
            ob_start();
            if($request == '/app-settings') {
                include_once ROOT_FOLDER . "/src/sites/app-header.php";
            }else{
                include_once ROOT_FOLDER . "/src/sites/site1/partials/header.php";
            }

            echo "<main class='app-main'>";
            if (!isset($file) || $file == '') {
                echo $file;
                echo "<div>Page Not Found - 404</div>";
            } else {
                include_once $file;
            }
            echo "</main>";
            if($request == '/app-settings') {
                include_once ROOT_FOLDER . "/src/sites/app-footer.php";
            }else{
                include_once ROOT_FOLDER . "/src/sites/site1/partials/footer.php";
            }
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