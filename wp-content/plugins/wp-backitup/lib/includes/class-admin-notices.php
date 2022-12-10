<?php  if (!defined ('ABSPATH')) die('No direct access allowed');

/**
 * WP BackItUp -  Admin Review Nag Class
 *
 * @since   1.14.2
 * @package WP BackItUp
 * @author  Chris Simmons <chris.simmons@wpbackitup.com>
 * @link    http://www.wpbackitup.com
 *
 */

if ( ! class_exists( 'WPBackitup_Admin_Notices' ) ) {


	class WPBackitup_Admin_Notices {

		private static $default_log = 'debug_notices';
		private $log_name;

		public $is_wpbackitup_page; //Check whether admin is in backitup pages.

		private $promo;
		private $today;

		//PROMO Constants
		private $BLACK_FRIDAY_2017_PROMO = 'black-friday-2017';
		private $BLACK_FRIDAY_2018_PROMO = 'black-friday-2018';
		private $SAFE_BETA_PROMO = 'safe-beta-december';
		private $INDEPENDENCE_DAY_PROMO = 'independence-day-promo';
		private $LABOR_DAY_PROMO = 'labor-day-promo';

		public function __construct(){
            try {
	            //Only need to perform notices when on wpbackitup
	            if(! $this->is_notice_pages()) return;

				$this->log_name = self::$default_log; //default log name
				$today   = new DateTime('now', new DateTimeZone('America/New_York'));

				//TODO: comment out for LIVE
//				if ($_SERVER["HTTP_HOST"]=="localhost") {
//					$today   = new DateTime('2018-11-26 00:00:00', new DateTimeZone('America/New_York'));
//				}

	            $this->today =$today;

		 } catch ( Exception $e ) {
			 WPBackItUp_Logger::log_error( $this->log_name, __METHOD__, 'Constructor Exception: ' . $e );
			 throw $e;
		 }
		}

		/**
		 * Run the active notice
		 * Only one notice should be displayed at a time
		 *
		 */
		public function run() {

			//Only need to perform notices when on wpbackitup
			if(! $this->is_wpbackitup_page) return;

			try {

				//error_log("Today:". var_export($today,true));
				WPBackItUp_Logger::log_info($this->log_name,__METHOD__, 'Today:' . var_export($this->today,true));

				//IS there a promo to run
				$this->promo = $this->get_active_promo();

				switch ( $this->promo ) {
//					case $this->SAFE_BETA_PROMO:
//						$promo =  sprintf("%s-%s",$this->promo,$this->get_safe_beta_notice_id());
//						$notice = $this->get_safe_beta_notice();
//						$this->show_notice($promo,$notice);
//						break;
//					case $this->BLACK_FRIDAY_2018_PROMO:
//						$promo =  sprintf("%s-%s",$this->promo,$this->get_black_friday_day_id_2018());
//						$notice = $this->get_black_friday_notice_2018();
//						$this->show_notice($promo,$notice);
//						break;
//					case $this->INDEPENDENCE_DAY_PROMO:
//						$promo =  sprintf("%s-%s",$this->promo,$this->get_indepence_day_promo_id());
//						$notice = $this->get_independence_day_notice();
//						$this->show_notice($promo,$notice);
//						break;
//					case $this->LABOR_DAY_PROMO:
//						$promo =  sprintf("%s-%s",$this->promo,$this->get_labor_day_promo_id());
//						$notice = $this->get_labor_day_notice();
//						$this->show_notice($promo,$notice);
//						break;
					default:
						//ToDo: This needs to be fixed so that user can close it.
						//$this->wordpress_review();
				}

			} catch ( Exception $e ) {

			}
		}

		/**
		 *  Checks whether this is plugins page or wpbackitup pages
		 *
		 * @return boolean
		 *
		 */
		public function is_notice_pages(){
			global $pagenow;

			if(isset($_GET['page'])){
				if ( false !== strpos($_GET['page'],'wp-backitup-backup')){
					$this->is_wpbackitup_page = true;
				}
			}

			if( $this->is_wpbackitup_page != false ){
				return true;
			}

			return false;
		}

		/**
		 * Get the active notice
		 *
		 */
		private function get_active_promo() {

			//Is the independence day sale active?
//			if ( false !== $this->get_indepence_day_promo_id()) {
//				return $this->INDEPENDENCE_DAY_PROMO;
//			}

//			if ( false !== $this->get_labor_day_promo_id()) {
//				$wpbacktiup_license = new WPBackItUp_License();
//				if (! $wpbacktiup_license->is_premium_license() || ! $wpbacktiup_license->is_license_active() ) {
//					return  $this->LABOR_DAY_PROMO;
//				}
//			}

			//Is the safe beta promo active
//			if ( false !== $this->get_safe_beta_notice_id()) {
//				return $this->SAFE_BETA_PROMO;
//			}
//
//
//			//Is the black friday active
//			if ( false !== $this->get_black_friday_day_id_2018()) {
//				$wpbacktiup_license = new WPBackItUp_License();
//
//				//Don't show notice when premium is installed
//				if (!$wpbacktiup_license->is_premium_license() || ! $wpbacktiup_license->is_license_active() ) {
//					return  $this->BLACK_FRIDAY_2018_PROMO;
//				}
//			}

			return false; //no active promos

		}



		/**
		 * WordPress Review Notice
		 *
		 */
		private function wordpress_review() {
			global $WPBackitup;

			//if they had more than 10 successful backups then show the message in 1 day
			$days_after = 10;//default to 10 days after install
			$successfull_backups =$WPBackitup->successful_backup_count();
			if ($successfull_backups>=10) $days_after = 1;

			new WPBackitup_Admin_Notice( array(
				'id' => 'wpbu-review-me',
				'days_after' => $days_after,
				'type' => 'updated'));
		}

		/**
		 * Show Notice
		 *
		 * @param $id
		 * @param $notice
		 */
		private function show_notice($id, $notice) {

			if (is_array($notice)) {
				$promo_notice = array(
					'id'                => $id,
					'days_after'        => $notice['days_after'],
					'temp_days_after'   => $notice['temp_days_after'],
					'type'              => 'updated',
					'message'           => $notice['message'],
					'link_1'            => $notice['link_1'],
					'link_label_1'      => $notice['link_label_1'],
					'link_label_2'      => $notice['link_label_2'],
					'link_label_3'      => $notice['link_label_3'],
				);

				new WPBackitup_Admin_Notice($promo_notice);
			}
		}

		/**
		 * Get SAFE promo ID
		 *
		 * @return bool|int false = no promo
		 *
		 */
//		private function get_safe_beta_notice_id() {
//			$id = false;
//
//			//12:00 AM EST = 5:00 AM UTC
//			//11:59 PM EST = 4:59 AM UTC
//
//			$promo_start = date( "Y-m-d H:i", strtotime( "01 December 2017 5:00 AM UTC" ) );
//			$promo_end   = date( "Y-m-d H:i", strtotime( "30 December 2017 4:59 AM UTC" ) );
//
//			if ( $this->today >= $promo_start && $this->today <= $promo_end ) {
//				$id = 0;
//			}
//
//			return $id;
//		}

		/**
		 * Get Independence Day promo ID
		 *
		 * @return bool|int false = no promo
		 *
		 */
//		private function get_indepence_day_promo_id() {
//			$id = false;
//
//			//12:00 AM EST = 5:00 AM UTC
//			//11:59 PM EST = 4:59 AM UTC
//
//			$promo_start = date( "Y-m-d H:i", strtotime( "02 July 2018 5:00 AM UTC" ) );
//			$promo_end   = date( "Y-m-d H:i", strtotime( "08 July 2018 4:59 AM UTC" ) );
//
//			if ( $this->today >= $promo_start && $this->today <= $promo_end ) {
//				$id = 0;
//			}
//
//			return $id;
//		}

		/**
		 * Get Labor Day promo ID
		 *
		 * @return bool|int false = no promo
		 *
		 */
//		private function get_labor_day_promo_id() {
//			$id = false;
//
//			//12:00 AM EST = 5:00 AM UTC
//			//11:59 PM EST = 4:59 AM UTC
//
//			$promo_start = date( "Y-m-d H:i", strtotime( "29 August 2018 5:00 AM UTC" ) );
//			$promo_end   = date( "Y-m-d H:i", strtotime( "04 September 2018 4:59 AM UTC" ) );
//
//			if ( $this->today >= $promo_start && $this->today <= $promo_end ) {
//				$id = 0;
//			}
//
//			return $id;
//		}


		/**
		 * Get Black Friday Promo ID
		 *
		 * @return bool|int false = no promo
		 *
		 */
//		private function get_black_friday_day_id_2017() {
//			$id = false;
//
//			//12:00 AM EST = 5:00 AM UTC
//			//11:59 PM EST = 4:59 AM UTC
//
//			$pre_sale_start = date( "Y-m-d H:i", strtotime( "16 November 2017 5:00 AM UTC" ) ); // 16th  12:00 AM EST
//			$pre_sale_end   = date( "Y-m-d H:i", strtotime( "24 November 2017 4:59 AM UTC" ) ); // 23rd 11:59 PM EST
//
//			$sale_start     = date( "Y-m-d H:i", strtotime( "24 November 2017 5:00 AM UTC" ) );// 24th 12:00 AM EST
//			$sale_end       = date( "Y-m-d H:i", strtotime( "27 November 2017 4:59 AM UTC" ) );// 26th 11:59 PM EST
//
//			$lastday_start  = date( "Y-m-d H:i", strtotime( "27 November 2017 5:00 AM UTC" ) );// 27th 12:00 AM EST
//			$lastday_end    = date( "Y-m-d H:i", strtotime( "28 November 2017 4:59 AM UTC" ) );// 27th 11:59 PM EST
//
//
//			if ( $this->today >= $pre_sale_start && $this->today <= $pre_sale_end ) {
//				$id = 0;
//			} elseif ( $this->today >= $sale_start && $this->today <= $sale_end ) {
//				$id = 1;
//			} elseif ( $this->today >= $lastday_start && $this->today <= $lastday_end ) {
//				$id = 2;
//			}
//
//			return $id;
//		}





		/**
		 * Get Black Friday notice
		 *
		 * @return array|false on no notice
		 */
//		private function get_black_friday_notice() {
//			$message= array();
//			$link_1=array();
//			$link_label_1=array();
//			$link_label_2=array();
//			$link_label_3=array();
//			$days_after=array();
//			$temp_days_after=array();
//
//			$id = $this->get_black_friday_day_id();
//			if (false===$id) return false;
//
//			//PRESALE
//			$message[]=sprintf( "%s<p>%s<p>%s",
//				'<h2>' . esc_html__( "Black Friday/Cyber Monday Sale Starts Soon!", "wp-backitup") . ' </h2>',
//				__( "Save <b>30%</b> on WPBackItUp Premium for a limited time!", "wp-backitup" ),
//				__( "We just wanted to let you know that WPBackItUp will be participating in the Black Friday and Cyber Monday craziness next week.<br/><br/>If you purchase WPBackItUp Premium or upgrade an existing license between <b>Friday, November 24, 2017, 12 AM EST (5 AM UTC)</b> and <b>Monday, November 27, 2017, 11:59 PM EST ( 4:59 AM UTC )</b> you'll automatically get <b>30%</b> off our regular prices.", "wp-backitup" )
//			);
//
//			$days_after[]=0;
//			$temp_days_after[]=1;
//			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-1";
//			$link_label_1[] =  esc_html__( 'Buy now, I don\'t need the discount!', 'wp-backitup' );
//			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
//			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
//
//			//SALE
//			$message[]=sprintf( "%s<p>%s<p>%s",
//				'<h2>' . esc_html__( "WPBackItUp Black Friday SALE! Save 30% on all purchases and upgrades!", "wp-backitup") . ' </h2>',
//				__( "<b>It’s SALE time!</b><br/><br/>The WPBackItUp Black Friday sale has started so if you have been thinking about safeguarding your WordPress site with WPBackItUp Premium then now is the time.", "wp-backitup" ),
//				__( "If you purchase WPBackItUp Premium or upgrade an existing license between <b>Friday, November 24, 2017, 12 AM EST (5 AM UTC)</b> and <b>Monday, November 27, 2017, 11:59 PM EST ( 4:59 AM UTC )</b> you'll automatically get 30% off our regular prices.", "wp-backitup" )
//			);
//			$days_after[]=0;
//			$temp_days_after[]=1;
//			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-2";;
//			$link_label_1[] =  esc_html__( 'Buy now and save 30%', 'wp-backitup' );
//			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
//			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
//
//			//LAST DAY
//			$message[]=sprintf( "%s<p>%s<p>%s",
//				'<h2>' . esc_html__( "Less than 24 hours left to save 30%  on WPBackItUp Premium!", "wp-backitup") . ' </h2>',
//				__( "Happy Cyber Monday! Today is your last chance to save <b>30% </b> on WPBackItUp Premium.", "wp-backitup" ),
//				__( "If you purchase WPBackItUp Premium or upgrade an existing license between <b>Friday, November 24, 2017, 12 AM EST (5 AM UTC)</b> and <b>Monday, November 27, 2017, 11:59 PM EST ( 4:59 AM UTC )</b> you'll automatically get 30% off our regular prices.", "wp-backitup" )
//			);
//			$days_after[]=0;
//			$temp_days_after[]=1;
//			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-3";;
//			$link_label_1[] =  esc_html__( 'Buy now and save 30%', 'wp-backitup' );
//			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
//			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
//
//			$rtn = array(
//				'message'=>$message[$id],
//				'days_after'=>$days_after[$id],
//				'temp_days_after'=>$temp_days_after[$id],
//				'link_1'=>$link_1[$id],
//				'link_label_1'=>$link_label_1[$id],
//				'link_label_2'=>$link_label_2[$id],
//				'link_label_3'=>$link_label_3[$id],
//				);
//
//			return $rtn;
//
//		}

		/**
		 * Get Promo ID
		 *
		 * @return bool|int false = no promo
		 *
		 */
		private function get_black_friday_day_id_2018() {
			$id = false;

			//Presale - week before thanksgiving - start early to catch people that are gone thanksgiving week
			$sale_start_0   = new DateTime('2018-11-12 00:00:00', new DateTimeZone('America/New_York'));
			$sale_end_0     = new DateTime('2018-11-14 23:59:59' , new DateTimeZone('America/New_York'));
//			error_log('Start 0:' . var_export($sale_start_0->format('Y-m-d H:i'),true));
//			error_log('End 0:' . var_export($sale_end_0->format('Y-m-d H:i'),true));


			//Thanksgiving week sale
			$sale_start_1   = new DateTime('2018-11-15 00:00:00', new DateTimeZone('America/New_York'));
			$sale_end_1     = new DateTime('2018-11-22 23:59:00' , new DateTimeZone('America/New_York'));


			//Black Friday/Cyber Monday Sale
			$sale_start_2   = new DateTime('2018-11-23 00:00:00', new DateTimeZone('America/New_York'));
			$sale_end_2     = new DateTime('2018-11-25 23:59:59' , new DateTimeZone('America/New_York'));

			//Last Day of sale Message
			$sale_start_3   = new DateTime('2018-11-26 00:00:00', new DateTimeZone('America/New_York'));
			$sale_end_3     = new DateTime('2018-11-27 23:59:59' , new DateTimeZone('America/New_York'));

			if ( $this->today >= $sale_start_0 && $this->today <= $sale_end_0 ) {
				$id = 0;
			} elseif ( $this->today >= $sale_start_1 && $this->today <= $sale_end_1 ) {
				$id = 1;
			} elseif ( $this->today >= $sale_start_2 && $this->today <= $sale_end_2 ) {
				$id = 2;
			} elseif ( $this->today >= $sale_start_3 && $this->today <= $sale_end_3 ) {
				$id = 3;
			}

			return $id;
		}

		/**
		 * Get Black Friday notice
		 *
		 * @return array|false on no notice
		 */
		private function get_black_friday_notice_2018() {
			$message= array();
			$link_1=array();
			$link_label_1=array();
			$link_label_2=array();
			$link_label_3=array();
			$days_after=array();
			$temp_days_after=array();

			$id = $this->get_black_friday_day_id_2018();
			if (false===$id) return false;

			/** Pre-Sale
			 *
			 * Thanksgiving Pre Sale Week Before Thanksgiving - let them know a sale is coming
			 *
			 */
			$message[]=sprintf( "<div align='center'>%s %s</div><p>%s</p>",
				'<h1>' . esc_html__( "Thanksgiving/Black Friday/Cyber Monday Sale Starts Soon!", "wp-backitup") . ' </h1>',
				'<h2>' .__( "Save 30% on WPBackItUp Premium for a limited time!", "wp-backitup" ). ' </h2>',
				__( "We just wanted to let you know that WPBackItUp will be participating in all the Thanksgiving, Black Friday, Cyber Monday craziness next week.<br/><br/>If you purchase WPBackItUp Premium or upgrade an existing license between <b>November 15, 2018</b> and <b>November 22, 2018</b> you'll get <b>30%</b> off our regular prices.", "wp-backitup" )
			);

			$days_after[]=0;
			$temp_days_after[]=1;
			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-2018_".$id;
			$link_label_1[] =  esc_html__( 'Buy now, I don\'t need the discount!', 'wp-backitup' );
			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
			/** END Pre-Sale **/

			/**
			 *  Thanksgiving Week Sale
			 *
			 */
			$discount_code = '3PTHX';
			$message[]=sprintf( "<div align='center'>%s %s</div><p>%s</p>%s",
			'<h1>' . esc_html__( "WPBackItUp Thanksgiving week SALE!", "wp-backitup") . ' </h1>',
				'<h2>' .__( "Save 30% on WPBackItUp Premium for a limited time!", "wp-backitup" ). ' </h2>',
			 	__( "The WPBackItUp Thanksgiving Week sale has started so if you have been thinking about safeguarding your WordPress site with WPBackItUp Premium then now is the time.", "wp-backitup" ),
				__( "Click the link below before <b>November 22, 2018, 3:59 AM UTC</b> and you'll automatically get <b>30% off</b> our regular prices.", "wp-backitup" )
			);

			$days_after[]=0;
			$temp_days_after[]=1;
			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-2018_".$id .'&discount='.$discount_code;
			$link_label_1[] =  esc_html__( 'Buy now and save 30%', 'wp-backitup' );
			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );

			//Black Friday SALE
			$discount_code = '3PBFX';
			$message[]=sprintf( "<div align='center'>%s %s</div><p>%s</p>%s",
				'<h1>' . esc_html__( "WPBackItUp Black Friday SALE starts NOW!", "wp-backitup") . ' </h1>',
				'<h2>' .__( "Save 30% on WPBackItUp Premium for a limited time!", "wp-backitup" ). ' </h2>',
				__( "The WPBackItUp Black Friday sale has started so if you have been thinking about safeguarding your WordPress site with WPBackItUp Premium then now is the time.", "wp-backitup" ),
				__( "Click the link below before <b>November 25, 2018, 3:59 AM UTC</b> and you'll automatically get <b>30% off</b> our regular prices.", "wp-backitup" )
			);

			$days_after[]=0;
			$temp_days_after[]=1;
			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-2018_".$id.'&discount='.$discount_code;
			$link_label_1[] =  esc_html__( 'Buy now and save 30%', 'wp-backitup' );
			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );

			//LAST DAY
			$discount_code = '3PCMX';
			$message[]=sprintf( "<div align='center'>%s %s</div><p>%s</p>%s",
				'<h1>' . esc_html__( "WPBackItUp Cyber Monday SALE end SOON!", "wp-backitup") . ' </h1>',
				'<h2>' . esc_html__( "Less than 24 hours left to save 30%  on WPBackItUp Premium!", "wp-backitup") . ' </h2>',
				__( "Happy Cyber Monday! Today is your last chance to save <b>30% </b> on WPBackItUp Premium.", "wp-backitup" ),
				__( "Click the link below before the end of the day today <b>(3:59 AM UTC)</b> and you'll automatically get <b>30% off</b> our regular prices.", "wp-backitup" )
			);
			$days_after[]=0;
			$temp_days_after[]=1;
			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-2018_".$id.'&discount='.$discount_code;
			$link_label_1[] =  esc_html__( 'Buy now and save 30%', 'wp-backitup' );
			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );

			$rtn = array(
				'message'=>$message[$id],
				'days_after'=>$days_after[$id],
				'temp_days_after'=>$temp_days_after[$id],
				'link_1'=>$link_1[$id],
				'link_label_1'=>$link_label_1[$id],
				'link_label_2'=>$link_label_2[$id],
				'link_label_3'=>$link_label_3[$id],
				);

			return $rtn;

		}

		/**
		 * Get SAFE beta promo
		 *         		 *
		 * @return array|false false on no notice
		 */
