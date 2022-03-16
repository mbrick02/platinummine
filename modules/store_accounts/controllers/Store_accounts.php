<?php
class Store_accounts extends Trongate {
    function _get_shopper_id() {
        $shopper_id = 0;

        // attempt to get trongate token
        $this->module('trongate_tokens');
        $token = $this->trongate_tokens->_attempt_get_valid_token(2);

        if ($token == false) {
            return $shopper_id;
        } else {
            // get shopper id is store_accounts->(user)id
            // store_accounts->trongate_user_id links trongate_tokens->user_id
            $sql = 'SELECT
                    store_accounts.id
                    FROM
                    store_accounts
                    JOIN trongate_tokens
                    ON store_accounts.trongate_user_id = trongate_tokens.user_id
                    WHERE trongate_tokens.token = :token';

            $params['token'] = $token;
            $rows = $this->model->query_bind($sql, $params, 'object');

            if (count($rows) == 0) {
                // no record found
                return $shopper_id;  // return 0 for none found
            } else {
                // get the id (of user) from the rows
                $user_obj = $rows[0]; // 1st object
                $shopper_id = $user_obj->id;
                return $shopper_id;
            }

        }

        return $shopper_id;
    }

    function no_thanks() {
        // customer does not want to create an account

        // make sure they have items in basket
        $got_items = $this->_got_items();

        if ($got_items == false) {
            redirect(BASE_URL); // mostly for spam bots
        } else {
            // create a guest account fo this user
            $data['first_name'] = 'Guest Account '.make_rand_str(4, true);
            // make guest account unique;
            $data['last_name'] = '';
            $data['company'] = '';
            $data['street_address'] = '';
            $data['address_line_2'] = '';
            $data['city'] = '';
            $data['state'] = '';
            $data['zip_code'] = '';
            $data['telephone_number'] = '';
            $data['email'] = '';
            $data['date_created'] = '';
            $data['pword'] = '';

            // insert a new trongate_user record
            $trongate_user_data['code'] = make_rand_str(32);
            $trongate_user_data['user_level_id'] = 2;  // 2 = customer
            $data['trongate_user_id'] = $this->model->insert($trongate_user_data, 'trongate_users');
            $update_id = $this->model->insert($data, 'store_accounts');

            // automatically give this user a token (since they now have a guest account)
            $this->module('trongate_tokens');
            $token_data['user_id'] = $update_id;

            // set short term token (session)
            $_SESSION['trongatetoken'] = $this->trongate_tokens->_generate_token($token_data);
            redirect('store_basket/checkout');
        }
    }

    function login() {
        $data['form_location'] = str_replace('/login', '/submit_login', current_url());
        $data['view_module'] = 'store_accounts';
        $data['view_file'] = 'login';
        $this->template('public_defiant', $data);
    }

    function start() {
        $data['form_location'] = str_replace('/start', '/submit_create_account', current_url());
        $data['view_module'] = 'store_accounts';
        $data['view_file'] = 'create_new_account';
        $this->template('public_defiant', $data);
    }

    function manage() {
        $this->module('security');
        $data['token'] = $this->security->_make_sure_allowed();
        $data['order_by'] = 'id';

        //format the pagination
        $data['total_rows'] = $this->model->count('store_accounts');
        $data['record_name_plural'] = 'store accounts';

        $data['headline'] = 'Manage Store Accounts';
        $data['view_module'] = 'store_accounts';
        $data['view_file'] = 'manage';

        $this->template('admin', $data);
    }

    function show() {
        $this->module('security');
        $token = $this->security->_make_sure_allowed();

        $update_id = $this->url->segment(3);

        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('store_accounts/manage');
        }

        $data = $this->_get_data_from_db($update_id);
        $data['token'] = $token;

