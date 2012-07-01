<?php

/**
 * HTML_QuickForm_CAPTCHA mix example - Form
 *
 * In this example, we'll pick the type of CAPTCHA loaded at runtime. So, if
 * the answer doesn't match the first time, the user may be prompted for a
 * different type of CAPTCHA on the next try.
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_QuickForm_CAPTCHA
 * @subpackage Examples
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyright  2006-2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD
 * @version    CVS: $Id: qfcaptcha_form_random.php,v 1.1 2008/04/26 23:27:32 jausions Exp $
 * @filesource
 * @link       http://pear.php.net/package/HTML_QuickForm_CAPTCHA
 * @see        qfcaptcha_image.php
 */

/**
 * Because the CAPTCHA elements are serialized in the PHP session,
 * you need to include the class declarations BEFORE the session starts.
 * So BEWARE if you have php.ini session.auto_start enabled, you won't be
 * able to use this element, unless you're also using PHP 5's __autoload()
 * or php.ini's unserialize_callback_func setting
 */
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/CAPTCHA/Equation.php';
require_once 'HTML/QuickForm/CAPTCHA/Figlet.php';
require_once 'HTML/QuickForm/CAPTCHA/Image.php';
require_once 'HTML/QuickForm/CAPTCHA/Word.php';


/**
 * A session is required to store the Text_CAPTCHA instance
 */
session_start();

// Options are mixed between the different CAPTCHA drivers
// (see the other examples for more details)
$options = array('sessionVar'   => basename(__FILE__, '.php'),

                 'options'      => array('font_file' => array(
                                         '/usr/share/fonts/figlet/basic.flf',
                                         '/usr/share/fonts/figlet/big.flf',
                                         '/usr/share/fonts/figlet/nancyj.flf',
                         )),
                 'width'        => 250,
                 'height'       => 90,

                 'callback'     => 'qfcaptcha_image.php?var='
                                   .basename(__FILE__, '.php'),
                 'imageOptions' => array(
                     'font_size' => 20,
                     'font_path' => '/usr/share/fonts/truetype/',
                     'font_file' => 'cour.ttf'),
    );

$form = new HTML_QuickForm('qfCaptcha');

// Pick a random CAPTCHA driver
$drivers = array('CAPTCHA_Word',
                 'CAPTCHA_Image',
                 'CAPTCHA_Equation',
                 'CAPTCHA_Figlet',
                );
$captcha_type = $drivers[array_rand($drivers)];

// Create the CAPTCHA element:
$captcha_question =& $form->addElement($captcha_type, 'captcha_question',
                                       'How do you understand this?', $options);
if (PEAR::isError($captcha_question)) {
    echo $captcha_type . ' :: ' . $captcha_question->getMessage();
    exit;
}

$captcha_answer =& $form->addElement('text', 'captcha', 'Enter the answer');

$form->addRule('captcha', 'Enter your answer',
               'required', null, 'client');

$form->addRule('captcha', 'What you entered didn\'t match. Try again.',
               'CAPTCHA', $captcha_question);

$form->addElement('checkbox', 'blocker', 'Validate Form?',
                  'Uncheck this box to fail form validation (beside CAPTCHA)');
$form->addRule('blocker', 'Form failed validation', 'required');

$form->setDefaults(array('blocker' => 1));

$form->addElement('submit', '', 'Verify');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm_CAPTCHA random example</title>
</head>
<body>
<h1>Random CAPTCHA Type HTML QuickForm</h1>

<?php
if ($form->validate()) {
    // Prevent the re-use of the same CAPTCHA phrase for future submissions
    // (If you do not destroy the CAPTCHA, someone could reuse the same
    // answer over and over again...)
    $captcha_question->destroy();

    // Don't need to see CAPTCHA related elements
    $form->removeElement('captcha_question');
    $form->removeElement('captcha');
    $form->freeze();
    echo '<p>Value matched!</p>';

    $form->display();

} else {
    // Since the CAPTCHA created within this call might be of a different type
    // from one created from a previous call (i.e. page refresh, or form
    // didn't validate) we need to scrap the old instance (of Text_CAPTCHA).
    // That's what the destroy() method does.
    // Downside is if the CAPTCHA was answered properly but the form
    // otherwise didn't pass validation, the user will have to reenter a new
    // answer to the CAPTCHA...
    $captcha_question->destroy();
    $captcha_answer->setValue('');

    $form->display();
}

?>
</body>
</html>
<?php

highlight_file(__FILE__);

?>