//		private function get_safe_beta_notice() {
//			$message= array();
//			$link_1=array();
//			$link_label_1=array();
//			$link_label_2=array();
//			$link_label_3=array();
//			$days_after=array();
//			$temp_days_after=array();
//
//			$id = $this->get_safe_beta_notice_id();
//			if (false===$id) return false;
//
//			$message[]=sprintf( "%s<p>%s<p>%s",
//				'<h2>' . esc_html__( "SAFE BETA - Black Friday/Cyber Monday Sale Starts Soon!", "wp-backitup") . ' </h2>',
//				__( "Save <b>30%</b> on WPBackItUp Premium for a limited time!", "wp-backitup" ),
//				__( "We just wanted to let you know that WPBackItUp will be participating in the Black Friday and Cyber Monday craziness next week.<br/><br/>If you purchase WPBackItUp Premium or upgrade an existing license between <b>Friday, November 24, 2017, 12 AM EST (5 AM UTC)</b> and <b>Monday, November 27, 2017, 11:59 PM EST ( 4:59 AM UTC )</b> you'll automatically get <b>30%</b> off our regular prices.", "wp-backitup" )
//			);
//			$days_after[]=0;
//			$temp_days_after[]=1;
//			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-black-friday-1";
//			$link_label_1[] =  esc_html__( 'Buy now, I don\'t need the discount!', 'wp-backitup' );
//			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
//			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
//
//
//			return array(
//				'message'=>$message[$id],
//				'days_after'=>$days_after[$id],
//				'temp_days_after'=>$temp_days_after[$id],
//				'link_1'=>$link_1[$id],
//				'link_label_1'=>$link_label_1[$id],
//				'link_label_2'=>$link_label_2[$id],
//				'link_label_3'=>$link_label_3[$id],
//			);
//
//		}


		/**
		 * Get Independence day promo
		 *
		 * @return array|false false on no notice
		 */
