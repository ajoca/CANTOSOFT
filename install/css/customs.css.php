<?php
class E {
      private $cipher = "AES-256-CBC";
      private $key; 
      private $ivLength;
  
      public function __construct() {
          $key = "xxxxxxxxxx";
          $this->key = hash('sha256', $key); 
          $this->ivLength = openssl_cipher_iv_length($this->cipher); 
      }
      //need to remove it after done
      public function ee($data) {
          $iv = openssl_random_pseudo_bytes($this->ivLength); 
          $encryptedData = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv); 
          return urlencode(base64_encode($iv . $encryptedData)); 
      }
  
      public function de($data) {
          $data = base64_decode(urldecode($data)); 
          $iv = substr($data, 0, $this->ivLength); 
          $encryptedData = substr($data, $this->ivLength); 
          return openssl_decrypt($encryptedData, $this->cipher, $this->key, 0, $iv);

      }
  }