# Deploy do Controla

Docker na VPS: **nginx do host termina o TLS e faz proxy** para o compose, que
sobe `web` (nginx), `app` (php-fpm) e `db` (MariaDB).

```
internet -> nginx do HOST (443, certbot)
              proxy_pass 127.0.0.1:8001
                -> web (nginx) -> fastcgi app:9000 -> app (php-fpm) -> db (mariadb)
```

A porta `8001` fica em `127.0.0.1` de proposito: quem alcanca e o nginx do host,
nao a internet.

O `deploy/nginx.conf` (na pasta acima desta) e o modo ANTIGO, sem docker, com
php-fpm no host. Ficou para referencia.

## Primeira subida

```sh
git clone <repo> ~/controla && cd ~/controla

cp deploy/env.example .env                       # senhas do banco
cp deploy/config.ini.example deploy/config.ini   # dominio + credenciais

# as credenciais do config.ini vao ofuscadas (Str::cuboDecode)
php deploy/cubo-encode.php "controla"        # -> user
php deploy/cubo-encode.php "a-senha-do-.env" # -> pass

docker compose up -d --build
docker compose logs -f app
```

O `database/schema.sql` roda sozinho na primeira vez, enquanto `./data/mysql`
estiver vazio. Depois disso ele e ignorado -- mudanca de schema e na mao.

Depois:

```sh
sudo cp deploy/nginx/host-proxy.conf /etc/nginx/sites-available/controla
sudo nano /etc/nginx/sites-available/controla        # server_name
sudo ln -s /etc/nginx/sites-available/controla /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d controla.SEU-DOMINIO.com
```

## Atualizar

```sh
cd ~/controla && git pull && docker compose up -d --build
```

O `vendor/` e o autoload otimizado sao gerados no build; nao ha `composer
install` na VPS nem build step de front (o Alpine e vendorizado no repo).

## Backup -- a parte que nao pode faltar

```sh
chmod +x deploy/backup.sh
crontab -e
15 3 * * * cd ~/controla && ./deploy/backup.sh >> data/backup.log 2>&1
```

Para mandar para fora do host (o que de fato importa), configure o rclone e
exporte `RCLONE_DESTINO=drive:backups/controla` no cron.

**Teste o restore uma vez.** Backup nao testado e fe, nao backup:

```sh
gunzip -c data/backup/controla-AAAAMMDD-HHMM.sql.gz \
  | docker compose exec -T db mariadb -u root -p"$DB_ROOT_PASSWORD" rosi_controla
```

## Watchdog

`restart: unless-stopped` nao traz o container de volta depois de um `docker stop`
explicito ou de um prune. O timer traz:

```sh
sudo cp deploy/controla.service deploy/controla-watchdog.service deploy/controla-watchdog.timer \
     /etc/systemd/system/
sudo nano /etc/systemd/system/controla.service          # User e WorkingDirectory
sudo nano /etc/systemd/system/controla-watchdog.service # idem
sudo systemctl daemon-reload
sudo systemctl enable --now controla controla-watchdog.timer
```

## Armadilhas conhecidas

1. **`SERVER_NAME`** -- `Cubo\Routing\Router::parseUrl()` monta a rota com
   `SERVER_NAME . REQUEST_URI` e corta o `CUBO_DIR_NAME`, que sai do `host.wan`
   do `config.ini` sem o protocolo. Se os dois nao casarem, a URL inteira vira
   segmento e **toda rota quebra**. Por isso o `proxy_set_header Host $host` no
   host e o `fastcgi_param SERVER_NAME $host` no container -- e o `host.wan`
   tem de ser o dominio real **com a barra final**.
2. **Dados do banco em bind mount** (`./data/mysql`), nao em volume gerenciado:
   `docker volume prune` nao enxerga diretorio do host. A VPS e compartilhada.
3. **`enviroment` != `development`** no `config.ini`, senao a excecao aparece na
   tela do usuario em vez de ir para o log.
4. **`opcache.validate_timestamps = 0`**: editar arquivo dentro do container nao
   muda nada. Atualizacao e sempre `up -d --build`.
5. **O `public/.htaccess` e inerte** aqui -- e regra de Apache. Quem faz o
   rewrite e o `try_files` do nginx.
6. **O `cuboEncode` passa por `cleanSpecialChars`**: senha com caractere exotico
   pode nao voltar igual. O `deploy/cubo-encode.php` confere o round-trip e
   avisa; se avisar, troque a senha.
7. **Crie o `deploy/config.ini` ANTES do primeiro `up`.** Se o arquivo nao
   existir, o docker cria um DIRETORIO com esse nome no lugar dele e a
   aplicacao quebra de um jeito confuso. Se acontecer: `rm -rf
   deploy/config.ini`, copie o example de novo e suba outra vez.
