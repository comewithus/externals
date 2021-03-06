<?php
/**
 * This script provides a simple example of using the Image_Resize library and
 * is designed to be used as a test of your setup.
 */
error_reporting(E_ALL);
define('IMAGE_TRANSFORM_LIB_PATH', '/netpbm/');
require_once 'Image/Transform.php';
// Change 'IM' to 'GD' to test using the GD library.
$im = Image_Transform::factory('NetPBM');
$im->load('Image/Transform/Examples/test.jpg');

// next will resize so that the largest length is 300px - height or width
$im->resize(300, 50);
// next is a subclass call that calls the above with a set size.
// $im->addText(array('text' => 'Annotated'));
//$im->display();
$im->save('/www/htdocs/test.jpg');
// Now free the memory
$im->free();
?>
<img src="test.jpg">
