<?php
namespace PC;
class Cache implements \PC\Cache\CacheInterface {
	const TYPE_FILE = 'file';
	const TYPE_MEMCACHE = 'memcache';
	const TYPE_APC = 'apc';

	public static $Types = array(self::TYPE_FILE, self::TYPE_MEMCACHE, self::TYPE_APC);

	protected static $instance;

	public static function GetInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	protected $type;
	protected $class;

	public function set($key, $value, $expire = NULL) {
		if($this->class) {
			return $this->class->set($key, $value, $expire);
		}
		return $value;
	}

	public function get($key) {
		if($this->class) {
			return $this->class->get($key);
		}
		return NULL;
	}

	public function remove($key) {
		if($this->class) {
			return $this->class->remove($key);
		}
		return NULL;
	}

	public function clear() {
		if($this->class) {
			return $this->class->clear();
		}
		return NULL;
	}

	public function setType($type) {
		if($type && !in_array($type, self::$Types)) {
			throw new \InvalidArgumentException('Unknown type');
		}
		$this->type = $type;
		switch($type) {
			case self::TYPE_MEMCACHE:
				$this->class = new \PC\Cache\CacheMemcache();
			case self::TYPE_APC:
				$this->class = new \PC\Cache\CacheApc();
		}
		$this->class = new \PC\Cache\CacheFile();
	}

	public function getType() {
		return $this->type;
	}

	public function getClass() {
		return $this->class;
	}
}