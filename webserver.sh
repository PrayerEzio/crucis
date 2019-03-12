#!/bin/sh
### BEGIN INIT INFO
# Provides:          land.sh
# Required-start:    $local_fs $remote_fs $network $syslog
# Required-Stop:     $local_fs $remote_fs $network $syslog
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: starts the svnd.sh daemon
# Description:       starts svnd.sh using start-stop-daemon
### END INIT INFO
 
cd /data/wwwroot/www.crucis.cn
nohup php artisan room:queue start > ./logs/room_queue.log 2>&1 &
nohup php artisan queue:work --queue=add_logs > ./logs/queue_work.log 2>&1 &
