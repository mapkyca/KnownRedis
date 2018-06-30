Redis support for Known
=======================

This plugin provides Redis cache support to Known.

It provides a ```PersistentCache``` derived cache, suitable for using with Known, and also
makes it easier for you to use Redis from your code.

Installation
------------

* Drop the Redis folder into the IndoPlugins folder of your idno installation.

Due to the way Known loads classes, you don't need to activate the plugin in order to be able to use the class.

If you want to use the Cache system wide, modify your ```config.ini``` as follows:

```
cache = 'IdnoPlugins\Redis\RedisCache'
```

Note, you need to use at least Known build 20180630.

See
---
 * Author: Marcus Povey <http://www.marcus-povey.co.uk> 

Also contains
-------------

* Predis, which is distributed under the MIT License. Source: https://github.com/nrk/predis
