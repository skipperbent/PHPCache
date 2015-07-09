<?php
namespace PC\Cache;
class CacheMemcache implements CacheInterface {
	public function __construct() {
		throw new \ErrorException('Memcache yet not implemented!');
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
