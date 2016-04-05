<pre>
<?php

//header("content-type","text/plain;charset=utf-8");
error_reporting(E_ALL);

require_once __DIR__ . '/Thrift/ClassLoader/ThriftClassLoader.php';
require_once __DIR__ . '/com/weinong/basedb/api/BankApi.php';
require_once __DIR__ . '/com/weinong/basedb/bean/Types.php';

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
use \com\weinong\basedb\api\BankApiClient;
use Thrift\Protocol\TMultiplexedProtocol;

// Load
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', __DIR__ . '/');

$loader->register();



// Init
$socket = new TSocket('192.168.1.32', 7911);
//$socket = new TSocket('localhost', 7911);
$transport = new TBufferedTransport($socket, 1024, 1024);
$protocol = new TBinaryProtocol($transport);
$bankApi = new TMultiplexedProtocol($protocol, "BankApi");
$client = new BankApiClient($bankApi);
//$client = new WeixinUserApiClient($protocol);

// Config
$socket->setSendTimeout(30 * 1000);
$socket->setRecvTimeout(30 * 1000);

// Connect
$transport->open();

// Create request
//$request = new Request();
//$request->studentID = 100;

//$response = $client->getAllList();
$response = $client->getById(5);
$json = json_encode($response);

$transport->close();
?>
<script type="text/javascript">
	document.write(JSON.stringify(<?php echo $json?>,null,"\t"));
</script>

</pre>
