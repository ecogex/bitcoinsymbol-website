JS_FILES = js/jquery-1.10.2.min.js \
           js/jquery.ba-throttle-debounce.min.js \
           js/jquery.magnific-popup.min.js \
           js/zclip.js \
           js/mobilemenu.js \
           js/main.js

CSS_FILES = css/f/stylesheet.css \
            css/main.css \
            css/magnific-popup.css

JS_FINAL = js/bitcoinsymbol.js
CSS_FINAL = css/bitcoinsymbol.css

all: $(JS_FINAL) $(CSS_FINAL)

$(JS_FINAL): $(JS_FILES)
	cat $^ > $@

$(CSS_FINAL): $(CSS_FILES)
	cat $^ > $@

clean:
	rm ${JS_FINAL}
