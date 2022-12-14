/**
 * Shortcode select component.
 */
import { escapeAttribute, escapeHTML } from "@wordpress/escape-html";
import { __ } from '@wordpress/i18n';
import { Fragment, createElement } from '@wordpress/element';
const el = createElement;

const DynamicShortcodeInput = ({ attributes: { shortcode }, shortCodeList, shortcodeUpdate }) => (
    <Fragment>
        {el('div', { className: 'spwpcf-gutenberg-shortcode editor-styles-wrapper' },
            el('select', { className: 'spwpcf-shortcode-selector', onChange: e => shortcodeUpdate(e), value: escapeAttribute(shortcode) },
                el('option', { value: escapeAttribute('0') }, escapeHTML(__('-- Select a shortcode --', 'wp-carousel-free'))),
                shortCodeList.map(shortcode => {
                    var title = (shortcode.title.length > 35) ? shortcode.title.substring(0, 30) + '.... #(' + shortcode.id + ')' : shortcode.title + ' #(' + shortcode.id + ')';
                    return el('option', { value: escapeAttribute(shortcode.id.toString()), key: escapeAttribute(shortcode.id.toString()) }, escapeHTML(title))
                })
            )
        )}
    </Fragment>
);

export default DynamicShortcodeInput;