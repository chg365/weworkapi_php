<?php

require_once(__DIR__ . '/TokenCacheInterface.class.php');

class TokenCacheDefault implements TokenCacheInterface
{
    protected $_tokens = array();

    // {{{ public function get($key)
    public function get($key)
    {
        if (isset($this->_tokens[$key])) {
            if ($this->_tokens[$key][1] !== 0 && $this->_tokens[$key][1] < time()) {
                unset($this->_tokens[$key]);
                return null;
            }
            return $this->_tokens[$key][0];
        }
        return null;
    }
    // }}}
    // {{{ public function set($key, $token, $expire)
    public function set($key, $token, $expire)
    {
        $expire = (int)$expire;
        if ($expire <= 60 * 60 * 24 * 30) {
            $expire = time() + $expire;
        }
        $this->_tokens[$key] = array(
                0 => $token,
                1 => $expire,
                );
    }
    // }}}

}
