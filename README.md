# F5-BigIp-Encoder-Decoder
Php class to encode/decode F5 BigIP cookies

# Usage
```php
$f5BigIp = new F5BigIP();
$f5BigIp->encode('10.1.1.100', 8080); // 1677787402.36895.0000
$f5BigIp->decode('1677787402.36895.0000'); // 10.1.1.100:8080
```

Instructions at: https://support.f5.com/csp/article/K6917
