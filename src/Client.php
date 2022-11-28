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
     * Cria uma nova requisição para o Curl.
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
     * Descrição (alterar, adicionado parametro)
     * (Adicionar detalhes depois de testes)
     * (Requer parâmetro)
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

    /**
     * Limpa o log principal, 
     * sempre retornará 'true', em excessões de casos de erro.
     *
     * @return bool
     */
    public function clearLog()
    {
        return $this->call('supervisor.clearLog');
    }

    /**
     * Limpa o log do processo especificado no parâmetro.
     * (Requer parâmetro)
     */
    public function clearProcessLog()
    {
        return $this->call('supervisor.clearProcessLog');
    }

    /**
     * Limpa os logs especificados e os abrem novamente.
     */
    public function clearProcessLogs()
    {
        return $this->call('supervisor.clearProcessLogs');
    }

    /**
     * Retorna a versão da API.
     *
     * @return string
     */
    public function getAPIVersion()
    {
        return $this->call('supervisor.getAPIVersion');
    }

    /**
     * Retorna um array com todas informações de configuração.
     * (Adicionar detalhes depois de testes)
     * 
     * @return string
     */
    public function getAllConfigInfo()
    {
        return $this->call('supervisor.getAllConfigInfo');
    }

    /**
     * Retorna um array com todas as informações de processos.
     * (Adicionar detalhes depois de testes)
     *
     */
    public function getAllProcessInfo()
    {
        return $this->call('supervisor.getAllProcessInfo');
    }

    /**
     * Retorna uma string com o 'identificador', 
     * possibilitando mostrar com qual instância do Supervisor
     * o cliente está se comunicando.
     * 
     * @return string
     */
    public function getIdentification()
    {
        return $this->call('supervisor.getIdentification');
    }

    /**
     * Retorna o PID do Supervisord.
     *
     * @return int
     */
    public function getPID()
    {
        return $this->call('supervisor.getPID');
    }

    /**
     * Retorna as informações do processo nomeado no parâmetro.
     * (Requer parâmetro)
     * @return string
     */
    public function getProcessInfo()
    {
        return $this->call('supervisor.getProcessInfo');
    }

    /**
     * Retorna o estado atual da estrutura do Supervisor.
     *
     * @return string 'FATAL', o Supervisor encontrou um erro grave
     * @return string 'RUNNING', o Supervisor está funcionando normalmente
     * @return string 'RESTARTING', o Supervisor está atualmente reiniciando
     * @return string 'SHUTDOWN', o Supervisor está atualmente desligando
     */
    public function getState()
    {
        return $this->call('supervisor.getState');
    }

    /**
     * Retorna a versão do pacote do Supervisor.
     * 
     * @return string
     */
    public function getSupervisorVersion()
    {
        return $this->call('supervisor.getSupervisorVersion');
    }

    /**
     * Deprecated Method,
     * Retorna a versão do Supervisor,
     * atualmente substituído por getAPIVersion();
     * @return string
     */
    public function getVersion()
    {
        return $this->call('supervisor.getVersion');
    }

    /**
     * Lê o log especificado no parâmetro.
     * (Requer parâmetros)
     */
    public function readLog()
    {
        return $this->call('supervisor.readLog');
    }

    /**
     * Deprecated Method
     * Lê o log principal da configuração,
     * atualmente substituído por readLog();
     *
     */
    public function readMainLog()
    {
        return $this->call('supervisor.readMainLog');
    }

    /**
     * (Requer parâmetros)
     */
    public function readProcessLog()
    {
        return $this->call('supervisor.readProcessLog');
    }

    /**
     * (Requer parâmetros)
     */
    public function readProcessStderrLog()
    {
        return $this->call('supervisor.readProcessStderrLog');
    }

    /**
     * (Requer parâmetros)
     */
    public function readProcessStdoutLog()
    {
        return $this->call('supervisor.readProcessStdoutLog');
    }

    /**
     * Recarrega as configurações,
     * o método retornará três arrays:
     *
     * @return mixed 'added' retorna os grupos de processos que foram adicionados
     * @return mixed 'changed' retorna os grupos de processos que foram alterados
     * @return mixed 'removed' retorna os grupos de processos que não estão mais nas configurações
     *
     */
    public function reloadConfig()
    {
        return $this->call('supervisor.reloadConfig');
    }

    /**
     * (Requer parâmetros)
     */
    public function removeProcessGroup()
    {
        return $this->call('supervisor.removeProcessGroup');
    }

    /**
     * Reinicia o processo do Supervisor,
     * sempre retornará 'true', em excessões de casos de erro.
     *
     * @return bool
     */
    public function restart()
    {
        return $this->call('supervisor.restart');
    }

    /**
     * (Requer parâmetros)
     */
    public function sendProcessStdin()
    {
        return $this->call('supervisor.sendProcessStdin');
    }

    /**
     * (Requer parâmetros)
     */
    public function sendRemoteCommEvent()
    {
        return $this->call('supervisor.sendRemoteCommEvent');
    }

    /**
     * Desativa o processo do Supervisor,
     * se algum processo estiver em andamento, eles serão automaticamente encerrados
     * sem avisos adicionais
     */
    public function shutdown()
    {
        return $this->call('supervisor.shutdown');
    }

    /**
     * (Requer parâmetros)
     */
    public function signalAllProcesses()
    {
        return $this->call('supervisor.signalAllProcesses');
    }

    /**
     * (Requer parâmetros)
     */
    public function signalProcess()
    {
        return $this->call('supervisor.signalProcess');
    }

    /**
     * (Requer parâmetros)
     */
    public function signalProcessGroup()
    {
        return $this->call('supervisor.signalProcessGroup');
    }

    /**
     * Inicia todos os processos listados no arquivo de configuração.
     */
    public function startAllProcesses()
    {
        return $this->call('supervisor.startAllProcesses');
    }

    /**
     * Inicia um processo especificado.
     * (Requer parâmetros)
     */
    public function startProcess()
    {
        return $this->call('supervisor.startProcess');
    }

    /**
     * Inicia todos os processos no grupo nomeado no parâmetro.
     * (Requer parâmetros)
     */
    public function startProcessGroup()
    {
        return $this->call('supervisor.startProcessGroup');
    }

    /**
     * Interrompe todos os processos na lista de processos.
     *
     */
    public function stopAllProcesses()
    {
        return $this->call('supervisor.stopAllProcesses');
    }

    /**
     * Interrompe um processo especificado.
     * (Requer parâmetros)
     */
    public function stopProcess()
    {
        return $this->call('supervisor.stopProcess');
    }

    /**
     * Interrompe todos os processos no grupo nomeado no parâmetro.
     * (Requer parâmetros)
     */
    public function stopProcessGroup()
    {
        return $this->call('supervisor.stopProcessGroup');
    }

    /**
     * Fornece uma forma mais eficiente para averiguar um log de processo.
     * (Requer parâmetros)
     */
    public function tailProcessLog()
    {
        return $this->call('supervisor.tailProcessLog');
    }

    /**
     * Fornece uma forma mais eficiente para averiguar um log de processo.
     * (Requer parâmetros)
     */
    public function tailProcessStderrLog()
    {
        return $this->call('supervisor.tailProcessStderrLog');
    }

    /**
     * Fornece uma forma mais eficiente para averiguar um log de processo.
     * (Requer parâmetros)
     */
    public function tailProcessStdoutLog()
    {
        return $this->call('supervisor.tailProcessStdoutLog');
    }

    /**
     * Retorna uma lista de comandos disponíveis
     * no Supervisord
     *
     * @return array<string>
     */
    public function listMethods()
    {
        return $this->call('system.listMethods');
    }

    /**
     * Retorna as informações de ajuda do método requirido
     *
     * @param string $name Nome do método requerido
     *
     * @return string
     */
    public function methodHelp($name)
    {
        return $this->call('system.methodHelp', [$name]);
    }

    /**
     * Retorna a descrição da assinatura do método
     *
     * @return array
     */
    public function methodSignature($name)
    {
        return $this->call('system.methodSignature', [$name]);
    }

    /**
     * Faz uma chamada de multiplos métodos
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
