#!/bin/sh
# Dump do banco, compactado e rotacionado. Roda no HOST, pelo cron.
#
#   crontab -e
#   15 3 * * * /caminho/do/projeto/deploy/backup.sh >> /caminho/do/projeto/data/backup.log 2>&1
#
# O dump local nao e backup: se a VPS for embora, ele vai junto. Configure o
# RCLONE_DESTINO para mandar a copia para fora do host.

set -eu

PROJETO="$(cd "$(dirname "$0")/.." && pwd)"
DESTINO="$PROJETO/data/backup"
DIAS=14

# ex.: RCLONE_DESTINO=drive:backups/controla  (deixe vazio para nao enviar)
RCLONE_DESTINO="${RCLONE_DESTINO:-}"

. "$PROJETO/.env"

ARQUIVO="$DESTINO/controla-$(date +%Y%m%d-%H%M).sql.gz"

mkdir -p "$DESTINO"

cd "$PROJETO"
docker compose exec -T db \
    mariadb-dump --single-transaction --routines --events \
    -u root -p"$DB_ROOT_PASSWORD" "${DB_NAME:-rosi_controla}" \
    | gzip -9 > "$ARQUIVO"

# dump vazio ou truncado nao serve de backup e nao pode passar calado
if [ ! -s "$ARQUIVO" ] || [ "$(stat -c %s "$ARQUIVO")" -lt 1024 ]; then
    echo "$(date -Is) FALHOU: $ARQUIVO saiu vazio ou pequeno demais"
    rm -f "$ARQUIVO"
    exit 1
fi

if [ -n "$RCLONE_DESTINO" ]; then
    rclone copy "$ARQUIVO" "$RCLONE_DESTINO"
fi

find "$DESTINO" -name 'controla-*.sql.gz' -mtime "+$DIAS" -delete

echo "$(date -Is) ok: $ARQUIVO ($(stat -c %s "$ARQUIVO") bytes)"
