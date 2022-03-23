<?php

namespace Read175\HtmlCrafter\Classes;

/**
 * The Singleton class defines the `GetInstance` method that serves as an
 * alternative to constructor and lets clients access the same instance of this
 * class over and over.
 */
class HtmlCrafterSingleton
{
    /**
     * The Singleton's instance is stored in a static field. This field is an
     * array, because we'll allow our Singleton to have subclasses. Each item in
     * this array will be an instance of a specific Singleton's subclass. You'll
     * see how this works in a moment.
     */
    private static $instances = [];

    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    protected function __construct()
    {
        global $session;
        $session = HtmlCrafterSession::getInstance();
    }

    /**
     * Singletons should not be cloneable.
     */
    protected function __clone()
    {
    }

    /**
     * Singletons should not be restorable from strings.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     */
    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    protected static function loadHelpers()
    {
        $helper_dir_path = ROOT_FOLDER . '/src/helpers';
        $helper_files = glob($helper_dir_path . '/*.php');
        if (isset($helper_files) && is_array($helper_files) && count($helper_files)) {
            foreach ($helper_files as $key => $file) {
                include_once $file;
            }
        }
    }

    protected static function loadConfigs()
    {
        global $appConfig, $session;

        if(isset($session->appConfig) && $session->appConfig) {
            $appConfig = $session->appConfig;
        }else{
            $config_dir_path = ROOT_FOLDER . '/src/configs';
            $config_files = glob($config_dir_path . '/*.php');
            if (isset($config_files) && is_array($config_files) && count($config_files)) {
                foreach ($config_files as $key => $file) {
                    if (!is_file($file) || !file_exists($file)) continue;

                    $info = pathinfo($file);
                    $info['file_content'] = self::fetchConfig($file);
                    $appConfig[$info['filename']] = $info['file_content'];
                }
            }
            $session->appConfig = $appConfig;
        }
    }

    protected static function fetchConfig($file)
    {
        if (file_exists($file) && is_file($file))
            return include $file;
        return false;
    }
}