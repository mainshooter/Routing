<?php

  class Router {
    public $installedPath = '';
    public $standardController = '';
    public $standardMethod = 'index';

    private $url;
    private $path;
    private $controller;
    private $method;
    private $parameters;

    public function __construct() {
      $this->url = $this->getUrl();
    }

    public function parseUrl() {
        $this->path = str_replace($this->installedPath, '', $this->url);
        $this->path = explode('/', $this->path);
    }

    public function parseRouter() {
      require_once $this->controller . "Controller.php";

      $controller = new $this->controller;
      $method = $this->method;
      $parameters = $this->parameters;
      call_user_func_array($controller, $method, [$parameters]);
    }

    public function getController() {
      $controller = $this->path[0];

      if (file_exists('controller/' . $controller . 'Controller.php')) {
        // Check if there is a controller
        $this->controller = $controller;
      }
      else {
        // We will set the default controller to be used
        $this->controller = $this->standardMethod;
      }
    }

    public function getMethod() {
      $method = $this->path[1];

      if (method_exists($this->controller, $method)) {
        $this->method = $method;
      }
      else {
        $this->method = $this->standardMethod;
      }
    }

    public function getParameters() {
      $parameters = $this->path;
      unset($parameters[0]);
      unset($parameters[1]);
      // To remove the method and the controller
      if (!empty($parameters)) {
        $this->parameters = $parameters;
      }
      else {
        $this->parameters = array();
      }
    }

    public function routerDebug() {
      echo '<div style="font-size: 1.6em;padding: 1em;">';
        echo "<h2 style='padding: 0; margin: 4px;'>Router debug</h2>";
        echo "Url: " . $this->url;
        echo "<br>";
        echo "Path: ";
        echo "<pre>";
          var_dump($this->path);
        echo "</pre>";
        echo "<br>";
        echo "Controller: " . $this->controller;
        echo "<br>";
        echo "Methode: " . $this->method;
        echo "<br>";
        echo "Parameters: ";
        echo "<pre>";
        var_dump($this->parameters);
        echo "</pre>";
      echo "</div>";
    }

    public function getUrl() {
      $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      return($url);
    }
  }


?>
