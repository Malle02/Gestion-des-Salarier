// index.js

document.addEventListener('DOMContentLoaded', () => {
    const voirPlusButtons = document.querySelectorAll('.btn-voir-plus');
  
    voirPlusButtons.forEach(button => {
      button.addEventListener('click', () => {
        const card = button.closest('.salarie-card');
        const details = card.querySelector('.salarie-details');
  
        details.classList.toggle('show-details');
  
        if (details.classList.contains('show-details')) {
          button.textContent = 'Voir moins';
        } else {
          button.textContent = 'Voir plus';
        }
      });
    });
  });
  