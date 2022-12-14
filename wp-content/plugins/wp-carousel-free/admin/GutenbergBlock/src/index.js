import icons from "./shortcode/blockIcon";
import DynamicShortcodeInput from "./shortcode/dynamicShortcode";
import { escapeAttribute, escapeHTML } from "@wordpress/escape-html";
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, PanelRow } from '@wordpress/components';
import { Fragment, createElement } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
const ServerSideRender = wp.serverSideRender;
const el = createElement;

/**
 * Register: WP Carousel Free Gutenberg Block.
 */
registerBlockType("sp-wp-carousel-pro/shortcode", {
  title: escapeHTML( __("WP Carousel", "wp-carousel-free") ),
  description: escapeHTML( __(
    "Use WP Carousel to insert a carousel or gallery in your page.",
    "wp-carousel-free"
  )),
  icon: icons.spwpcfIcon,
  category: "common",
  supports: {
    html: true,
  },
  edit: (props) => {
    const { attributes, setAttributes } = props;
    var shortCodeList = sp_wp_carousel_free.shortCodeList;
    let scriptLoad = ( shortcodeId ) => {
      let spwpcfBlockLoaded = false;
      let spwpcfBlockLoadedInterval = setInterval(function () {
        let uniqId = jQuery(".wpcp-wrapper-" + shortcodeId).parents().attr('id');
        if (document.getElementById(uniqId)) {
          //Actual functions goes here
          jQuery.getScript(sp_wp_carousel_free.loadScript);
          jQuery('#wpcp-preloader-' + shortcodeId).animate({ opacity: 0 }, 600).remove();
          jQuery('#sp-wp-carousel-free-id-' + shortcodeId).animate({ opacity: 1 }, 600);
          spwpcfBlockLoaded = true;
          uniqId = '';
        }
        if (spwpcfBlockLoaded) {
          clearInterval(spwpcfBlockLoadedInterval);
        }
        if ( 0 == shortcodeId ) {
          clearInterval(spwpcfBlockLoadedInterval);
        }
      }, 10);
    }

    let updateShortcode = ( updateShortcode ) => {
      setAttributes({shortcode: escapeAttribute( updateShortcode.target.value )});
    }

    let shortcodeUpdate = (e) => {
      updateShortcode(e);
      let shortcodeId = escapeAttribute( e.target.value );
      scriptLoad(shortcodeId);
    }

    document.addEventListener('readystatechange', event => {
      if (event.target.readyState === "complete") {
        let shortcodeId = escapeAttribute( attributes.shortcode );
        scriptLoad(shortcodeId);
      }
    });

    if( attributes.preview ) {
      return (
        el('div', {className: 'spwpcf_shortcode_block_preview_image'},
          el('img', { src: escapeAttribute( sp_wp_carousel_free.url + "admin/GutenbergBlock/assets/wpc-block-preview.svg" )})
        )
      )
    }

    if (shortCodeList.length === 0 ) {
      return (
        <Fragment>
          {
            el('div', {className: 'components-placeholder components-placeholder is-large'}, 
              el('div', {className: 'components-placeholder__label'}, 
                el('img', {className: 'block-editor-block-icon', src: escapeAttribute( sp_wp_carousel_free.url + 'admin/GutenbergBlock/assets/wp-carousel-icon.svg' )}),
                escapeHTML( __("WP Carousel", "wp-carousel-free") )
              ),
              el('div', {className: 'components-placeholder__instructions'}, 
                escapeHTML( __("No shortcode found. ", "wp-carousel-free") ),
                el('a', {href: escapeAttribute( sp_wp_carousel_free.link )}, 
                  escapeHTML( __("Create a shortcode now!", "wp-carousel-free") )
                )
              )
            )
          }
        </Fragment>
      );
    }

    if ( ! attributes.shortcode || attributes.shortcode == 0 ) {
      return (
        <Fragment>
          <InspectorControls>
            <PanelBody title="Select a shortcode">
                <PanelRow>
                  <DynamicShortcodeInput
                    attributes={attributes}
                    shortCodeList={shortCodeList}
                    shortcodeUpdate={shortcodeUpdate}
                  />
                </PanelRow>
            </PanelBody>
          </InspectorControls>
          {
            el('div', {className: 'components-placeholder components-placeholder is-large'}, 
              el('div', {className: 'components-placeholder__label'},
                el('img', { className: 'block-editor-block-icon', src: escapeAttribute( sp_wp_carousel_free.url + "admin/GutenbergBlock/assets/wp-carousel-icon.svg" )}),
                escapeHTML( __("WP Carousel", "wp-carousel-free") )
              ),
              el('div', {className: 'components-placeholder__instructions'}, escapeHTML( __("Select a shortcode", "wp-carousel-free") ) ),
              <DynamicShortcodeInput
                attributes={attributes}
                shortCodeList={shortCodeList}
                shortcodeUpdate={shortcodeUpdate}
              />
            )
          }
        </Fragment>
      );
    }

    return (
      <Fragment>
        <InspectorControls>
            <PanelBody title="Select a shortcode">
                <PanelRow>
                  <DynamicShortcodeInput
                    attributes={attributes}
                    shortCodeList={shortCodeList}
                    shortcodeUpdate={shortcodeUpdate}
                  />
                </PanelRow>
            </PanelBody>
        </InspectorControls>
        <ServerSideRender block="sp-wp-carousel-pro/shortcode" attributes={attributes} />
      </Fragment>
    );
  },
  save() {
    // Rendering in PHP
    return null;
  },
});
