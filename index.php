<?php

  require_once 'model/Router.class.php';

  $Router = new Router();

  $Router->installedPath = '/leerjaar2/php/Routing/';
  $Router->standardController = 'standard';

  $Router->parseUrl();

  $Router->getController();
  $Router->getMethod();
  $Router->getParameters();

  $Router->parseRouter();

  $Router->routerDebug();

?>
