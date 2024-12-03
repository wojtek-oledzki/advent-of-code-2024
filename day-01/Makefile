INPUT=input

run:
	cat $(INPUT) | awk '{print $$1}' | sort -n > $(INPUT)-left
	cat $(INPUT) | awk '{print $$2}' | sort -n > $(INPUT)-right
	paste $(INPUT)-left $(INPUT)-right | awk 'function abs(x){return ((x < 0.0) ? -x : x)} BEGIN{ s=0 } {s += abs(int($$1) - int($$2)); print s}'
