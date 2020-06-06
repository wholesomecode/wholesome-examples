/**
 * WordPress dependencies
 */

/**
 * WordPress Imports.
 *
 * - api
 *   The REST API interface.
 *   @see https://developer.wordpress.org/rest-api/reference/
 *   - loadPromise @see https://developer.wordpress.org/rest-api/using-the-rest-api/
 *     backbone-javascript-client/#waiting-for-the-client-to-load
 *   - models @see https://developer.wordpress.org/rest-api/using-the-rest-api/
 *     backbone-javascript-client/#model-examples
 *
 * - BaseControl
 *   BaseControl component is used to generate labels and help text for components handling user inputs.
 *   @see https://developer.wordpress.org/block-editor/components/base-control/
 *
 * - Button
 *   Buttons let users take actions and make choices with a single click or tap.
 *   @see https://developer.wordpress.org/block-editor/components/button/
 *
 * - ExternalLink
 *   Component for an external link.
 *   @see https://developer.wordpress.org/block-editor/components/external-link/
 *
 * - PanelBody
 *   The PanelBody creates a collapsible container that can be toggled open or closed.
 *   @see https://developer.wordpress.org/block-editor/components/panel/#panelbody
 *
 * - PanelRow
 *   The is a generic container for panel content. Default styles add a top margin
 *   and arrange items in a flex row.
 *   @see https://developer.wordpress.org/block-editor/components/panel/#panelrow
 *
 * - Placeholder
 *   @see https://developer.wordpress.org/block-editor/components/placeholder/
 *
 * - Spinner
 *   Spinners notify users that their action is being processed.
 *   @see https://developer.wordpress.org/block-editor/components/spinner/
 *
 * - ToggleControl
 *   ToggleControl is used to generate a toggle user interface.
 *   @see https://developer.wordpress.org/block-editor/components/toggle-control/
 *
 * - render
 *   Abstraction of the React render command.
 *   @see https://reactjs.org/docs/react-dom.html#render
 *
 * - Component
 *   A base class to create WordPress Components (Refs, state and lifecycle hooks).
 *   @see https://developer.wordpress.org/block-editor/packages/packages-element/#Component
 *
 * - Fragment
 *   A component which renders its children without any wrapping element.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-element/#Fragment
 *
 * - __
 *   Internationalization - multilingual translation support.
 *   @see https://developer.wordpress.org/block-editor/developers/internationalization/
 */
import api from '@wordpress/api';

import {
	BaseControl,
	Button,
	ExternalLink,
	PanelBody,
	PanelRow,
	Placeholder,
	SelectControl,
	Spinner,
	ToggleControl,
} from '@wordpress/components';

import {
	render,
	Component,
	Fragment,
} from '@wordpress/element';

import { __ } from '@wordpress/i18n';

/**
 * Plugin Imports.
 *
 * - settings
 *   Localized settings from the PHP part of the application.
 *
 * Used here to retrieve the page templates.
 */
import settings from '../../settings';

class App extends Component {
	constructor() {
		// eslint-disable-next-line prefer-rest-params
		super( ...arguments );

		this.changeOptions = this.changeOptions.bind( this );

		this.state = {
			isAPILoaded: false,
			isAPISaving: false,
			wholesome_examples_analytics_status: false,
			wholesome_examples_analytics_key: '',
			wholesome_examples_logged_out_template: '',
		};
	}

	componentDidMount() {
		api.loadPromise.then( () => {
			this.settings = new api.models.Settings();

			const { isAPILoaded } = this.state;

			if ( isAPILoaded === false ) {
				this.settings.fetch().then( ( response ) => {
					this.setState( {
						wholesome_examples_analytics_status: Boolean( response.wholesome_examples_analytics_status ),
						wholesome_examples_analytics_key: response.wholesome_examples_analytics_key,
						wholesome_examples_logged_out_template: response.wholesome_examples_logged_out_template,
						isAPILoaded: true,
					} );
				} );
			}
		} );
	}

	changeOptions( option, value ) {
		this.setState( { isAPISaving: true } );

		const model = new api.models.Settings( {
			[ option ]: value,
		} );

		model.save().then( ( response ) => {
			this.setState( {
				[ option ]: response[ option ],
				isAPISaving: false,
			} );
		} );
	}

	render() {
		const {
			isAPILoaded,
			isAPISaving,
			wholesome_examples_analytics_key: wholesomeExamplesAnalyticsKey,
			wholesome_examples_analytics_status: wholesomeExamplesAnalyticsStatus,
			wholesome_examples_logged_out_template: wholesomeExamplesLoggedOutTemplate,
		} = this.state;

		const { pageTemplates } = settings;

		if ( ! isAPILoaded ) {
			return (
				<Placeholder>
					<Spinner />
				</Placeholder>
			);
		}

		return (
			<Fragment>
				<div className="wholesome-examples-header">
					<div className="wholesome-examples-container">
						<div className="wholesome-examples-logo">
							<h1>{ __( 'Wholesome Examples Settings' ) }</h1>
						</div>
					</div>
				</div>

				<div className="wholesome-examples-main">
					<PanelBody
						title={ __( 'Template' ) }
					>
						<PanelRow>
							<SelectControl
								className="wholesome-examples-text-field"
								// eslint-disable-next-line
								help={ __( 'Choose the template you wish to display instead of a membership post if a user is not logged in.' ) }
								label={ __( 'Template' ) }
								onChange={ ( value ) => this.changeOptions(
									'wholesome_examples_logged_out_template',
									value
								) }
								options={ [
									{
										label: __( 'Please Select...' ),
										value: '',
									},
									...pageTemplates,
								] }
								value={ wholesomeExamplesLoggedOutTemplate }
							/>
						</PanelRow>

					</PanelBody>

					<PanelBody
						title={ __( 'Google Analytics' ) }
					>
						<PanelRow>
							<BaseControl
								label={ __( 'Google Analytics Key' ) }
								help={ __( 'In order to use Google Analytics, you need to use an API key.' ) }
								id="wholesome-examples-options-google-analytics-api"
								className="wholesome-examples-text-field"
							>
								<input
									type="text"
									id="wholesome-examples-options-google-analytics-api"
									value={ wholesomeExamplesAnalyticsKey }
									placeholder={ __( 'Google Analytics API Key' ) }
									disabled={ isAPISaving }
									onChange={ ( e ) => this.setState( {
										wholesome_examples_analytics_key: e.target.value,
									} ) }
								/>

								<div className="wholesome-examples-text-field-button-group">
									<Button
										isPrimary
										isLarge
										disabled={ isAPISaving }
										onClick={ () => this.changeOptions(
											'wholesome_examples_analytics_key',
											wholesomeExamplesAnalyticsKey
										) }
									>
										{ __( 'Save' ) }
									</Button>

									<ExternalLink
										href="#"
									>
										{ __( 'Get API Key' ) }
									</ExternalLink>
								</div>
							</BaseControl>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label={ __( 'Track Admin Users?' ) }
								help={ __( 'Would you like to track views of logged-in admin accounts?' ) }
								checked={ wholesomeExamplesAnalyticsStatus }
								onChange={ () => this.changeOptions(
									'wholesome_examples_analytics_status',
									! wholesomeExamplesAnalyticsStatus
								) }
							/>
						</PanelRow>
					</PanelBody>
				</div>
			</Fragment>
		);
	}
}

const htmlOutput = document.getElementById( 'wholesome-examples-settings' );

if ( htmlOutput ) {
	render(
		<App />,
		htmlOutput
	);
}
