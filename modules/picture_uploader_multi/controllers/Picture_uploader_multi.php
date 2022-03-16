<?php
class Picture_uploader_multi extends Trongate {

    function upload() {

        api_auth();
        $target_module = $this->url->segment(3);
        $update_id = $this->url->segment(4);

        if (($target_module == '') || (!is_numeric($update_id))) {
            http_response_code(422);
            echo 'Invalid target module and/or update_id.';
            die();
        }

        $request_type = $_SERVER['REQUEST_METHOD'];

        if ($request_type == 'DELETE') {
            //remove the picture from the server
            $this->_remove_picture($target_module, $update_id);
        } else {
            //upload the picture
            $this->_do_upload($target_module, $update_id);
        }
    }

    function _do_upload($target_module, $update_id) {

        //get picture settings
        $this->module($target_module);
        $uploader_settings = $this->$target_module->_init_picture_uploader_multi_settings();

        $config['targetModule']     = $target_module;
        $config['maxFileSize']      = $uploader_settings['max_file_size'];
        $config['maxWidth']         = 1400;
        $config['maxHeight']        = 1400;
        $config['resizedMaxWidth']  = $uploader_settings['max_width'];
        $config['resizedMaxHeight'] = $uploader_settings['max_height'];
        $config['destination']      = $uploader_settings['destination'] . '/' . $update_id;

        //Make sure the directory exists.
        if (!is_dir($config['destination'])) {
            //Directory does not exist, so lets create it.
            mkdir($config['destination'], 0755);
        }

        //upload the picture
        $this->upload_picture($config);
        http_response_code(200);
        echo $_FILES['file']['name'];
    }

    function _fetch() {

        $target_module = $this->url->segment(3);
        $update_id = $this->url->segment(4);

        if (($target_module == '') || (!is_numeric($update_id))) {
            http_response_code(422);
            echo 'Invalid target module and/or update_id.';
            die();
        }

        //get the settings
        $this->module($target_module);
        $uploader_settings = $this->$target_module->_init_picture_uploader_multi_settings();
        $pictures = $this->_fetch_pictures($update_id, $uploader_settings);

        http_response_code(200);
        echo json_encode($pictures);
    }

    function uploader() {

        $this->module('security');
        $data['token'] = $this->security->_make_sure_allowed();
        $target_module = $this->url->segment(3);
        $update_id = $this->url->segment(4);

        $this->module($target_module);
        $uploader_settings = $this->$target_module->_init_picture_uploader_multi_settings();
        $data['target_module'] = $uploader_settings['targetModule'];
        $target_module_desc = str_replace("_", " ", $data['target_module']);
        $data['target_module_desc'] = ucwords($target_module_desc);
        $data['update_id'] = $update_id;
        $data['previous_url'] = BASE_URL . $target_module . '/show/' . $update_id;
        $data['api_url'] = BASE_URL.'picture_uploader_multi/upload/' . $target_module . '/' . $update_id;
        $data['headline'] = 'Upload Pictures';
        $data['view_file'] = 'uploader';
        $additional_includes_top[] = 'https://unpkg.com/filepond/dist/filepond.css';
        $additional_includes_top[] = 'https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
        $data['additional_includes_top'] = $additional_includes_top;
        $this->template('admin', $data);
    }

    function _draw_summary_panel($update_id, $uploader_settings) {

        $this->module('security');
        $data['token'] = $this->security->_make_sure_allowed();

        $this->_make_sure_got_sub_folder($update_id, $uploader_settings);

        $data['update_id'] = $update_id;
        $data['target_module'] = $uploader_settings['targetModule'];
        $data['pictures'] = $this->_fetch_pictures($update_id, $uploader_settings);
        $data['target_directory'] = BASE_URL.$data['target_module'].'_pictures/'.$update_id.'/';
        $this->view('multi_summary_panel', $data);
    }

    function _fetch_pictures($update_id, $uploader_settings) {

        $data = [];
        $pictures_directory = $this->_get_pictures_directory($uploader_settings);
        $picture_directory_path = str_replace(BASE_URL, './', $pictures_directory . '/' . $update_id);

        if (is_dir($picture_directory_path)) {

            $pictures = scandir($picture_directory_path);

            foreach ($pictures as $key => $value) {

                if (($value !== '.') && ($value !== '..') && ($value !== '.DS_Store')) {
                    $data[] = $value;
                }

            }

        }

        return $data;
    }

    function _get_pictures_directory($uploader_settings) {

        $target_module = $uploader_settings['targetModule'];
        $directory = $target_module . '_pictures';
        return $directory;
    }

    function _remove_picture($target_module, $update_id) {

        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);

        $picture_name = file_get_contents("php://input");
        $picture_directory = './' . $target_module . '_pictures/' . $update_id;
        $picture_path = $picture_directory . '/' . $picture_name;

        if (file_exists($picture_path)) {
            //delete the picture
            unlink($picture_path);
            $this->_fetch();
        } else {
            http_response_code(422);
            echo $picture_path;
        }

    }

    function _make_sure_got_sub_folder($update_id, $uploader_settings) {
        $destination = $uploader_settings['destination'];
        $target_dir = APPPATH.'public/'.$destination.'/'.$update_id;;

        if (!file_exists($target_dir)) {
            //generate the image folder
            mkdir($target_dir, 0777, true);
        }
    }

}