import './bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

import '@fortawesome/fontawesome-free/css/all.min.css';

document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // Sidebar
    // =========================

    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('toggleSidebar');
    const main = document.getElementById('main-content');

    if (toggle && sidebar && main) {

        toggle.addEventListener('click', () => {

            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');

        });

    }

    // =========================
    // Tanggal
    // =========================

    const element = document.getElementById('currentDate');

    if (element) {

        const today = new Date();

        element.innerHTML = today.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    }

});