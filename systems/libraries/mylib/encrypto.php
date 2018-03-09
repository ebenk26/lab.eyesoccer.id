<?php
class Encrypto extends CI_Encrypt
{
    /**
     * Encodes a string.
     *
     * @param string $string The string to encrypt.
     * @param string $key[optional] The key to encrypt with.
     * @param bool $url_safe[optional] Specifies whether or not the
     *                returned string should be url-safe.
     * @return string
     *
     * Warning : Load Library Encrypt Codeigniter Before Use
     */
    
    function encode($string, $key = "", $url_safe = TRUE)
    {
        $ret = parent::encode($string, $key);
        if ($url_safe)
        {
            $ret = strtr($ret, array(
                    '+' => '.',
                    '=' => '-',
                    '/' => '~'
            ));
        }

        return $ret;
    }

    /**
     * Decodes the given string.
     *
     * @access public
     * @param string $string The encrypted string to decrypt.
     * @param string $key[optional] The key to use for decryption.
     * @return string
     */
    function decode($string, $key = "")
    {
        $string = strtr($string, array(
            '.' => '+',
            '-' => '=',
            '~' => '/'
        ));
        return parent::decode($string, $key);
    }

    function encrypt_id($id, $key = '')
    {
        $key = parent::get_key($key);
        $id = base_convert($id, 10, 36); // Save some space
        $data = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $id, 'ecb');
        $data = bin2hex($data);
        return $data;
    }

    function decrypt_id($encrypted_id, $key = '')
    {
        $key = parent::get_key($key);
        $data = pack('H*', $encrypted_id); // Translate back to binary
        $data = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $data, 'ecb');
        $data = base_convert($data, 36, 10);
        return $data;
    }

    private $hex_iv = '00000000000000000000000000000000'; // converted JAVA byte code in to HEX and placed it here
    private $key = 'token'; //Same as in JAVA
    function initialize($key = '')
    {
        $this->key = hash('sha256', $key, true);
    }

    function ssencrypt($str)
    {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($str) % $block);
        $str.= str_repeat(chr($pad) , $pad);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }

    function ssdecrypt($code)
    {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $str = mdecrypt_generic($td, base64_decode($code));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $this->strippadding($str);
    }

    /*
    For PKCS7 padding
    */
    private
    function addpadding($string, $blocksize = 16)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string.= str_repeat(chr($pad) , $pad);
        return $string;
    }

    private
    function strippadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string))
        {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

    function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i+= 2)
        {
            $string.= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }

        return $string;
    }
}