<?php

require_once(__DIR__ . '/TokenCacheInterface.class.php');

class TokenCacheMemcached implements TokenCacheInterface
{
    /**
     * memcache连接资源
     * 
     * @var object | null
     */
    protected $__connection = null;


    // {{{ public function __construct()

    /**
     * 构造函数
     * 
     * @param array $servers 要添加的服务器列表
     * @return void
     */
    public function __construct(array $servers)
    {
        $this->_connect();
        $this->add_servers($servers);
    }

    // }}}
    // {{{ protected function _connect()

    /**
     * 连接memcached
     * 
     * @return object memcached对象
     */
    protected function _connect()
    {
        if (isset($this->__connection)) {
            return $this->__connection;
        }
        $this->__connection = new Memcached();
        //$this->__connection->setOption(Memcached::OPT_COMPRESSION, false);
        $this->__connection->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
        return $this->__connection;
    }

    // }}}
    // {{{ public function add_server()

    /**
     * 添加缓存服务器
     * 
     * @param string $host 服务器域名或ip
     * @param integer $port 服务器端口
     * @param integer $weight 在多个服务器设置中所占的比重
     * @return boolean
     */
    public function add_server($host, $port, $weight = 0)
    {
        return $this->__connection->addServer($host, $port, $weight);
    }

    // }}}
    // {{{ public function add_servers()

    /**
     * 添加缓存服务器
     * 
     * @param array $servers 要添加的服务器列表
     * @return boolean
     */ 
    public function add_servers(array $servers)
    {       
        $this->_connect();
        return $this->__connection->addServers($servers);
    }

    // }}}
    // {{{ public function get($key)
    public function get($key)
    {
        if (strlen($key) == 0) {
            return null;
        }
        return $this->__connection->get($key);
    }
    // }}}
    // {{{ public function set($key, $token, $expire)
    public function set($key, $token, $expire)
    {
        if (strlen($key) == 0) {
            return null;
        }
        return $this->__connection->set($key, $token, $expire);
    }
    // }}}
    // {{{ public function __destruct()
    public function __destruct()
    {
        if ($this->__connection) {
            $this->__connection->quit();
            $this->__connection = null;
        }
    }
    // }}}

}
