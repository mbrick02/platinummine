<?php
class Paypal extends Trongate {
	function ipn_listener() {
		$posted_data = file_get_contents('php://input');
		$params = json_decode($posted_data, true);

		$data['posted_information'] = serialize($params);
		$data['date_created'] = time();
		$store_order_data['ipn_id'] = $this->model->insert($data, 'paypal');

		if (isset($params['custom'])) {
			$this->module('encryption');
			error_reporting(0);
			$customer_session_id = $this->encryption->_decrypt($params['custom']);

			if ($customer_session_id !== false) {
				// customer session_id appears to be okay - probably order

				// attempt to fetch from store_basket where session _id = customer_session_id
				// $items = $this->model->get_many_where('session_id', $customer_session_id, 'store_basket');

				$sql = 'SELECT store_items.item_price,
						store_item_colors.item_color,
						store_item_sizes.item_size,
						store_basket.*
						FROM
						store_basket
						LEFT JOIN store_items
						ON store_basket.item_id = store_items.id 
						LEFT JOIN store_item_colors
						ON store_basket.item_color_id = store_item_colors.id 
						LEFT JOIN store_item_sizes
						ON store_basket.item_size_id = store_item_sizes.id 
						WHERE store_basket.session_id = :session_id';

				$query_data['session_id'] = $customer_session_id;
				$items = $this->model->query_bind($sql, $query_data, 'object');

				foreach ($items as $store_basket_item) {
					$shopper_id = $store_basket_item->shopper_id;
					$ip_address = $store_basket_item->ip_address;
				}


				if (count($items)>0) {
					//this must be a new order!
					$store_order_data['tracking_url'] = ''; // created by shipping co.
					$store_order_data['date_created'] = time();
					$store_order_data['order_ref'] = make_rand_str(6, true); // true = uppercase

					$store_order_data['shopper_id'] = $shopper_id;
					$store_order_data['ip_address'] = $ip_address;

					$store_order_data['mc_gross'] = 0;
					if (isset($params['mc_gross'])) {
						$store_order_data['mc_gross'] = $params['mc_gross'];
					}


					$store_order_data['mc_shipping'] = 0;
					if (isset($params['mc_shipping'])) {
						$store_order_data['mc_shipping'] = $params['mc_shipping'];
					}

					$store_order_data['store_order_status_levels_id'] = '1'; // order submitted
					$order_id = $this->model->insert($store_order_data, 'store_orders');
					$this->_transfer_to_store_shoppertrack($order_id, $items);
					echo 'New Order Inserted';
				}
			}
		}
	}

	function _transfer_to_store_shoppertrack($order_id, $store_basket_items) {
		// id	order_id	item_id	item_title	item_price	item_qty	item_color	item_size

		foreach ($store_basket_items as $store_basket_item) {
			$store_shoppertrack_data['order_id'] = $order_id;
			$store_shoppertrack_data['item_id'] = $store_basket_item->item_id;

			if (isset($store_basket_item->item_title)) {
				$store_shoppertrack_data['item_title'] = $store_basket_item->item_title;
			} else {
				$store_shoppertrack_data['item_title'] = '';
			}

			$store_shoppertrack_data['item_price'] = $store_basket_item->item_price;
			$store_shoppertrack_data['item_qty'] = $store_basket_item->item_qty;

			if (isset($store_basket_item->item_color)) {
				$store_shoppertrack_data['item_color'] = $store_basket_item->item_color;
			} else {
				$store_shoppertrack_data['item_color'] = '';
			}			
			
			if (isset($store_basket_item->item_size)) {
				$store_shoppertrack_data['item_size'] = $store_basket_item->item_size;
			} else {
				$store_shoppertrack_data['item_size'] = '';
			}
			
			$this->model->insert($store_shoppertrack_data, 'store_shoppertrack');
		}

		$sql = 'delete from store_basket where session_id = :session_id';
		$params['session_id'] = $store_basket_item->session_id;
		$this->model->query_bind($sql, $params);
	}

	function thankyou() {
		// give the user a new session_id -- make sure can't use old order sesssion_id AGAIN
		session_regenerate_id();

		$data['view_module'] = 'paypal';
		$data['view_file'] = 'thankyou';
		$this->template('public_defiant', $data);
	}

	function cancel() {
		$data['view_module'] = 'paypal';
		$data['view_file'] = 'cancel';
		$this->template('public_defiant', $data);
	}

	function _draw_checkout_btn($data) {
		$this->module('encryption');
		$data['custom'] = $this->encryption->_encrypt(session_id());
		$data['view_module'] = 'paypal';
		$this->view('checkout_btn', $data);
	}

	/* function test() {
		$string = 'hello';

		$this->module('encryption');
		$enc_string = $this->encryption->_encrypt($string);;

		echo $string;
		echo '<hr>';
		echo $enc_string;
		echo '<hr>';

		$decrypted_string = $this->encryption->_decrypt($enc_string);

		echo $decrypted_string;
	} */

	/* function test() {
		$this->view('test_btn');
	} */
}