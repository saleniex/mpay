# mpay
Mobilly MPay service integration

# Example

```php
namespace MpayTest;

use Mobilly\Mpay\Connector;
use Mobilly\Mpay\Request;
use Mobilly\Mpay\SecurityContext;
use Mobilly\Mpay\SuccessResponse;

require_once 'vendor/autoload.php';

// Credentials provided by Mpay (Mobilly) 
$mpayUser = 'testuser';
$publicKey = './mpay-public.pem';

// Private key created locally (public key should be sent to Mobilly)
$privateKey = './private.pem';
$privateKeySecret = 'SuperSecretPrivateKeySecret';

$context = new SecurityContext($mpayUser, $privateKey, $privateKeySecret, $publicKey);
$request = new Request($context);
$connector = new Connector($context);
$response = $connector->send($request);
if ( ! $response instanceof SuccessResponse) {
    die("Error.");
}

$transactionId = $response->getTransactionId();

header("Location: https://mpay.mobilly.lv?transid=" . $transactionId);
exit();
```

# Private/public key creation

```
#!sh

$ openssl genrsa -out private.pem -aes256 4096
$ openssl rsa -pubout -in private.pem -out public.pem
```