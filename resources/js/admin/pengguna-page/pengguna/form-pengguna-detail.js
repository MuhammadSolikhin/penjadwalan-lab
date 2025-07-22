import { Modal } from "bootstrap";

export function initDatatablesValueToModalDetailPengguna() {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-detail-pengguna');
        if (!btn) return;

        try {
            const dataAttr = btn.getAttribute('data-row');
            const data = JSON.parse(dataAttr);

            // Isi semua data ke elemen modal detail
            document.getElementById('detail-namaPengguna').textContent = data.nama_pengguna || '-';
            document.getElementById('detail-emailPengguna').textContent = data.email || '-';
            document.getElementById('detail-peranPengguna').textContent = data.nama_peran || '-';
            document.getElementById('detail-unitPengguna').textContent = data.nama_unit || '-';
            document.getElementById('detail-lokasiPengguna').textContent = data.nama_lokasi || '-';

            const detailModal = new Modal(document.getElementById('modalDetailPengguna'));
            detailModal.show();

            feather.replace(); // Render ulang icon feather
        } catch (error) {
            console.error('❌ Gagal parsing data-row:', error);
        }
    });
}
