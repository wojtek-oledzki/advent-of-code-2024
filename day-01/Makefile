INPUT=input

run:
	cat $(INPUT) | awk '{print $$1}' | sort -n > $(INPUT)-left
	cat $(INPUT) | awk '{print $$2}' | sort -n > $(INPUT)-right
	paste $(INPUT)-left $(INPUT)-right | awk 'function abs(x){return ((x < 0.0) ? -x : x)} BEGIN{ s=0 } {s += abs(int($$1) - int($$2)); print s}'

run2:
	cat $(INPUT) | awk '{print $$1}' | sort -n > $(INPUT)-left
	cat $(INPUT) | awk '{print $$2}' | sort -n > $(INPUT)-right
	comm -12 $(INPUT)-left $(INPUT)-right > $(INPUT)-intersect
	cat $(INPUT)-right | uniq -c > $(INPUT)-right-count
	awk 'NR!=FNR{m[$$2]=$$2 * $$1;} NR==FNR{l[NR]=$$1;} END { r=0; for (k in l) { r+=m[l[k]] }; print r}' $(INPUT)-intersect $(INPUT)-right-count
