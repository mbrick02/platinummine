<?php 
class Contactus extends Trongate {
	function submit () {
		$submit = $this->input('submit');

		if ($submit == 'Submit') {
			$this->validation_helper->set_rules('your_name', 'name', 'required|min_length[4]|max_lenght[65]');
			$this->validation_helper->set_rules('your_email', 'email address', 'required|valid_email');
			$this->validation_helper->set_rules('your_telnum', 'telephone number', 'required|min_length[7]|max_lenght[25]');
			$this->validation_helper->set_rules('your_message', 'message', 'required|min_length[10]');

			$result = $this->validation_helper->run();

			if ($result == true) {
				echo 'well done';
			} else {
				$this->index();
			}
		}
	}

	function index() {
		$data = $this->_get_data_from_post();
		$data['form_location'] = BASE_URL.'contactus/submit';
		$data['view_module'] = 'contactus';
		$data['view_file'] = 'contactus';
		$this->template('public_defiant', $data);
	}

	function _get_data_from_post() {
		$data['your_name'] = $this->input('your_name');
		$data['your_email'] = $this->input('your_email');
		$data['your_telnum'] = $this->input('your_telnum');
		$data['your_message'] = $this->input('your_message');
		return $data;
	}
}