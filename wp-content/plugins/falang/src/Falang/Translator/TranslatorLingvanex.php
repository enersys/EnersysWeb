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

class TranslatorLingvanex extends TranslatorDefault {

    function __construct()
    {
        $this->token= Falang()->get_model()->get_option('lingvanex_key');

        $this->setServiceLanguage();

        $this->script = 'translatorLingvanex.js';
    }

    public function installScripts ($from,$to)
    {
        parent::installScripts($from,$to);

        $inline_script = "var translator = {'from' : '".strtolower($from). "','to' : '".strtolower($to). "'};\n";
        $inline_script .= "var LingvanexKey = '".$this->token."';\n";
        wp_add_inline_script('translatorService',$inline_script,'before');
    }

    //return the language code in specific format aa_AA
    //key is the WordPress language code
    //example en_GB, es_ES, ru_RU
    public function languageCodeToISO ($language){
        $l = strtolower($language);
        if (isset(TranslatorDefault::$languageCodeInISO[$l])){
            return TranslatorDefault::$languageCodeInISO[$l];
        } else {
            return '';
        }
    }

    private function setServiceLanguage(){
        //wordpress locale lowercase => lingvanex code
        $this->addServiceLanguage('af','af_ZA');//
        $this->addServiceLanguage('sq','sa_AL');//
        $this->addServiceLanguage('bel','be_BY');//
        $this->addServiceLanguage('bg_bg','bg_BG');//
        $this->addServiceLanguage('zh_cn','zh_Hans_CN');//
        $this->addServiceLanguage('cs_cz','cs_CZ');//
        $this->addServiceLanguage('da_dk','da_DK');//
        $this->addServiceLanguage('nl_nl','nl_NL');//
        $this->addServiceLanguage('fi','fi_FI');//
        $this->addServiceLanguage('de_de','de_DE');//
        $this->addServiceLanguage('de_ch','de_DE');//
        $this->addServiceLanguage('el','el_GR');//
        $this->addServiceLanguage('id_id','id_ID');//
        $this->addServiceLanguage('it_it','it_IT');//
        $this->addServiceLanguage('ja','ja_JP');//
        $this->addServiceLanguage('km','km_KH');//
        $this->addServiceLanguage('ko_kr','ko_KR');//
        $this->addServiceLanguage('lv','lv_LV');//
        $this->addServiceLanguage('lt_lt','lt_LT');//
        $this->addServiceLanguage('pt','pt_PT');//
        $this->addServiceLanguage('pt_br','pt_PT');//
        $this->addServiceLanguage('ro_ro','ro_RO');//
        $this->addServiceLanguage('sl_sl','sl_SL');//
        $this->addServiceLanguage('es_ar','es_ES');//
        $this->addServiceLanguage('es_mx','es_ES');//
        $this->addServiceLanguage('es_es','es_ES');//
        $this->addServiceLanguage('sv_se','sv_SE');//
        $this->addServiceLanguage('th','th_TH');//
        $this->addServiceLanguage('tr_tr','tr_TR');//
        $this->addServiceLanguage('uk','uk_UA');//ukrainian
        $this->addServiceLanguage('vi','vi_VN');//
        $this->addServiceLanguage('en_au','en_US');//English (Australia)
        $this->addServiceLanguage('en_ca','en_US');//English (Canada)
        $this->addServiceLanguage('en_gb','en_US');//English (UK)
        $this->addServiceLanguage('en_us','en_US');//English
        $this->addServiceLanguage('en','en_US');//English
        $this->addServiceLanguage('fr_be','fr_FR');//French
        $this->addServiceLanguage('fr_fr','fr_FR');//French
        $this->addServiceLanguage('fr_ca','fr_CA');//French
        $this->addServiceLanguage('ru_ua','uk_ua');//ukrainian
    }



}