// Import block dependencies and components
import debounce from 'lodash/debounce';
import AYGServerSideRender from './server-side-render';

// Components
const {
	Disabled,
	PanelBody,
	Placeholder,
	RangeControl,
	SelectControl,
	Spinner,
	TextControl,
	TextareaControl,
	ToggleControl,
} = wp.components; 

const {
	Component,
	Fragment
} = wp.element;

const {	
	PanelColorSettings 
} = wp.editor;

const {	
	InspectorControls
} = wp.blockEditor;

const {	applyFilters } = wp.hooks;

/**
 * Create an AYGBlockEdit Component.
 */
class AYGBlockEdit extends Component {

	constructor() {
		super( ...arguments );

		this.state = {
			fetchAPI: true
		}
		
		this.onChange = this.onChange.bind( this );
		this.toggleAttribute = this.toggleAttribute.bind( this );
		this.apiCallDebounced = debounce( this.canFetchAPI, 5000 );
		this.initializeGallery = this.initializeGallery.bind( this );
	}

	getControl( field, index ) {
		const { attributes } = this.props;

		const placeholder = field.placeholder ? field.placeholder : '';
		const description = field.description ? field.description : '';

		switch ( field.type ) {		
			case 'number':
				return this.canShowControl( field.name ) && <RangeControl	
					key={ index }					
					label={ field.label }
					help={ description }
					placeholder={ placeholder }
					value={ attributes[ field.name ] }
					min={ field.min }
					max={ field.max }
					onChange={ this.onChange( field.name ) }
				/>
			case 'textarea':
				return this.canShowControl( field.name ) && <TextareaControl
					key={ index }					
					label={ field.label }
					help={ description }
					placeholder={ placeholder }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>
			case 'select':
			case 'radio':
				let options = [];

				for ( let key in field.options ) {
					options.push({
						label: field.options[ key ],
						value: key
					});
				};

				return this.canShowControl( field.name ) && <SelectControl
					key={ index }						
					label={ field.label }
					help={ description }						
					options={ options }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>
			case 'checkbox':
				return this.canShowControl( field.name ) && <ToggleControl
					key={ index }
					label={ field.label }
					help={ description }
					checked={ attributes[ field.name ] }
					onChange={ this.toggleAttribute( field.name ) }
				/>
			case 'color':
				return this.canShowControl( field.name ) && <PanelColorSettings
					key={ index }
					title={ field.label }
					colorSettings={ [
						{
							label: ayg_block.i18n.selected_color,
							value: attributes[ field.name ],
							onChange: this.onChange( field.name ),							
						}
					] }
				></PanelColorSettings>
			default:
				return this.canShowControl( field.name ) && <TextControl	
					key={ index }					
					label={ field.label }
					help={ description }
					placeholder={ placeholder }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>
		}		
	}

	canShowPanel( panel ) {
		const { attributes } = this.props;

		let value = true;

		if ( 'gallery' == panel && 'video' == attributes.type ) {
			value = false;
		}

		return applyFilters( 'ayg_block_toggle_panels', value, panel, attributes );
	}

	canShowControl( control ) {
		const { attributes } = this.props;

		let value = true;

		if ( 'playlist' == control || 'channel' == control || 'username' == control || 'search' == control || 'video' == control || 'videos' == control ) {
			value = ( control == attributes.type ) ? true : false;
		}

		if ( 'order' == control || 'limit' == control ) {
			value = ( 'search' == attributes.type ) ? true : false;
		}

		return applyFilters( 'ayg_block_toggle_controls', value, control, attributes );
	}

	onChange( attribute ) {
		return ( newValue ) => {
			this.canFetchAPI( false );
			this.props.setAttributes( { [ attribute ]: newValue } );
			this.apiCallDebounced( true );
		};
	}

	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.canFetchAPI( false );
			this.props.setAttributes( { [ attribute ]: newValue } );
			this.apiCallDebounced( true );
		};
	}

	canFetchAPI( value ) {
		this.setState( { fetchAPI: value } );
	}

	initializeGallery() {
		applyFilters( 'ayg_block_init', this.props.attributes );
	}

	render() {
		const { attributes, clientId } = this.props;
		const { fetchAPI } = this.state;

		attributes.uid = clientId;

		return (
			<Fragment>
				<InspectorControls>
					{Object.keys( ayg_block.options ).map(( key, index ) => {
						return (
							this.canShowPanel( key ) && <PanelBody 
								key={ 'ayg-block-panel-' + index } 
								title={ ayg_block.options[ key ].label }
								initialOpen={ 0 == index ? true : false }
								className="ayg-block-panel">

								{Object.keys( ayg_block.options[ key ].fields ).map(( _key, _index ) => {
									return this.getControl( ayg_block.options[ key ].fields[ _key ], 'ayg-block-control-' + _index );
								})}

							</PanelBody>
						)
					})}
				</InspectorControls>

				{!fetchAPI && <Placeholder>
					<Spinner />
					<p>{ ayg_block.i18n.spinner_message }</p>
				</Placeholder>}

				{fetchAPI && <Disabled>
					<AYGServerSideRender
						block="automatic-youtube-gallery/block"
						attributes={ Object.assign( {}, attributes, { is_admin: true } ) }
						onChange={ this.initializeGallery }
					/>
				</Disabled>}				
			</Fragment>
		);
	}
	
}

export default AYGBlockEdit;
