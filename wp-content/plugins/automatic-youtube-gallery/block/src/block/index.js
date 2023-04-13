/**
 * BLOCK: Automatic YouTube Gallery.
 */

// Import block dependencies and components
import { getAttributes } from './helper';
import edit from './edit';

// Components
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register the block.
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'automatic-youtube-gallery/block', {
	title: ayg_block.i18n.block_title,
	description: ayg_block.i18n.block_description,
	icon: 'video-alt3',
	category: 'automatic-youtube-gallery',
	keywords: [
		__( 'youtube' ),
		__( 'gallery' ),
		__( 'videos' ),
	],
	attributes: getAttributes(),
	supports: {
		customClassName: false,
	},

	edit,

	// Render via PHP
	save: function() {
		return null;
	},
});
