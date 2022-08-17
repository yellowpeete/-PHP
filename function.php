  function ifHasTimeOut($ip) {
    $timeToBlock=5; //количество запросов до блокировки
    $liveTime = 5;  //через какое время будет обновляться счетчик обращений (в секундах)
    $memcache = new \Memcache; 
    $memcache->addServer('localhost', 11211);
    $count = $memcache->get($ip);


    if ($count) {
        if ($count >= $timeToBlock) {
            return true;
        } else {
            $memcache->increment($ip, 1);
            return false;
        }
    } else {
        $memcache->set($ip, 1, false, $liveTime);
    }
    }
