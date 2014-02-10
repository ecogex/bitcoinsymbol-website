(function(doc) {

  function selectorEach(selector, fn, container) {
    if (!container) container = document;
    var elts = container.querySelectorAll(selector);
    var i = elts.length;
    while (i--) fn(elts[i]);
  }

  function on(event, elt, fn) {
    elt.addEventListener(event, fn, false);
  }

  function closestTagName(elt, tagName) {
    return closest(elt, function(elt) {
      return elt.tagName.toLowerCase() == tagName;
    });
  }

  function closest(elt, fn) {
    do {
      elt = elt.parentNode;
    } while (elt && elt !== document.documentElement && !fn(elt));
    return (elt && fn(elt))? elt : null;
  }
}(document));
