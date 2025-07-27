import { Modal } from 'bootstrap';

const modalElement = document.getElementById('modalDeleteJenisLab');
const deleteModal = new Modal(modalElement);

export function initSoftDeleteJenisLabModal() {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-jenis-lab')
        if (!btn) return;

        try {
            const row = JSON.parse(btn.getAttribute('data-row'));

            // Set form action
            const form = document.getElementById('formDeleteJenisLab');
            form.setAttribute('action', `/laboran/hapus-jenis-laboratorium/${row.id_jenis_lab}`);

            // Set pesan konfirmasi
            const message = `Apakah Anda yakin ingin menghapus Jenis Lab <strong>${row.nama_jenis_lab}</strong> ?`;
            document.getElementById('deleteJenisLabMessage').innerHTML = message;

            // Tampilkan modal
            deleteModal.show();
        } catch (error){
            console.log('Gagal mengambil data : ', error);
            
        }
    });
}
