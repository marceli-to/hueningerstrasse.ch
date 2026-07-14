const Iso = (function() {
  
  const selectors = {
    body: 'body',
    object: '[data-object]',
    building: '[data-building]',
    iso: '[data-iso]',
    floor: '[data-iso-floor]',
  };

  const initialize = function() {
    bind();
  };

  const bind = function() {

    // Event listeners for 'selectors.floor'
    document.querySelectorAll(selectors.floor).forEach(function(floor) {
      floor.addEventListener('mouseover', function() {
        hideFloor(floor);
      });
      floor.addEventListener('mouseleave', function() {
        showFloor(floor);
      });
    }); 

    // Event listeners for 'selectors.object' (desktop only)
    document.querySelectorAll(selectors.object).forEach(function(object) {
      if (object.closest('.md\\:hidden')) return;
      // Add mouseover event listener for selectors.object
      object.addEventListener('mouseover', function() {
        highlightIso(object);
      });
      object.addEventListener('click', function() {
        highlightIso(object);
      });
      // Add mouseout event listener for selectors.object
      object.addEventListener('mouseout', function() {
        clearIso();
      });
    });

    // Event listeners for 'selectors.iso'
    document.querySelectorAll(selectors.iso).forEach(function(iso) {
      iso.addEventListener('mouseover', function() {
        hightlightRow(iso);
      });

      // Add touch-start event listener for selectors.iso
      iso.addEventListener('touchstart', function() {
        hightlightRow(iso);
      });

      // Add touch-end event listener for selectors.iso
      iso.addEventListener('touchend', function() {
        clearRow();
        clearIso();
      });

      // Add mouseout event listener for selectors.iso
      iso.addEventListener('mouseout', function() {
        clearRow();
        clearIso();
      });
    });

  };

  const highlightIso = function(object, moveSiblings = true) {
    // get data set
    const objectData = object.dataset;

    // get iso item data-iso="data.objectNumber" within data-iso-building="data.objectBuilding"
    const isos = document.querySelectorAll('[data-iso="' + objectData.objectNumber + '"]');

    isos.forEach(function(iso) {

      // add class '.is-active.is-available' to iso item if it exists
      if (!iso) return;
      iso.classList.add('is-active', objectData.objectState === 'free' ? 'is-available' : 'is-taken');

      if (moveSiblings) {
        // Get the parent <g> element for the object
        const parent = iso.parentElement;

        // find all siblings of the parent <g> element that are after it
        const nextSiblings = getNextSiblings(parent);

        // add styles to translate the parent <g> elements siblings
        nextSiblings.forEach(function(sibling) {
          sibling.classList.add('is-up')
        });
      }
    });
  };

  const hightlightRow = function(iso) {
    const isoData = iso.dataset;
    const objects = document.querySelectorAll('[data-object-number="'+isoData.iso+'"]');
    if (!objects.length) return;
    const objectData = objects[0].dataset;
    objects.forEach(function(object) {
      object.classList.add('is-active');
    });

    // find all data-iso="iso.dataset.iso"
    const isos = document.querySelectorAll('[data-iso="' + isoData.iso + '"]');
    isos.forEach(function(iso) {
      iso.classList.add('is-active', objectData.objectState === 'free' ? 'is-available' : 'is-taken');
    });

  };

  const clearIso = function() {
    document.querySelectorAll(selectors.iso).forEach(function(iso) {
      iso.classList.remove('is-active', 'is-available', 'is-taken');
      // Get the parent <g> element for the isoItem
      const parent = iso.parentElement;

      // find all siblings (before and after) of the parent <g> element
      const siblings = getAllSiblings(parent);

      // remove all instances of the is-up and is-down classes
      parent.classList.remove('is-up');
      siblings.forEach(function(sibling) {
        sibling.classList.remove('is-up');
      });
    });
  };

  const clearRow = function() {
    document.querySelectorAll(selectors.object).forEach(function(object) {
      object.classList.remove('is-active');
    });
  };

  const hideFloor = (floor) =>  {
    // find all siblings of the parent <g> element that are after it
    const nextSiblings = getNextSiblings(floor);

    // add styles to translate the parent <g> elements siblings
    nextSiblings.forEach(function(sibling) {
      sibling.classList.add('is-up')
    });
  };

  const showFloor = (floor) =>  {
    // find all siblings of the parent <g> element that are after it
    const nextSiblings = getNextSiblings(floor);

    // add styles to translate the parent <g> elements siblings
    nextSiblings.forEach(function(sibling) {
      sibling.classList.remove('is-up')
    });
  };

  const getNextSiblings = (parent) => {
    const siblings = [];
    let nextSibling = parent.nextElementSibling;
    while (nextSibling) {
      siblings.push(nextSibling);
      nextSibling = nextSibling.nextElementSibling;
    }
    return siblings;
  };

  const getPreviousSiblings = (parent) => {
    const previousSiblings = [];
    let previousSibling = parent.previousElementSibling;
    while (previousSibling) {
      previousSiblings.push(previousSibling);
      previousSibling = previousSibling.previousElementSibling;
    }
    return previousSiblings;
  };

  const getAllSiblings = (parent) => {
    const siblings = [];
    let nextSibling = parent.nextElementSibling;
    while (nextSibling) {
      siblings.push(nextSibling);
      nextSibling = nextSibling.nextElementSibling;
    }
    let previousSibling = parent.previousElementSibling;
    while (previousSibling) {
      siblings.push(previousSibling);
      previousSibling = previousSibling.previousElementSibling;
    }
    return siblings;
  };

  const selectByNumber = function(number, state) {
    clearIso();
    clearRow();
    const isos = document.querySelectorAll('[data-iso="' + number + '"]');
    isos.forEach(function(iso) {
      if (!iso) return;
      iso.classList.add('is-active', state === 'free' ? 'is-available' : 'is-taken');
      const parent = iso.parentElement;
      let next = parent.nextElementSibling;
      while (next) { next.classList.add('is-up'); next = next.nextElementSibling; }
    });
  };

  const clearSelection = function() {
    clearIso();
    clearRow();
  };

  return {
    init: initialize,
    select: selectByNumber,
    clear: clearSelection,
  };
})();

// Initialize
Iso.init();
window.Iso = Iso;
