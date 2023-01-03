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

class TranslatorAzure extends TranslatorDefault {

    function __construct()
    {
        $falang_model = new Falang_Model();
        $this->token= $falang_model->get_option('azure_key');

        //supported language https://docs.microsoft.com/en-us/azure/cognitive-services/translator/language-support
        //add extra language for bing
        $this->addServiceLanguage('fr-ca','fr-ca');//canadian

        $this->script = 'translatorAzure.js';
    }

    public function installScripts ($from,$to)
    {
        parent::installScripts($from,$to);

        $inline_script = "var translator = {'from' : '".strtolower($from). "','to' : '".strtolower($to). "'};\n";
        $inline_script .= "var azureKey = '".$this->token."';\n";
        wp_add_inline_script('translatorService',$inline_script,'before');
    }



}