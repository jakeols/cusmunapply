<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       jakeols.com
 * @since      1.0.0
 *
 * @package    Cusmunapply
 * @subpackage Cusmunapply/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cusmunapply
 * @subpackage Cusmunapply/public
 * @author     Jake Ols <jakeo@tgs.org>
 */
class Cusmunapply_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cusmunapply_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cusmunapply_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cusmunapply-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cusmunapply_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cusmunapply_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cusmunapply-public.js', array( 'jquery' ), $this->version, false );

	}

	function register_cusmun_shortcode() {
		add_shortcode( 'cusmun_form', array( $this, 'shortcode_cusmun' ) );
	}
	function shortcode_cusmun($args) {
		echo '<div id="cusmunapplyform"></div>';
		echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react.js"></script>';
		echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react-dom.js"></script>';
		echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>';
		?>
		<script type="text/babel">

		class Form extends React.Component {
			constructor(props) {
				super(props);
				this.state = {region: ''}
			}
			handleRegionChange(event) {
				this.setState({region: event.target.value});
			}
			render() {
				return (
					<div>
					{this.state.region == "" ? (
						<p>Please select your region</p>
					) : (
						<p>Please fill out the form below</p>
					)}
					<select onChange={this.handleRegionChange.bind(this)}>
						<option value="">-</option>
						<option value="Cambridge">Cambridge</option>
						<option value="UK">UK</option>
						<option value="Other">Rest of the World</option>
					</select>
					{this.state.region !== "" && (
						<FormFields region={this.state.region} />
					)}

					</div>
				);
			}
		}
		class FormFields extends React.Component {
			constructor(props) {
				super(props);
			}
			render() {
				return (
					<div>
					{this.props.region == "UK" && (
						<div>
							<p>International Form</p>
							<form>
							<label>
							Name of your school:
							<input type="text" />
							</label>
							<label>
							Which part of the UK is your school is from:
							<input type="text" />
							</label>
							<label>
							Name of teacher who will accompany delegation:
							<input type="text"/>
							</label>
							<label>
							Email of teacher who will accompany delegation:
							<input type="text" />
							</label>
							<label>
							Number of students your delegation be composed of:
							<input type="text" />
							</label>
							<input type="checkbox" name="vehicle" value="no" />My school is willing to send students to assist with the chairing process at the conference<br/>
  						<input type="checkbox" name="vehicle" value="yes" checked /> My schol is not willing to send students to assist with the chairing process at the conference<br/><br/>
							<label>
							Please state any past experience your school has had with Model United Nations:
							<textarea></textarea>
							</label>
							<label>
							Click this box to agree to the terms of CUSMUN:
							<input type="checkbox" name="vehicle" value="yes" />
							</label><br/>
							<input type="submit" value="Submit"/>
							</form>
						</div>
					)}
					{this.props.region == "Other" && (
						<div>
							<p>International Form</p>
							<form>
							<label>
							Name of your school:
							<input type="text" />
							</label>
							<label>
							Country your school is from:
							<input type="text" />
							</label>
							<label>
							Name of teacher who will accompany delegation:
							<input type="text"/>
							</label>
							<label>
							Email of teacher who will accompany delegation:
							<input type="text" />
							</label>
							<label>
							Number of students your delegation be composed of:
							<input type="text" />
							</label>
							<input type="checkbox" name="vehicle" value="no" />My school is willing to send students to assist with the chairing process at the conference<br/>
  						<input type="checkbox" name="vehicle" value="yes" checked /> My schol is not willing to send students to assist with the chairing process at the conference<br/><br/>
							<label>
							Please state any past experience your school has had with Model United Nations:
							<textarea></textarea>
							</label>
							<label>
							Click this box to agree to the terms of CUSMUN:
							<input type="checkbox" name="vehicle" value="yes" />
							</label><br/>
							<input type="submit" value="Submit"/>
							</form>
						</div>
					)}
					{this.props.region == "Cambridge" && (
						<div>
							<p>Cambridge Form</p>
							<form>
							<label>
							Name of your school:
							<input type="text" />
							</label>
							<label>
							Name of teacher who will accompany delegation:
							<input type="text"/>
							</label>
							<label>
							Email of teacher who will accompany delegation:
							<input type="text" />
							</label>
							<label>
							Number of students your delegation be composed of:
							<input type="text" />
							</label>
							<input type="checkbox" name="vehicle" value="no" />My school is willing to send students to assist with the chairing process at the conference<br/>
  						<input type="checkbox" name="vehicle" value="yes" checked /> My schol is not willing to send students to assist with the chairing process at the conference<br/><br/>
							<label>
							Please state any past experience your school has had with Model United Nations:
							<textarea></textarea>
							</label>
							<label>
							Click this box to agree to the terms of CUSMUN:
							<input type="checkbox" name="vehicle" value="yes" />
							</label><br/>
							<input type="submit" value="Submit"/>
							</form>
						</div>
					)}
					</div>

				);
			}
		}

		ReactDOM.render(
			<Form />,
			document.getElementById('cusmunapplyform')
		);

		</script>
<?php

	}

}
