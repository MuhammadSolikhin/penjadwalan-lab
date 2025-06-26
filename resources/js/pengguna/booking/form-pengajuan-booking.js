import flatpickr from "flatpickr";
import { Indonesian } from "flatpickr/dist/l10n/id.js";
import "flatpickr/dist/flatpickr.min.css";
import "flatpickr/dist/themes/airbnb.css";
import Swal from 'sweetalert2';

flatpickr.localize(Indonesian);
window.flatpickr = flatpickr;

import select2 from "select2";
select2();

window.initFuncInput = {
    initLokasiSelect2,
    initLaboratoriumSelect2,
    initTanggalMultiFlatpickr,
    initTanggalRangeFlatpickr,
    initJamOperasionalSelect2,
};

// Reset Lewat Dispatch Livewire
Livewire.on('resetLokasiSelect', () => {
    const $select = $('#lokasiId');
    $select.val(null).trigger('change');
});

Livewire.on('bookingDisimpan', () => {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Pengajuan booking berhasil disimpan!',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
});

Livewire.on('resetLaboratoriumSelect', () => {
    const $select = $('#laboratoriumId');
    $select.val(null).trigger('change');
});

Livewire.on('resetTanggalMultiFlatpickr', () => {
    const el = document.querySelector('#tanggalMulti');
    if (el && el.flatpickrInstance) {
        el.flatpickrInstance.clear();
    }
});

Livewire.on('initFlatpickrWithHariAktif', ({ hariAktif }) => {
    const el = document.querySelector('#tanggalMulti');
    if (el && el.flatpickrInstance) {
        el.flatpickrInstance.destroy();
        initFuncInput.initTanggalMultiFlatpickr(el, Livewire.find(el.closest('[wire\\:id]')), hariAktif);
    }
});

Livewire.on('resetTanggalRangeFlatpickr', () => {
    const el = document.querySelector('#tanggalRange');
    if (el && el.flatpickrInstance) {
        el.flatpickrInstance.clear();
    }
});

function initLokasiSelect2(lokasi, livewire) {
    const $select = $(lokasi); // lokasi => $el.querySelector

    $select.select2({
        theme: 'bootstrap-5',
        dropdownParent: $select.parent(),
    });

    if (livewire) {
        $select.on('change', function () {
            livewire.set('lokasiId', $(this).val());
        });
    }
}

function initLaboratoriumSelect2(laboratorium, livewire) {
    const $select = $(laboratorium);

    let selectedIds = livewire.get('laboratoriumIds');
    $select.val(selectedIds);

    $select.select2({
        theme: "bootstrap-5",
        dropdownParent: $select.parent(),
        placeholder: "Pilih Laboratorium",
        width: 'style',
    });

    setTimeout(() => {
        const container = $select.data('select2')?.$container;
        if (container) {
            container.addClass('select2-fit'); // ⬅️ penting!
        }
    }, 0);

    $select.val(selectedIds).trigger('change');

    if (livewire) {
        $select.on('change', function () {
            livewire.set('laboratoriumIds', $(this).val());
        });
    }
}

function initTanggalMultiFlatpickr(tanggalMultiInput, livewire, hariAktif) {
    const tanggalMultiFromLivewire = livewire.get('tanggalMulti') || [];

    const instance = flatpickr(tanggalMultiInput, {
        mode: 'multiple',
        altInput: true,
        altFormat: 'd F Y',
        dateFormat: 'Y-m-d',
        locale: 'id',
        defaultDate: tanggalMultiFromLivewire,
        disable: [
            function (date) {
                return !hariAktif.includes(date.getDay());
            }
        ],
        onChange: function (selectedDates, dateStr) {
            const tanggalArray = dateStr.split(', ').filter(t => t !== '');
            livewire.set('tanggalMulti', tanggalArray);
        }
    });

    tanggalMultiInput.flatpickrInstance = instance;
}

function initTanggalRangeFlatpickr(tanggalRange, livewire) {
    const tanggalRangeFromLivewire = livewire.get('tanggalRange') || '';

    const instance = flatpickr(tanggalRange, {
        mode: 'range',
        altInput: 'true',
        altFormat: 'd F Y',
        dateFormat: 'Y-m-d',
        locale: 'id',
        defaultDate: tanggalRangeFromLivewire,
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const start = instance.formatDate(selectedDates[0], 'Y-m-d');
                const end = instance.formatDate(selectedDates[1], 'Y-m-d');
                livewire.set('tanggalRange', `${start} - ${end}`);
            } else {
                livewire.set('tanggalRange', null);
            }
        }
    });

    tanggalRange.flatpickrInstance = instance;
}

Livewire.on('initJamSelect2Rentang', () => {
    setTimeout(() => {
        const el = document.querySelector('#jam-rentang');
        if (el) {
            initFuncInput.initJamOperasionalSelect2(
                el,
                Livewire.find(el.closest('[wire\\:id]')),
                'rentang'
            );
        }
    }, 100);
});


function initJamOperasionalSelect2(jamOperasional, livewire, tanggalStr, selectedValues = []) {
    const $select = $(jamOperasional);

    if ($select.hasClass('select2-hidden-accessible')) {
        return;
    }

    $select.select2({
        theme: 'bootstrap-5',
        dropdownParent: $select.parent()
    });

    if (selectedValues.length > 0) {
        $select.val(selectedValues).trigger('change');
    }

    if (livewire) {
        $select.on('change', function () {
            if (tanggalStr === 'rentang') {
                livewire.set(`jamRentangTerpilih`, $(this).val());
            } else {
                livewire.set(`jamTerpilih.${tanggalStr}`, $(this).val());
            }

        });
    }
}
