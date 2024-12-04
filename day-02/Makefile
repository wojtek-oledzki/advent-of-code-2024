INPUT=input

watch:
	find . | entr -d make test

test:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/safe-report.php input-test

run:
	awk '{ d = $$2 - $$1 > 0 ? 1: -1; r = 1; for(i=1; i<NF; i++) if($$i!="e") { s = ($$(i+1) - $$i) * d; if (s > 3 || s < 1) { r = 0}  }; print r "" }' $(INPUT) | sort | uniq -c | tail -n 1

run2:
	docker run --rm  -v $$(pwd):/app php:cli-alpine3.18 php /app/safe-report.php input
