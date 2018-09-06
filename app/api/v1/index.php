<?php
	if(false)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}

	require_once __DIR__ . '/model/DBConnection.class.php';
	require_once __DIR__ . '/model/DBHandler.class.php';

	if(!isset($_REQUEST['request']))
		sendResponse(404);

	$endpoints = array();
	$endpoints[] = array('regex' => 'casual/kd/players', 'method' => 'casualKDPlayers');
	$endpoints[] = array('regex' => 'casual/kd', 'method' => 'casualKD');

	switch($_SERVER['REQUEST_METHOD'])
	{
		case 'GET':
			processGet($endpoints, $_REQUEST['request'], json_decode(file_get_contents('php://input'), true));
			break;
		default:
			sendResponse(501);
			break;
	}

	/**
	 * @param array $endpoints
	 * @param string $request
	 * @param array $params
	 */
	function processGet($endpoints, $request, $params)
	{
		if($params === null)
			$params = array();
		$params = array_merge($params, $_GET);

		foreach($endpoints as $endpointIndex => $endpoint)
		{
			$groups = array();
			if(preg_match($endpoint['regex'], $request, $groups))
			{
				$handler = new R6\DBHandler();
				array_shift($groups);
				$result = call_user_func_array(array($handler, $endpoint['method']), $groups);
				if($result)
				{
					sendResponse($result['code'], json_encode($result));
				}
				else
				{
					sendResponse(500, json_encode(array()));
				}
				return;
			}
		}
		sendResponse(404);
	}

	/**
	 * @param int $status
	 * @param string $body
	 */
	function sendResponse($status = 200, $body = '')
	{
		header('HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status));
		header('Content-type:' . 'application/json');
		header('Access-Control-Allow-Methods:' . 'POST,PUT,GET,DELETE,OPTIONS');
		$http_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
		if($http_origin !== null && $http_origin === "http://*.mrcraftcod.fr")
		{
			header("Access-Control-Allow-Origin: $http_origin");
		}
		if($body != '')
		{
			echo $body;
			exit;
		}
		else
		{
			echo json_encode(array('code' => $status, 'result' => ''));
			exit;
		}
	}

	/**
	 * @param int $status
	 * @return string
	 */
	function getStatusCodeMessage($status)
	{
		$codes = Array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => '(Unused)', 307 => 'Temporary Redirect', 400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported');
		return (isset($codes[$status])) ? $codes[$status] : '';
	}
