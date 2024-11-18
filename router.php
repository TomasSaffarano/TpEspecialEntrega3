<?php   
    require_once 'libs/router.php';
    require_once 'api/controllers/productApiController.php';
   
    $router = new Router();

    //                Endpoint                          Verbo      Controller                   Metodo
    $router->addRoute('productos'      ,                'GET',     'productApiController',      'getAll');
    $router->addRoute('productos/:id'  ,                'GET',     'productApiController',      'get');
    $router->addRoute('productos/:id'  ,                'DELETE',  'productApiController',      'delete');
    $router->addRoute('productos'      ,                'POST',    'productApiController',      'create');
    $router->addRoute('categorias'      ,               'GET',    'productApiController',       'serveCategories');
    $router->addRoute('categorias/:id'      ,           'GET',    'productApiController',       'getCat');
    $router->addRoute('productos/categorias/:id_cat',    'GET',     'productApiController',      'getAllCat');
    $router->addRoute('productos/:id'  ,                'PUT',     'productApiController',      'update');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
