<?php


namespace Falang\Filter\Site;


use Falang\Core\Taxonomy;

class Yoast {

    /**
     * Constructor
     *
     * @since 1.3.8
     *
     */
    public function __construct() {

        //add_filter('wpseo_robots', array($this, 'wpseo_translation_noindex'), 10, 2);
        //add_filter( 'yoast_seo_development_mode', '__return_true' );

        //for only translated language test default in the function
        add_filter('wpseo_title', array($this, 'wpseo_title'), 10, 2);
        add_filter('wpseo_opengraph_title', array($this, 'wpseo_og_title'), 10, 2);

        add_filter('wpseo_metadesc', array($this, 'wpseo_metadesc'), 10, 2);
        add_filter('wpseo_opengraph_desc', array($this, 'wpseo_opengraph_desc'), 10, 2);
        //add_filter('wpseo_opengraph_url',array($this, 'wpseo_opengraph_url'), 10, 2);

        add_filter( 'wpseo_should_save_indexable', array( $this, 'wpseo_should_save_indexable' ) );

        add_filter( 'wpseo_schema_organization',[ $this,'wpseo_schema_url'],10);
        add_filter( 'wpseo_schema_website',[ $this,'wpseo_schema_url'],10);
        add_filter( 'wpseo_schema_webpage',[ $this,'wpseo_schema_url'],10);

        //for all languages
        add_filter( 'wpseo_frontend_presentation', array( $this, 'translatePermalinks' ) );//this should be enabled for main_language. Maybe can be disabled for main language if we are sure that link on main language are always right(after disabling indexable generation)


    }

    public function wpseo_translation_noindex($robots,$presentation){
        //this is only to prevent robots to index translations. It's only needed for test period, And should be not used when everything is ok.
        if (!Falang()->is_default() ){$robots="noindex, nofollow"; }
        return $robots;
    }

    /*
     * @since 1.3.15  $data['@type'] is no more an array
     * @since 1.3.20 check $data['publisher']
     * @since 1.3.27 add isset on $data['publisher']['@id'] and  $data['potentialAction'][0]['target']
     * @since 1.3.30 php 8 waring fix $data is an array
     */
    public function wpseo_schema_url($data){
        if (Falang()->is_default() ) return $data;
        //there is problem:if indexable is empty -then it adds double /language-codes ex /uk/uk/

        $home_url=home_url('/');
        $home_default =str_replace('/'.Falang()->current_language->slug,'',$home_url);

        if (isset($data['url'])){
            $data['url']=str_replace($home_default, $home_url,$data['url']);
        }
        if (isset($data['@id'])){
            $data['@id']=str_replace($home_default, $home_url,$data['@id']);
        }
        //additional replacments because some of them were in internal array. Not all links should be changed thats why it's targeting only selected.
        if ($data['@type']=='Organization'){

            $data['logo']['@id']=str_replace($home_default, $home_url,$data['logo']['@id']);
            $data['image']['@id']=str_replace($home_default, $home_url,$data['image']['@id']);
        }
        elseif ($data['@type']=='WebSite'){

            if (isset($data['publisher']) && isset($data['publisher']['@id'])){
                $data['publisher']['@id']=str_replace($home_default, $home_url,$data['publisher']['@id']);
            }
            if (isset( $data['potentialAction']) && isset($data['potentialAction'][0]) && isset( $data['potentialAction'][0]['target'])){
                $data['potentialAction'][0]['target']=str_replace($home_default, $home_url,$data['potentialAction'][0]['target']);
            }
        }

        elseif($data['@type']=='ItemPage' ){
            $data['isPartOf']=str_replace($home_default, $home_url,$data['isPartOf']);
        }

        return $data;
    }


    public function wpseo_title($title,$presentation)
    {
        return $this->translate_title($title,$presentation,array('_yoast_wpseo_title','post_title'));
    }

    public function wpseo_og_title($title,$presentation)
    {
        return  $this->translate_title($title,$presentation,array('_yoast_wpseo_opengraph-title','_yoast_wpseo_title','post_title'));
    }

    public function wpseo_metadesc($description, $presentation)
    {
        return $this->translate_description($description, $presentation,array('_yoast_wpseo_metadesc','post_excerpt'));
    }

    public function wpseo_opengraph_desc($description, $presentation)
    {
        return $this->translate_description($description, $presentation,array('_yoast_wpseo_opengraph-description','_yoast_wpseo_metadesc','post_excerpt'));
    }

