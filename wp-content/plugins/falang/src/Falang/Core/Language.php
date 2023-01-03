<?php

namespace Falang\Core;

/**
 * A language object is made of two terms in 'language' and 'term_language' taxonomies
 * manipulating only one object per language instead of two terms should make things easier
 *
 * Properties:
 * term_id             => id of term in 'language' taxonomy
 * name                => language name. Ex: English
 * slug                => language code used in url. Ex: en
 * term_taxonomy_id    => term taxonomy id in 'language' taxonomy
 * taxonomy            => 'language'
 * description         => language locale for backward compatibility

 *
**/

class Language {
	public $term_id;    //id of term in 'language' taxonomy
	public $name;       //language name. Ex: English
	public $slug;       //language code used in url. Ex: en
	public $position; //order of the language when displayed in a list of languages
	public $term_taxonomy_id;//term taxonomy id in 'language' taxonomy
	public $taxonomy;   //'language'
	public $description;
	public $tl_term_id;
	public $tl_term_taxonomy_id;
	public $tl_count;
	public $locale;
	public $rtl;//is_rtl              => 1 if the language is rtl
	public $mo_id;  //id of the post storing strings translations


	/**
	 * Language constructor.
	 *
	 * @since 1.0
	 *
	 * @param object|array $language      'language' term or language object properties stored as an array
	 * @param object       $term_language Corresponding 'term_language' term
	 */
	public function __construct( $language, $term_language = null ) {
		// Build the object from all properties stored as an array
		if ( empty( $term_language ) ) {
			foreach ( $language as $prop => $value ) {
				$this->$prop = $value;
			}
		} else {
			// Build the object from taxonomies
			foreach ( $language as $prop => $value ) {
				$this->$prop = in_array( $prop, array( 'term_id', 'term_taxonomy_id', 'count' ) ) ? (int) $language->$prop : $language->$prop;
			}

			$this->tl_term_id = (int) $term_language->term_id;
			$this->tl_term_taxonomy_id = (int) $term_language->term_taxonomy_id;
			$this->tl_count = (int) $term_language->count;

			// The description field can contain any property
			$description = maybe_unserialize( $language->description );
			foreach ( $description as $prop => $value ) {
				$this->$prop = $value;
			}

			$this->mo_id = Falang_Mo::get_id( $this );

		}
	}

	/**
	 * Sets flag_url and flag properties
	 **/

	public function set_flag(){
		/**
		 * Filter flag informations
		 * 'url'    => Flag url
		 * 'src'    => Optional, src attribute value if different of the url, for example if base64 encoded
		 * 'width'  => Optional, flag width in pixels
		 * 'height' => Optional, flag height in pixels
		 *
		 * @since 2.4
		 *
		 * @param array  $flag Information about the flag
		 * @param string $code Flag code
		 */
		$flags['flag'] = apply_filters( 'falang_flag', $flags['flag'], $this->flag_code );
	}

	public function get_flag(){
		$flag_url ='';
		$file = FALANG_DIR.'/flags/' . $this->flag_code . '.png';
		if ( ! empty( $this->flag_code ) && file_exists( $file) ) {
			$flag_url = plugins_url( 'flags/'.$this->flag_code . '.png', FALANG_FILE );
		}
		return sprintf(
			'<img src="%1$s" alt="%2$s"/>',
			$flag_url,
			/* translators: accessibility text */
			esc_html( sprintf( __( '%s', 'falang' ), $this->name ) )
		);
	}
}