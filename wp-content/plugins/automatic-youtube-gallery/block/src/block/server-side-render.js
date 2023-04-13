// Import block dependencies and components
import isEqual from 'lodash/isEqual';
import debounce from 'lodash/debounce';

// Components
const { 
	__, 
	sprintf 
} = wp.i18n;

const {
	Placeholder,
	Spinner
} = wp.components;

const {
	Component,
	RawHTML,
} = wp.element;

const { addQueryArgs } = wp.url;

/**
 * Create an AYGServerSideRender Component.
 */
export function AYGRendererPath( block, attributes = null, urlQueryArgs = {} ) {
	return addQueryArgs( `/wp/v2/block-renderer/${ block }`, {
		context: 'edit',
		...( null !== attributes ? { attributes } : {} ),
		...urlQueryArgs,
	} );
}

export class AYGServerSideRender extends Component {

	constructor( props ) {
		super( props );

		this.state = {
			response: null,
		};
	}

	componentDidMount() {
		this.isStillMounted = true;
		this.fetch( this.props );
		// Only debounce once the initial fetch occurs to ensure that the first
		// renders show data as soon as possible.
		this.fetch = debounce( this.fetch, 500 );
	}

	componentWillUnmount() {
		this.isStillMounted = false;
	}

	componentDidUpdate( prevProps, prevState ) {
		if ( ! isEqual( prevProps, this.props ) ) {
			this.fetch( this.props );
		}

		if ( this.state.response !== prevState.response ) {
			if ( this.props.onChange ) {
				this.props.onChange();
			}
		}
	}

	fetch( props ) {
		if ( ! this.isStillMounted ) {
			return;
		}

		if ( null !== this.state.response ) {
			this.setState( { response: null } );
		}

		const { block, attributes = null, urlQueryArgs = {} } = props;

		const path = AYGRendererPath( block, attributes, urlQueryArgs );

		// Store the latest fetch request so that when we process it, we can
		// check if it is the current request, to avoid race conditions on slow networks.
		const fetchRequest = this.currentFetchRequest = wp.apiFetch( { path } )
			.then( ( response ) => {
				if ( this.isStillMounted && fetchRequest === this.currentFetchRequest && response && response.rendered ) {
					this.setState( { response: response.rendered } );
				}
			} )
			.catch( ( error ) => {
				if ( this.isStillMounted && fetchRequest === this.currentFetchRequest ) {
					this.setState( { response: {
						error: true,
						errorMsg: error.message,
					} } );
				}
			} );

		return fetchRequest;
	}

	render() {
		const response = this.state.response;

		if ( ! response ) {
			return (
				<Placeholder><Spinner /></Placeholder>
			);
		} else if ( response.error ) {			
			// translators: %s: error message describing the problem
			const errorMessage = sprintf( __( 'Error loading block: %s' ), response.errorMsg );

			return (
				<Placeholder>{ errorMessage }</Placeholder>
			);
		} else if ( ! response.length ) {
			return (
				<Placeholder>{ __( 'No results found.' ) }</Placeholder>
			);
		}

		return (
			<RawHTML key="html">{ response }</RawHTML>
		);
	}

}

export default AYGServerSideRender;
