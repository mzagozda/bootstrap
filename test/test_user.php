<?

/**
 * Created by JetBrains PhpStorm.
 * User: mzag
 * Date: 24/10/12
 * Time: 14:28
 * There's a convention that assues that user_id is returned by each of those method
 */


define("PAGE_STARTED",1);
define('DOC_ROOT', dirname(dirname(__FILE__)));

require_once('autorun.php');
require_once( '../model/model.php');
require_once( '../model/user.php');

class TestOfUser extends UnitTestCase
{
    function testCreateUserId()
    {

        $user = new User();
        $result = $user->createUserId('test@pureholidayhomes.com', 'password');
        $result = $result[0]['user_id'];
        $this->assertTrue($result > 0);

    }

    function testReturnUserId()
    {

        $user = new User();
        $result = $user->returnUserId('test@pureholidayhomes.com', 'password');
        $result = $result[0]['user_id'];
        $this->assertTrue($result > 0);

    }

    /*
    function  testDeleteUserId()
    {
        $user = new User();
        $result = $user->deleteUserId('test@pureholidayhomes.com');
        $result = $result[0]['user_id'];
        $this->assertTrue($result > 0);
    }
    */



}
