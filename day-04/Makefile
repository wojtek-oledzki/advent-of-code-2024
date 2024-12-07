INPUT=input

watch.run1:
	find . | entr -d $(MAKE) run1 INPUT=input-test

watch.run2:
	find . | entr -d $(MAKE) run2 INPUT=input-test

run1:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/xmas-scanner.php $(INPUT)

run2:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/x-mas-scanner.php $(INPUT)
