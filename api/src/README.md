# API.class.php
API抽象类，
# CorpAPI.class.php
为企业开放的接口
# GovAPI.class.php
为政务微信开放的接口, 是自定义的url,可以调用方法setBaseUrl设置
# ServiceCorpAPI.class.php
为服务商开放的接口, 使用应用授权的token
# ServiceProviderAPI.class.php
为服务商开放的接口, 使用服务商的token
# 以上API类，都会自动获取、刷新token，调用者不用关心token

# 缓存说明:
# TokenCacheInterface.class.php
token缓存接口
# TokenCacheDefault.class.php
token缓存的例子，无实际意义
# TokenCacheMemcached.class.php
token缓存到memcached的例子，使用php的memcached扩展
要缓存token,需要先生成实现了TokenCacheInterface接口的对象， 并把对象传给API接口, 方法为: setTokenCacheObj
# 默认是没有使用缓存的，也就是当前对象有效，如果要使用缓存，需要自己实现TokenCacheInterface接口
