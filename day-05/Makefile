INPUT=input

watch.%:
	find . | entr -d $(MAKE) $(subst  watch.,,$@) INPUT=input-test

run1:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/find-correct-updates.php $(INPUT)

run2:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/find-incorrect-updates.php $(INPUT)
