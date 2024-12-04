INPUT=input

watch:
	find . | entr -d make test

test:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/memory-descrumbler.php input-test

task1:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/memory-descrumbler.php input