//		private function get_independence_day_notice() {
//			$message= array();
//			$link_1=array();
//			$link_label_1=array();
//			$link_label_2=array();
//			$link_label_3=array();
//			$days_after=array();
//			$temp_days_after=array();
//
//			$id = $this->get_indepence_day_promo_id();
//			if (false===$id) return false;
//
//			$message[]=sprintf( "%s<p>%s<p>%s",
//				'<h2>' . esc_html__( "Celebrate Independence Day with WPBackItUp and Save 30%!", "wp-backitup") . ' </h2>',
//				__( "WPBackItUp would like to wish a happy Independence Day to all Americans!", "wp-backitup" ),
//				__( "This week only purchases and upgrades of WPBackItUp Premium will automatically receive <b>30%</b> off our regular prices.", "wp-backitup" )
//			);
//			$days_after[]=0;
//			$temp_days_after[]=1;
//			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-independence-day-promo";
//			$link_label_1[] =  esc_html__( 'Buy now!', 'wp-backitup' );
//			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
//			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
//
//
//			return array(
//				'message'=>$message[$id],
//				'days_after'=>$days_after[$id],
//				'temp_days_after'=>$temp_days_after[$id],
//				'link_1'=>$link_1[$id],
//				'link_label_1'=>$link_label_1[$id],
//				'link_label_2'=>$link_label_2[$id],
//				'link_label_3'=>$link_label_3[$id],
//			);
//
//		}

		/**
		 * Get Labor day promo
		 *
		 * @return array|false false on no notice
		 */
