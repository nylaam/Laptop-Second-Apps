// Interaksi UI kecil yang bisa dipakai semua modul lewat atribut data-*.
//
//  <form data-confirm="Yakin hapus?">          -> dialog konfirmasi sebelum submit
//  <select data-auto-submit>                   -> submit form otomatis saat nilai berubah

document.addEventListener('submit', (event) => {
    const message = event.target.dataset.confirm;

    if (message && !window.confirm(message)) {
        event.preventDefault();
    }
});

document.addEventListener('change', (event) => {
    if (event.target.matches('[data-auto-submit]')) {
        event.target.form?.submit();
    }
});
