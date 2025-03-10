<?php
/**
 * Class WC_Email_Customer_Shipped_Order file.
 *
 * @package WooCommerce\Emails
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Email_Customer_Shipped_Order', false ) ) :

	/**
	 * Customer Shipped Order Email.
	 *
	 * An email sent to the customer when a new order is paid for.
	 *
	 * @class       WC_Email_Customer_Shipped_Order
	 * @version     3.5.0
	 * @package     WooCommerce/Classes/Emails
	 * @extends     WC_Email
	 */
	class WC_Email_Customer_Shipped_Order extends WC_Email {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id             = 'customer_shipped_order';
			$this->customer_email = true;

			$this->title          = __( 'Shipped order', 'woocommerce' );
			$this->description    = __( 'This is an order notification sent to customers containing order details after payment.', 'woocommerce' );
			$this->template_html  = 'emails/customer-shipped-order.php';
			$this->template_plain = 'emails/plain/customer-processing-order.php';
			$this->placeholders   = array(
				'{site_title}'   => $this->get_blogname(),
				'{order_date}'   => '',
				'{order_number}' => '',
			);

			// Triggers for this email.
			add_action( 'woocommerce_order_status_cancelled_to_shipped_notification', array( $this, 'trigger' ), 10, 2 );
			add_action( 'woocommerce_order_status_failed_to_shipped_notification', array( $this, 'trigger' ), 10, 2 );
			add_action( 'woocommerce_order_status_on-hold_to_shipped_notification', array( $this, 'trigger' ), 10, 2 );
			add_action( 'woocommerce_order_status_pending_to_shipped_notification', array( $this, 'trigger' ), 10, 2 );

			// Call parent constructor.
			parent::__construct();
		}

		/**
		 * Get email subject.
		 *
		 * @since  3.1.0
		 * @return string
		 */
		public function get_default_subject() {
			return __( 'Your {site_title} order has been shipped!', 'woocommerce' );
		}

		/**
		 * Get email heading.
		 *
		 * @since  3.1.0
		 * @return string
		 */
		public function get_default_heading() {
			$order_contact = '<div id="shipped_header">
				<div id="shipped_header_up" style="display: flex; align-item: center; text-align: right;margin-bottom: 10px;">
					<strong>US Toll Free : </strong>
					<a href="tel:18779251112"  style="text-decoration: none;">+1(877) 925-1112</a>
				</div>
				<div id="shipped_header_down"  style="display: flex; align-item: center; text-align: right;">
					<strong>Whatsapp : </strong>
					<a href="javascript:void(0)" style="text-decoration: none;">+1(877) 925-1112</a>
				</div>
			</div>';
			return __( $order_contact, 'woocommerce' );
		}

		/**
		 * Trigger the sending of this email.
		 *
		 * @param int            $order_id The order ID.
		 * @param WC_Order|false $order Order object.
		 */
		public function trigger( $order_id, $order = false ) {
			$this->setup_locale();

			if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
				$order = wc_get_order( $order_id );
			}

			if ( is_a( $order, 'WC_Order' ) ) {
				$this->object                         = $order;
				$this->recipient                      = $this->object->get_billing_email();
				$this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
				$this->placeholders['{order_number}'] = $this->object->get_order_number();
			}

			if ( $this->is_enabled() && $this->get_recipient() ) {
				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}

			$this->restore_locale();
		}

		/**
		 * Get content html.
		 *
		 * @return string
		 */
		public function get_content_html() {
			return wc_get_template_html(
				$this->template_html,
				array(
					'order'         => $this->object,
					'email_heading' => $this->get_heading(),
					'sent_to_admin' => false,
					'plain_text'    => false,
					'email'         => $this,
				)
			);
		}

		/**
		 * Get content plain.
		 *
		 * @return string
		 */
		public function get_content_plain() {
			return wc_get_template_html(
				$this->template_plain,
				array(
					'order'         => $this->object,
					'email_heading' => $this->get_heading(),
					'sent_to_admin' => false,
					'plain_text'    => true,
					'email'         => $this,
				)
			);
		}
	}

endif;

return new WC_Email_Customer_Shipped_Order();