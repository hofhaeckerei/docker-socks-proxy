# SOCKS proxy written in PHP as Docker container

based on https://github.com/clue/reactphp-socks

## Example for docker-compose.yml

```
services:
  # socks proxy on 127.0.0.1:1080 using separate network
  proxy:
    image: proxy
    container_name: ddev-typo3v10-forensics-proxy
    environment:
      APP_PROXY: >
        [proxy]
        listen=0.0.0.0:1080
        [proxy.targets]
        127.0.0.1=web
    ports:
      - "1080:1080"
    networks:
      - t3-forensics
```

* `proxy`
  + `listen=host:port` host and port that shall listen for SOCKS connections (e.g. `listen=127.0.0.1:1080`)
* `proxy.targets`
  + `source-host:target-host` substitions for requested data on https or http ports (e.g. `127.0.0.1=web` mapping `localhost` to `web` service/host inside Docker scope)

## Proxy invocation

```
curl --socks5 127.0.0.1:1080 https://xn--hofhckerei-t5a.de/
```
