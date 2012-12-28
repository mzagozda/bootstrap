<?
/*
 * This is assumed to be placed in the root of the application
 * This is based on the following patterns: MVC OOP
 *
 * Routing
 *
 * Basic routing support via .htaccess (note dependency on apache server),
 * Router object providing parameters:
 * c - name of controller to be invoked, note GetController
 * a - action on the controller to be invoked, note GetAction
 * p - parameters (supplied by either get or post), note GetParameters
 *
 * Naming conventions:
 * - Controllers: plural (example: pages, errors, etc)
 * - Models: singular (example: page, error, etc)
 * - Methods: consistent (example: createObject, updateObject, deleteObject, returnObject)
 * - Variables: camel case (example: variableName, sampleObject)
 * - Database tables: plural (example: users, threads, posts)
 * - Database input parameters: camel case (example: userId)
 * - Database output parameters and results: (example: user_id)
 *
 * Development conventions:
 *
 * MVC:
 * - Implement Objects by inheriting from Model object (/model) to provide object persistence support (via database helper)
 * - Implement Templates (/template) to provide either html or json output
 * - Implement Views in Templates (/view) to provide
 * - Implement Controllers by inheriting from Controller object (/controller)
 *
 * OOP:
 * - Implement auxiliary objects via Helpers (\helper)
 * - Construct objects without parameters to use as repositories
 *   this is useful when you want focus on methods of the object
 *   (with none of the object data populated on instantiation due to performance)
 *
 *   example 1:
 *
 *   $o = new Object()
 *   $list($objectId, $objectName) = $o->GetLatestObjectData
 *
 *   example 2:
 *
 *   $o = new Object()
 *   $objectId = $o->getByName($objectName)
 *
 * - Construct object with id parameter  // TODO: this is yet to be seen ;-)
 *   this is useful when you want to focus on the data of the object
 *   (with all object data populated on instantiation at once due to performance)
 *
 *   example 1:
 *
 *   $o = new Object($objectId)
 *   $objectName = $o->FullName;
 *
 * - Store configuration elements in config (/config) *
 * - Use single quotes in strings wherever possible // TODO: this is yet to be seen ;-)
 * - Use basic type autoboxing with type hinting wherever strong types are required
 * - All file names in lowercase to suppress issues with *nix on *win development
 *
 * Goals:
 * - explicit object oriented programming around model view controller pattern
 * - few dependencies on: magic methods, global scoping, passing by reference
 * - supports ide features for inspection and refactoring via phpdoc
 */

define('PAGE_STARTED', true);
define('DOC_ROOT', dirname(__FILE__));
define('PAGE_DEFAULT_CONTROLLER', 'pages');
define('PAGE_DEFAULT_EXTENSION', '.php');
define('SALT','loancalculator');

$test_post = 0;

require_once DOC_ROOT . '/config/config.php';
require_once DOC_ROOT . '/helper/router.php';
require_once DOC_ROOT . '/helper/loader.php';
require_once DOC_ROOT . '/controller/controller.php';
require_once DOC_ROOT . '/model/model.php';

require_once DOC_ROOT . '/helper/session.php';

// controller
$controller = Router::getController();
$controller_file = Router::getControllerFile();

/** @noinspection PhpIncludeInspection */
require_once DOC_ROOT . '/controller/' . $controller_file;

if (class_exists($controller)) {
    $controller = new $controller;
} else {
    require_once DOC_ROOT . '/controller/errors.php';
    $controller = new Errors;
}

// action
$action = Router::getAction($controller);

// template
//$controller->template = $controller::getTemplate($action);

// params
$controller->$action(Router::getParameters());

// TODO: implement 404.html document