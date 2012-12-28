<?

define("PAGE_STARTED",1);
define('DOC_ROOT', dirname(dirname(__FILE__)));

require_once('autorun.php');
require_once( '../model/model.php');
require_once( '../model/post.php');

/**
 * Post test class
 */
class TestOfPost extends UnitTestCase
{
    function testCreatePost()
    {
        $post = new Post();
        $result = $post->createPost(1,1,'unittest');
        $result = $result['post_id'];
        $this->assertTrue($result > 0);
    }

    function testReturnPosts()
    {

        $post = new Post();
        $result = end($post->returnPosts(1));
        $this->assertTrue($result['message'] == 'unittest');

    }

}
