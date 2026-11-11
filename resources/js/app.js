const menuToggle = document.querySelector('[data-menu-toggle]');
const sidebar = document.querySelector('#sidebar');

menuToggle?.addEventListener('click', () => {
    const isOpen = sidebar?.classList.toggle('is-open') ?? false;
    menuToggle.setAttribute('aria-expanded', String(isOpen));
});

document.addEventListener('click', (event) => {
    if (!sidebar?.classList.contains('is-open')) return;
    if (sidebar.contains(event.target) || menuToggle?.contains(event.target)) return;

    sidebar.classList.remove('is-open');
    menuToggle?.setAttribute('aria-expanded', 'false');
});

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    });
});

const toast = document.querySelector('[data-toast]');
const dismissToast = () => {
    toast?.classList.add('is-hiding');
    window.setTimeout(() => toast?.remove(), 220);
};

document.querySelector('[data-toast-close]')?.addEventListener('click', dismissToast);
if (toast) window.setTimeout(dismissToast, 4500);
