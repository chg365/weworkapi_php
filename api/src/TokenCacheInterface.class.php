<?php

interface TokenCacheInterface
{
    public function get($key);
    public function set($key, $token, $expire);
}
