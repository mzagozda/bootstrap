<?

define("PAGE_STARTED",1);
define('DOC_ROOT', dirname(dirname(__FILE__)));

require_once('autorun.php');
require_once( '../model/model.php');
require_once( '../model/post.php');

class TestOfPost extends UnitTestCase
{
    function testPostModel()
    {
        $post = new Post();
        $result = $post->set(1,'unittest');
        $result = end($post->get(1));
        $this->assertTrue($result['message'] == 'unittest');
    }
}
