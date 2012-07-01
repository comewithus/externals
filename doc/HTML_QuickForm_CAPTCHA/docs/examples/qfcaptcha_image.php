<?php
/**
 * HTML_QuickForm_CAPTCHA example - Image generator
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_QuickForm_CAPTCHA
 * @subpackage Examples
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyright  2006-2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD
 * @version    CVS: $Id: qfcaptcha_image.php,v 1.1 2008/04/26 23:27:32 jausions Exp $
 * @filesource
 * @link       http://pear.php.net/package/HTML_QuickForm_CAPTCHA
 * @see        qfcaptcha_form_image.php
 * @see        qfcaptcha_form_random.php
 */

// Require the class before opening the session
// so the instance unserialize properly
require_once 'Text/CAPTCHA.php';
require_once 'Text/CAPTCHA/Driver/Image.php';

session_start();

header('Content-Type: image/jpeg');

$sessionVar = (empty($_REQUEST['var']))
              ? '_HTML_QuickForm_CAPTCHA'
              : $_REQUEST['var'];

// Force a new CAPTCHA for each one displayed
$_SESSION[$sessionVar]->setPhrase();

echo $_SESSION[$sessionVar]->getCAPTCHAAsJPEG();

?>