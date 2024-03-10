<?php

namespace core;

class Request {

	private array $input = [];

	public function __construct() {
		foreach ($this->isHttpPost() ? $_POST : $_GET as $key => $value) {
			$this->input[$key] = $value;
		}
	}

	/**
	 * @return string The HTTP request method. eg. "post", "get", etc.
	 */
	public function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}

	public function isHttpPost() {
		return $this->method() === 'POST';
	}

	public function isHttpGet() {
		return $this->method() === 'GET';
	}

	/**
	 * @return bool|string
	 */
	public function getPath(): bool|string {
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');
		return $position === false ? $path : substr($path, 0, $position);
	}

	public function input(string $key) {
		return $this->input[$key] ?? null;
	}

    /**
     * Check if a file with the given key exists.
     *
     * @param string $key
     * @return bool
     */
    public function hasFile(string $key): bool {
        return isset($this->files[$key]);
    }
    /**
     * Get the uploaded file with the given key.
     *
     * @param string $key
     * @return UploadedFile|null
     */
    public function getFile(string $key): ?UploadedFile {
        return $this->files[$key] ?? null;
    }
}