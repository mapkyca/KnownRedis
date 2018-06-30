<?php
namespace IdnoPlugins\Redis {
    
    class RedisCache extends \Idno\Caching\PersistentCache {
	
	private $redis;
	private $size = 0;
	
	public function init() {
	    
	    require_once(dirname(__FILE__) . '/Vendor/predis-1.1/src/Autoloader.php');
	    
	    \Predis\Autoloader::register();
	    
	    try {
		$this->redis = new \Predis\Client(null, [
		    'prefix' => 'Known_'.str_replace('.','_', \Idno\Core\Idno::site()->config()->host).':' // Ensure multiple domains play nice.
		]);
	    } catch (\Exception $ex) {
		\Idno\Core\Idno::site()->logging()->error($ex->getMessage());
	    }
	    
	    $this->size = $this->load('size');
	    
	    parent::init();
	}
	
	public function delete($key): bool {
	    return $this->redis->del($key);
	}

	public function load($key) {
	    return $this->redis->get($key);
	}

	public function size() {
	    return $this->size;
	}

	public function store($key, $value): bool {
	    $this->size += strlen($value);
	    $this->redis->set('size', $size);
	    
	    return $this->redis->set($key, $value);
	}

    }
}