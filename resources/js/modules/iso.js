/*
 | Isometrie – Etagen-Interaktion (Hüningerstrasse 40)
 |
 | Hover auf eine Listenzeile [data-object] -> Etage der Zeile markieren und die
 | darüberliegenden Etagen anheben. Hover auf eine Etage im SVG [data-iso-floor]
 | -> die zugehörigen Listenzeilen markieren (reziprok).
 |
 | Etagen-Reihenfolge im DOM ist von unten (UG) nach oben (3.OG); "darüberliegend"
 | = nachfolgende .iso-floor-Geschwister.
 |
 | TODO (sobald Wohnungen im SVG separiert + Mieterspiegel final): zusätzlich die
 | einzelne Wohnung über data-object-number <-> data-iso einfärben.
*/
const Iso = (function () {

  const selectors = {
    object: '[data-object]',        // Listenzeilen
    floor:  '[data-iso-floor]',     // Etagen-Gruppen im SVG
    part:   '[data-iso-part]',      // benanntes Teilobjekt innerhalb einer Etage
  };

  // Nachfolgende Etagen-Geschwister = im Gebäude darüberliegende Etagen
  const floorsAbove = function (floorEl) {
    const out = [];
    let n = floorEl.nextElementSibling;
    while (n) {
      if (n.classList && n.classList.contains('iso-floor')) out.push(n);
      n = n.nextElementSibling;
    }
    return out;
  };

  const clear = function () {
    document.querySelectorAll('.iso-floor').forEach(function (el) {
      el.classList.remove('is-active', 'is-up');
    });
    document.querySelectorAll('.is-part-active').forEach(function (el) {
      el.classList.remove('is-part-active');
    });
    document.querySelectorAll(selectors.object).forEach(function (o) {
      o.classList.remove('is-active');
    });
  };

  // Etage markieren + darüberliegende Etagen anheben. Die Etagen-Beschriftung ist
  // Teil der Etagen-Gruppe (Pfade aus dem AI) und wird dabei mitbewegt.
  //
  // Ist ein Teilobjekt (part) angegeben und im SVG als [data-iso-part="…"] vorhanden,
  // wird NUR dieses eingefärbt (die restliche Etage bleibt neutral). Sonst die ganze Etage.
  const activateFloor = function (key, part) {
    const floorEl = document.querySelector('[data-iso-floor="' + key + '"]');
    if (!floorEl) return null;
    floorsAbove(floorEl).forEach(function (f) { f.classList.add('is-up'); });

    // Teilobjekt-Flächen können einzelne Pfade ODER eine Gruppe mit
    // [data-iso-part="…"] sein. Sind welche vorhanden -> nur die einfärben.
    const partEls = part ? floorEl.querySelectorAll('[data-iso-part="' + part + '"]') : [];
    if (partEls.length) {
      partEls.forEach(function (el) { el.classList.add('is-part-active'); });
    } else {
      floorEl.classList.add('is-active');  // ganze Etage
    }
    return floorEl;
  };

  const bind = function () {

    // Listenzeile -> Etage
    document.querySelectorAll(selectors.object).forEach(function (row) {
      const key = row.dataset.objectFloor;
      if (!key) return;
      const part = row.dataset.objectPart || null;
      const enter = function () { clear(); row.classList.add('is-active'); activateFloor(key, part); };
      row.addEventListener('mouseenter', enter);
      row.addEventListener('mouseleave', clear);
    });

    // Etage im SVG -> Listenzeilen (reziprok)
    document.querySelectorAll(selectors.floor).forEach(function (floorEl) {
      const key = floorEl.dataset.isoFloor;
      floorEl.addEventListener('mouseenter', function () {
        clear();
        activateFloor(key);
        document.querySelectorAll(selectors.object + '[data-object-floor="' + key + '"]')
          .forEach(function (o) { o.classList.add('is-active'); });
      });
      floorEl.addEventListener('mouseleave', clear);
    });
  };

  const initialize = function () {
    if (document.querySelector(selectors.floor)) bind();
  };

  return {
    init: initialize,
    selectFloor: function (key) { clear(); activateFloor(key); },
    clear: clear,
  };
})();

// Module-Scripts werden deferred ausgeführt -> DOM steht bereit
Iso.init();
window.Iso = Iso;
