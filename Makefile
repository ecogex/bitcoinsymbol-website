JS_FILES := js/jquery-1.10.2.min.js \
           js/jquery.magnific-popup.min.js \
           js/zclip.js \
           js/shop.js \
           js/main.js

ESLINT_FILES := js/shop.js \
               js/main.js

JS_FINAL := js/bitcoinsymbol.js

CSS_FINAL := css/main.css \
             css/shop.css

all: lint $(JS_FINAL) $(CSS_FINAL)
	@echo ""

lint:
	@echo "\nChecking files with ESLint…"
	node_modules/.bin/eslint $(ESLINT_FILES)

$(JS_FINAL): $(JS_FILES)
	@echo "\nConcatenating files into $(JS_FINAL)…"
	cat $^ > $@

css: $(CSS_FINAL)

%.css: %.styl
	@echo "\nGenerating $@…"
	node_modules/.bin/stylus \
		--compress \
		--include node_modules/nib/lib \
		--include css/ \
		< $< > $@

clean:
	rm $(JS_FINAL)
