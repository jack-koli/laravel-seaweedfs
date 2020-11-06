laravel + seaweedfs

见 app\Console\Commands\Upload.php

```bash

$composer require guzzlehttp/guzzle

```

## seaweedfs 安装

```bash

192.168.8.240

$nohup weed master -mdir=/opt/seaweedfs/master_tmp -ip=192.168.8.240 -port=9333 > logs/master.log 2>&1 &
$nohup weed volume -dir=/opt/seaweedfs/volume1 -mserver=192.168.8.240:9333 -ip=192.168.8.240 -port=8081 > logs/volume1.log 2>&1 &
$nohup weed volume -dir=/opt/seaweedfs/volume2 -mserver=192.168.8.240:9333 -ip=192.168.8.240 -port=8082 > logs/volume2.log 2>&1 &
$nohup weed volume -dir=/opt/seaweedfs/volume3 -mserver=192.168.8.240:9333 -ip=192.168.8.240 -port=8083 > logs/volume3.log 2>&1 &
$weed scaffold -config=filer -output=filer.toml
$nohup weed filer -ip=192.168.8.240 -master=127.0.0.1:9333 -port=8888 -ip=192.168.8.240 -port.readonly=7777 -disableDirListing > logs/filer.log 2>&1 &
```

## 参考

1. https://laravel.com/docs/8.x/http-client#introduction
1. https://github.com/tystuyfzand/seaweedfs-client/blob/master/src/SeaweedFS.php
