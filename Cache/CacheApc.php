<?php
namespace PC\Cache;
class CacheApc implements CacheInterface {
	public function __construct() {
		throw new \ErrorException('APC cache-type yet not implemented!');
	}

	public function set($key, $value, $expireSeconds = NULL) {

	}

	public function get($key) {

	}

	public function remove($key) {

	}

	public function clear() {

	}
}