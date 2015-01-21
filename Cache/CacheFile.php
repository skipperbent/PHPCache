<?php
namespace PC\Cache;
class CacheFile implements CacheInterface {
	protected $cacheDir;
	public function __construct() {
		$this->cacheDir = (isset($_SERVER['DOCUMENT_ROOT']) ? dirname($_SERVER['DOCUMENT_ROOT']) : dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'cache';
	}

	protected function getFile($key) {
		return $this->cacheDir . DIRECTORY_SEPARATOR . md5($key). '.cache';
	}

	public function set($key, $value, $expireSeconds = NULL) {
		if($value) {
			$handle = fopen($this->getFile($key), 'w+');
			$obj = array('Expires' => time() + $expireSeconds, 'Value' => $value);

			fwrite($handle, serialize($obj));
			fclose($handle);
		}
	}

	public function get($key) {
		if(file_exists($this->getFile($key))) {
			$obj = unserialize(file_get_contents($this->getFile($key)));
			if(is_array($obj) && isset($obj['Expires']) && $obj['Expires'] > time() && isset($obj['Value']) ) {
				return $obj['Value'];
			}
		}
		return NULL;
	}

	public function remove($key) {
		unlink($this->getFile($key));
	}

	public function cleanup() {
		$dir = new \DirectoryIterator($this->cacheDir);
		foreach ($dir as $file) {
			if (\Pecee\IO\File::GetExtension($file) == 'cache') {
				$obj = unserialize(file_get_contents($this->cacheDir . DIRECTORY_SEPARATOR . $file));
				if(is_array($obj) && isset($obj['Expires']) && $obj['Expires'] < time()) {
					unlink($this->cacheDir . DIRECTORY_SEPARATOR . $file);
				}
			}
		}
	}

	public function clear() {
		$dir = new \DirectoryIterator($this->cacheDir);
		foreach ($dir as $file) {
			if (\Pecee\IO\File::GetExtension($file) == 'cache') {
				unlink($this->cacheDir . DIRECTORY_SEPARATOR . $file);
			}
		}
	}
}