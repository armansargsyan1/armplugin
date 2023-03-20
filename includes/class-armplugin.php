<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://.bok
 * @since      1.0.0
 *
 * @package    Armplugin
 * @subpackage Armplugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Armplugin
 * @subpackage Armplugin/includes
 * @author     arman <arman.sargsyan0223@gmail.com>
 */
class Armplugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Armplugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'ARMPLUGIN_VERSION' ) ) {
			$this->version = ARMPLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'armplugin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->register();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Armplugin_Loader. Orchestrates the hooks of the plugin.
	 * - Armplugin_i18n. Defines internationalization functionality.
	 * - Armplugin_Admin. Defines all hooks for the admin area.
	 * - Armplugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-armplugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-armplugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-armplugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-armplugin-public.php';

		$this->loader = new Armplugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Armplugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Armplugin_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Armplugin_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Armplugin_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Armplugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	//------------------------------------------------------------------------------my changes
	public function register() {
		add_shortcode('arm_register_short', [ $this, 'arm_register_short' ]);
        add_shortcode('arm_users_table_short', [$this, 'arm_users_table_short']);
        add_shortcode('arm_edit_users_short',[$this, 'arm_edit_users_short']);

        $this->loader->add_action('admin_post_submit_btn' , $this, 'add_db');
        $this->loader->add_action('admin_post_edit' , $this, 'edit_users_func');
        if ( ! session_id() ) {
			session_start();
		}
    }


	/**
	 * This function is create a registration form , and
	 * after submitting send data in admin-post , witch is calling add_db() func
	 *
	 * @return false|string
	 */
	public function arm_register_short(){
		ob_start()?>
        <form method="post" id="form" enctype="multipart/form-data" action="<?php echo admin_url( 'admin-post.php' ) ?>">
            <input type="hidden" name="action" value="submit_btn">
            <div class="container">
                <div class="col">
                    <div class="row w-100 p-0">
                        <label for="name" class="form-label">UserName</label>
                        <input name="name" class="form-control">
                    </div>
                    <div class="row w-100 p-0">
                        <label for="password">Password</label>
                        <input name="password" class="form-control">
                    </div>
                    <div class="row w-100 p-0">
                        <label for="email">Email</label>
                        <input name="email" class="form-control">
                    </div>
                    <div class="row w-100 p-0 justify-content-center">
                        <label for="upload_img" class="input-group-text w-50">Your image</label>
                        <input type="file" id="upload_img" name="image" class=" btn btn-secondary w-50">
                    </div>
                    <div class="row w-100">
                        <label for="submitBtn"></label>
                        <input type="submit" class="btn btn-primary w-100 " name="upload_file" value="Register">
                    </div>
                </div>
            </div>
        </form>
		<?php
		return ob_get_clean();
	}

	/**
     * This function take a data from register form ,
     * and add users data in db without image src,
     * and after call a file_upload func
     *
	 * @return void
	 */
    public function add_db(){
	    $name     = sanitize_text_field( $_POST['name'] );
	    $password = sanitize_text_field( $_POST['password'] );
	    $email    = sanitize_email( $_POST['email'] );
        $be_checked_nonce = $_POST['login_nonce'] ?? null;

        if (isset($_POST['login_nonce']))
            if(!wp_verify_nonce($be_checked_nonce, 'login_nonce'))
                die('dont try to hack me');

	    if ( strlen( $name ) > 3 && strlen( $password ) > 5 && strlen( $email ) > 5 ) {
		    $last_id = wp_create_user( $name, $password, $email );
		    $_SESSION['armplugin']['success'] = "'$name' - this user was registered, ";
		    $_SESSION['armplugin']['error'] = null;
	    } else {
		    $last_id = null;
		    $_SESSION['armplugin']['error'] = "name should be more than 3 symbol, password 5, email 5";
		    $_SESSION['armplugin']['success'] = null;
	    }

	    wp_safe_redirect(site_url('users'));
	    $this->file_upload( $last_id );
    }

	/**
     * this function is taking a last added user id,
	 * taking a file data and uploads it in wp media,
	 * and after changes a user_url to uploaded img url
	 *
	 * @param $id
	 *
	 * @return void
	 */
    private function file_upload($id){
	    $upload = wp_upload_bits( $_FILES['image']['name'], null, file_get_contents( $_FILES['image']['tmp_name'] ) );
	    if ( !$upload['error'] ) {
		    $filename      = $upload['file'];
		    $filetype   = wp_check_filetype( $filename );
		    $attachment    = array(
			    'post_type'    => $filetype['type'],
			    'post_name'    => sanitize_file_name( $filename ),
			    'post_content' => '',
			    'post_status'  => 'inherit'
		    );
		    $attachment_id = wp_insert_attachment( $attachment, $filename, '111' );
		    if ( ! is_wp_error( $attachment_id ) ) {
			    require_once( ABSPATH . 'wp-admin/includes/image.php' );
		    }
	    } else {
		    $_SESSION['armplugin']['success'] .= null;
		    $_SESSION['armplugin']['error']   .= $upload['error'];
	    }
	    $get_updated = wp_update_user( [
		    'ID'       => $id,
		    'user_url' => $upload['url']
	    ] );
	    if ( is_wp_error( $get_updated ) ) {
		    $_SESSION['armplugin']['success'] = null;
		    $_SESSION['armplugin']['error']   .= $get_updated->get_error_message();
	    } else {
		    $_SESSION['armplugin']['success'] .= "image uploaded successfully";
		    $_SESSION['armplugin']['error']   = null;
	    }
	    wp_safe_redirect( site_url( 'users' ) );
    }

