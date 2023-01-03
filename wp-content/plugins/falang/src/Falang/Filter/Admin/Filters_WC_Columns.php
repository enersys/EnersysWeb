<?php
/**
 * Adds the language column in woocommerce attributes
 *
 * @since 1.2.1
 */


namespace Falang\Filter\Admin;

use Falang\Filter\Filters;

class Filters_WC_Columns extends Filters {

    var $falang_wc_attributes_options;
    var $option_wc_attr_name = 'falang_wc_attributes';


	/**
	 * Constructor.
	 */
	public function __construct(&$falang) {

		parent::__construct($falang);

	    //load options
		$this->falang_wc_attributes_options = get_option($this->option_wc_attr_name);

		//add attributes translation on the edit attribute page
		add_action( 'woocommerce_after_edit_attribute_fields', array( $this, 'add_attributes_fields'), 10, 0 );

        //save translated attribute
		add_action('woocommerce_attribute_updated', array($this ,'woocommerce_attribute_updated'), 10, 3);

		//delte translated attributes on default attribute language deleted
		add_action('woocommerce_attribute_deleted', array($this ,'woocommerce_attribute_deleted'), 10, 3);

		//add column in attributes table
		add_action('admin_head', array($this ,'add_attributes_column') );


	}

	public function add_attributes_fields() {
		global $wpdb;
		$edit = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;

		//same request from wp-content/plugins/woocommerce/includes/admin/class-wc-admin-attributes.php
        //to try to use query cache
		$attribute_to_edit = $wpdb->get_row(
			$wpdb->prepare(
				"
				SELECT attribute_type, attribute_label, attribute_name, attribute_orderby, attribute_public
				FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_id = %d
				",
				$edit
			)
		);

		$att_label   = format_to_edit( $attribute_to_edit->attribute_label );
		$att_name    = $attribute_to_edit->attribute_name;
		?>
		<tr>
            <th><h2><?php echo __('Translations', 'falang'); ?></h2></th>
        </tr>
        <?php
		foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) { ?>
            <tr>
                <th>
                    <label><?php echo $language->name.' '.$language->get_flag(); ?></label>
                </th>
			<!-- label is name displayed-->
			    <td>
                    <div style="display:flex;display: -webkit-flex;flex-wrap:wrap;-webkit-flex-wrap:wrap">
                        <div style="margin-bottom:1em; width:100%">
                            <?php
                            $key = $attribute_to_edit->attribute_name."_label_".$language->locale;
                            $label = isset($this->falang_wc_attributes_options[$key])?$this->falang_wc_attributes_options[$key]:'';
                            ?>
                            <input name="<?php echo "attribute_label_".$language->locale;?>" id="<?php echo "attribute_label_".$language->locale;?>"
                                   type="text" value="<?php echo $label; ?>"  placeholder="<?php echo $att_label; ?>" style="box-sizing:border-box"/>
                            <p class="description"><?php echo __('Atribute Name', 'falang'); ?></p>
                        </div>
                        <div style="margin-bottom:1em;  width:100%">
                            <?php
                            $key = $attribute_to_edit->attribute_name."_name_".$language->locale;
                            $name = isset($this->falang_wc_attributes_options[$key])?$this->falang_wc_attributes_options[$key]:'';
                            ?>
                            <input name="<?php echo "attribute_name_".$language->locale;?>" id="<?php echo "attribute_name_".$language->locale;?>"
                                   type="text" value="<?php echo $name; ?>" maxlength="28" placeholder="<?php echo $att_name; ?>" style="box-sizing:border-box"/>
                            <p class="description"><?php echo __('Atribute Slug', 'falang'); ?></p>
                        </div>
                    </div>
                </td>
            </tr>
		   <?php
		}
	}

	/**
	 * Add translation for label and name attributes
	 *
	 * @since 1.2.1
	 *
	 */
	public function woocommerce_attribute_updated($id, $data, $old_slug) {
	    //TODO see security
		$edit = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
		//check_ajax_referer( 'save-attributes', 'security' );

        //the translated slug are stored like
        //slug_label_locale
        //slub_name_locale

        //slug change need to delete all existing translation
        if ($old_slug != $data['attribute_name']){
	        foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) {
		        unset($this->falang_wc_attributes_options[$old_slug.'_label_'.$language->locale]);
		        unset($this->falang_wc_attributes_options[$old_slug.'_name_'.$language->locale]);
	        }
	        update_option($this->option_wc_attr_name, $this->falang_wc_attributes_options);
        }

		foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) {
			$label = "attribute_label_".$language->locale;
		    if (isset($_POST[$label])) {
		        if(!empty($_POST[$label])){
			        $this->falang_wc_attributes_options[$data['attribute_name'].'_label_'.$language->locale] = ucfirst($_POST[$label]);
			        update_option($this->option_wc_attr_name, $this->falang_wc_attributes_options);
                } else {
			        unset($this->falang_wc_attributes_options[$data['attribute_name'].'_label_'.$language->locale]);
			        update_option($this->option_wc_attr_name, $this->falang_wc_attributes_options);
                }
            }
			$name = "attribute_name_".$language->locale;
			if (isset($_POST[$name])) {
				if(!empty($_POST[$name])) {
					$this->falang_wc_attributes_options[ $data['attribute_name'].'_name_'.$language->locale ] = sanitize_title( $_POST[ $name ] );
					update_option( $this->option_wc_attr_name, $this->falang_wc_attributes_options );
				} else {
					unset($this->falang_wc_attributes_options[$data['attribute_name'].'_name_'.$language->locale]);
					update_option($this->option_wc_attr_name, $this->falang_wc_attributes_options);
                }
			}
		}

		//update permalink
        Falang()->get_model()->update_option('need_flush', 1);


	}

	/**
	 * remove name and label for each language of this attributes
	 *
	 * @since 1.2.1
     * @update 1.2.4 use $name and no key to delete
	 *
	 */
	public function woocommerce_attribute_deleted( $id, $name, $taxonomy ){
		//TODO see security
		foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) {
		    //remove name and label for each language of this attributes
			$label = $name."_label_".$language->locale;
			unset($this->falang_wc_attributes_options[$label]);
			$name = $name."_name_".$language->locale;
			unset($this->falang_wc_attributes_options[$name]);

			update_option($this->option_wc_attr_name, $this->falang_wc_attributes_options);
		}

    }

	/**
	 * add column on attibute table for each language
	 *
	 * @since 1.2.4
	 *
	 */
    public function add_attributes_column (){
        if (isset($_GET['post_type']) && $_GET['post_type']  == 'product' &&
            isset($_GET['page']) && $_GET['page']  == 'product_attributes' &&
            empty( $_GET['edit']) ) {
            //only attributes list
            $languages = Falang()->get_model()->get_languages_list(array('hide_default' => true));

            //put flag image in language
            foreach ($languages as $key => $language){
                $language->flag_img = $language->get_flag();
            }
            $attributes = array();
	        $wc_attributes = wc_get_attribute_taxonomies();
	        foreach ($wc_attributes as $wc_attribute){
		        foreach ($languages as $language) {
			        $key = $wc_attribute->attribute_name."_label_".$language->locale;
			        $label = isset($this->falang_wc_attributes_options[$key])?$this->falang_wc_attributes_options[$key]:'';
			        $attributes['pa_'.$wc_attribute->attribute_name][$language->locale] = $label;
		        }
            }

	        ?>
		        <script type="text/javascript">
                     /* <![CDATA[ */
                     jQuery( document ).ready(function() {
                         var languages = <?php echo json_encode($languages); ?>;
                         var language_count = Object.keys(languages).length;
                         var attributes = <?php echo json_encode($attributes); ?>;

                         //add language header
                         jQuery('.attributes-table thead').find('tr').each(function(){
                             for (i = 0 ; i < language_count; i++){
                                 jQuery(this).find('th').eq(1).after('<td>'+languages[i]['flag_img']+'</td>');
                             }
                         });
                         jQuery('.attributes-table tbody').find('tr').each(function(){
                             //add thead
                             for (i = 0 ; i < language_count; i++){
                                 var link = jQuery(this).find('td').eq(0).find('a').attr('href');
                                 var taxo = getURLParameter(link,'taxonomy');
                                 var locale = languages[i]['locale']
                                 var value = attributes[taxo][locale];
                                 if (value === ''){
                                     var original_value = jQuery(this).find('td').eq(0).find('a').first().text();
                                     value = '<span style="color: grey;font-style: italic">'+original_value+'</span>';
                                 }
                                 //1 after slug
                                 jQuery(this).find('td').eq(1).after('<td>'+value+'</td>');
                             }
                         });

                         function getURLParameter(url, name) {
                             return (RegExp(name + '=' + '(.+?)(&|$)').exec(url)||[,null])[1];
                         }
                     });
		        	/* ]]> */
                </script>
	       <?php
        }
	    //add column

    }

}