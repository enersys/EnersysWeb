<?php
/**
 * The translator external functionality of the plugin.
 *
 * @link       www.faboba.com
 * @since      1.3.5
 *
 * @package    Falang
 */
namespace Falang\Translator;

use Falang\Model\Falang_Model;

class TranslatorGoogle extends TranslatorDefault {

    function __construct()
    {
        $falang_model = new Falang_Model();
        $this->token= $falang_model->get_option('google_key');

        //supported language https://cloud.google.com/translate/docs/languages
        //add extra language for google
        $this->addServiceLanguage('el','el');//greek

        $this->script = 'translatorGoogle.js';
    }

    public function installScripts ($from,$to)
    {
        parent::installScripts($from,$to);

        $inline_script = "var translator = {'from' : '".strtolower($from). "','to' : '".strtolower($to). "'};\n";
        $inline_script .= "var googleKey = '".$this->token."';\n";
        wp_add_inline_script('translatorService',$inline_script,'before');
    }

}