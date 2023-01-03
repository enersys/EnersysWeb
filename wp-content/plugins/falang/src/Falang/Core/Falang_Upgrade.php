<?php
/**
 * @package Falang
 * this code use Falang upgrade process system
 */


namespace Falang\Core;


/**
 * Manages Falang upgrades
 *
 * @since 1.2
 */
class Falang_Upgrade
{
    /**
     * Stores the plugin options.
     *
     * @var array
     */
    public $options;

    /**
     * Constructor
     *
     * @since 1.1.23
     *
     * @param array $options Falang options
     */
    public function __construct( &$options ) {
        $this->options = &$options;
    }

    /**
     * Upgrades if possible otherwise returns false to stop Falang loading
     *
     * @since 1.1.23 store the version in the options
     *
     * @return bool true if upgrade is possible, false otherwise
     */
    public function upgrade() {
        //Actually always possilbe
        if (!$this->can_upgrade()){
            return false;
        }

        foreach ( array( '1.1.23') as $version ) {
            if ( version_compare(  $version,FALANG_VERSION ,'<=' ) ) {
                call_user_func( array( $this, 'upgrade_' . str_replace( '.', '_', $version ) ) );
            }
        }
        $this->options['previous_version'] = isset($this->options['version'])?$this->options['version']:FALANG_VERSION; // Remember the previous version of Falang since v1.1.23
        $this->options['version'] = FALANG_VERSION;
        update_option( 'falang', $this->options );

        return true;
    }

    /**
     * Check if we the previous version is not too old
     * Upgrades if OK
     * /!\ never start any upgrade before admin_init as it is likely to conflict with some other plugins
     *
     * @since 1.1.23
     *
     * @return bool true if upgrade is possible, false otherwise
     */
    public function can_upgrade() {
       return true;
    }

    /**
     * Upgrades if the previous version is <= 1.1.22
     * change the fisrt-activation dismiss notice name
     *
     * @since 1.1.22
     *
     * @return void
     */
    protected function upgrade_1_1_23() {
        $dismissed = get_option( 'falang_dismissed_notices', array() );
        if ( in_array( 'first-activation',$dismissed ) ) {
            $key = array_search('first-activation', $dismissed);
            unset($dismissed[$key]);
            update_option( 'falang_dismissed_notices', array_unique( $dismissed ) );
        }
    }

}