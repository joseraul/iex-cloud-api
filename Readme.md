
## IEX cloud Client Api
PHP Client for the [IEX Cloud Api](https://iexcloud.io/docs/api/)

## Get Started
### Installation
```
composer require joseraul/iex-cloud-api
```

### Example of use

```
use IEXCloud\Client;

$client = new Client();
$news = $client
    ->setVersion('v1')
    ->setToken('token')
    ->balanceSheet('OTLK', 'quarter', 5);
```


