<?php

/**
 * HTML_QuickForm_CAPTCHA "Word" example - Form
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_QuickForm_CAPTCHA
 * @subpackage Examples
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyright  2006-2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD
 * @version    CVS: $Id: qfcaptcha_form_word.php,v 1.1 2008/04/26 23:27:32 jausions Exp $
 * @filesource
 * @link       http://pear.php.net/package/HTML_QuickForm_CAPTCHA
 */

/**
 * Because the CAPTCHA element is serialized in the PHP session,
 * you need to include the class declaration BEFORE the session starts.
 * So BEWARE if you have php.ini session.auto_start enabled, you won't be
 * able to use this element, unless you're also using PHP 5's __autoload()
 * or php.ini's unserialize_callback_func setting
 */
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/CAPTCHA/Word.php';

/**
 * A session is required to store the Text_CAPTCHA instance
 */
session_start();

$options = array('sessionVar' => basename(__FILE__, '.php'));

$form = new HTML_QuickForm('qfCaptcha');

$captcha_question =& $form->addElement('CAPTCHA_Word', 'captcha_question',
                                       'Can you read this?', $options);
if (PEAR::isError($captcha_question)) {
    echo $captcha_question->getMessage();
    exit;
}

$captcha_answer =& $form->addElement('text', 'captcha', 'Enter the answer');

$form->addRule('captcha', 'Enter the answer to the question',
               'required', null, 'client');

$form->addRule('captcha', 'What you entered didn\'t match the question',
               'CAPTCHA', $captcha_question);

$form->addElement('submit', '', 'Verify');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML_QuickForm_CAPTCHA &quot;Spelled-Out Number Words&quot; example</title>
</head>
<body>
<h1>Spelled-Out Number Words CAPTCHA HTML QuickForm</h1>
<?php
if ($form->validate()) {
    // Prevent the re-use of the same CAPTCHA phrase for future submissions
    // (If you do not destroy the CAPTCHA, someone could reuse the same
    // answer over and over again...)
    $captcha_question->destroy();

    echo '<p>Value matched</p>';
} else {
    // Force a new CAPTCHA if the answer submitted was incorrect
    // (this is not required, but it improves the effectiveness of the CAPTCHA
    // by preventing brut force attack)
    if ($form->getElementError('captcha')) {
        $captcha_question->destroy();
        $captcha_answer->setValue('');
    }

    $form->display();
}

?>
</body>
</html>
<?php

highlight_file(__FILE__);

?>