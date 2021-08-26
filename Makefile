# подключаем переменные окружения
include .env
export

# бинарник миграций
PHINX_BIN=vendor/bin/phinx
# вызов бинарника миграций
PHINX_CALL=$(PHINX_PHP_BIN) $(PHINX_BIN)
# определение переменных для подключения к бд
define PHINX_DATABASE_ENVIRONMENT
PHINX_DATABASE_HOST=$(DATABASE_HOST) \
PHINX_DATABASE_PORT=$(DATABASE_PORT) \
PHINX_DATABASE_NAME=$(DATABASE_NAME) \
PHINX_DATABASE_USER=$(DATABASE_USER) \
PHINX_DATABASE_PASS=$(DATABASE_PASS) \
PHINX_DATABASE_CHARSET=$(DATABASE_CHARSET)
endef

.PHONY: migration/init
migration/init:
	$(PHINX_CALL) init --format yml

.PHONY: migration/create/%
migration/create/%:
	$(PHINX_CALL) create $*

.PHONY: migration/up
migration/up:
	@ $(PHINX_DATABASE_ENVIRONMENT) $(PHINX_CALL) migrate

.PHONY: migration/rollback
migration/rollback:
	@ $(PHINX_DATABASE_ENVIRONMENT) $(PHINX_CALL) rollback

.PHONY: migration/status
migration/status:
	@ $(PHINX_DATABASE_ENVIRONMENT) $(PHINX_CALL) status