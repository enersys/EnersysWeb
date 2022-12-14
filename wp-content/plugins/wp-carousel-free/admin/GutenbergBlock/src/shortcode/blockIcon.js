import { escapeAttribute } from "@wordpress/escape-html";
const el = wp.element.createElement;
const icons = {};
icons.spwpcfIcon = el('img', {src: escapeAttribute( sp_wp_carousel_free.url + 'admin/GutenbergBlock/assets/wp-carousel-icon.svg' )})
export default icons;