//		private function get_labor_day_notice() {
//			$message= array();
//			$link_1=array();
//			$link_label_1=array();
//			$link_label_2=array();
//			$link_label_3=array();
//			$days_after=array();
//			$temp_days_after=array();
//
//			$id = $this->get_labor_day_promo_id();
//			if (false===$id) return false;
//
//			$message[]=sprintf( "%s<p>%s<p>%s",
//				'<h2>' . esc_html__( "Celebrate Labor Day with WPBackItUp and Save 30%!", "wp-backitup") . ' </h2>',
//				__( "WPBackItUp would like to wish a Happy Labor Day to all Americans!", "wp-backitup" ),
//				__( "From now until September 4th use the discount code: <b>LaborDay2018</b> at checkout and receive <b>30%</b> off WPBackItUp Premium.", "wp-backitup" )
//			);
//			$days_after[]=0;
//			$temp_days_after[]=1;
//			$link_1[] =  "https://www.wpbackitup.com/pricing-purchase/?utm_medium=plugin&utm_source=wp-backitup&utm_campaign=plugin-labor-day-promo";
//			$link_label_1[] =  esc_html__( 'Buy now!', 'wp-backitup' );
//			$link_label_2[] = esc_html__( 'Remind me later', 'wp-backitup' );
//			$link_label_3[] = esc_html__( 'I already purchased', 'wp-backitup' );
//
//
//			return array(
//				'message'=>$message[$id],
//				'days_after'=>$days_after[$id],
//				'temp_days_after'=>$temp_days_after[$id],
//				'link_1'=>$link_1[$id],
//				'link_label_1'=>$link_label_1[$id],
//				'link_label_2'=>$link_label_2[$id],
//				'link_label_3'=>$link_label_3[$id],
//			);
//		}

	}
}