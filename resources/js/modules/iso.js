/*
 | Isometrie – Etagen-Interaktion (Hüningerstrasse 40)
 |
 | Hover auf eine Listenzeile [data-object] -> Fläche der Zeile markieren und die
 | darüberliegenden Etagen anheben. Reziprok im SVG: Hover auf eine Etage hebt den
 | Stapel und markiert deren Zeilen, Hover auf eine einzelne Fläche
 | [data-iso-part] engt das auf diese eine Wohnung ein.
 |
 | Etagen-Reihenfolge im DOM ist von unten (UG) nach oben (3.OG); "darüberliegend"
 | = nachfolgende .iso-floor-Geschwister.
 |
 | Einzelne Wohnung einfärben: die Zeile trägt data-object-part mit ihrer Nummer,
 | im SVG hängt dieselbe Nummer als data-iso-part an der Illustrator-Gruppe
 | (V.1 -> <g id="V1" data-iso-part="V.1">). Trifft der Key keine Fläche, wird
 | als Fallback die ganze Etage markiert.
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
    document.querySelectorAll('.is-label-active').forEach(function (el) {
      el.classList.remove('is-label-active');
    });
    document.querySelectorAll(selectors.object).forEach(function (o) {
      o.classList.remove('is-active');
    });
  };

  // Etage markieren + darüberliegende Etagen anheben. Die Etagen-Beschriftung ist
  // Teil der Etagen-Gruppe (Pfade aus dem AI) und wird dabei mitbewegt.
  //
  // Sind Teilobjekte (parts) angegeben und im SVG als [data-iso-part="…"] vorhanden,
  // werden NUR diese eingefärbt (die restliche Etage bleibt neutral). Sonst die ganze
  // Etage. parts ist eine einzelne Wohnung (Zeilen-Hover) oder alle Wohnungen der
  // Etage (Etagen-Hover) – bei Gewerbe jeweils die eine Fläche "gewerbe".
  const activateFloor = function (key, parts) {
    const floorEl = document.querySelector('[data-iso-floor="' + key + '"]');
    if (!floorEl) return null;
    floorsAbove(floorEl).forEach(function (f) { f.classList.add('is-up'); });

    // Teilobjekt-Flächen können einzelne Pfade ODER eine Gruppe mit
    // [data-iso-part="…"] sein. Sind welche vorhanden -> nur die einfärben.
    const keys = (parts == null ? [] : [].concat(parts)).filter(Boolean);
    let hit = 0;
    keys.forEach(function (p) {
      floorEl.querySelectorAll('[data-iso-part="' + p + '"]').forEach(function (el) {
        el.classList.add('is-part-active');
        hit++;
      });
    });
    if (!hit) floorEl.classList.add('is-active');  // ganze Etage

    // Die Etagen-Beschriftung liegt auf genau einer Fläche (data-iso-label-part).
    // Weiss wird sie nur, wenn diese Fläche selbst rot ist – bei einer Wohnung
    // am anderen Ende der Etage bliebe sie sonst weiss auf hellem Grund.
    const label = floorEl.querySelector('.iso-label[data-iso-label-part]');
    if (label && keys.indexOf(label.dataset.isoLabelPart) !== -1) {
      label.classList.add('is-label-active');
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

    // SVG -> Listenzeilen (reziprok). Nur Etagen mit zugehörigem Objekt sind
    // interaktiv – Etagen ohne Objekt (z.B. Wohn-OGs auf der Gewerbe-Seite)
    // bleiben passiv und werden nicht eingefärbt.
    document.querySelectorAll(selectors.floor).forEach(function (floorEl) {
      const key = floorEl.dataset.isoFloor;
      const rows = [...document.querySelectorAll(selectors.object + '[data-object-floor="' + key + '"]')];
      if (!rows.length) {
        floorEl.style.cursor = 'default';
        return;
      }

      const ownParts = rows.map(function (r) { return r.dataset.objectPart; }).filter(Boolean);

      // Der Hover hängt an der Etage, verfeinert sich aber auf die einzelne
      // Wohnung, sobald der Zeiger über deren Fläche steht. Nötig ist der Umweg
      // über die Etage, weil im Ruhezustand nur das oberste Geschoss frei liegt:
      // erst das Anheben legt die Grundrisse darunter überhaupt frei.
      //
      // mouseover statt mouseenter, weil es bubbelt und bei jedem Wechsel des
      // Kindelements erneut feuert – so greift der Wechsel Etage <-> Wohnung,
      // ohne dass der Stapel zwischendurch zusammenfällt.
      let last;
      floorEl.addEventListener('mouseover', function (e) {
        const shape = e.target.closest ? e.target.closest('[data-iso-part]') : null;
        const part = shape && ownParts.indexOf(shape.dataset.isoPart) !== -1
          ? shape.dataset.isoPart
          : null;
        if (part === last) return;
        last = part;
        clear();
        activateFloor(key, part || ownParts);
        rows.forEach(function (o) {
          if (!part || o.dataset.objectPart === part) o.classList.add('is-active');
        });
      });
      floorEl.addEventListener('mouseleave', function () {
        last = undefined;
        clear();
      });
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
