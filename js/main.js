document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // DROPDOWN DE PERFIL
    // ============================================
    const profileDropdownBtn = document.getElementById('profileDropdownBtn');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');

    if (profileDropdownBtn && profileDropdownMenu) {
        profileDropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            profileDropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-container')) {
                profileDropdownMenu.classList.remove('show');
            }
        });

        const dropdownLinks = profileDropdownMenu.querySelectorAll('a');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', function() {
                profileDropdownMenu.classList.remove('show');
            });
        });
    }

    // ============================================
    // DASHBOARD ADMIN — TABS
    // ============================================
    const urlParams = new URLSearchParams(window.location.search);
    const abaParaReabrir = urlParams.get('aba');

    if (abaParaReabrir) {
        if (abaParaReabrir === 'usuario')      switchTab('tab-usuarios');
        if (abaParaReabrir === 'newsletter')   switchTab('tab-newsletter');
        if (abaParaReabrir === 'agendamento')  switchTab('tab-agendamentos');
    }

});

// ============================================
// DASHBOARD ADMIN — FUNÇÕES
// ============================================
function switchTab(tabId) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));

    const clickedBtn = Array.from(document.querySelectorAll('.tab-btn')).find(btn => btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(tabId));
    if (clickedBtn) clickedBtn.classList.add('active');

    const panel = document.getElementById(tabId);
    if (panel) panel.classList.add('active');
}

function confirmarExclusao(item) {
    return confirm("Tem certeza absoluta que deseja remover " + item + "? Esta ação não poderá ser desfeita.");
}

// ============================================
// FORMULÁRIOS DE AUTH (LOGIN / CADASTRO)
// ============================================
function switchForm(formType) {
    const loginCard = document.getElementById('login-card');
    const cadastroCard = document.getElementById('cadastro-card');

    if (loginCard && cadastroCard) {
        if (formType === 'cadastro') {
            loginCard.classList.add('d-none');
            cadastroCard.classList.remove('d-none');
        } else {
            cadastroCard.classList.add('d-none');
            loginCard.classList.remove('d-none');
        }
    }
}

function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    if (!input) return;

    const icon = button.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        if (icon) {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    } else {
        input.type = 'password';
        if (icon) {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
}

// ============================================
// NEWSLETTER
// ============================================
function showNewsletterFeedback(message, type) {
    const feedback = document.querySelector('.newsletter-feedback');
    if (feedback) {
        feedback.textContent = message;
        feedback.className = `newsletter-feedback ${type}`;
    }
}

// ============================================
// EVENTOS GLOBAIS
// ============================================
window.addEventListener('load', function() {
    const params = new URLSearchParams(window.location.search);

    if (document.getElementById('login-card')) {
        if (params.get('cadastro') === 'sucesso' || params.get('erro') || params.get('form') === 'login') {
            switchForm('login');
        }
        if (params.get('form') === 'cadastro') {
            switchForm('cadastro');
        }
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');
        if (profileDropdownMenu) {
            profileDropdownMenu.classList.remove('show');
        }
    }
});