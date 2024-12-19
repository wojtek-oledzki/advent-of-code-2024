INPUT=input
TASK ?=

watch.%:
	find . | entr -d $(MAKE) $(subst  watch.,,$@) INPUT=input-test

run1: TASK:=blink.php
run1: run

run:
	docker run --rm  -v \
		$$(pwd):/app \
		php:cli-alpine3.18 php /app/$(TASK) $(INPUT)
