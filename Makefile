JS_FILES := js/jquery-1.11.0.js \
           js/jquery.magnific-popup.min.js \
           js/jquery.cycle2.js \
           js/jquery.mmenu.min.js \
           js/zclip.js \
           js/shop.js \
           js/main.js

ESLINT_FILES := js/shop.js \
               js/main.js

JS_FINAL := js/bitcoinsymbol.js

CSS_FINAL := css/main.css \
             css/shop.css

all: js css
	@echo ""

css: $(CSS_FINAL)
js: $(JS_FINAL)

lint:
	@echo "\nChecking files with ESLint…"
	node_modules/.bin/eslint $(ESLINT_FILES)

$(JS_FINAL): $(JS_FILES)
	@echo "\nConcatenating and compressing files into $(JS_FINAL)…"
	cat $^ | node_modules/.bin/uglifyjs -m -c - > $@
	@echo ""

%.css: %.styl
	@echo "\nGenerating $@…"
	node_modules/.bin/stylus \
		--compress \
		--include-css \
		--include node_modules/nib/lib \
		--include css/ \
		< $< > $@

clean:
	rm $(JS_FINAL)
