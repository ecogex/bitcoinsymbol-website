(function(doc) {

  selectorEach('tr form.update', function(form) {
    on('submit', form, updateFormFields.bind(null, form));
  });

  selectorEach('.edit input[type=text], .edit input[type=number]', function(elt) {
    on('keypress', elt, function(e) {
      if (e.keyCode !== 13) return;
      var form = closestTagName(elt, 'tr').querySelector('form.update');
      updateFormFields(form);
      form.submit();
    });
  });

  selectorEach('tr button.edit', function(elt) {
    on('click', elt, function() {
      selectorEach('tr', function(tr) {
        tr.classList.remove('edit');
      });
      closestTagName(this, 'tr').classList.add('edit')
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

  function updateFormFields(form) {
    var tr = closestTagName(form, 'tr');
    var fields = form.querySelectorAll('input[type=hidden]');
    var i = fields.length;
    while (i--) {
      fields[i].value = tr.querySelector('.edit [name='+fields[i].name+']').value;
    }
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
