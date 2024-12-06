INPUT=input

watch:
	find . | entr -d make run1 run2 INPUT=input-test

run1:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/memory-descrumbler.php $(INPUT)


run2:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/memory-advanced-descrumbler.php $(INPUT)
