<?php
require_once('vendor/autoload.php');

$settings = parse_ini_string(
    str_replace(
        ' ',
        "\n",
        (string)getenv('APP_PROXY')
    ),
    true
);

$listen = $settings['proxy']['listen'] ?? '127.0.0.1:1081';
$targetSubstitutes = $settings['proxy.targets'] ?? [];

echo 'Starting SOCKS proxy...' . PHP_EOL;
printf('* listen: %s' . PHP_EOL, $listen);
if (empty($targetSubstitutes)) {
    echo '* substitutes: 0' . PHP_EOL;
}
foreach ($targetSubstitutes as $from => $to) {
    printf('* substituting %s -> %s' . PHP_EOL, $from, $to);
}

$loop = React\EventLoop\Factory::create();
$connector = new \OliverHader\PhpProxies\Connector($loop);
$server = new \OliverHader\PhpProxies\Server($loop, $connector, null, $targetSubstitutes);
$server->on('substituted', function(\OliverHader\PhpProxies\Change $change) {
    printf('  + substituted %s to %s' . PHP_EOL, $change->oldValue, $change->newValue);
});
$socket = new React\Socket\Server($listen, $loop);
$socket->on('connection', function (\React\Socket\ConnectionInterface $connection) {
    printf('+ connection from %s to %s' . PHP_EOL, $connection->getLocalAddress(), $connection->getRemoteAddress());
});
$server->listen($socket);
$loop->run();
