const Filter = (() => {
  const selectors = {
    attribute: '.js-filter-attribute',
    row: '[data-filterable]',
    building: '[data-building]',
    btnReset: '.js-btn-reset',
  };

  let activeFilters = {};

  const init = () => {
    document.addEventListener('change', (e) => {
      if (e.target.matches(selectors.attribute)) {
        setFilter(e.target);
      }
    });

    document.addEventListener('click', (e) => {
      if (e.target.closest(selectors.btnReset)) {
        reset(e);
      }
    });
  };

  const setFilter = (el) => {
    const type = el.dataset.filtertype;
    const value = el.value;

    if (value === 'NULL') {
      delete activeFilters[type];
    } else {
      activeFilters[type] = value;
    }

    updateSelectStyle(el);
    apply();
  };

  const updateSelectStyle = (el) => {
    const isActive = el.selectedIndex !== 0;
    el.classList.toggle('ring-2', isActive);
    el.classList.toggle('ring-ink/50', isActive);
  };

  const apply = () => {
    const rows = document.querySelectorAll(selectors.row);
    const buildings = document.querySelectorAll(selectors.building);
    const hasFilters = Object.keys(activeFilters).length > 0;

    if (!hasFilters) {
      rows.forEach((row) => (row.style.display = ''));
      buildings.forEach((b) => (b.style.display = ''));
      return;
    }

    rows.forEach((row) => {
      const matches = Object.entries(activeFilters).every(
        ([key, value]) => row.getAttribute(`data-${key}`) === value
      );
      row.style.display = matches ? '' : 'none';
    });

    // hide buildings where all rows are hidden
    buildings.forEach((building) => {
      const hasVisible = [...building.querySelectorAll(selectors.row)].some(
        (row) => row.style.display !== 'none'
      );
      building.style.display = hasVisible ? '' : 'none';
    });
  };

  const reset = (e) => {
    e.preventDefault();
    activeFilters = {};
    document.querySelectorAll(selectors.attribute).forEach((select) => {
      select.selectedIndex = 0;
      select.classList.remove('ring-2', 'ring-ink/50');
    });
    apply();
  };

  return { init };
})();

Filter.init();
