<?php
/**
 * PayFast Payment Gateway
 *
 * Provides a PayFast Payment Gateway.
 *
 * @class 		woocommerce_payfast
 * @package		WooCommerce
 * @category	Payment Gateways
 * @author		WooThemes
 */
class WC_Gateway_PayFast extends WC_Payment_Gateway {

	/**
	 * Version
	 *
	 * @var string
	 */
	public $version = '1.2.8';

	/**
	 * @access protected
	 * @var array $data_to_send
	 */
	protected $data_to_send = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id = 'payfast';
		$this->method_title       = __( 'PayFast', 'woocommerce-gateway-payfast' );
		$this->method_description = sprintf( __( 'PayFast works by sending the user to %sPayFast%s to enter their payment information.', 'woocommerce-gateway-payfast' ), '<a href="http://payfast.co.za/">', '</a>' );
		$this->icon               = WP_PLUGIN_URL . '/' . plugin_basename( dirname( dirname( __FILE__ ) ) ) . '/assets/images/icon.png';
		$this->debug_email        = get_option( 'admin_email' );
		$this->available_countries  = array( 'ZA' );
		$this->available_currencies = array( 'ZAR' );

		// Supported functionality
		$this->supports = array(
						'products',
						'pre-orders',
						'subscriptions',
						'subscription_cancellation',
						'subscription_suspension',
						'subscription_reactivation',
						'subscription_amount_changes',
						'subscription_date_changes',
						'subscription_payment_method_change',
		);

		$this->init_form_fields();
		$this->init_settings();

		if ( ! is_admin() ) {
			$this->setup_constants();
		}

		// Setup default merchant data.
		$this->merchant_id      = $this->get_option( 'merchant_id' );
		$this->merchant_key     = $this->get_option( 'merchant_key' );
		$this->pass_phrase      = $this->get_option( 'pass_phrase' );
		$this->url              = 'https://www.payfast.co.za/eng/process?aff=woo-free';
		$this->validate_url     = 'https://www.payfast.co.za/eng/query/validate';
		$this->title            = $this->get_option( 'title' );
		$this->response_url	    = add_query_arg( 'wc-api', 'WC_Gateway_PayFast', home_url( '/' ) );
		$this->send_debug_email = 'yes' === $this->get_option( 'send_debug_email' );
		$this->description = $this->get_option( 'description' );
		$this->enabled = $this->is_valid_for_use() ? 'yes': 'no'; // Check if the base currency supports this gateway.

		// Setup the test data, if in test mode.
		if ( 'yes' === $this->get_option( 'testmode' ) ) {
			$this->url          = 'https://sandbox.payfast.co.za/eng/process?aff=woo-free';
			$this->validate_url = 'https://sandbox.payfast.co.za/eng/query/validate';
			$this->add_testmode_admin_settings_notice();
		} else {
			$this->send_debug_email = false;
		}

