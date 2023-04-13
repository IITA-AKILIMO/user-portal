/**
 * Helper Functions
 */

/**
 * Get block attributes 
 *
 * @since 1.0.0
 */
export function getAttributes() {
	var attributes = {
		is_admin: {
			type: 'boolean',
			default: false
		},
		uid: {
			type: 'string',
			default: ''
		}
	};
	
	for ( var key in ayg_block.options ) {
		var fields = ayg_block.options[ key ].fields;

		for ( var field in fields ) {
			var name = fields[ field ].name;

			attributes[ name ] = {
				type: getAttributeType( fields[ field ].type ),
				default: fields[ field ].value
			};
		}
	}

	return attributes;
}

/**
 * Get attribute type
 *
 * @since 1.0.0
 */
function getAttributeType( type ) {
	var _type = 'string';

	if ( 'number' == type ) {
		_type = 'number';
	} else if ( 'checkbox' == type ) {
		_type = 'boolean';
	}

	return _type;
}
