// Gestion de la langue FR / EN
(function () {
    var STORAGE_KEY = 'portfolio_lang';
    // Attributs traduisibles : data-fr-placeholder, data-en-note, etc.
    var ATTRS = ['placeholder', 'aria-label', 'title', 'alt', 'data-note', 'data-default'];

    function getInitialLang() {
        var saved = null;
        try { saved = localStorage.getItem(STORAGE_KEY); } catch (e) {}
        if (saved === 'fr' || saved === 'en') return saved;
        return (navigator.language || 'fr').toLowerCase().indexOf('en') === 0 ? 'en' : 'fr';
    }

    function applyLang(lang) {
        document.documentElement.lang = lang;

        // Textes : data-fr / data-en
        document.querySelectorAll('[data-fr]').forEach(function (el) {
            var value = el.getAttribute('data-' + lang);
            if (value !== null) el.innerHTML = value;
        });

        // Attributs : data-fr-placeholder, data-en-aria-label, data-fr-note…
        ATTRS.forEach(function (attr) {
            var key = attr.replace(/^data-/, '');
            document.querySelectorAll('[data-' + lang + '-' + key + ']').forEach(function (el) {
                el.setAttribute(attr, el.getAttribute('data-' + lang + '-' + key));
            });
        });

        // Remet les zones de détail des compétences sur leur texte par défaut
        document.querySelectorAll('.skill-note[data-default]').forEach(function (el) {
            el.textContent = el.getAttribute('data-default');
        });

        // Bouton : affiche la langue vers laquelle on bascule
        var btn = document.getElementById('langToggle');
        if (btn) {
            btn.textContent = lang === 'fr' ? 'EN' : 'FR';
            btn.setAttribute('aria-label', lang === 'fr' ? 'Switch to English' : 'Passer en français');
        }

        try { localStorage.setItem(STORAGE_KEY, lang); } catch (e) {}
    }

    document.addEventListener('DOMContentLoaded', function () {
        var lang = getInitialLang();
        applyLang(lang);

        var btn = document.getElementById('langToggle');
        if (btn) {
            btn.addEventListener('click', function () {
                lang = lang === 'fr' ? 'en' : 'fr';
                applyLang(lang);
            });
        }
    });
})();