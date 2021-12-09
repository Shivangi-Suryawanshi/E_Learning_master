<?php

namespace App\Module;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class PluginManager
{
    private $app;

    /**
     * @var PluginManager
     */
    private static $instance = null;

    /**
     * @var string
     */
    protected $pluginDirectory;

    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * @var array
     */
    protected $classMap = [];

    /**
     * PluginManager constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app             = $app;
        $this->pluginDirectory = $app->path() . DIRECTORY_SEPARATOR . 'Plugins';
        $this->bootPlugins();

        $this->registerClassLoader();
    }

    /**
     * Registers plugin autoloader.
     */
    private function registerClassLoader()
    {
        spl_autoload_register([new ClassLoader($this), 'loadClass'], true, true);
    }

    /**
     * @param $app
     * @return PluginManager
     */
    public static function getInstance($app)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($app);
        }

        return self::$instance;
    }

    protected function bootPlugins()
    {
        $lms_version = config('app.version');


        foreach (Finder::create()->in($this->pluginDirectory)->directories()->depth(0) as $dir) {
            /** @var SplFileInfo $dir */
            $directoryName = $dir->getBasename();

            $pluginClass = $this->getPluginClassNameFromDirectory($directoryName);

            if (!class_exists($pluginClass)) {
                dd('Plugin ' . $directoryName . ' needs a ' . $directoryName . 'Plugin class.');
            }

            try {
                $plugin = $this->app->makeWith($pluginClass, [$this->app]);
            } catch (\ReflectionException $e) {
                dd('Plugin ' . $directoryName . ' could not be booted: "' . $e->getMessage() . '"');
                exit;
            }

            if (!($plugin instanceof PluginBase)) {
                dd('Plugin ' . $directoryName . ' must extends the Plugin Base Class');
            }

            if ($plugin->activated) {
                if (version_compare($plugin->lms_version, $lms_version, '>')) {
                    add_action('admin_notices', function () use ($plugin, $lms_version) {
                        echo "<div class='alert alert-warning d-flex'> <p class='mb-0 mr-2' style='font-size: 35px; line-height: 1'><i class='la la-info-circle'></i></p> <p class='mb-0'> UnitedForTech LMS is running version {$lms_version} but {$plugin->name} requires at least {$plugin->lms_version}, in order to use <strong>{$plugin->name} Plugin</strong>, please update your Teachiy LMS version.  </p> </div>";
                    });
                } else {
                    $plugin->boot();
                }
            }

            $this->plugins[$plugin->slug] = $plugin;
        }
    }

    /**
     * @param $directory
     * @return string
     */
    protected function getPluginClassNameFromDirectory($directory)
    {
        return "App\\Plugins\\${directory}\\${directory}Plugin";
    }

    /**
     * @return array
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * @param array $classMap
     * @return $this
     */
    public function setClassMap($classMap)
    {
        $this->classMap = $classMap;

        return $this;
    }

    /**
     * @param $classNamespace
     * @param $storagePath
     */
    public function addClassMapping($classNamespace, $storagePath)
    {
        $this->classMap[$classNamespace] = $storagePath;
    }

    /**
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @return string
     */
    public function getPluginDirectory()
    {
        return $this->pluginDirectory;
    }
}