	/**
     * This function is taking data from db and generates a table
     *
	 * @return false|string
     *
	 */
	public function arm_users_table_short(){
        if (isset($_SESSION['armplugin']['error'])){
            ?><script> alert( "<?php echo $_SESSION['armplugin']['error'] ?>") </script><?php
        }

        else if(isset($_SESSION['armplugin']['success']))
        {
		    ?><script> alert( "<?php echo $_SESSION['armplugin']['success'] ?>") </script><?php
        }
        session_destroy();

		$current_page = $_GET['current'] ?? 0;
        // amount count of users
        $row_count = (count_users()['total_users']);
		$row_per_page = 2;
        $number_of_page = ceil($row_count / $row_per_page);
		$initial_page = $current_page * $row_per_page;

        $arr_from_db = json_decode(json_encode(get_users(array( 'offset' => $initial_page,
                                                                'number' => $row_per_page,
                                                                'orderby' => 'ID',
                                                                ))), true);

        ob_start();
		?>
        <div class="container m-0 p-0">
            <div class="row w-100">
                <div>
                    <form class="p-0 m-0" method="get" action="<?php echo site_url( 'edit' ) ?>">
                        <input type="hidden" name="action" value="edit_func">
                        <table class="table table-striped table-dark table-hover">
							<?php
                            foreach ($arr_from_db as $key){
                                ?>
                                <tr>
                                    <td><?php echo esc_attr( $key[ 'data' ]['ID'] ) ?></td>
                                    <td><?php echo esc_attr( $key[ 'data' ]['display_name'] ) ?></td>
                                    <td><?php echo esc_attr( $key[ 'data' ]['user_email'] ) ?></td>
                                    <td>
                                        <input class="btn btn-hover btn-danger" type="submit" name="edit" value="<?php echo esc_attr( $key['data']['ID'] ) ?>">
                                    </td>
                                    <td>
                                        <img src="<?php echo ( strlen( $key['data']['user_url'] ) > 0 ) ? esc_attr( $key['data']['user_url'] ) : 'http://localhost/wordpress/wp-content/uploads/2023/03/tomcat.jpg'
                                        ?>"
                                             width="50"
                                             height="50" sizes="" srcset="">
                                    </td>
                                </tr>
                                <?php
                                $last_id = esc_attr( $key[ 'data' ]['ID'] );
                            }
							?>
                        </table>
                    </form>
                </div>
                <div class="row w-100  padding-left-10">
                    <form class="w-50 p-0" action="" method="get">
                        <input type="submit" class="btn-success" name="current" value="<?php echo $current_page == 0 ? 0 : ($current_page == ($number_of_page - 1) ? ($number_of_page - 2) : $current_page - 1)  ?>">
                        <?php
                        for ($i = 0; $i < $number_of_page; ++$i){
                            ?><input type="submit" class="btn-primary" name="current" value = '<?php echo $i?>'><?php
                        }
                        ?>
                        <input type="submit" class="btn-danger" name="current" value="<?php echo $current_page == 0 ? 1 : ($current_page == ($number_of_page - 1) ? ($number_of_page - 1) : $current_page + 1)?>">
                    </form>
                </div>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	/**
     * This function is generates a form based recipient edit id
	 * @return false|string
	 */
    public function arm_edit_users_short(){
	    $id_from_get = 0;
	    if ( isset( $_GET['edit'] ) ) {
		    $id_from_get = esc_attr( $_GET['edit'] );
	    }
	    ob_start(); ?>
        <form method="get" enctype="multipart/form-data" action="<?php echo admin_url( 'admin-post.php' ) ?>">
            <input type="hidden" name="action" value="edit">
            <div class="container">
                <div class="col">
                    <div class="row w-100 p-0">
                        <label for="name">new name</label>
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    <div class="row w-100 p-0">
                        <label for="password">new password</label>
                        <input class="form-control" type="text" name="password" id="password">
                    </div>
                    <div class="row w-100 p-0">
                        <label for="email">new email</label>
                        <input class="form-control" type="text" name="email" id="email">
                    </div>
                    <div class="row w-100 p-0">
                        <label for="id">current ID</label>
                        <input class="form-control" type="number" name="id" id="id" value="<?php echo esc_attr( $id_from_get ) ?>" readonly>
                    </div>
                    <div class="row w-100 p-0">
                        <input type="submit" class="btn btn-primary ">
                    </div>
                </div>
            </div>
        </form>
	    <?php
	    return ob_get_clean();
    }

	/**
	 * This function is taking a users new data ,
	 * from arm_edit_users_short() func,
     * and updates a data
     *
	 * @return void
	 */
    public function edit_users_func(){

	    $name     = sanitize_text_field( $_GET['name'] );
	    $password = sanitize_text_field( $_GET['password'] );
	    $email    = sanitize_email( $_GET['email'] );
	    $id       = sanitize_text_field( $_GET['id'] );
	    if ( strlen( $name ) >= 3 && strlen( $password ) >= 5 && strlen( $email ) >= 5 ) {
		    get_userdata( $id );
		    $updated_user_data = wp_update_user( [
			    'ID'           => $id,
			    'user_email'   => $email,
			    'display_name' => $name
		    ] );
		    if ( is_wp_error( $updated_user_data ) ) {
			    $_SESSION['armplugin']['error']   = 'Error' . $updated_user_data->get_error_message();
			    $_SESSION['armplugin']['success'] = null;
		    } else {
			    $_SESSION['armplugin']['success'] = 'updated successfully';
			    $_SESSION['armplugin']['error']   = null;
		    }
	    } else {
		    $_SESSION['armplugin']['success'] = null;
		    $_SESSION['armplugin']['error']  ="name should be more than 3 symbol , surname 5, email 5";
	    }
	    wp_safe_redirect( site_url( 'users' ) );
    }
}
