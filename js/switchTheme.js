// Überprüfen Sie beim Laden der Seite, ob der Dunkelmodus im Local Storage gespeichert ist
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark');
    document.getElementById('themeSwitch').checked = true;
}

document.getElementById('themeSwitch').addEventListener('change', function () {
    document.body.classList.toggle('dark', this.checked);

    // Speichern Sie den Zustand des Dunkelmodus im Local Storage
    localStorage.setItem('darkMode', this.checked);
});