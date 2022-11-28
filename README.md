## About PHP - Supervisord XMLRPC

Esse projeto serve como uma ponte para facilitar a conexão via XMLRPC com o (Supervisord)[http://supervisord.org] 
utilizando pacotes do próprio php para fazer essa conexão.

### Requirements

- PHP - >= 5.6
- php-xmlrpc - *
- php-curl   - *

### Install

```
composer install abismostudios/supervisord
```

### Implementation

```php
require_once 'vendor/autoload.php';

use AbismoStudios\Supervisord\Client;
use AbismoStudios\Supervisord\HTTPConnection;

use AbismoStudios\Supervisord\Exceptions\InvalidArgumentException;
use AbismoStudios\Supervisord\Exceptions\ConnectionException;

try {
    $connection = new HTTPConnection('host', 'username', 'password');
    $client     = new Client($connection);
    $result     = $client->listMethods();
    
    var_dump($result); // Retorno do chamado do metodo
} catch (InvalidArgumentException $e) {
    echo $e->getMessage(); // Falha no argumento
} catch (ConnectionException $e) {
    echo $e->getMessage(); // Falha na conexao com o supervisord
} catch (Exception $e) {
    echo $e->getMessage(); // Exception
}
```

### Settings Supervisord

Adicionar a opções de configuração no arquivo de configuração do Supervisord.

O arquivo geralmente está no local ’/etc/supervisor/supervisord.conf’, esse local pode variar de implementação.

Para mais detalhes acesse (http://supervisord.org/configuration.html#inet-http-server-section-settings)[http://supervisord.org/configuration.html#inet-http-server-section-settings]

```
[inet_http_server]
username=admin
password=secret
port=127.0.0.1:9001
```

### Author / Dev
[Gabriel Senna - Abismo Studios](https://abismostudios.com/)<br>
[Nicolas Lucio - Abismo Studios](https://abismostudios.com/)
