<?php
class Encryption extends Trongate {

	/*
		IMPORTANT:  Be sure to generate your own key using make_key() before using this!
		Thanks and gratitude goes to Derek McLean @delboy1978uk for helping out with this
	*/

    private $cipher = "aes-128-gcm";
    private $options = 0;
    private $key = 'Ys3mZ0N/rNQzPFDI6vLE5ByI4w3Yx4y6VBJVs3xM2uaPCj/uDzt82sHu9MsQeDWxFH3G/4Ydo/wg5Wes1aCuWw==';

    function make_key() {
    	if (ENV == 'dev') {
    		echo base64_encode(openssl_random_pseudo_bytes(64));
    	}
    }

    function _encrypt($plaintext) {
        $ivlen = \openssl_cipher_iv_length($this->cipher);
        $iv = \openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, $this->options, $iv,$tag);
        $enc_string = bin2hex($iv).bin2hex($tag).$ciphertext;
        return $enc_string;
    }

    function _decrypt($enc_string) {
    	$iv = substr($enc_string, 0, 24);
    	$tag = substr($enc_string, 24, 32);
    	$ciphertext = substr($enc_string, 56, strlen($enc_string));
    	$result = \openssl_decrypt($ciphertext, $this->cipher, $this->key, $this->options, \hex2bin($iv), \hex2bin($tag));
    	return $result;
    }

}