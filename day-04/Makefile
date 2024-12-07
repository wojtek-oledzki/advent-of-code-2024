INPUT=input

watch.%:
	find . | entr -d make $< INPUT=input-test

run1:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/xmas-scanner.php $(INPUT)
