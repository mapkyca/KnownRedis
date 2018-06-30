<?php
namespace IdnoPlugins\Redis {
    
    class RedisCache extends \Idno\Caching\PersistentCache {
	
	private $redis;
	private $size = 0;
	
	public function init() {
	    
	    require_once(dirname(__FILE__) . '/Vendor/predis-1.1/src/Autoloader.php');
	    
	    \Predis\Autoloader::register();
	    
	    if (!extension_loaded('redis')) 
		throw new \RuntimeException("Redis module not enabled, please install php-redis");
	    
	    try {
		$this->redis = new \Predis\Client([
		    'scheme' => 'tcp',
		    'host'  => '127.0.0.1',
		    'port'  => 6379,
		], [
		    'prefix' => 'Known-'.str_replace('.','_', \Idno\Core\Idno::site()->config()->host).':' // Ensure multiple domains play nice.
		]);
	    } catch (\Exception $ex) {die($ex->getMessage());
		\Idno\Core\Idno::site()->logging()->error($ex->getMessage());
	    }
	    
	    $this->size = $this->load('size');
	    
	    parent::init();
	}
	
	public function delete($key): bool {
	    $val = $this->load($key);
	    $this->redis->decrby('size', strlen($val));
	    
	    return $this->redis->del($key);
	}

	public function load($key) {
	    return $this->redis->get($key);
	}

	public function size() {
	    return $this->redis->get('size');
	}

	public function store($key, $value): bool {
	    $this->redis->incrby('size', strlen($value));
	    
	    return $this->redis->set($key, $value);
	}

    }
}