(function(doc) {

  selectorEach('tr form.update', function(form) {
    on('submit', form, function(e) {
      var tr = closestTagName(this, 'tr');
      var fields = form.querySelectorAll('input[type=hidden]');
      var i = fields.length;
      while (i--) {
        fields[i].value = tr.querySelector('.edit [name='+fields[i].name+']').value;
      }
    });
  });

  selectorEach('tr button.edit', function(elt) {
    on('click', elt, function() {
      selectorEach('tr', function(tr) {
        tr.classList.remove('edit');
      });
      closestTagName(this, 'tr').classList.add('edit');
    });
  });

  selectorEach('tr button.cancel', function(elt) {
    on('click', elt, function() {
      closestTagName(this, 'tr').classList.remove('edit');
    });
  });

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
