import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import Swal from 'sweetalert2';
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';


Livewire.on('bookingDisimpan', () => {
    calendar.refetchEvents();
});

let calendar;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    let semuaBookingSlot = [];
    function getSlotByHari(dateString) {
        const day = new Date(dateString).getDay();
        return (day === 4 || day === 6)
            ? [['07:40:00', '09:20:00'], ['09:20:00', '11:00:00'], ['11:00:00', '13:50:00'], ['13:50:00', '15:30:00'], ['16:00:00', '17:40:00'], ['18:20:00', '20:00:00'], ['20:00:00', '21:40:00']]
            : [['07:10:00', '08:50:00'], ['08:50:00', '10:30:00'], ['10:30:00', '12:10:00'], ['13:00:00', '14:40:00'], ['14:40:00', '16:20:00'], ['18:20:00', '20:00:00'], ['20:00:00', '21:40:00']];
    }
    calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin],
        initialView: 'dayGridMonth',
        locale: 'id',
        firstDay: 1,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek,listDay'
        },
        buttonText: {
            dayGridMonth: 'Bulan',
            timeGridWeek: 'Minggu',
            listWeek: 'Daftar Minggu',
            listDay: 'Daftar Hari'
        },
        events: {
            url: '/api/booking-events',
            method: 'GET',
            failure: () => {
                alert('Gagal memuat jadwal');
            },
            success: function (data) {
                semuaBookingSlot = [];

                data.forEach(event => {
                    (event.extendedProps.jadwal || []).forEach(j => {
                        semuaBookingSlot.push({
                            tanggal: j.tanggal,
                            mulai: j.mulai,
                            selesai: j.selesai,
                            lab: j.lab,
                        });
                    });
                });


                return data.map(event => {
                    const role = event.extendedProps?.jadwal?.[0]?.role || '';
                    if (event.color === '#9ca3af') return event;
                    return {
                        ...event,
                        color: role === 'prodi' ? '#22c55e' : '#fde047'
                    };
                });
            },
        },
        datesSet: function () {
            document.getElementById('calendar-loader').style.display = 'none';
            document.getElementById('calendar').style.display = 'block';
        },

        eventClick: function (info) {
            const extended = info.event.extendedProps;
            const mode = extended.mode || 'multi';
            const pemesan = extended.pemesan || '-';
            const keperluan = info.event.title;

            let jadwal = [];

            if (mode === 'range') {
                // Buat daftar tanggal dari start hingga end
                const start = new Date(info.event.start);
                const end = new Date(info.event.end); // eksklusif
                for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                    const tanggal = d.toISOString().split('T')[0];
                    const slotWaktu = getSlotByHari(tanggal);
                    slotWaktu.forEach(([mulai, selesai]) => {
                        jadwal.push({
                            tanggal,
                            mulai,
                            selesai,
                            lab: extended.lab || '-',
                        });
                    });
                }
            } else {
                // mode multi/single
                jadwal = [{
                    tanggal: extended.tanggal,
                    mulai: extended.mulai,
                    selesai: extended.selesai,
                    lab: extended.lab,
                }];
            }

            // Grouped untuk build tabel
            const grouped = {};
            jadwal.forEach(j => {
                if (!grouped[j.tanggal]) grouped[j.tanggal] = [];
                grouped[j.tanggal].push({
                    mulai: j.mulai,
                    selesai: j.selesai,
                    lab: j.lab
                });
            });

            let tableHtml = `
                    <strong>Keperluan:</strong> ${keperluan}<br>
                    <strong>Pemesan:</strong> ${pemesan}<br>
                `;

            if (mode === 'range') {
                const labList = Array.isArray(extended.lab) ? extended.lab : [extended.lab];
                const labFormatted = labList.filter(Boolean).join(', ') || '-';
                tableHtml += `<strong>Lab:</strong> ${labFormatted}<br>`;
            }
            tableHtml += `
       
        <div style="max-height:300px;overflow:auto">
        <table border="1" cellpadding="4" cellspacing="0" style="width:100%;text-align:left;font-size:0.9em;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    ${mode !== 'range' ? '<th>Lab</th>' : ''}                
                </tr>
            </thead>
            <tbody>
    `;

            Object.keys(grouped).forEach(tanggal => {
                const slotWaktu = getSlotByHari(tanggal);
                let mergedSlots = [];
                let prev = null;

                slotWaktu.forEach(([mulai, selesai]) => {
                    let match = false;

                    if (mode === 'range') {
                        const jamMulai = parseInt(mulai.split(':')[0], 10);
                        if (jamMulai < 18) match = true;
                    } else {
                        // mode multi: cocokkan lab juga
                        const labsDiSlotIni = (grouped[tanggal] || [])
                            .filter(slot => slot.mulai === mulai && slot.selesai === selesai)
                            .map(slot => slot.lab);

                        match = semuaBookingSlot.some(slot =>
                            slot.tanggal === tanggal &&
                            slot.mulai === mulai &&
                            slot.selesai === selesai &&
                            labsDiSlotIni.includes(slot.lab)
                        );
                    }

                    const slotData = (grouped[tanggal] || []).find(slot => slot.mulai === mulai && slot.selesai === selesai);
                    const lab = (mode === 'range') ? '' : (slotData?.lab ?? '-');

                    const warna = match ? 'red' : 'green';
                    const status = match ? 'Terbooking' : 'Tersedia';

                    if (prev && prev.status === status && (mode === 'range' || prev.lab === lab)) {
                        // Gabungkan slot
                        prev.end = selesai;
                    } else {
                        // Simpan slot sebelumnya
                        if (prev) mergedSlots.push(prev);

                        // Mulai slot baru
                        prev = {
                            tanggal,
                            start: mulai,
                            end: selesai,
                            status,
                            warna,
                            lab
                        };
                    }
                });

                // Simpan slot terakhir
                if (prev) mergedSlots.push(prev);

                // Render ke HTML
                mergedSlots.forEach(slot => {
                    tableHtml += `
            <tr>
                <td>${slot.tanggal}</td>
                <td>${slot.start.substring(0, 5)} s/d ${slot.end.substring(0, 5)}</td>
                <td style="color:${slot.warna}">● ${slot.status}</td>
                ${mode !== 'range' ? `<td>${slot.lab}</td>` : ''}
            </tr>
        `;
                });
            });


            tableHtml += '</tbody></table></div>';

            Swal.fire({
                title: 'Detail Booking',
                html: tableHtml,
                width: '60%',
                confirmButtonText: 'Tutup',
            });
        },
        eventColor: '#f87171',
    });

    calendar.render();
});

document.querySelector('button[data-bs-target="#calendarPane"]').addEventListener('shown.bs.tab', function () {
    if (!calendar) return;
    calendar.render(); // render ulang saat tab diaktifkan
});

window.exportEventsToExcel = function () {
    const events = calendar.getEvents();
    const data = events.map(event => ({
        Judul: event.title,
        Mulai: event.start?.toLocaleString(),
        Selesai: event.end?.toLocaleString(),
        AllDay: event.allDay ? 'Ya' : 'Tidak',
    }));

    const worksheet = XLSX.utils.json_to_sheet(data);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Jadwal');

    const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
    const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
    saveAs(blob, 'jadwal-booking.xlsx');
};

window.exportCalendarToPDF = function () {
    const calendarEl = document.getElementById('calendar');
    html2canvas(calendarEl).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('landscape', 'pt', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('kalender-booking.pdf');
    });
};

