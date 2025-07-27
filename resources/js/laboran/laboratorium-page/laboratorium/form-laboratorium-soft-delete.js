import { Modal } from 'bootstrap';

const modalElement = document.getElementById('modalDeleteLab');
const deleteModal = new Modal(modalElement);

export function initSoftDeleteLaboratoriumModal() {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-laboratorium');
        if (!btn) return;

        try {
             const row = JSON.parse(btn.getAttribute('data-row'));

            // Set form action
            const form = document.getElementById('formDeleteLab');
            form.setAttribute('action', `/laboran/hapus-laboratorium/${row.id_laboratorium}`);

            // Set pesan konfirmasi
            const message = `Apakah Anda yakin ingin menghapus Laboratorium <strong>${row.nama_laboratorium}</strong> dari Lokasi <strong>${row.nama_lokasi}</strong> ?`;
            document.getElementById('deleteLabMessage').innerHTML = message;

            // Tampilkan modal
            deleteModal.show();
        } catch (error) {
            console.log('Gagal mengambil data : ', error);
            
        }
    });
}
