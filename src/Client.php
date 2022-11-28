<?php

namespace AbismoStudios\Supervisord;

use AbismoStudios\Supervisord\HTTPConnection;
use AbismoStudios\Supervisord\Interfaces\Connection;

use Exception;

class Client
{
    /**
     * Base de conexão com o Supervisord
     *
     * @var HTTPConnection $connection
     */
    private $connection;

    /**
     * Opcões default para a conexão ('connection').
     * 
     * @var array<int,mixed> $optionsDefault
     */
    private $optionsDefault = [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true
    ];

    /**
     * Curl Client
     * 
     * @var mixed $ch
     */
    private $ch;

    public function __construct($connection)
    {
        $this->connection = $connection;

        if (!($this->connection instanceof Connection)) {
            throw new Exception(
                'O argumento connection e invalido para a' .
                ' operacao de conexao com o supervisord'
            );
        }
    }

    /**
     * Cria uma nova requisição para o Curl
     *
     * @return void
     */
    private function startCurlClient()
    {
        $this->ch                              = curl_init();
        $this->optionsDefault[CURLOPT_URL]     = $this->connection->getURL();
        $this->optionsDefault[CURLOPT_USERPWD] = $this->connection->getAutentication();
    }

    /**
     * Faz uma chamada para o Supervisord e
     * retorna o seu resultado.
     *
     * @param string $method Método a ser chamado no Supervisord.
     * @param mixed $params Parâmetro para o método a ser chamado.
     * 
     * @throws Exception
     *
     * @return mixed
     */
    public function call($method, $params = null)
    {
        $this->startCurlClient();

        $data = xmlrpc_encode_request($method, $params);

        curl_setopt_array(
            $this->ch,
            [CURLOPT_POSTFIELDS => $data] + $this->optionsDefault
        );

        if (!$result = curl_exec($this->ch)) {
            throw new Exception('Falha na ');
        }

        return xmlrpc_decode($result);
    }

    /**
     * Descrição
     *
     * @return int
     */
    public function addProcessGroup($name)
    {
        return $this->call('supervisor.addProcessGroup', [$name]);
    }

    /**
     * Limpa todos os log de processo.
     * 
     * @return array<mixed>
     */
    public function clearAllProcessLogs()
    {
        return $this->call('supervisor.clearAllProcessLogs');
    }

    public function clearLog()
    {
        return $this->call('supervisor.clearLog');
    }

    public function clearProcessLog()
    {
        return $this->call('supervisor.clearProcessLog');
    }

    public function clearProcessLogs()
    {
        return $this->call('supervisor.clearProcessLogs');
    }

    /**
     * Retorna a versão da API
     *
     * @return string
     */
    public function getAPIVersion()
    {
        return $this->call('supervisor.getAPIVersion');
    }

    public function getAllConfigInfo()
    {
        return $this->call('supervisor.getAllConfigInfo');
    }

    public function getAllProcessInfo()
    {
        return $this->call('supervisor.getAllProcessInfo');
    }

    public function getIdentification()
    {
        return $this->call('supervisor.getIdentification');
    }

    /**
     * Explicação
     *
     * @return int
     */
    public function getPID()
    {
        return $this->call('supervisor.getPID');
    }

    public function getProcessInfo()
    {
        return $this->call('supervisor.getProcessInfo');
    }

    public function getState()
    {
        return $this->call('supervisor.getState');
    }

    public function getSupervisorVersion()
    {
        return $this->call('supervisor.getSupervisorVersion');
    }

    public function getVersion()
    {
        return $this->call('supervisor.getVersion');
    }

    public function readLog()
    {
        return $this->call('supervisor.readLog');
    }

    public function readMainLog()
    {
        return $this->call('supervisor.readMainLog');
    }

    public function readProcessLog()
    {
        return $this->call('supervisor.readProcessLog');
    }

    public function readProcessStderrLog()
    {
        return $this->call('supervisor.readProcessStderrLog');
    }

    public function readProcessStdoutLog()
    {
        return $this->call('supervisor.readProcessStdoutLog');
    }

    public function reloadConfig()
    {
        return $this->call('supervisor.reloadConfig');
    }

    public function removeProcessGroup()
    {
        return $this->call('supervisor.removeProcessGroup');
    }

    public function restart()
    {
        return $this->call('supervisor.restart');
    }

    public function sendProcessStdin()
    {
        return $this->call('supervisor.sendProcessStdin');
    }

    public function sendRemoteCommEvent()
    {
        return $this->call('supervisor.sendRemoteCommEvent');
    }

    public function shutdown()
    {
        return $this->call('supervisor.shutdown');
    }

    public function signalAllProcesses()
    {
        return $this->call('supervisor.signalAllProcesses');
    }

    public function signalProcess()
    {
        return $this->call('supervisor.signalProcess');
    }

    public function signalProcessGroup()
    {
        return $this->call('supervisor.signalProcessGroup');
    }

    public function startAllProcesses()
    {
        return $this->call('supervisor.startAllProcesses');
    }

    public function startProcess()
    {
        return $this->call('supervisor.startProcess');
    }

    public function startProcessGroup()
    {
        return $this->call('supervisor.startProcessGroup');
    }

    public function stopAllProcesses()
    {
        return $this->call('supervisor.stopAllProcesses');
    }

    public function stopProcess()
    {
        return $this->call('supervisor.stopProcess');
    }

    public function stopProcessGroup()
    {
        return $this->call('supervisor.stopProcessGroup');
    }

    public function tailProcessLog()
    {
        return $this->call('supervisor.tailProcessLog');
    }

    public function tailProcessStderrLog()
    {
        return $this->call('supervisor.tailProcessStderrLog');
    }

    public function tailProcessStdoutLog()
    {
        return $this->call('supervisor.tailProcessStdoutLog');
    }

    /**
     * Retorna uma lista de comandos disponiveis
     * no supervisord
     *
     * @return array<string>
     */
    public function listMethods()
    {
        return $this->call('system.listMethods');
    }

    /**
     * Retorna as informacoes de ajuda do metodo requiredo
     *
     * @param string $name Nome do metodo requerido
     *
     * @return string
     */
    public function methodHelp($name)
    {
        return $this->call('system.methodHelp', [$name]);
    }

    /**
     * Retorna a descricao da assinatura do metodo
     *
     * @return array
     */
    public function methodSignature($name)
    {
        return $this->call('system.methodSignature', [$name]);
    }

    /**
     * Faz uma chamade de multiplos methodos
     *
     * @param array<string,array> $calls ['methodName' => ['params']]
     *
     * @return array
     */
    public function multicall($calls)
    {
        return $this->call('system.multicall', $calls);
    }
}
