<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.matrixinternet.ie/
 * @since      1.0.0
 *
 * @package    Woo_Raffle_Ticket_Extension
 * @subpackage Woo_Raffle_Ticket_Extension/includes
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
 * @package    Woo_Raffle_Ticket_Extension
 * @subpackage Woo_Raffle_Ticket_Extension/includes
 * @author     Bernard Hanna <bernard@matrixinternet.ie>
 */
class Woo_Raffle_Ticket_Extension {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Raffle_Ticket_Extension_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->version = '1.0.0';

		$this->plugin_name = 'woo raffle ticket extension';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Raffle_Ticket_Extension_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Raffle_Ticket_Extension_i18n. Defines internationalization functionality.
	 * - Woo_Raffle_Ticket_Extension_Admin. Defines all hooks for the admin area.
	 * - Woo_Raffle_Ticket_Extension_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo raffle ticket extension-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo raffle ticket extension-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo raffle ticket extension-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo raffle ticket extension-public.php';

		$this->loader = new Woo_Raffle_Ticket_Extension_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Raffle_Ticket_Extension_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Raffle_Ticket_Extension_i18n();

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

		$plugin_admin = new Woo_Raffle_Ticket_Extension_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_public = new Woo_Raffle_Ticket_Extension_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $this, 'cfwc_create_custom_field' );
		$this->loader->add_action( 'woocommerce_process_product_meta', $this, 'cfwc_save_custom_field' );
		$this->loader->add_action( 'woocommerce_thankyou', $this, 'add_free_product', 9, 1 );

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
	 * @return    Woo_Raffle_Ticket_Extension_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Display the custom text field
	 *
	 * @since 1.0.0
	 */
	function cfwc_create_custom_field() {
		global $post;
		$product_ids = json_decode( get_post_meta( $post->ID, 'additional_products', true ) );

		?><p class="form-field hide_if_grouped hide_if_external">
		<label for="additional_products"><?php esc_html_e( 'Additional Products Included In This Sale', 'woocommerce' ); ?></label>
		<select class="wc-product-search" multiple="multiple" style="width: 50%;" id="additional_products" name="additional_products[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
			<?php

			foreach ( $product_ids as $product_id ) {
				$product = wc_get_product( $product_id );
				if ( is_object( $product ) ) {
					echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
				}
			}
			?>
			</select> <?php echo wc_help_tip( __( 'Add additional products which should be included in the price of this sale, a bit like a linked product but no additional charge.', 'woocommerce' ) ); // WPCS: XSS ok. ?>
			</p> 
			<?php
	}

	/**
	 * Save the custom field
	 *
	 * @since 1.0.0
	 */
	function cfwc_save_custom_field( $post_id ) {
		$product = wc_get_product( $post_id );
		$title = isset( $_POST['additional_products'] ) ? $_POST['additional_products'] : '';
		$product->update_meta_data( 'additional_products', json_encode( $title ) );
		$product->save();
	}

	function add_free_product( $order_id ) {
		global $wpdb;
		$additional_products_added = get_post_meta( $order_id, 'additional_products_added', true );
		if ( ! empty( $additional_products_added ) ) {
			return;
		}
		$order = wc_get_order( $order_id );
		$order_items = $order->get_items();
		foreach ( $order_items as $key => $item ) {
			$product = $item->get_product();
			$item->get_meta_data();
			$free_products = get_post_meta( $product->get_id(), 'additional_products', true );
			$products_added[] = $free_products;
			$free_products = json_decode( $free_products );
			$quantity = wc_stock_amount( $item['qty'] );
			if ( is_array( $free_products ) ) {
				foreach ( $free_products as $keys => $free_product ) {
					$free_product = wc_get_product( $free_product );
					$free_product->set_price( 0.00 );
					$order->add_product( $free_product, $quantity );
					$order->save();
				}
			}
		}
		cancel_tickets( $order_id );
		insert_raffle_tickets_manual( $order_id );

		foreach ( $order_items as $key => $item ) {
			$product = $item->get_product();
			$prize_chosen = wc_get_order_item_meta( $key, 'Prize Chosen', true );
			$wpdb->query( 'UPDATE ' . $wpdb->prefix . 'rafflepro_tickets_customer_to_tickets SET prize_chosen="' . $prize_chosen . '" where order_id = "' . $order->get_id() . '" AND products_id = "' . $product->get_id() . '"' );
			$prize_chosen = '';
		}
		update_post_meta( $order_id, 'additional_products_added', json_encode( $products_added ), $prev_value = '' );
		$order->save();
	}

}
