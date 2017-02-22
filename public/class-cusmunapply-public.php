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
				this.state = {
					schoolname: '',
					schoollocation: '',
					teachername: '',
					teacheremail: '',
					delegationnumber: '',
					postexperience: '',
					sendstudents: false,
					schoolcountry: ''
				}
				this.handleInputChange = this.handleInputChange.bind(this);
			}
			handleInputChange(event) {
				const target = event.target;
				const value = target.type === 'checkbox' ? target.checked : target.value;
				const name = target.name;
		    this.setState({
		      [name]: value
		    });
			}
			render() {
				return (
					<div>
					{this.props.region == "UK" && (
						<div>
							<p>UK Form</p>
							<form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
							<input type="hidden" name="action" value="process_uk_form" />
							<label>
							Name of your school:
							<input onChange={this.handleInputChange} value={this.state.schoolname} name="schoolname" type="text" /><br/>
							</label>
							<label>
							Which part of the UK is your school is from:
							<input onChange={this.handleInputChange} value={this.state.schoollocation} name="schoollocation" type="text" /><br/>
							</label>
							<label>
							Name of teacher who will accompany delegation:
							<input onChange={this.handleInputChange} value={this.state.teachername} name="teachername" type="text"/><br/>
							</label>
							<label>
							Email of teacher who will accompany delegation:
							<input onChange={this.handleInputChange} value={this.state.teacheremail} name="teacheremail" type="text" /><br/>
							</label>
							<label>
							Number of students your delegation will be composed of:
							<input onChange={this.handleInputChange} value={this.state.delegationnumber} name="delegationnumber" type="text" /><br/>
							</label>
							<input type="checkbox" name="sendstudents" onChange={this.handleInputChange} value={this.state.sendstudents} />My school is willing to send students to assist with the chairing process at the conference<br/>
							<label>
							Please state any past experience your school has had with Model United Nations:
							<textarea onChange={this.handleInputChange} value={this.state.postexperience} name="postexperience"></textarea>
							</label>
							<p>
							<i>By submitting this form you agree to the terms of CUSMUN</i>
							</p><br/>
							<input type="submit" value="Submit"/>
							</form>
						</div>
					)}
					{this.props.region == "Other" && (
						<div>
							<p>International Form</p>
							<form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
							<input type="hidden" name="action" value="process_international_form" />
							<label>
							Name of your school:
							<input name="schoolname" value={this.state.schoolname} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<label>
							Country your school is from:
							<input name="schoolcountry" value={this.state.schoolcountry} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<label>
							Name of teacher who will accompany delegation:
							<input name="teachername" value={this.state.teachername} onChange={this.handleInputChange} type="text"/><br/>
							</label>
							<label>
							Email of teacher who will accompany delegation:
							<input name="teacheremail" value={this.state.teacheremail} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<label>
							Number of students your delegation will be composed of:
							<input name="delegationnumber" value={this.state.delegationnumber} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<input type="checkbox" name="sendstudents" value={this.state.sendstudents} onChange={this.handleInputChange} />My school is willing to send students to assist with the chairing process at the conference<br/>
							<label>
							Please state any past experience your school has had with Model United Nations:
							<textarea name="postexperience" value={this.state.postexperience} onChange={this.handleInputChange}></textarea>
							</label>
							<p>
							<i>By submitting this form you agree to the terms of CUSMUN</i>
							</p><br/>
							<input type="submit" value="Submit"/>
							</form>
						</div>
					)}
					{this.props.region == "Cambridge" && (
						<div>
							<p>Cambridge Form</p>
							<form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
							<input type="hidden" name="action" value="process_cambridge_form" />
							<label>
							Name of your school:
							<input name="schoolname" value={this.state.schoolname} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<label>
							Name of teacher who will accompany delegation:
							<input name="teachername" value={this.state.teachername} onChange={this.handleInputChange} type="text"/><br/>
							</label>
							<label>
							Email of teacher who will accompany delegation:
							<input name="teacheremail" value={this.state.teacheremail} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<label>
							Number of students your delegation will be composed of:
							<input name="delegationnumber" value={this.state.delegationnumber} onChange={this.handleInputChange} type="text" /><br/>
							</label>
							<input name="sendstudents" type="checkbox" name="sendstudents" value={this.state.sendstudents} onChange={this.handleInputChange} />My school is willing to send students to assist with the chairing process at the conference<br/>
							<label>
							Please state any past experience your school has had with Model United Nations:
							<textarea name="postexperience" value={this.state.postexperience} onChange={this.handleInputChange}></textarea>
							</label>
							<p>
							<i>By submitting this form you agree to the terms of CUSMUN</i>
							</p><br/>
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
	public function process_uk_form() {
		// processes UK form submition
		$schoolname = $_REQUEST['schoolname'];
		$schoollocation = $_REQUEST['schoollocation'];
		$teachername = $_REQUEST['teachername'];
		$teacheremail = $_REQUEST['teacheremail'];
		$delegationnumber = $_REQUEST['delegationnumber'];
		$postexperience = $_REQUEST['postexperience'];
		$sendstudents = $_REQUEST['sendstudents'];
		$message = "You have received a new CUSMUN Application.\n\n"."Here are the details:\n\nSchool Name: $schoolname\n\nSchool Location: $schoollocation\n\nTeachers Name: $teachername\n\nTeacher Email:\n$teacheremail\n\nNumber of Delegates: $delegationnumber\n\nWilling to Send Students to Assist: $sendstudents\n\nPast Experience: $postexperience";
		mail('jakeo@tgs.org', 'New CUSMUN Application', $message);

	}
	public function process_international_form() {
		// process international form

		$schoolname = $_REQUEST['schoolname'];
		$schoolcountry = $_REQUEST['schoolcountry'];
		$teachername = $_REQUEST['teachername'];
		$teacheremail = $_REQUEST['teacheremail'];
		$delegationnumber = $_REQUEST['delegationnumber'];
		$postexperience = $_REQUEST['postexperience'];
		$sendstudents = $_REQUEST['sendstudents'];
		$message = "You have received a new CUSMUN Application.\n\n"."Here are the details:\n\nSchool Name: $schoolname\n\nSchool Location: $schoolcountry\n\nTeachers Name: $teachername\n\nTeacher Email:\n$teacheremail\n\nNumber of Delegates: $delegationnumber\n\nWilling to Send Students to Assist: $sendstudents\n\nPast Experience: $postexperience";
		mail('jakeo@tgs.org', 'New CUSMUN Application', $message);



	}
	public function process_cambridge_form() {
		// process cambridge form
		var_dump($_REQUEST);
		$schoolname = $_REQUEST['schoolname'];
		$teachername = $_REQUEST['teachername'];
		$teacheremail = $_REQUEST['teacheremail'];
		$delegationnumber = $_REQUEST['delegationnumber'];
		$postexperience = $_REQUEST['postexperience'];
		$sendstudents = $_REQUEST['sendstudents'];
		$message = "You have received a new CUSMUN Application.\n\n"."Here are the details:\n\nSchool Name: $schoolname\n\nSchool Location: 'Cambridge'\n\nTeachers Name: $teachername\n\nTeacher Email:\n$teacheremail\n\nNumber of Delegates: $delegationnumber\n\nWilling to Send Students to Assist: $sendstudents\n\nPast Experience: $postexperience";
		mail('jakeo@tgs.org', 'New CUSMUN Application', $message);



	}

}
