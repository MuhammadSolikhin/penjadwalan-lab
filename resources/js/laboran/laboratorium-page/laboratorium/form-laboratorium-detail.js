import { Modal } from "bootstrap";

export function initDatatablesValueToModalDetailLaboratorium() {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-detail-laboratorium');
        if (!btn) return;

        // try {
            const dataAttr = btn.getAttribute('data-row');
            const data = JSON.parse(dataAttr);

            console.log(data.nama_laboratorium);
            

            // Isi semua data ke elemen modal detail
            document.getElementById('detail-namaLaboratorium').textContent = data.nama_laboratorium || '-';
            document.getElementById('detail-jenisLaboratorium').textContent = data.nama_jenislab || '-';
            document.getElementById('detail-lokasiLaboratorium').textContent = data.nama_lokasi || '-';
            document.getElementById('detail-kapasitasLaboratorium').textContent = data.kapasitas_laboratorium || '-';
            document.getElementById('detail-statusLaboratorium').textContent = data.status_laboratorium == 1 ? 'Tersedia' : 'Diperbaiki';
            document.getElementById('detail-deskripsiLaboratorium').textContent = data.deskripsi_laboratorium || '-';

            const detailModal = new Modal(document.getElementById('modalDetailLaboratorium'));
            detailModal.show();

            feather.replace(); // Render ulang icon feather
        // } catch (error) {
        //     console.error('❌ Gagal parsing data-row:', error);
        // }
    });
}
