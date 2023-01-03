<?php
/**
 * The translator external functionality of the plugin.
 *
 * @link       www.faboba.com
 * @since      1.3
 *
 * @package    Falang
 */

namespace Falang\Translator;


class TranslatorYandex extends TranslatorDefault {


    function __construct()
    {
        $this->token= Falang()->get_model()->get_option('yandex_key');

        //add script to page
        $this->script = 'translatorYandex.js';

    }

    public function installScripts ($from,$to) {

        parent::installScripts($from,$to);

        $inline_script = "var translator = {'from' : '".strtolower($from). "','to' : '".strtolower($to). "'};\n";
        $inline_script .= "var YandexKey = '".$this->token."';\n";
        wp_add_inline_script('translatorService',$inline_script,'before');
    }

    public function ajax_yandex_translate(){
        $url = "https://translate.api.cloud.yandex.net/translate/v2/translate";
        $sourceLanguageCode        = !empty( $_POST['sourceLanguageCode'] ) ? $_POST['sourceLanguageCode'] :'' ;
        $targetLanguageCode        = !empty( $_POST['targetLanguageCode'] ) ? $_POST['targetLanguageCode'] :'' ;
        $text = !empty( $_POST['texts'] ) ? $_POST['texts'] :'' ;

        //$this->token don't work here
        $token= Falang()->get_model()->get_option('yandex_key');

        $postfields = array();
        $postfields['sourceLanguageCode'] = $sourceLanguageCode;
        $postfields['targetLanguageCode'] = $targetLanguageCode;
        $postfields['format'] = 'HTML';
        $postfields['texts'] = array($text);

        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: Api-Key '.$token;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postfields));
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Set curl options relating to SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);



        if( ! $result = curl_exec($ch))
        {
            $error = curl_error($ch);
            $response          = new \stdClass();
            $response->error = true;
            $response->text[]  = $error;//allow to display error in the input result
            Falang()->return_json( $response );
            exit();
        }
        curl_close($ch);

        $response          = new \stdClass();
        $response->success = true;
        $response->data = $result;
        Falang()->return_json($response);
        exit();

    }

}