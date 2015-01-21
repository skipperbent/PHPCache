<?php
namespace PC\Cache;
interface CacheInterface {
	public function set($key, $value, $expire = NULL);
	public function get($key);
	public function remove($key);
	public function clear();
}