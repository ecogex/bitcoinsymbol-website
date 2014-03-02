JS_FILES = js/jquery-1.10.2.min.js \
           js/jquery.magnific-popup.min.js \
           js/zclip.js \
           js/main.js

JS_FINAL = js/bitcoinsymbol.js

STYL_FILE = css/main.styl
CSS_FINAL = css/main.css

all: $(JS_FINAL) $(CSS_FINAL)

$(JS_FINAL): $(JS_FILES)
	cat $^ > $@

$(CSS_FINAL): $(STYL_FILE)
	node_modules/.bin/stylus \
		--compress \
		--include node_modules/nib/lib \
		--include css/ \
		< $^ > $@

clean:
	rm ${JS_FINAL}
