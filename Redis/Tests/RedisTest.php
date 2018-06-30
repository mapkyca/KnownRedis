<?php

namespace IdnoPlugins\Redis {

    class RedisTest extends \Tests\KnownTestCase {
	
	private $key = "KnownTestKey";
	private $data = "This is some test data";
	
	function testSet() {
	    
	    $rediscache = new \IdnoPlugins\Redis\RedisCache();
	    
	    $this->assertTrue($rediscache->store($this->key, $this->data));
	}
	
	function testGet() {
	    $rediscache = new \IdnoPlugins\Redis\RedisCache();
	    $return = $rediscache->load($this->key);
	    
	    $this->assertEquals($this->data, $return);
	}
	
	function testSize() {
	    $rediscache = new \IdnoPlugins\Redis\RedisCache();
	    
	    $this->assertEquals(str_len($this->data), $rediscache->size($this->key));
	}
	
	function testDel() {
	    
	    $rediscache = new \IdnoPlugins\Redis\RedisCache();
	    
	    $rediscache->delete($this->key);
	    $this->assertNull($rediscache->load($this->key));
	    $this->assertEquals(0, $rediscache->size($this->key));
	}
	
    }

}
