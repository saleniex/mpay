# MPay
Mobilly MPay service integration library.

# Download via packagist.org

```
$ composer require mobilly/mpay
```
On how to use Composer please see following [link](https://getcomposer.org/download/).


# Usage example

```php
namespace MpayTest;

use Mobilly\Mpay\Connector;
use Mobilly\Mpay\Request;
use Mobilly\Mpay\SecurityContext;
use Mobilly\Mpay\SuccessResponse;

require_once 'vendor/autoload.php';

$mpayUser = 'mpayuser';
$privateKey = './private.pem';
$privateKeySecret = 'SuperSecretPrivateKeySecret';
$publicKey = './mpay-public.pem';
$endpoint = 'https://mpay-test.mobilly.lv'; // In production: "https://mpay.mobilly.lv"

$context = new SecurityContext($mpayUser, $privateKey, $privateKeySecret, $publicKey);

$request = new Request($context);
$request
    ->setAmount(250)
    ->setSummary('Test transaction')
    ->setServiceId(100)
    ->setResultUrl('https://mydomain.com/result')
    ->setReturnUrl('https://mydomain.com/return')
    ->setContacts('John', 'Doe', 'john@doe.com')
    ->setLanguage('en');
    
$connector = new Connector($context, $endpoint . '/transaction');
$response = $connector->send($request);

if ( ! $response instanceof SuccessResponse) {
    die("Error.");
}

$transactionId = $response->getTransactionId();

header("Location: " . $endpoint . "?transid=" . $transactionId);
exit();
```

# Private/public key creation

```
$ openssl genrsa -out private.pem -aes256 4096
$ openssl rsa -pubout -in private.pem -out public.pem
```