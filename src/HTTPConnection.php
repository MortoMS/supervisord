<?php

namespace DBSeller\Supervisord;

use DBSeller\Supervisord\Interfaces\Connection;

class HTTPConnection implements Connection
{
    /**
     * Protocolo de segurança SSL
     *
     * @var bool $ssl Default false
     */
    private $ssl = false;

    /**
     * Host de connexao com o servidor RPC
     *
     * @var string $url
     */
    private $host;

    /**
     * Porta de acesso ao servidor RPC
     *
     * @var int $port Default 9001
     */
    private $port = 9001;

    /**
     * Usuario para autenticacao com o servidor RPC
     *
     * @var string $username
     */
    private $username;

    /**
     * Camilho adicionas na url
     * 
     * @var string $path default /RPC2
     */
    private $path = '/RPC2';

    /**
     * Senha de autenticacao com o servidor RPC
     *
     * @var string $password
     */
    private $password;

    public function __construct($host, $username = '', $password = '')
    {
        $this->host      = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Retorna a URL do servidor
     * 
     * @return string
     */
    public function getURL()
    {
        $protocolo = ($this->ssl) ? 'https://' : 'http://';
        $port      = ':' . $this->port;

        return ($protocolo . $this->host . $port . $this->path);
    }

    /**
     * Retorna os dados de acesso ao RPC
     *
     * @return string Formato autenticacao basica XML-RPC
     */
    public function getAutentication()
    {
        return $this->username . ':' . $this->password;
    }

    /**
     * Altera a configuracao de SSL
     *
     * @param bool $ssl
     *
     * @return DBSeller\Supervisord\HTTPConnection
     */
    public function setSSL($ssl = false)
    {
        $this->ssl = $ssl;

        return $this;
    }

    /**
     * Alterar a porta de conexao com o servidor
     *
     * @param int $port
     *
     * @return DBSeller\Supervisord\HTTPConnection
     */
    public function setPort($port = 9901)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Altera caminho adicional do host
     *
     * @param string $path
     *
     * @return DBSeller\Supervisord\HTTPConnection
     */
    public function setPath($path = '/RPC2')
    {
        $this->path = $path;

        return $this;
    }
}