    private function translate_title($title,$presentation,array $optionNames) {
        if(Falang()->is_default()) return $title;
        $object_type = $presentation->model->object_type;
        if ($object_type == 'term'){
            //nothing to do the title is already translated.
            //format tested %%term_title%% Archivy %%page%% %%sep%% %%sitename%%
        } else {
            //post, page, product..
            $language = Falang()->get_current_language();
            $post_id=$presentation->model->object_id;
            $post = get_post ($post_id);
            //normal post title translation
            $falang_post = new \Falang\Core\Post($presentation->model->object_id);

            if ($post && $falang_post->is_post_type_translatable($post->post_type)){

                $last_key = $this->array_key_last($optionNames);
                foreach ($optionNames as $key => $optionName) {
                    //last key post_title
                    if ($key == $last_key) {
                        $title = $falang_post->translate_post_field($post, 'post_title', $language, $title);
                    } else {
                        //specific yoast title set
                        $yoast_wpseo_title = $falang_post->translate_post_meta($post, $optionName,true,$language, '');
                        if (!empty($yoast_wpseo_title)) {
                            $title = $yoast_wpseo_title;
                            break;
                        }
                    }
                }

                $title = wpseo_replace_vars( $title, $presentation );

            }
        }

        return $title;

    }

    /*
     * array_key_last only since php 7
     * */
    private function array_key_last(array $array) {
        if( !empty($array) ) return key(array_slice($array, -1, 1, true));
    }

    /**
     * Filters the meta description for stories.
     *
     * @param string                 $description The description sentence.
     * @param Indexable_Presentation $presentation The presentation of an indexable.
     * @return string The description sentence.
     */
    public function translate_description($description, $presentation,$optionNames) {
        if(Falang()->is_default()) return $description;
        $object_type = $presentation->model->object_type;
        $object_id=$presentation->model->object_id;
        $language = Falang()->get_current_language();

        if ($object_type == 'term'){
            //$falang_taxo = new \Falang\Core\Taxonomy($object_id,Falang()->get_model());
            $term=get_term($object_id);
            $description=term_description($term);
        } else {
            //post, page, product
            $object_id=$presentation->model->object_id;
            $post = get_post ($object_id);
            $falang_post = new \Falang\Core\Post($object_id);

            if ($post && $falang_post->is_post_type_translatable($post->post_type)){

                $last_key = $this->array_key_last($optionNames);
                foreach ($optionNames as $key => $optionName) {
                    //last key post_excerpt
                    if ($key == $last_key) {
                        $description = $falang_post->translate_post_field($post, 'post_excerpt', $language,'' );
                        if ( empty($description)){
                            $description = wp_trim_words($falang_post->translate_post_field($post, 'post_content', $language, $description));
                        }
                    } else {
                        //specific yoast title set
                        $yoast_description = $falang_post->translate_post_meta($post, $optionName, true ,$language,'' );
                        if (!empty($yoast_description)) {
                            $description = $yoast_description;
                            break;
                        }
                    }
                }
            }
        }

        $description = wpseo_replace_vars( $description, $presentation );
        return $description;

    }

    /**
     * Filter: 'wpseo_opengraph_url' - Allow changing the Yoast SEO generated open graph URL.
     *
     * @api string $url The open graph URL.
     *
     * @param Indexable_Presentation $presentation The presentation of an indexable.
     */
    public function wpseo_opengraph_url($wpseo_opengraph_url, $presentation) {
        $language = Falang()->get_current_language();
        $url = Falang()->get_translated_url( $language );
        return $url;
    }


    /**
     * Translate permalinks.
     *
     * @param Indexable_Presention $presentation The indexable presentation.
     *
     * @return Indexable_Presention
     */
    public function translatePermalinks( $presentation ) {
        //it also returns correct link for main language, if somehow in indexables table is wrong link saved. It should be also executed on main language. (it is right now)
        $presentation = clone $presentation;

        if ( 'post' === $presentation->model->object_type ) {
            $presentation->model->permalink = get_permalink( $presentation->model->object_id );
        } elseif ( 'term' === $presentation->model->object_type ) {
            $presentation->model->permalink = get_term_link( $presentation->model->object_id );
        }

        return $presentation;
    }

    /*
     * preventing saving indexables on non default language
     * */
    public function wpseo_should_save_indexable(){
        if(!Falang()->is_default()) return false;
        return true;
    }

    /**
     * Returns the option name for the object being translated.
     *
     * @param Indexable_Presentation $presentation The presentation class.
     *
     * @return string
     */
//    private function getOptionName( $presentation ) {
//        return $this->isHomePageObjectType( $presentation ) ? 'wpseo_social' : 'wpseo_titles';
//    }

    /**
     * Returns true if we are we handling the home page.
     *
     * @param Indexable_Presentation $presentation The presentation class.
     *
     * @return bool
     */
//    private function isHomePageObjectType( $presentation ) {
//        return 'home-page' === $presentation->model->object_type;
//    }

}