		add_action( 'woocommerce_api_wc_gateway_payfast', array( $this, 'check_itn_response' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_receipt_payfast', array( $this, 'receipt_page' ) );
		add_action( 'woocommerce_scheduled_subscription_payment_' . $this->id, array( $this, 'scheduled_subscription_payment' ), 10, 2 );
		add_action( 'woocommerce_subscription_status_cancelled', array( $this, 'cancel_subscription_listener' ) );
		add_action( 'wc_pre_orders_process_pre_order_completion_payment_' . $this->id, array( $this, 'process_pre_order_payments' ) );
	}

	/**
	 * Initialise Gateway Settings Form Fields
	 *
	 * @since 1.0.0
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'       => __( 'Enable/Disable', 'woocommerce-gateway-payfast' ),
				'label'       => __( 'Enable PayFast', 'woocommerce-gateway-payfast' ),
				'type'        => 'checkbox',
				'description' => __( 'This controls whether or not this gateway is enabled within WooCommerce.', 'woocommerce-gateway-payfast' ),
				'default'     => 'yes',
				'desc_tip'    => true,
			),
			'title' => array(
				'title'       => __( 'Title', 'woocommerce-gateway-payfast' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce-gateway-payfast' ),
				'default'     => __( 'PayFast', 'woocommerce-gateway-payfast' ),
				'desc_tip'    => true,
			),
			'description' => array(
				'title'       => __( 'Description', 'woocommerce-gateway-payfast' ),
				'type'        => 'text',
				'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce-gateway-payfast' ),
				'default'     => '',
				'desc_tip'    => true,
			),
			'testmode' => array(
				'title'       => __( 'PayFast Sandbox', 'woocommerce-gateway-payfast' ),
				'type'        => 'checkbox',
				'description' => __( 'Place the payment gateway in development mode.', 'woocommerce-gateway-payfast' ),
				'default'     => 'yes',
			),
			'merchant_id' => array(
				'title'       => __( 'Merchant ID', 'woocommerce-gateway-payfast' ),
				'type'        => 'text',
				'description' => __( 'This is the merchant ID, received from PayFast.', 'woocommerce-gateway-payfast' ),
				'default'     => '',
			),
			'merchant_key' => array(
				'title'       => __( 'Merchant Key', 'woocommerce-gateway-payfast' ),
				'type'        => 'text',
				'description' => __( 'This is the merchant key, received from PayFast.', 'woocommerce-gateway-payfast' ),
				'default'     => '',
			),
			'pass_phrase' => array(
				'title'       => __( 'Passphrase', 'woocommerce-gateway-payfast' ),
				'type'        => 'text',
				'description' => __( 'Needed in order to handle subscriptions and Pre-Orders. This phrase must match the phrase set on your merchant account., received from PayFast.', 'woocommerce-gateway-payfast' ),
				'default'     => '',
			),
			'send_debug_email' => array(
				'title'   => __( 'Send Debug Emails', 'woocommerce-gateway-payfast' ),
				'type'    => 'checkbox',
				'label'   => __( 'Send debug e-mails for transactions through the PayFast gateway (sends on successful transaction as well).', 'woocommerce-gateway-payfast' ),
				'default' => 'yes',
			),
			'debug_email' => array(
				'title'       => __( 'Who Receives Debug E-mails?', 'woocommerce-gateway-payfast' ),
				'type'        => 'text',
				'description' => __( 'The e-mail address to which debugging error e-mails are sent when in test mode.', 'woocommerce-gateway-payfast' ),
				'default'     => get_option( 'admin_email' ),
			),
		);
	}

	/**
	 * add_testmode_admin_settings_notice()
	 * Add a notice to the merchant_key and merchant_id fields when in test mode.
	 *
	 * @since 1.0.0
	 */
	public function add_testmode_admin_settings_notice() {
		$this->form_fields['merchant_id']['description']  .= ' <strong>' . __( 'Sandbox Merchant ID currently in use', 'woocommerce-gateway-payfast' ) . ' ( ' . esc_html( $this->merchant_id ) . ' ).</strong>';
		$this->form_fields['merchant_key']['description'] .= ' <strong>' . __( 'Sandbox Merchant Key currently in use', 'woocommerce-gateway-payfast' ) . ' ( ' . esc_html( $this->merchant_key ) . ' ).</strong>';
	}

	/**
	 * is_valid_for_use()
	 *
	 * Check if this gateway is enabled and available in the base currency being traded with.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function is_valid_for_use() {
		$is_available          = false;
		$is_available_currency = in_array( get_woocommerce_currency(), $this->available_currencies );

		if ( $is_available_currency && $this->merchant_id && $this->merchant_key ) {
			$is_available = true;
		}

		return $is_available;
	}

	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 */
	public function admin_options() {
		if ( in_array( get_woocommerce_currency(), $this->available_currencies ) ) {
			parent::admin_options();
		} else {
		?>
			<h3><?php _e( 'PayFast', 'woocommerce-gateway-payfast' ); ?></h3>
			<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'woocommerce-gateway-payfast' ); ?></strong> <?php echo sprintf( __( 'Choose South African Rands as your store currency in %1$sPricing Options%2$s to enable the PayFast Gateway.', 'woocommerce-gateway-payfast' ), '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=general' ) ) . '">', '</a>' ); ?></p></div>
			<?php
		}
	}

	/**
	 * Generate the PayFast button link.
	 *
	 * @since 1.0.0
	 */
	public function generate_payfast_form( $order_id ) {
		$order         = wc_get_order( $order_id );
		// Construct variables for post
		$this->data_to_send = array(
			// Merchant details
			'merchant_id'      => $this->merchant_id,
			'merchant_key'     => $this->merchant_key,
			'return_url'       => $this->get_return_url( $order ),
			'cancel_url'       => $order->get_cancel_order_url(),
			'notify_url'       => $this->response_url,

			// Billing details
			'name_first'       => $order->billing_first_name,
			'name_last'        => $order->billing_last_name,
			'email_address'    => $order->billing_email,

			// Item details
			'm_payment_id'     => ltrim( $order->get_order_number(), __( '#', 'hash before order number', 'woocommerce-gateway-payfast' ) ),
			'amount'           => $order->get_total(),
			'item_name'        => get_bloginfo( 'name' ) . ' - ' . $order->get_order_number(),
			'item_description' => sprintf( __( 'New order from %s', 'woocommerce-gateway-payfast' ), get_bloginfo( 'name' ) ),

			// Custom strings
			'custom_str1'      => $order->order_key,
			'custom_str2'      => 'WooCommerce/' . WC_VERSION . '; ' . get_site_url(),
			'custom_str3'      => $order->id,
			'source'           => 'WooCommerce-Free-Plugin',
		);

		// add subscription parameters
		if ( $this->order_contains_subscription( $order_id ) ) {
			// 2 == ad-hoc subscription type see PayFast API docs
			$this->data_to_send['subscription_type'] = '2';
		}

		// pre-order: add the subscription type for pre order that require tokenization
		// at this point we assume that the order pre order fee and that
		// we should only charge that on the order. The rest will be charged later.
		if ( $this->order_contains_pre_order( $order_id )
		     && $this->order_requires_payment_tokenization( $order_id ) ) {
			$this->data_to_send['amount']            = $this->get_pre_order_fee( $order_id );
			$this->data_to_send['subscription_type'] = '2';
		}

		$payfast_args_array = array();
		foreach ( $this->data_to_send as $key => $value ) {
			$payfast_args_array[] = '<input type="hidden" name="' . esc_attr( $key ) .'" value="' . esc_attr( $value ) . '" />';
		}

		return '<form action="' . esc_url( $this->url ) . '" method="post" id="payfast_payment_form">
				' . implode( '', $payfast_args_array ) . '
				<input type="submit" class="button-alt" id="submit_payfast_payment_form" value="' . __( 'Pay via PayFast', 'woocommerce-gateway-payfast' ) . '" /> <a class="button cancel" href="' . $order->get_cancel_order_url() . '">' . __( 'Cancel order &amp; restore cart', 'woocommerce-gateway-payfast' ) . '</a>
				<script type="text/javascript">
					jQuery(function(){
						jQuery("body").block(
							{
								message: "' . __( 'Thank you for your order. We are now redirecting you to PayFast to make payment.', 'woocommerce-gateway-payfast' ) . '",
								overlayCSS:
								{
									background: "#fff",
									opacity: 0.6
								},
								css: {
									padding:        20,
									textAlign:      "center",
									color:          "#555",
									border:         "3px solid #aaa",
									backgroundColor:"#fff",
									cursor:         "wait"
								}
							});
						jQuery( "#submit_payfast_payment_form" ).click();
					});
				</script>
			</form>';
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @since 1.0.0
	 */
	public function process_payment( $order_id ) {

		if ( $this->order_contains_pre_order( $order_id )
			&& $this->order_requires_payment_tokenization( $order_id )
			&& ! $this->cart_contains_pre_order_fee() ) {
				throw new Exception( 'PayFast does not support transactions without any upfront costs or fees. Please select another gateway' );
		}

		$order = wc_get_order( $order_id );
		return array(
			'result' 	 => 'success',
			'redirect'	 => $order->get_checkout_payment_url( true ),
		);
	}

	/**
	 * Reciept page.
	 *
	 * Display text and a button to direct the user to PayFast.
	 *
	 * @since 1.0.0
	 */
	public function receipt_page( $order ) {
		echo '<p>' . __( 'Thank you for your order, please click the button below to pay with PayFast.', 'woocommerce-gateway-payfast' ) . '</p>';
		echo $this->generate_payfast_form( $order );
	}

	/**
	 * Check PayFast ITN response.
	 *
	 * @since 1.0.0
	 */
	public function check_itn_response() {
		$this->handle_itn_request( stripslashes_deep( $_POST ) );
	}

	/**
	 * Check PayFast ITN validity.
	 *
	 * @param array $data
	 * @since 1.0.0
	 */
	public function handle_itn_request( $data ) {
		$this->log( "\n" . '----------' . "\n" . 'PayFast ITN call received' );
		$this->log( 'Get posted data' );
		$this->log( 'PayFast Data: '. print_r( $data, true ) );

		$payfast_error  = false;
		$payfast_done   = false;
		$debug_email    = $this->get_option( 'debug_email', get_option( 'admin_email' ) );
		$session_id     = $data['custom_str1'];
		$vendor_name    = get_bloginfo( 'name' );
		$vendor_url     = home_url( '/' );
		$order_id       = absint( $data['custom_str3'] );
		$order_key      = wc_clean( $session_id );
		$order          = wc_get_order( $order_id );

		// Notify PayFast that information has been received
		header( 'HTTP/1.0 200 OK' );
		flush();

		if ( false === $data ) {
			$payfast_error  = true;
			$payfast_error_message = PF_ERR_BAD_ACCESS;
		}

		// Verify security signature
		if ( ! $payfast_error && ! $payfast_done ) {
			$this->log( 'Verify security signature' );
			$signature = md5( $this->_generate_parameter_string( $data, false, false ) ); // false not to sort data
			// If signature different, log for debugging
			if ( ! $this->validate_signature( $data, $signature ) ) {
				$payfast_error         = true;
				$payfast_error_message = PF_ERR_INVALID_SIGNATURE;
			}
		}

		// Verify source IP (If not in debug mode)
		if ( ! $payfast_error && ! $payfast_done && $this->get_option( 'testmode' ) != 'yes' ) {
			$this->log( 'Verify source IP' );

			if ( ! $this->validate_ip( $_SERVER['REMOTE_ADDR'] ) ) {
				$payfast_error  = true;
				$payfast_error_message = PF_ERR_BAD_SOURCE_IP;
			}
		}

		// Get internal order and verify it hasn't already been processed
		if ( ! $payfast_error && ! $payfast_done ) {
			$this->log( "Purchase:\n". print_r( $order, true ) );

			// Check if order has already been processed
			if ( 'completed' === $order->status ) {
				$this->log( 'Order has already been processed' );
				$payfast_done = true;
			}
		}

		// Verify data received
		if ( ! $payfast_error ) {
			$this->log( 'Verify data received' );
			$validation_data = $data;
			unset( $validation_data['signature'] );
			$has_valid_response_data = $this->validate_response_data( $validation_data );

			if ( ! $has_valid_response_data ) {
				$payfast_error = true;
				$payfast_error_message = PF_ERR_BAD_ACCESS;
			}
		}

		// Check data against internal order
		if ( ! $payfast_error && ! $payfast_done ) {
			$this->log( 'Check data against internal order' );

			// Check order amount
			if ( ! $this->amounts_equal( $data['amount_gross'], $order->order_total )
				 && ! $this->order_contains_pre_order( $order_id )
				 && ! $this->order_contains_subscription( $order_id ) ) {
				$payfast_error  = true;
				$payfast_error_message = PF_ERR_AMOUNT_MISMATCH;
			} elseif ( strcasecmp( $data['custom_str1'], $order->order_key ) != 0 ) {
				// Check session ID
				$payfast_error  = true;
				$payfast_error_message = PF_ERR_SESSIONID_MISMATCH;
			}
		}

		// If an error occurred
		if ( $payfast_error ) {
			$this->log( 'Error occurred: '. $payfast_error_message );

			if ( $this->send_debug_email ) {
				$this->log( 'Sending email notification' );

				 // Send an email
				$subject = "PayFast ITN error: ". $payfast_error_message;
				$body =
					"Hi,\n\n".
					"An invalid PayFast transaction on your website requires attention\n".
					"------------------------------------------------------------\n".
					"Site: ". $vendor_name ." (". $vendor_url .")\n".
					"Remote IP Address: ".$_SERVER['REMOTE_ADDR']."\n".
					"Remote host name: ". gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) ."\n".
					"Purchase ID: ". $order->id ."\n".
					"User ID: ". $order->user_id ."\n";
				if( isset( $data['pf_payment_id'] ) )
					$body .= "PayFast Transaction ID: ". $data['pf_payment_id'] ."\n";
				if( isset( $data['payment_status'] ) )
					$body .= "PayFast Payment Status: ". $data['payment_status'] ."\n";
				$body .=
					"\nError: ". $payfast_error_message ."\n";

				switch( $payfast_error_message ) {
					case PF_ERR_AMOUNT_MISMATCH:
						$body .=
							"Value received : ". $data['amount_gross'] ."\n".
							"Value should be: ". $order->order_total;
						break;

					case PF_ERR_ORDER_ID_MISMATCH:
						$body .=
							"Value received : ". $data['custom_str3'] ."\n".
							"Value should be: ". $order->id;
						break;

					case PF_ERR_SESSION_ID_MISMATCH:
						$body .=
							"Value received : ". $data['custom_str1'] ."\n".
							"Value should be: ". $order->id;
						break;

					// For all other errors there is no need to add additional information
					default:
						break;
				}

				wp_mail( $debug_email, $subject, $body );
			}
		} elseif ( ! $payfast_done ) {

			$this->log( 'Check status and update order' );

			if ( $order->order_key !== $order_key ) {
				exit;
			}

			// alter order object to be the renewal order if
			// the ITN request comes as a result of a renewal submission request
			$description = json_decode( $data['item_description'] );
			if ( isset( $description->renewal_order_id ) ) {
				$order = wc_get_order( $description->renewal_order_id );
			}

			$status = strtolower( $data['payment_status'] );
			if ( 'complete' === $status ) {
				$this->handle_itn_payment_complete( $data, $order );
			} elseif ( 'failed' === $status ) {
				$this->handle_itn_payment_failed( $data, $order );
			} elseif ( 'pending' === $status ) {
				$this->handle_itn_payment_pending( $data, $order );
			} elseif ( 'cancelled' === $status ) {
				$this->handle_itn_payment_cancelled( $data, $order );
			}
		}
	}

	/**
	 * This funtion mainly responds to ITN cancell requests initiated on PayFast, but also acts
	 * just in case they are not cancelled.
	 *
	 *
	 * @param array $data should be from the Gatewy ITN callback.
	 * @param WC_Order $order
	 */
	public function handle_itn_payment_cancelled( $data, $order ) {
		$subscriptions = wcs_get_subscriptions_for_order( $order );

		remove_action( 'woocommerce_subscription_status_cancelled', array( $this, 'cancel_subscription_listener' ) );
		foreach ( $subscriptions as $subscription ) {
			if ( 'cancelled' !== $subscription->get_status() ) {
				$subscription->update_status( 'cancelled', __( 'Merchant cancelled subscription on PayFast.' , 'woocommerce-gateway-payfast' ) );
				$this->_delete_subscription_token( $subscription );
			}
		}
		add_action( 'woocommerce_subscription_status_cancelled', array( $this, 'cancel_subscription_listener' ) );
	}

	/**
	 * @param array $data should be from the Gatewy ITN callback.
	 * @param WC_Order $order
	 */
	public function handle_itn_payment_complete( $data, $order ) {
		$this->log( '- Complete' );
		$order->add_order_note( __( 'ITN payment completed', 'woocommerce-gateway-payfast' ) );

		//store token for future subscription deductions
		if ( $this->order_contains_subscription( $order ) && isset( $data['token'] ) ) {
			$token = sanitize_text_field( $data['token'] );
			$subscriptions = wcs_get_subscriptions_for_order( $order->id );
			foreach ( $subscriptions as $subscription ) {
				$this->_set_subscription_token( $token, $subscription );
			}
		}

		// the same mechanism (adhoc token) is used to capture payment later
		if ( $this->order_contains_pre_order( $order->id )
			&& $this->order_requires_payment_tokenization( $order->id ) ) {

			$token = sanitize_text_field( $data['token'] );
			$is_pre_order_fee_paid = get_post_meta( $order->id, '_pre_order_fee_paid', true ) === 'yes';

			if ( ! $is_pre_order_fee_paid ) {
				$order->add_order_note( sprintf( __( 'PayFast pre-order fee paid: R %s (%s)', 'woocommerce-gateway-payfast' ), $data['amount_gross'], $data['pf_payment_id'] ) );
				$this->_set_pre_order_token( $token, $order );
				// set order to pre-ordered
				WC_Pre_Orders_Order::mark_order_as_pre_ordered( $order );
				update_post_meta( $order->id, '_pre_order_fee_paid', 'yes' );
				WC()->cart->empty_cart();
			} else {
				$order->add_order_note( sprintf( __( 'PayFast pre-order product line total paid: R %s (%s)', 'woocommerce-gateway-payfast' ), $data['amount_gross'],$data['pf_payment_id'] ) );
				$order->payment_complete();
				$this->cancel_pre_order_subscription( $token );
			}
		} else {
			$order->payment_complete();
		}

		$debug_email   = $this->get_option( 'debug_email', get_option( 'admin_email' ) );
		$vendor_name    = get_bloginfo( 'name' );
		$vendor_url     = home_url( '/' );
		if ( $this->send_debug_email ) {
			$subject = 'PayFast ITN on your site';
			$body =
				"Hi,\n\n".
				'A PayFast transaction has been completed on your website\n'.
				'------------------------------------------------------------\n'.
				"Site: ". $vendor_name ." (". $vendor_url .")\n".
				"Purchase ID: ". $data['m_payment_id'] ."\n".
				"PayFast Transaction ID: ". $data['pf_payment_id'] ."\n".
				"PayFast Payment Status: ". $data['payment_status'] ."\n".
				"Order Status Code: ". $order->status;
			wp_mail( $debug_email, $subject, $body );
		}
	}

	/**
	 * @param $data
	 * @param $order
	 */
	public function handle_itn_payment_failed( $data, $order ) {
		$this->log( '- Failed' );
		$order->update_status( 'failed', sprintf( __( 'Payment %s via ITN.', 'woocommerce-gateway-payfast' ), strtolower( sanitize_text_field( $data['payment_status'] ) ) ) );
		$debug_email   = $this->get_option( 'debug_email', get_option( 'admin_email' ) );
		$vendor_name    = get_bloginfo( 'name' );
		$vendor_url     = home_url( '/' );

		if ( $this->send_debug_email ) {
			$subject = 'PayFast ITN Transaction on your site';
			$body =
				'Hi,\n\n'.
				'A failed PayFast transaction on your website requires attention\n'.
				'------------------------------------------------------------\n'.
				"Site: ". $vendor_name ." (". $vendor_url .")\n".
				"Purchase ID: ". $order->id ."\n".
				"User ID: ". $order->user_id ."\n".
				"PayFast Transaction ID: ". $data['pf_payment_id'] ."\n".
				"PayFast Payment Status: ". $data['payment_status'];
			wp_mail( $debug_email, $subject, $body );
		}
	}

	/**
	 * @since 1.4.0 introduced
	 * @param $data
	 * @param $order
	 */
	public function handle_itn_payment_pending( $data, $order ) {
		$this->log( '- Pending' );
		// Need to wait for "Completed" before processing
		$order->update_status( 'on-hold', sprintf( __( 'Payment %s via ITN.', 'woocommerce-gateway-payfast' ), strtolower( sanitize_text_field( $data['payment_status'] ) ) ) );
	}

	/**
	 * @param string $order_id
	 * @return double
	 */
	public function get_pre_order_fee( $order_id ) {
		foreach ( wc_get_order( $order_id )->get_fees() as $fee ) {
			if ( is_array( $fee ) && 'Pre-Order Fee' == $fee['name'] ) {
				return doubleval( $fee['line_total'] ) + doubleval( $fee['line_tax'] );
			}
		}
	}
	/**
	 * @param string $order_id
	 * @return bool
	 */
	public function order_contains_pre_order( $order_id ) {
		if ( class_exists( 'WC_Pre_Orders_Order' ) ) {
			return WC_Pre_Orders_Order::order_contains_pre_order( $order_id );
		}
		return false;
	}

	/**
	 * @param string $order_id
	 *
	 * @return bool
	 */
	public function order_requires_payment_tokenization( $order_id ) {
		if ( class_exists( 'WC_Pre_Orders_Order' ) ) {
			return WC_Pre_Orders_Order::order_requires_payment_tokenization( $order_id );
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function cart_contains_pre_order_fee() {
		if ( class_exists( 'WC_Pre_Orders_Cart' ) ) {
			return WC_Pre_Orders_Cart::cart_contains_pre_order_fee();
		}
		return false;
	}
	/**
	 * Store the PayFast subscription token
	 *
	 * @param string $token
	 * @param WC_Subscription $subscription
	 */
	protected function _set_subscription_token( $token, $subscription ) {
		update_post_meta( $subscription->id, '_payfast_subscription_token', $token );
	}

	/**
	 * Retrieve the PayFast subscription token for a given order id.
	 *
	 * @param WC_Subscription $subscription
	 * @return mixed
	 */
	protected function _get_subscription_token( $subscription ) {
		return get_post_meta( $subscription->id, '_payfast_subscription_token', true );
	}

	/**
	 * Retrieve the PayFast subscription token for a given order id.
	 *
	 * @param WC_Subscription $subscription
	 * @return mixed
	 */
	protected function _delete_subscription_token( $subscription ) {
		return delete_post_meta( $subscription->id, '_payfast_subscription_token' );
	}

	/**
	 * Store the PayFast pre_order_token token
	 *
	 * @param string $token
	 * @param WC_Order$order
	 */
	protected function _set_pre_order_token( $token, $order ) {
		update_post_meta( $order->id, '_payfast_pre_order_token', $token );
	}

	/**
	 * Retrieve the PayFast pre-order token for a given order id.
	 *
	 * @param WC_Order $order
	 * @return mixed
	 */
	protected function _get_pre_order_token( $order ) {
		return get_post_meta( $order->id, '_payfast_pre_order_token', true );
	}

	/**
	 * Wrapper function for wcs_order_contains_subscription
	 *
	 * @param WC_Order $order
	 * @return bool
	 */
	public function order_contains_subscription( $order ) {
		if ( ! function_exists( 'wcs_order_contains_subscription' ) ) {
			return false;
		}
		return wcs_order_contains_subscription( $order );
	}

	/**
	 * @param $amount_to_charge
	 * @param WC_Order $renewal_order
	 */
	public function scheduled_subscription_payment( $amount_to_charge, $renewal_order ) {

		$subscription = wcs_get_subscription( get_post_meta( $renewal_order->id, '_subscription_renewal', true ) );
		if ( empty( $subscription ) ) {
			return;
		}
		$response = $this->submit_subscription_payment( $subscription, $amount_to_charge );

		if ( is_wp_error( $response ) ) {
			$renewal_order->update_status( 'failed', sprintf( __( 'PayFast Subscription renewal transaction failed (%s:%s)', 'woocommerce-gateway-payfast' ), $response->get_error_code() ,$response->get_error_message() ) );
		}
		// Payment will be completion will be capture only when the ITN callback is sent to $this->handle_itn_request().
		$renewal_order->add_order_note( __( 'PayFast Subscription renewal transaction submitted.', 'woocommerce-gateway-payfast' ) );

	}

	/**
	 * @param WC_Subscription $subscription
	 * @param $amount_to_charge
	 * @return mixed WP_Error on failure, bool true on success
	 */
	public function submit_subscription_payment( $subscription, $amount_to_charge ) {
		$token = $this->_get_subscription_token( $subscription );
		$item_name = $this->get_subscription_name( $subscription );

		foreach ( $subscription->get_related_orders( 'all', 'renewal' ) as $order ) {
			$statuses_to_charge = array( 'on-hold', 'failed', 'pending' );
			if ( in_array( $order->get_status(), $statuses_to_charge ) ) {
				$latest_order_to_renew = $order;
				break;
			}
		}
		$item_description = json_encode( array( 'renewal_order_id' => $latest_order_to_renew->id ) );

		return $this->submit_add_hoc_payment( $token, $amount_to_charge, $item_name, $item_description );
	}

	/**
	 * Get a name for the subscription item. For multiple
	 * item only Subscription $date will be returned.
	 *
	 * For subscriptions with no items Site/Blog name will be returned.
	 *
	 * @param WC_Subscription $subscription
	 * @return string
	 */
	public function get_subscription_name( $subscription ) {

		if ( $subscription->get_item_count() > 1 ) {
			return $subscription->get_date_to_display( 'start' );
		} else {
			$items = $subscription->get_items();

			if ( empty( $items ) ) {
				return get_bloginfo( 'name' );
			}

			$item = array_shift( $items );
			return $item['name'];
		}
	}

	/**
	 * Setup api data for the the adhoc payment.
	 *
	 * @since 1.4.0 introduced.
	 * @param string $token
	 * @param double $amount_to_charge
	 * @param string $item_name
	 * @param string $item_description
	 *
	 * @return bool|WP_Error
	 */
	public function submit_add_hoc_payment( $token, $amount_to_charge, $item_name, $item_description ) {
		$args = array(
			'body' => array(
				'amount'           => $amount_to_charge * 100, // convert to cents
				'item_name'        => $item_name,
				'item_description' => $item_description,
			),
		);
		return $this->api_request( 'adhoc', $token, $args );
	}

	/**
	 * Send off API request.
	 *
	 * @since 1.4.0 introduced.
	 *
	 * @param $command
	 * @param $token
	 * @param $api_args
	 * @param string $method GET | PUT | POST | DELETE.
	 *
	 * @return bool|WP_Error
	 */
	public function api_request( $command, $token, $api_args, $method = 'POST' ) {
		$api_endpoint  = "https://api.payfast.co.za/subscriptions/$token/$command";
		$api_endpoint .= 'yes' === $this->get_option( 'testmode' ) ? '?testing=true' : '';

		$timestamp = current_time( rtrim( DateTime::ATOM, 'P' ) ) . '+02:00';
		$api_args['timeout'] = 45;
		$api_args['headers'] = array(
			'merchant-id' => $this->merchant_id,
			'timestamp'   => $timestamp,
			'version'     => 'v1',
		);

		// generate signature
		$all_api_variables                = array_merge( $api_args['headers'], (array)$api_args['body'] );
		$api_args['headers']['signature'] = md5( $this->_generate_parameter_string( $all_api_variables ) );
		$api_args['method']               = strtoupper( $method );

		$results = wp_remote_request( $api_endpoint, $api_args );

		if ( 200 !== $results['response']['code'] ) {
			return new WP_Error( $results['response']['code'], $results['response']['message'], $results );
		}

		return true;
	}

	/**
	 * Responds to Subscriptions extension cancellation event.
	 *
	 * @since 1.4.0 introduced.
	 * @param WC_Subscription $subscription
	 */
	public function cancel_subscription_listener( $subscription ) {
		$token = $this->_get_subscription_token( $subscription );
		if ( empty( $token ) ) {
			return;
		}
		$this->api_request( 'cancel', $token, array(), 'PUT' );
	}

	/**
	 * @since 1.4.0
	 * @param string $token
	 *
	 * @return bool|WP_Error
	 */
	public function cancel_pre_order_subscription( $token ) {
		return $this->api_request( 'cancel', $token, array(), 'PUT' );
	}

	/**
	 * @since 1.4.0 introduced.
	 * @param      $api_data
	 * @param bool $sort_data_before_merge? default true.
	 * @param bool $skip_empty_values Should key value pairs be ignored when generating signature?  Default true.
	 *
	 * @return string
	 */
	protected function _generate_parameter_string( $api_data, $sort_data_before_merge = true, $skip_empty_values = true ) {

		// if sorting is required the passphrase should be added in before sort.
		if ( ! empty( $this->pass_phrase ) && $sort_data_before_merge ) {
			$api_data['passphrase'] = $this->pass_phrase;
		}

		if ( $sort_data_before_merge ) {
			ksort( $api_data );
		}

		// concatenate the array key value pairs.
		$parameter_string = '';
		foreach ( $api_data as $key => $val ) {

			if ( $skip_empty_values && empty( $val ) ) {
				continue;
			}

			if ( 'signature' !== $key ) {
				$val = urlencode( $val );
				$parameter_string .= "$key=$val&";
			}
		}
		// when not sorting passphrase should be added to the end before md5
		if ( $sort_data_before_merge ) {
			$parameter_string = rtrim( $parameter_string, '&' );
		} elseif ( ! empty( $this->pass_phrase ) ) {
			$parameter_string .= 'passphrase=' . urlencode( $this->pass_phrase );
		} else {
			$parameter_string = rtrim( $parameter_string, '&' );
		}

		return $parameter_string;
	}

	/**
	 * @since 1.4.0 introduced.
	 * @param WC_Order $order
	 */
	public function process_pre_order_payments( $order ) {

		// The total amount to charge is the the order's total.
		$total = $order->get_total() - $this->get_pre_order_fee( $order->id );
		$token = $this->_get_pre_order_token( $order );

		if ( ! $token ) {
			return;
		}
		// get the payment token and attempt to charge the transaction
		$item_name = 'pre-order';
		$results = $this->submit_add_hoc_payment( $token, $total, $item_name );

		if ( is_wp_error( $results ) ) {
			$order->update_status( 'failed', sprintf( __( 'PayFast Pre-Order payment transaction failed (%s:%s)', 'woocommerce-gateway-payfast' ), $results->get_error_code() ,$results->get_error_message() ) );
			return;
		}

		// Payment completion will be handled by ITN callback
	}

	/**
	 * Setup constants.
	 *
	 * Setup common values and messages used by the PayFast gateway.
	 *
	 * @since 1.0.0
	 */
	public function setup_constants() {
		//// Create user agent string
		define( 'PF_SOFTWARE_NAME', 'WooCommerce' );
		define( 'PF_SOFTWARE_VER', WC_VERSION );
		define( 'PF_MODULE_NAME', 'WooCommerce-PayFast-Free' );
		define( 'PF_MODULE_VER', $this->version );

		// Features
		// - PHP
		$pfFeatures = 'PHP ' . phpversion() .';';

		// - cURL
		if ( in_array( 'curl', get_loaded_extensions() ) ) {
			define( 'PF_CURL', '' );
			$pfVersion = curl_version();
			$pfFeatures .= ' curl '. $pfVersion['version'] .';';
		} else {
			$pfFeatures .= ' nocurl;';
		}

		// Create user agrent
		define( 'PF_USER_AGENT', PF_SOFTWARE_NAME .'/'. PF_SOFTWARE_VER .' ('. trim( $pfFeatures ) .') '. PF_MODULE_NAME .'/'. PF_MODULE_VER );

		// General Defines
		define( 'PF_TIMEOUT', 15 );
		define( 'PF_EPSILON', 0.01 );

		// Messages
		// Error
		define( 'PF_ERR_AMOUNT_MISMATCH', __( 'Amount mismatch', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_BAD_ACCESS', __( 'Bad access of page', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_BAD_SOURCE_IP', __( 'Bad source IP address', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_CONNECT_FAILED', __( 'Failed to connect to PayFast', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_INVALID_SIGNATURE', __( 'Security signature mismatch', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_MERCHANT_ID_MISMATCH', __( 'Merchant ID mismatch', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_NO_SESSION', __( 'No saved session found for ITN transaction', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_ORDER_ID_MISSING_URL', __( 'Order ID not present in URL', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_ORDER_ID_MISMATCH', __( 'Order ID mismatch', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_ORDER_INVALID', __( 'This order ID is invalid', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_ORDER_NUMBER_MISMATCH', __( 'Order Number mismatch', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_ORDER_PROCESSED', __( 'This order has already been processed', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_PDT_FAIL', __( 'PDT query failed', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_PDT_TOKEN_MISSING', __( 'PDT token not present in URL', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_SESSIONID_MISMATCH', __( 'Session ID mismatch', 'woocommerce-gateway-payfast' ) );
		define( 'PF_ERR_UNKNOWN', __( 'Unkown error occurred', 'woocommerce-gateway-payfast' ) );

		// General
		define( 'PF_MSG_OK', __( 'Payment was successful', 'woocommerce-gateway-payfast' ) );
		define( 'PF_MSG_FAILED', __( 'Payment has failed', 'woocommerce-gateway-payfast' ) );
		define( 'PF_MSG_PENDING',
			__( 'The payment is pending. Please note, you will receive another Instant', 'woocommerce-gateway-payfast' ).
			__( ' Transaction Notification when the payment status changes to', 'woocommerce-gateway-payfast' ).
			__( ' "Completed", or "Failed"', 'woocommerce-gateway-payfast' )
		);

		do_action( 'woocommerce_gateway_payfast_setup_constants' );
	}

	/**
	 * Log system processes.
	 * @since 1.0.0
	 */
	public function log( $message ) {
		if ( 'yes' === $this->get_option( 'testmode' ) ) {
			if ( ! $this->logger ) {
				$this->logger = new WC_Logger();
			}
			$this->logger->add( 'payfast', $message );
		}
	}

	/**
	 * validate_signature()
	 *
	 * Validate the signature against the returned data.
	 *
	 * @param array $data
	 * @param string $signature
	 * @since 1.0.0
	 * @return string
	 */
	public function validate_signature( $data, $signature ) {
	    $result = $data['signature'] === $signature;
	    $this->log( 'Signature = '. ( $result ? 'valid' : 'invalid' ) );
	    return $result;
	}

	/**
	 * validate_ip()
	 *
	 * Validate the IP address to make sure it's coming from PayFast.
	 *
	 * @param array $sourceIP
	 * @since 1.0.0
	 * @return bool
	 */
	public function validate_ip( $sourceIP ) {
	    // Variable initialization
	    $validHosts = array(
	        'www.payfast.co.za',
	        'sandbox.payfast.co.za',
	        'w1w.payfast.co.za',
	        'w2w.payfast.co.za',
	    );

	    $validIps = array();

	    foreach( $validHosts as $pfHostname ) {
	        $ips = gethostbynamel( $pfHostname );

	        if ( $ips !== false ) {
	            $validIps = array_merge( $validIps, $ips );
			}
	    }

	    // Remove duplicates
	    $validIps = array_unique( $validIps );

	    $this->log( "Valid IPs:\n". print_r( $validIps, true ) );

	    return in_array( $sourceIP, $validIps );
	}

	/**
	 * validate_response_data()
	 *
	 * @param array $post_data
	 * @param string $proxy Address of proxy to use or NULL if no proxy.
	 * @since 1.0.0
	 * @return bool
	 */
	public function validate_response_data( $post_data, $proxy = null ) {
		$this->log( 'Host = '. $this->validate_url );
		$this->log( 'Params = '. print_r( $post_data, true ) );

		if ( ! is_array( $post_data ) ) {
			return false;
		}

		$response = wp_remote_post( $this->validate_url, array(
			'body'       => $post_data,
			'timeout'    => 70,
			'user-agent' => PF_USER_AGENT
		));

		if ( is_wp_error( $response ) || empty( $response['body'] ) ) {
			return false;
		}

		parse_str( $response['body'], $parsed_response );

		$response = $parsed_response;

		$this->log( "Response:\n" . print_r( $response, true ) );

		// Interpret Response
		if ( is_array( $response ) && in_array( 'VALID', array_keys( $response ) ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * amounts_equal()
	 *
	 * Checks to see whether the given amounts are equal using a proper floating
	 * point comparison with an Epsilon which ensures that insignificant decimal
	 * places are ignored in the comparison.
	 *
	 * eg. 100.00 is equal to 100.0001
	 *
	 * @author Jonathan Smit
	 * @param $amount1 Float 1st amount for comparison
	 * @param $amount2 Float 2nd amount for comparison
	 * @since 1.0.0
	 * @return bool
	 */
	public function amounts_equal ( $amount1, $amount2 ) {
		return ! ( abs( floatval( $amount1 ) - floatval( $amount2 ) ) > PF_EPSILON );
	}
}
