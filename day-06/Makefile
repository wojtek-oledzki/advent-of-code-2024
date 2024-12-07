INPUT=input

watch.%:
	find . | entr -d $(MAKE) $(subst  watch.,,$@) INPUT=input-test

run1:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/map-guard.php $(INPUT)
