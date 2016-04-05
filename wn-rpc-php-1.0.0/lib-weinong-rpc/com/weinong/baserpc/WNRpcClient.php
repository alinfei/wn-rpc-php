<?php
	namespace com\weinong\baserpc;
	
	use Thrift\ClassLoader\ThriftClassLoader;
	use Thrift\Protocol\TBinaryProtocol;
	use Thrift\Transport\TSocket;
	use Thrift\Transport\TBufferedTransport;
	use Thrift\Protocol\TMultiplexedProtocol;

	//引入配置文件和工具类文件
	require_once __DIR__."/../../../thrift-lib-config.php";
	require_once __DIR__."/../../../util.php";


	//引入Thrift库文件
	require_once $WN_RPC_CONFIG['thrift_lib_location']. '/Thrift/ClassLoader/ThriftClassLoader.php';

	//注册Thrift类加载器
	$loader = new ThriftClassLoader();
	$loader->registerNamespace('Thrift',$WN_RPC_CONFIG['thrift_lib_location']);
	$loader->register();

	/**
	 * 微农RPC客户端工具类
	 * 可通过IP和端口获取一个客户端实例，对于同一IP:端口，再次获取时，会返回上次调用生成的客户端，除非客户端关闭<br/>
	 *
	 * 如果在调用WNRpcClient::getWNRpcClient($host,$port,$namespaceDir=null)指定了$namespaceDir(Api类命名空间)
	 * 那么这个客户端可以通过调用getXXXApi动态的获取$namespaceDir下存在的Api对象
	 * 调用结束后可以显示的关闭客户端，也可以不关闭，能够确定以后代码不会使用同样的IP:端口调用服务的情况下推荐显式关闭
	 *
	 * Class WNRpcClient
	 * @package com\weinong\baserpc
	 */
	class WNRpcClient{
		
		private $transport;//传输通道
		private $protocol;//二进制协议

		/**
		 * 客户端的状态,init:初始化,opened:已打开,closed:已关闭
		 */
		private $status = "init";

		//主机
		private $host;

		//端口
		private $port;

		//Api命名空间
		private $namespaceDir;

		/**
		 * 存放客户端的容器
		 * 以$ip:$port为key,以对应的Client为值
		*/
		private static $_instances = array();

		//私有化构造方法，不允许在外部实例化
		private function __construct(){
			
		}

		/**
		 * 销毁对象时关闭连接
		 */
		function __destruct(){
			
			if($this->status == "opened"){
				$this->close();
			}

		}

		/**
		 * 打开客户端
		 * @return bool 是否打开成功(多次调用只有第一次返回true)
		 */
		public function open(){
			if($this->status = "init"){
				$this->transport->open();
				$this->status = "opened";
				return true;
			} else return false;
		}

		/**
		 * 关闭客户端
		 * @return bool 是否打开成功(多次调用只有调用打开后第一次返回true)
		 */
		public function close(){
			if($this->status == "opened"){
				$this->transport->close();
				$this->status = "closed";
				unset(self::$_instances[$this->host.":".$this->port]);
				return true;
			}
			else return false;
		}

		/**
		 * @param $host 主机地址 ip/域名/hostname
		 * @param $port	端口 数字类型
		 * @param null $namespaceDir Api类命名空间的目录
		 * @return WNRpcClient
		 */
		public static function getWNRpcClient($host,$port,$namespaceDir=null){
			$key = $host.":".$port;
			if(!isset(self::$_instances[$key])){
			
				$_instance = new WNRpcClient();
				
				$socket = new TSocket($host, $port);
				$transport = new TBufferedTransport($socket, 1024, 1024);

				
				$_instance->namespaceDir = $namespaceDir;
				$_instance->host = $host;
				$_instance->port = $port;
				
				$_instance->transport = $transport;
				$_instance->protocol = new TBinaryProtocol($transport);

				self::$_instances[$key] = $_instance;
			}
			else {
				$_instance = self::$_instances[$key];
				
				if($_instance.status=="closed"){
					
					unset(self::$_instances[$key]);
					
					return self::getWNRpcClient($host,$port);
				}
				
				
			}
			return self::$_instances[$key];
		}


		/**
		 * 通过类全名和Api名称获取Api客户端
		 * @param $className ApiClient类全名
		 * @param $apiName Api名称
		 * @return $className对应的实例
		 */
		public function getWNRpcApiClient($className,$apiName){
			
			$api = new TMultiplexedProtocol($this->protocol, $apiName);
			
			return new $className($api);
		}


		/**
		 * 重载魔术方法__call,实现动态获取Api客户端
		 * 需要在调用WNRpcClient::getWNRpcClient($host,$port,$namespaceDir=null)时指定$namespaceDir(Api类命名空间)
		 * @param $name
		 * @param $arguments
		 * @return Api客户端
		 * @throws \ErrorException function not found.
		 */
		function __call($name, $arguments){

			$result = array();
			preg_match("/^get([a-zA-Z_]+Api)$/", $name,$result);


			if(sizeof($result)){

				$namespaceDir = sizeof($arguments) && is_string($arguments[0]) ? $arguments[0]:$this->namespaceDir;

				$apiName = $result[1];
				$apiName = ucfirst($apiName);
				echo $apiName;
				return $this->getWNRpcApiClient($namespaceDir."\\".$apiName."Client",$apiName);
			}
			else throw new \ErrorException("not found function:" . $name);
		}

	}