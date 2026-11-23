document.addEventListener('DOMContentLoaded', () => {
  const updateBadge = (count) => {
    const badges = document.querySelectorAll('[data-cart-count]');
    badges.forEach(badge => {
      if (count > 0) {
        badge.textContent = String(count);
        badge.style.display = 'inline-flex';
        
        // Add a gentle pop animation
        badge.classList.remove('pop-anim');
        void badge.offsetWidth; // trigger reflow
        badge.classList.add('pop-anim');
      } else {
        badge.textContent = '0';
        badge.style.display = 'none';
      }
    });
  };

  const addForms = document.querySelectorAll('form[data-cart-add]');
  addForms.forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      const formData = new FormData(form);
      const actionUrl = form.getAttribute('action') || form.action;

      try {
        const response = await fetch(actionUrl, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            Accept: 'application/json',
            'X-Requested-With': 'fetch',
          },
          body: formData,
        });

        if (response.ok) {
          const data = await response.json();
          if (typeof data.count === 'number') {
            updateBadge(data.count);
          }
        }
      } catch (error) {
        // Ignore network errors for now.
      }
    });
  });
  const filterButtons = document.querySelectorAll('[data-filter]');
  const productCards = document.querySelectorAll('[data-category]');

  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');
      filterButtons.forEach((btn) => btn.classList.remove('active'));
      button.classList.add('active');

      productCards.forEach((card) => {
        const category = card.getAttribute('data-category');
        const show = filter === 'all' || filter === category;
        card.style.display = show ? 'block' : 'none';
      });
    });
  });

  const dateInput = document.querySelector('[data-slot-date]');
  const slotOptions = document.querySelectorAll('[data-slot-day]');

  if (dateInput && slotOptions.length > 0) {
    const updateSlots = () => {
      const value = dateInput.value;
      if (!value) return;
      const day = new Date(value + 'T00:00:00').getDay();

      slotOptions.forEach((option) => {
        option.hidden = String(day) !== option.getAttribute('data-slot-day');
      });
    };

    dateInput.addEventListener('change', updateSlots);
    updateSlots();
  }
});