        if ($data == false) {
            redirect('store_accounts/manage');
        } else {
            $data['form_location'] = BASE_URL.'store_accounts/submit/'.$update_id;
            $data['update_id'] = $update_id;
            $data['headline'] = 'Store Account Information';
            $data['view_file'] = 'show';
            $this->template('admin', $data);
        }
    }

    function create() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $update_id = $this->url->segment(3);
        $submit = $this->input('submit', true);

        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('store_accounts/manage');
        }

        //fetch the form data
        if (($submit == '') && ($update_id > 0)) {
            $data = $this->_get_data_from_db($update_id);
        } else {
            $data = $this->_get_data_from_post();
        }

        $data['headline'] = $this->_get_page_headline($update_id);

        if ($update_id > 0) {
            $data['cancel_url'] = BASE_URL.'store_accounts/show/'.$update_id;
            $data['btn_text'] = 'UPDATE STORE ACCOUNT DETAILS';
        } else {
            $data['cancel_url'] = BASE_URL.'store_accounts/manage';
            $data['btn_text'] = 'CREATE STORE ACCOUNT RECORD';
        }

        $additional_includes_top[] = 'https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css';
        $additional_includes_top[] = 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css';
        $additional_includes_top[] = 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"';
        $additional_includes_top[] = 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js';
        $additional_includes_top[] = BASE_URL.'admin_files/js/i18n/jquery-ui-timepicker-addon-i18n.min.js';
        $additional_includes_top[] = BASE_URL.'admin_files/js/jquery-ui-sliderAccess.js';
        $data['additional_includes_top'] = $additional_includes_top;

        $data['form_location'] = BASE_URL.'store_accounts/submit/'.$update_id;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'create';
        $this->template('admin', $data);
    }

    function _get_page_headline($update_id) {
        //figure out what the page headline should be (on the store_accounts/create page)
        if (!is_numeric($update_id)) {
            $headline = 'Create New Store Account Record';
        } else {
            $headline = 'Update Store Account Details';
        }

        return $headline;
    }

    function _hash_string($str) {
        $hashed_string = password_hash($str, PASSWORD_BCRYPT, array(
            'cost' => 11
        ));
        return $hashed_string;
    }

    function _verify_hash($plain_text_str, $hashed_string) {
        $result = password_verify($plain_text_str, $hashed_string);
        return $result; //TRUE or FALSE
    }

    function submit_create_account() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $submit = $this->input('submit', true);

        if ($submit == 'Create Account') {
            $this->validation_helper->set_rules('email', 'Email', 
                'required|min_length[7]|max_length[255]|valid_email|callback_create_account_check');
            $this->validation_helper->set_rules('pword', 'Password', 'required|min_length[6]|max_length[65]');
            // $this->validation_helper->set_rules('pword_repeat', 'Password Repeat', 'required|matches[pword]');  
            // pword matches[] currently (20/05) has error  (uses field name) -- see callback_creat_acc...
            $this->validation_helper->set_rules('pword_repeat', 'Password Repeat', 'required');

            // Note: matches validation

            $result = $this->validation_helper->run();

            if ($result == true) {
                //insert the new record
                $data['email'] = $this->input('email');
                $pword = $this->input('pword');
                $data['pword'] = $this->_hash_string($pword);
                $data['date_created'] = time();

                // insert a new trongate_user record
                $trongate_user_data['code'] = make_rand_str(32);
                $trongate_user_data['user_level_id'] = 2;  // 2 = customer
                $data['trongate_user_id'] = $this->model->insert($trongate_user_data, 'trongate_users');

                // in case MySQL is in 'strict' mode -- avoid nulls
                $data['first_name'] = '';  // may want first_name as an option
                $data['last_name'] = '';  // may want last_name as an option
                $data['company'] = '';
                $data['street_address'] = '';
                $data['address_line_2'] = '';
                $data['city'] = '';
                $data['state'] = '';
                $data['zip_code'] = '';
                $data['telephone_number'] = '';

                $update_id = $this->model->insert($data, 'store_accounts');
                $flash_msg = 'Your new account was successfully created. Please login now.';

                redirect('store_accounts/login');

            } else {

                //form submission error
                $this->start();
            }

        }
    }

    function submit() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('first_name', 'First Name', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('last_name', 'Last Name', 'required|min_length[2]|max_length[85]');
            $this->validation_helper->set_rules('company', 'Company', 'min_length[2]|max_length[150]');
            $this->validation_helper->set_rules('street_address', 'Street Address', 'required|max_length[255]');
            $this->validation_helper->set_rules('address_line_2', 'Address Line 2', 'max_length[255]');
            $this->validation_helper->set_rules('city', 'City', 'min_length[4]|max_length[45]');
            $this->validation_helper->set_rules('state', 'State', 'min_length[2]|max_length[48]');
            $this->validation_helper->set_rules('zip_code', 'Zip Code', 'min_length[2]|max_length[10]|required');
            $this->validation_helper->set_rules('telephone_number', 'Telephone Number', 'min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('email', 'Email', 'min_length[7]|max_length[255]|valid email address|valid_email');

            $result = $this->validation_helper->run();

            if ($result == true) {

                $update_id = $this->url->segment(3);
                $data = $this->_get_data_from_post();
                if (is_numeric($update_id)) {
                    //update an existing record
                    $this->model->update($update_id, $data, 'store_accounts');
                    $flash_msg = 'The record was successfully updated';
                } else {
                    //insert the new record
                    $data['date_created'] = time();
                    $data['pword'] = '';

                    // insert a new trongate_user record
                    $trongate_user_data['code'] = make_rand_str(32);
                    $trongate_user_data['user_level_id'] = 2;  // 2 = customer
                    $data['trongate_user_id'] = $this->model->insert($trongate_user_data, 'trongate_users');


                    $update_id = $this->model->insert($data, 'store_accounts');
                    $flash_msg = 'The record was successfully created';
                }

                set_flashdata($flash_msg);
                redirect('store_accounts/show/'.$update_id);

            } else {
                //form submission error
                $this->create();
            }

        }
    }

    function _got_items() {
        $num_items = $this->model->count_rows('session_id', session_id(), 'store_basket');

        if ($num_items>0) {
            return true; // got item(s) in basket
        } else {
            return false; // no items in basket
        }
    }

    function submit_login() {
        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {
            $this->validation_helper->set_rules('email', 'Email Address', 'required|valid_email|callback_email_check');

            $result = $this->validation_helper->run();

            if ($result == true) {
                // has this user gotone or more items inthe shopping basket
                $got_items = $this->_got_items();

                if ($got_items == true) {
                    redirect('store_basket/checkout');
                } else {
                    redirect('your_account');
                }
            } else {
                //form submission error
                //  validation_errors() sent to ?$_SESSION
                $this->login();
            }

        }

    }

    function submit_delete() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {
            $update_id = $this->url->segment(3);

            if (!is_numeric($update_id)) {
                die();
            } else {
                $data['update_id'] = $update_id;

                //delete all of the comments associated with this record
                $sql = 'delete from comments where target_table = :module and update_id = :update_id';
                $data['module'] = $this->module;
                $this->model->query_bind($sql, $data);

                //delete the record
                $this->model->delete($update_id, $this->module);

                //set the flashdata
                $flash_msg = 'The record was successfully deleted';
                set_flashdata($flash_msg);

                //redirect to the manage page
                redirect('store_accounts/manage');
            }
        }
    }

    function _get_data_from_db($update_id) {
        $store_accounts = $this->model->get_where($update_id, 'store_accounts');

        if ($store_accounts == false) {
            $this->template('error_404');
            die();
        } else {
            $data['date_created'] = date('F jS, Y \a\t h:i A', $store_accounts->date_created);
            $data['first_name'] = $store_accounts->first_name;
            $data['last_name'] = $store_accounts->last_name;
            $data['company'] = $store_accounts->company;
            $data['street_address'] = $store_accounts->street_address;
            $data['address_line_2'] = $store_accounts->address_line_2;
            $data['city'] = $store_accounts->city;
            $data['state'] = $store_accounts->state;
            $data['zip_code'] = $store_accounts->zip_code;
            $data['telephone_number'] = $store_accounts->telephone_number;
            $data['email'] = $store_accounts->email;
            return $data;
        }
    }

    function _get_data_from_post() {
        $data['first_name'] = $this->input('first_name', true);
        $data['last_name'] = $this->input('last_name', true);
        $data['company'] = $this->input('company', true);
        $data['street_address'] = $this->input('street_address', true);
        $data['address_line_2'] = $this->input('address_line_2', true);
        $data['city'] = $this->input('city', true);
        $data['state'] = $this->input('state', true);
        $data['zip_code'] = $this->input('zip_code', true);
        $data['telephone_number'] = $this->input('telephone_number', true);
        $data['email'] = $this->input('email', true);
        return $data;
    }

    function create_account_check($email) { // callback for submit_create_account
        // return EITHER a string (error) or true (bool)
        // make sure the email account is available
        $account = $this->model->get_one_where('email', $email, 'store_accounts');

        if ($account !== false) {
            // this email must be in use!
            $error = 'The email address that you submitted appears to be in use.';
            return $error;
        } else {
            // the email address is available
            $pword = $this->input('pword');
            $pword_repeat = $this->input('pword');

            if ($pword !== $pword_repeat) {
                $error = 'The repeat password field must match the password field.';
                return $error;
            } else {
                return true;
            }
        }
    }

    function email_check($email) {
        $error = 'Your email and/or password was not valid.';
        // Model->get_one_where($column, $value, $target_tbl)
        $user_obj = $this->model->get_one_where('email', $email, 'store_accounts');

        if ($user_obj == false) {
            // email was NOT valid
            return $error;
        } else {
            // email was correct

            // check to see if the password was correct
            $pword = $this->input('pword');
            $password_result = $this->_verify_hash($pword, $user_obj->pword);

            if ($password_result == false) {
                // wrong password
                return $error;
            } else {
                // password was correct
                $remember = $this->input('remember');
                $this->module('trongate_tokens');
                $token_data['user_id'] = $user_obj->trongate_user_id;

                if ($remember == 1) {
                    // set token for 30 days (cookie)
                    $thirty_days = 86400*30; // number of seconds in 30days
                    $nowtime = time();
                    $token_data['expiry_date'] =  $nowtime+$thirty_days; // 30 days ahead as timestamp
                    $token_data['set_cookie'] = true;
                    $this->trongate_tokens->_generate_token($token_data); // generate token & set cookie
                } else {
                    // set short term token (session)
                    $_SESSION['trongatetoken'] = $this->trongate_tokens->_generate_token($token_data);
                }

                return true;
            }
        }
    }

}