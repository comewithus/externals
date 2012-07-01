<?php

/**
 * HTML_QuickForm_CAPTCHA Image example - Form
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_QuickForm_CAPTCHA
 * @subpackage Examples
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyright  2006-2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD
 * @version    CVS: $Id: qfcaptcha_form_image.php,v 1.1 2008/04/26 23:27:32 jausions Exp $
 * @filesource
 * @link       http://pear.php.net/package/HTML_QuickForm_CAPTCHA
 * @see        qfcaptcha_image.php
 */

/**
 * Because the CAPTCHA element is serialized in the PHP session,
 * you need to include the class declaration BEFORE the session starts.
 * So BEWARE if you have php.ini session.auto_start enabled, you won't be
 * able to use this element, unless you're also using PHP 5's __autoload()
 * or php.ini's unserialize_callback_func setting
 */
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/CAPTCHA/Image.php';

/**
 * A session is required to store the Text_CAPTCHA instance
 */
session_start();

$form = new HTML_QuickForm('qfCaptcha');

/**
 * - Default image size is 200 x 80 pixels
 * - Default session variable to store phrase in is _HTML_QuickForm_CAPTCHA
 * - Default font info is as listed below
 *   It is imperative to have a correct font path and file!
 *
 * 'callback' is the URL to the script that will generate the actual image
 * Here "qfcaptcha_image.php" refer to the other example file (also in this
 * package.)
 */
$options = array(
    'width'        => 250,
    'height'       => 90,
    'callback'     => 'qfcaptcha_image.php?var='.basename(__FILE__, '.php'),
    'sessionVar'   => basename(__FILE__, '.php'),
    'imageOptions' => array(
        'font_size' => 20,
        'font_path' => '/usr/share/fonts/truetype/',
        'font_file' => 'cour.ttf')
    );

// Minimum options using all defaults (including defaults for Image_Text):
//$options = array('callback' => 'qfcaptcha_image.php');

$captcha_question =& $form->addElement('CAPTCHA_Image', 'captcha_question',
                                       'Verification', $options);
if (PEAR::isError($captcha_question)) {
    echo $captcha_question->getMessage();
    exit;
}

$form->addElement('static', null, null, 'Click on the image for a new one');

$form->addElement('text', 'captcha', 'Enter the letters you see');

$form->addRule('captcha', 'Enter the characters you read in the image',
               'required', null, 'client');

$form->addRule('captcha', 'What you entered didn\'t match the picture',
               'CAPTCHA', $captcha_question);

$form->addElement('submit', '', 'Verify');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm_CAPTCHA Image example</title>
</head>
<body>
<h1>Image CAPTCHA HTML QuickForm</h1>
<?php
if ($form->validate()) {
    // Prevent re-use of the same CAPTCHA phrase
    $captcha_question->destroy();

    echo '<p>Value matched</p>';
} else {
    $form->display();
}

?>
<p><a href="qfcaptcha_image.phps">PHP file source for CAPTCHA image code</a></p>
</body>
</html>
<?php

highlight_file(__FILE__);

?>