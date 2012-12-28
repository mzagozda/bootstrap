<?

define("PAGE_STARTED",1);
define('DOC_ROOT', dirname(dirname(__FILE__)));

require_once('autorun.php');
require_once('../primitives.php');
require_once('../model/model.php');
require_once('../model/loan.php');

/**
 * Post test class
 */
class TestOfThread extends UnitTestCase
{
    function testCreateThread()
    {
        $thread = new Thread();

        $propertyId = 9999;
        $operatorId = 999;
        $customerId = 99;
        $checkIn = '2011-01-01';
        $checkOut = '2011-01-01';
        $statusId = 1;

        $result = $thread->createThread($propertyId, $operatorId, $customerId, $checkIn, $checkOut, $statusId);


        $resultVal = &String($result['thread_id']);
        $resultId = &Integer();
        $resultId = $resultVal->toInteger();

        $this->assertTrue($resultId > 0);
    }

    function testReturnThreads()
    {

        $thread = new Thread();

        $result = $thread->returnThreads(99, false);

        $this->assertTrue($result[0]['operator_id'] == 999);

    }

}
