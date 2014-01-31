JS_FILES = js/jquery-1.10.2.min.js \
           js/jquery.ba-throttle-debounce.min.js \
           js/jquery.magnific-popup.min.js \
           js/zclip.js \
           js/mobilemenu.js \
           js/main.js

JS_FINAL = js/bitcoinsymbol.js

STYL_FILE = css/main.styl
CSS_FINAL = css/main.css

all: $(JS_FINAL) $(CSS_FINAL)

$(JS_FINAL): $(JS_FILES)
	cat $^ > $@

$(CSS_FINAL): $(STYL_FILE)
	stylus \
		--compress \
		--include css/ \
		< $^ > $@

clean:
	rm ${JS_FINAL}
