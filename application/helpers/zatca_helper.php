<?php
require APPPATH.'third_party/endroid_qrcode/autoload.php';
require_once APPPATH . 'libraries/vendor/autoload.php'; 

use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\PublicKeyLoader;


 
function generate_uuid() {
    return strtoupper(sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    ));
}
function tlv_encode($tag, $value) {
    $length = strlen($value);
    return chr($tag) . chr($length) . $value;
}
function generate_qr_code($seller_name, $vat_number, $timestamp, $invoice_total, $vat_amount) {
    $tlv_data = tlv_encode(1, $seller_name);
    $tlv_data .= tlv_encode(2, $vat_number);
    $tlv_data .= tlv_encode(3, $timestamp);
    $tlv_data .= tlv_encode(4, $invoice_total);
    $tlv_data .= tlv_encode(5, $vat_amount);

    return base64_encode($tlv_data);
}

function generate_phase2_qr_code($seller_name, $vat_number, $timestamp, $invoice_total, $vat_amount, $invoice_hash, $csid, $signature) {
    $tlv_data = tlv_encode(1, $seller_name);
    $tlv_data .= tlv_encode(2, $vat_number);
    $tlv_data .= tlv_encode(3, $timestamp);
    $tlv_data .= tlv_encode(4, $invoice_total);
    $tlv_data .= tlv_encode(5, $vat_amount);
    $tlv_data .= tlv_encode(6, $invoice_hash);
    $tlv_data .= tlv_encode(7, $csid);
    $tlv_data .= tlv_encode(8, $signature);

    return base64_encode($tlv_data);
}
function generate_invoice_hash($invoice_data) {
    return base64_encode(hash('sha256', json_encode($invoice_data), true));
}

function generate_digital_signature($invoice_hash, $private_key) {
    $rsa = PublicKeyLoader::load($private_key)->withPadding(RSA::SIGNATURE_PKCS1);
    return base64_encode($rsa->sign($invoice_hash));
}

?>