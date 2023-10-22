<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
/**
 * 强制重启服务脚本，并清理缓存代理类.
 */
$pid = shell_exec(sprintf('cat %s/../runtime/hyperf.pid', __DIR__));
$rebootCmd = sprintf('rm -rf %s/../runtime/container/* && php %s/hyperf.php start > /dev/null 2>/dev/null &', __DIR__, __DIR__);

if (shell_exec(sprintf('ps -ef | grep -v grep | grep %s', $pid))) {
    shell_exec("kill -9 {$pid}");
    shell_exec($rebootCmd);
} else {
    shell_exec($rebootCmd);
}

// 执行 lsof 命令并查找 9502 端口
$output = shell_exec('lsof -i :9502 | grep LISTEN | awk \'{print $2}\'');

// 将进程 ID 转换为数组
$pidList = explode("\n", trim($output));

// 遍历进程 ID 列表并杀死相应进程
foreach ($pidList as $pid) {
    if (is_numeric($pid)) {
        shell_exec("kill -9 {$pid}");
        echo "进程 {$pid} 已杀死\n";
    }
}
