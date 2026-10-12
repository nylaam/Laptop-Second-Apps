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

//  <input type="file" data-image-preview="#selector-gambar">  untuk preview foto sebelum upload
document.addEventListener('change', (event) => {
    const input = event.target;

    if (!input.matches('[data-image-preview]')) {
        return;
    }

    const preview = document.querySelector(input.dataset.imagePreview);
    const file = input.files?.[0];

    if (!preview || !file || !file.type.startsWith('image/')) {
        return;
    }

    if (preview.dataset.objectUrl) {
        URL.revokeObjectURL(preview.dataset.objectUrl);
    }

    preview.dataset.objectUrl = URL.createObjectURL(file);
    preview.src = preview.dataset.objectUrl;
    preview.classList.remove('hidden');
    preview.parentElement?.querySelector('[data-image-preview-empty]')?.classList.add('hidden');
});
