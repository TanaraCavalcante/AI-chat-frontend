## [2026-09-07] - Pulizia .env.example

### Rimosso
- Rimosse da `.env.example` le variabili non utilizzate dal progetto (`BROADCAST_CONNECTION`, `MEMCACHED_*`, `REDIS_*`, `MAIL_*`, `AWS_*`) e le righe commentate relative a driver/config alternativi non in uso (MySQL/Postgres, `APP_MAINTENANCE_STORE`, `PHP_CLI_SERVER_WORKERS`, `CACHE_PREFIX`).

### Aggiunto
- Aggiunta `PYTHON_API_URL` a `.env.example`, richiesta da `ChatController` ma finora assente dal file di esempio.
