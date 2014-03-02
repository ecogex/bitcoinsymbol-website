JS_FILES := js/jquery-1.10.2.min.js \
           js/jquery.magnific-popup.min.js \
           js/zclip.js \
           js/shop.js \
           js/main.js

ESLINT_FILES := js/shop.js \
               js/main.js

JS_FINAL := js/bitcoinsymbol.js

STYL_FILE := css/main.styl
CSS_FINAL := css/main.css
CSS_DEPS := $(wildcard css/*.css css/*.styl)
CSS_DEPS := $(filter-out $(CSS_FINAL), $(CSS_DEPS))

all: lint $(JS_FINAL) $(CSS_FINAL)
	@echo ""

lint:
	@echo "\nChecking files with ESLint…"
	node_modules/.bin/eslint $(ESLINT_FILES)

$(JS_FINAL): $(JS_FILES)
	@echo "\nConcatenating files into $(JS_FINAL)…"
	cat $^ > $@

$(CSS_FINAL): $(CSS_DEPS) $(STYL_FILE)
	@echo "\nGenerating CSS file…"
	node_modules/.bin/stylus \
		--compress \
		--include node_modules/nib/lib \
		--include css/ \
		< $(STYL_FILE) > $@

clean:
	rm $(JS_FINAL)
