<?php

namespace core;

require_once __DIR__ . '/../routes/web.php';

class Router
{

	private Request $request;
	private ?Response $response;
	private static array $routes = [];

	public function __construct(Request $request, ?Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public static function get(string $path, array $callable): void
	{
		$callable[0] = new $callable[0];
		self::$routes['GET'][$path] = $callable;
	}

	public static function post(string $path, array|callable $callable): void
	{
		$callable[0] = new $callable[0];
		self::$routes['POST'][$path] = $callable;
	}

	public function resolve(): ?Response
	{
		$path = $this->request->getPath();
		$method = $this->request->method();
		$callback = self::$routes[$method][$path] ?? false;
		if ($callback) {
			$this->response = call_user_func($callback, $this->request);
		} else {
			$this->response = (new Response())->getStatus(404);
		}
		return $this->response;
	}
}
