<?php 
class Store_basket extends Trongate {
	function goto_checkout() {
		$data['view_module'] = 'store_basket';
		$data['view_file'] = 'create_account_invite';
		$this->template('public_defiant', $data);
	}

	function _attempt_draw_checkout_btn($data) {
		if (count($data['rows'])>0) {  // items in the basket
			if ($data['shopper_id']>0) {
				// draw the real (Paypal) checkout btn
				$this->module('paypal');
				$this->paypal->_draw_checkout_btn($data);
			} else {
				$this->view('fake_checkout_btn');
			}
		}
	}

	function _get_shopper_id() {
		$this->module('store_accounts');
		$shopper_id = $this->store_accounts->_get_shopper_id();
		return $shopper_id;
	}

	function checkout() {
		$this->display();  // display with shopper(_id) info
	}

	function display() {
		// load necessary modules
		$this->module('shipping');
		$this->module('store_items');

		// fetch items from the basket
		$picture_settings = $this->store_items->_init_picture_settings();
		$data['picture_dir'] = $picture_settings['thumbnailDir'];

		$sql = 'SELECT
				store_items.item_title,
				store_items.item_code,
				store_items.item_price,
				store_items.picture,
				store_items.id as item_id,
				store_basket.`code`,
				store_basket.item_qty,
				store_item_colors.item_color,
				store_item_sizes.item_size
				FROM
				store_basket
				JOIN store_items
				ON store_basket.item_id = store_items.id 
				LEFT JOIN store_item_colors
				ON store_basket.item_color_id = store_item_colors.id 
				LEFT JOIN store_item_sizes
				ON store_basket.item_size_id = store_item_sizes.id 
				WHERE store_basket.session_id = :session_id';

		$params['session_id'] = session_id();
		$data['rows'] = $this->model->query_bind($sql, $params, 'object');

		switch (count($data['rows'])) {
			case 0:
				$data['info'] = 'Your shopping basket is currently empty.';
				break;
			case 1:
				$data['info'] = 'Your have one item in your shopping basket.';
				break;
			default:
				$data['info'] = 'Your have ' .count ($data['rows']).' items in your shopping basket.';
				break;
		}

		if (count($data['rows'])>0) {
			$data['additional_table_code'] = ''; // show the basket table
		} else {
			$data['additional_table_code'] = ' style="display: none;"';
		}

		$data['shopper_id'] = $this->_get_shopper_id();

		if ($data['shopper_id']>0) {
			// make sure basket is assigned this shopper_id
			$basket_data['shopper_id'] = $data['shopper_id'];
			$basket_data['session_id'] = session_id();
			$sql = 'update store_basket set shopper_id = :shopper_id where session_id = :session_id';
			$this->model->query_bind($sql, $basket_data);
		}

		$data['shipping'] = $this->shipping->_calc_shipping();
		$data['view_module'] = 'store_basket';
		$data['view_file'] = 'display';
		$this->template('public_defiant', $data);
	}

	function remove($code) { // Trongate get $code $_GET var from end of url
		if (strlen($code) == 32) {
			$sql = 'delete from store_basket where code = :code';
			$params['code'] = $code;
			$this->model->query_bind($sql, $params);
		}

		redirect('store_basket/display');
	}

	function add_to_basket() {
		$errors = [];

		if (isset($_POST['item_color_id'])) {
			$data['item_color_id'] = $this->input('item_color_id');

			if ($data['item_color_id'] == 0) {
				$errors[] = 'You did not select an item color.';
			}
		}

		if (isset($_POST['item_size_id'])) {
			$data['item_size_id'] = $this->input('item_size_id');

			if ($data['item_size_id'] == 0) {
				$errors[] = 'You did not select an item size.';
			}
		}

		$data['item_qty'] = $this->input('item_qty');
		if ($data['item_qty'] == 0) {
			$errors[] = 'You did not select an item quantity.';
		}

		if (count($errors)>0) {
			$error_msg = '';
			foreach ($errors as $error) {
				$error_msg.= '<p style="margin: 0.2em; color: red;">'. $error.'</p>';
			}

			set_flashdata($error_msg);
			// send the user back to the previous page
			redirect(previous_url());
		} else {
			// insert into store_basket
			$data['code'] = make_rand_str(32);
			$data['session_id'] = session_id();
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$data['item_id'] = $this->input('item_id');
			$data['item_color_id'] = $this->input('item_color_id');
			if (!is_numeric($data['item_color_id'])) { //for MySQL "strict" mode err
				$data['item_color_id'] = 0;
			}

			$data['item_size_id'] = $this->input('item_size_id');
			if (!is_numeric($data['item_size_id'])) { // stops MySQL "strict" mode error
				$data['item_size_id'] = 0;
			}

			$data['item_qty'] = $this->input('item_qty');
			$data['date_added'] = time();
			$data['shopper_id'] = $this->_get_shopper_id();

			$this->model->insert($data, 'store_basket');

			redirect('store_basket/display');
		}
	}
}