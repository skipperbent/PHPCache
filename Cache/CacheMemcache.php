<?php
namespace PC\Cache;
class CacheMemcache implements CacheInterface {
	protected $memcache;
	public function __construct() {
		$this->memcache = \Pecee\Service\Memcache\Memcache::GetInstance();
	}

	public function set($key, $value, $expireSeconds = NULL) {
		$this->memcache->set($key, $value, null, $expireSeconds);
	}

	public function get($key) {
		$this->memcache->get($key);
	}

	public function remove($key) {
		$this->memcache->clear($key);
	}

	public function clear() {
		$this->memcache->clear();
	}
}