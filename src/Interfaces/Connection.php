<?php

namespace DBSeller\Supervisord\Interfaces;

interface Connection
{
    /**
     * Retorna a URL do servidor
     * 
     * @return string
     */
    public function getUrl();

    /**
     * Retorna os dados de acesso ao RPC
     *
     * @return string Formato autenticacao basica XML-RPC
     */
    public function getAutentication();
}
