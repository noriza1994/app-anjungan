<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    
    if ( ! function_exists('decript'))
    {
        function decript($key, $string)
        {   
            $encrypt_method = 'AES-256-CBC';
            $key_hash       = hex2bin(hash('sha256', $key));
            $iv             = substr(hex2bin(hash('sha256', $key)), 0, 16);
            $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
            return $output;
        }
    }

    if ( ! function_exists('compress'))
    {
        function compress($output)
        {
           $hasil = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
           return $hasil;
        }
    }