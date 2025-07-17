<?php

namespace App\Livewire\Pengguna\Booking;

use App\Models\HariOperasional;
use App\Models\JadwalBooking;
use App\Models\LaboratoriumUnpam;
use App\Models\Lokasi;
use App\Models\PengajuanBooking;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class FormPengajuanBookingCreate extends Component
{
    public $lokasiId;
    public $laboratoriumIds = [];
    public $laboratoriumList = [];
    public $modeTanggal = "multi";
    public $tanggalMulti = [];
    public $jamOperasionalPerTanggal = [];
    public $jamTerpilih = [];
    public $hariOperasionalList = [];
    public $tanggalRange = '';
    public $hariTerpilih = [];
    public $tanggalFiltered = [];
    public $keperluanBooking;
    public bool $showModal = false;
    public $modeJam = 'full';
    public $tanggalAktif = [];
    public $jadwalSudahDibooking = [];
    public $jamRentangTerpilih = [];

    protected function resetForm()
    {
        $this->reset([
            'lokasiId',
            'laboratoriumIds',
            'laboratoriumList',
            'tanggalMulti',
            'jamOperasionalPerTanggal',
            'jamTerpilih',
            'tanggalRange',
            'hariTerpilih',
            'tanggalFiltered',
            'keperluanBooking'
        ]);
        $this->modeTanggal = 'multi';
    }

    protected function getJamOperasionalForTanggal($tanggal)
    {
        try {
            $carbon = Carbon::parse($tanggal);
            $hariKe = $carbon->dayOfWeek;
            $tanggalStr = $carbon->format('Y-m-d');

            $data = HariOperasional::with('jamOperasionals')
                ->where('lokasi_id', $this->lokasiId)
                ->where('hari_operasional', $hariKe)
                ->where('is_disabled', false)
                ->first();

            if ($data) {
                return $data->jamOperasionals
                    ->map(fn($jam) => Carbon::parse($jam->jam_mulai)->format('H:i') . ' - ' . Carbon::parse($jam->jam_selesai)->format('H:i'))
                    ->toArray();
            }
        } catch (\Exception $e) {
        }
        return [];
    }

    protected function setJamOperasionalFromTanggalMulti(array $tanggalList): void
    {
        $this->jamOperasionalPerTanggal = [];
        foreach ($tanggalList as $tgl) {
            $this->jamOperasionalPerTanggal[$tgl] = $this->getJamOperasionalForTanggal($tgl);
        }
    }
    protected function loadJadwalSudahDibooking()
    {

        $tanggalList = $this->modeTanggal === 'multi' ? $this->tanggalMulti : $this->tanggalAktif;

        $this->jadwalSudahDibooking = [];

        foreach ($tanggalList as $tanggal) {

            $this->jadwalSudahDibooking[$tanggal] = JadwalBooking::where('tanggal_jadwal', $tanggal)
                ->whereIn('laboratorium_unpam_id', $this->laboratoriumIds ?? [])
                ->whereNot('status', 'dibatalkan')
                ->selectRaw("DATE_FORMAT(jam_mulai, '%H:%i') as mulai, DATE_FORMAT(jam_selesai, '%H:%i') as selesai")
                ->get()
                ->map(fn($item) => "{$item->mulai} - {$item->selesai}")
                ->toArray();
        }
    }

    protected function getListJamByLokasi()
    {
        $listJam = [];

        if (!$this->lokasiId) {
            return $listJam;
        }

        $hariList = HariOperasional::with('jamOperasionals')
            ->where('lokasi_id', $this->lokasiId)
            ->where('is_disabled', false)
            ->get();

        foreach ($hariList as $hari) {
            $hariKe = $hari->hari_operasional;

            $jamList = $hari->jamOperasionals->map(function ($jam) {
                $jamMulai = Carbon::parse($jam->jam_mulai)->format('H:i');
                $jamSelesai = Carbon::parse($jam->jam_selesai)->format('H:i');
                $jamFormat = "$jamMulai - $jamSelesai";

                $alternatif = match ($jamFormat) {
                    '07:10 - 08:50' => '07:40 - 09:20',
                    '08:50 - 10:30' => '09:20 - 11:00',
                    '10:30 - 12:10' => '11:00 - 13:50',
                    '13:00 - 14:40' => '13:50 - 15:30',
                    '14:40 - 16:20' => '16:00 - 17:40',
                    default => null,
                };

                return $alternatif ? "$jamFormat / $alternatif" : $jamFormat;
            })->toArray();

            if (in_array($hariKe, [4, 5])) {
                $jamList[] = '18:20 - 20:00';
                $jamList[] = '20:00 - 21:40';
            }
            // Simpan berdasarkan hari
            $listJam[$hariKe] = $jamList;
        }

        return $listJam;
    }

    public function updatedModeJam($value)
    {
        if ($value === 'full') {
            foreach ($this->tanggalAktif as $tanggal) {
                $this->jamTerpilih[$tanggal] = ($value === 'full')
                    ? [
                        '07:10 - 08:50',
                        '08:50 - 10:30',
                        '10:30 - 12:10',
                        '13:00 - 14:40',
                        '14:40 - 16:20',
                    ]
                    : [];
            }
        } else {
            foreach ($this->tanggalAktif as $tanggal) {
                $this->jamTerpilih[$tanggal] = [];
            }
        }
    }

    protected function loadHariOperasionalByLokasi($lokasiId)
    {
        if ($lokasiId) {
            return HariOperasional::where('lokasi_id', $lokasiId)
                ->where('is_disabled', false)
                ->orderBy('hari_operasional')
                ->get();
        }
        return collect();
    }

    #[On('openModalCreate')]
    public function openModalCreate()
    {
        $this->resetValidation();
        $this->resetForm();

        $this->lokasiId = auth()->user()->lokasi_id;
        $this->onLokasiChanged($this->lokasiId);

        $this->showModal = true;
    }

    #[On('closeModalCreate')]
    public function closeModalCreate()
    {
        $this->showModal = false;
    }

    public function updatedLokasiId($value)
    {
        $this->onLokasiChanged($value);
    }

    public function updatedModeTanggal()
    {
        $this->onModeTanggalChanged();

        if ($this->modeTanggal === 'multi') {
            $this->modeJam = 'manual';
        } elseif ($this->modeTanggal === 'range') {
            $this->modeJam = 'full';
        }
    }

    public function updatedTanggalMulti($value)
    {
        $this->onTanggalMultiChanged($value);
        $this->modeJam = 'manual';
    }

    public function updatedTanggalRange($value)
    {
        if (!$value)
            return;

        [$start, $end] = explode(' - ', $value);
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        $this->tanggalAktif = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $this->tanggalAktif[] = $date->format('Y-m-d');
        }

        // Reset jam yang dipilih per tanggal
        foreach ($this->tanggalAktif as $tanggal) {
            $this->jamTerpilih[$tanggal] = [];
        }

        $this->modeJam = 'full';
        $this->loadJadwalSudahDibooking();
    }

    public function updatedFullDay($value)
    {
        if ($value) {
            foreach ($this->tanggalAktif as $tanggal) {
                $this->jamTerpilih[$tanggal] = ['07:10 - 08:50', '08:50 - 10:30', '10:30 - 12:10', '13:00 - 14:40', '14:40 - 16:20'];
            }
        } else {
            foreach ($this->tanggalAktif as $tanggal) {
                $this->jamTerpilih[$tanggal] = [];
            }
        }
    }

    public function updatedJamRentangTerpilih($value)
    {
        foreach ($this->tanggalAktif as $tanggal) {
            $this->jamTerpilih[$tanggal] = $value ?? [];
        }
    }

    public function updatedHariTerpilih($value)
    {
        $this->onHariTerpilihChanged();
    }

    protected function onLokasiChanged($value)
    {
        if ($value) {
            $unit = User::with('unit')->where('id', auth()->user()->id)->first();
            $kodeUnit = $unit->unit->kode_unit;
            $jenisUnit = $unit->unit->jenis_unit;

            if ($jenisUnit == 'lembaga') {
                $this->laboratoriumList = LaboratoriumUnpam::where('status_laboratorium', 1)
                    ->where('lokasi_id', $value)->get();
            } else {
                $this->laboratoriumList = LaboratoriumUnpam::where('lokasi_id', $value)
                    ->whereHas('unit', function ($query) use ($kodeUnit) {
                        $query->where('kode_unit', '00000') 
                            ->orWhere('kode_unit', $kodeUnit);
                    })->get();
            }

            $this->hariOperasionalList = $this->loadHariOperasionalByLokasi($value);
        } else {
            $this->laboratoriumList = [];
            $this->hariOperasionalList = collect();
        }



        $this->laboratoriumIds = [];
        $this->tanggalMulti = [];
        $this->jamOperasionalPerTanggal = [];
        $this->jamTerpilih = [];
        $this->dispatch('resetLaboratoriumSelect');
        $this->dispatch('resetTanggalMultiFlatpickr');
        $this->dispatch('initFlatpickrWithHariAktif', ['hariAktif' => $this->hariAktif]);
        $this->dispatch('resetTanggalRangeFlatpickr');
    }


    protected function onModeTanggalChanged()
    {
        $this->tanggalMulti = [];
        $this->jamOperasionalPerTanggal = [];
        $this->jamTerpilih = [];
        $this->hariTerpilih = [];
    }

    protected function onTanggalMultiChanged($value)
    {
        $this->jamOperasionalPerTanggal = [];
        if (is_string($value)) {
            $value = explode(',', $value);
        }
        // Bersihkan jamTerpilih dari tanggal yang tidak ada di tanggalMulti
        $this->jamTerpilih = array_filter(
            $this->jamTerpilih,
            fn($tanggal) => in_array($tanggal, $this->tanggalMulti),
            ARRAY_FILTER_USE_KEY
        );
        $this->setJamOperasionalFromTanggalMulti($value);
        $this->tanggalAktif = $value;
        $this->loadJadwalSudahDibooking();
    }

    protected function onTanggalRangeChanged()
    {
        $this->filterTanggalByHari();
    }

    protected function onHariTerpilihChanged()
    {
        $this->filterTanggalByHari();
    }

    protected function filterTanggalByHari()
    {
        $this->tanggalFiltered = [];
        $this->jamOperasionalPerTanggal = [];

        if (!$this->tanggalRange || empty($this->hariTerpilih)) {
            $this->jamTerpilih = [];
            return;
        }

        $parts = explode(' - ', $this->tanggalRange);
        if (count($parts) !== 2) {
            $this->jamTerpilih = [];
            return;
        }

        try {
            $start = Carbon::parse(trim($parts[0]));
            $end = Carbon::parse(trim($parts[1]));
        } catch (\Exception $e) {
            $this->jamTerpilih = [];
            return;
        }

        $current = $start->copy();
        while ($current->lte($end)) {
            $hari = $current->dayOfWeek;
            if (in_array($hari, array_map('intval', $this->hariTerpilih))) {
                $tanggalStr = $current->format('Y-m-d');
                $this->tanggalFiltered[] = $tanggalStr;
                $this->jamOperasionalPerTanggal[$tanggalStr] = $this->getJamOperasionalForTanggal($tanggalStr);
            }
            $current->addDay();
        }

        // Sinkronkan jamTerpilih dengan tanggalFiltered
        $this->jamTerpilih = array_filter(
            $this->jamTerpilih,
            fn($tanggal) => in_array($tanggal, $this->tanggalFiltered),
            ARRAY_FILTER_USE_KEY
        );
    }

    public function validatePengajuanBooking()
    {
        $rules = [
            'laboratoriumIds' => 'required|array|min:1',
            'laboratoriumIds.*' => 'exists:laboratorium_unpams,id',
            'modeTanggal' => 'required|in:multi,range',
            'keperluanBooking' => 'required|string|max:255'
        ];

        if ($this->modeTanggal === 'multi') {
            $rules = array_merge($rules, [
                'tanggalMulti' => 'required|array|min:1',
                'tanggalMulti.*' => 'date',
            ]);

            if ($this->modeJam === 'manual') {
                $rules = array_merge($rules, [
                    'jamTerpilih' => 'required|array|min:1',
                    'jamTerpilih.*' => 'array|min:1',
                    'jamTerpilih.*.*' => 'string',
                ]);
            }
        } elseif ($this->modeTanggal === 'range') {
            $rules = array_merge($rules, [
                'tanggalRange' => 'required|string',
            ]);

            if ($this->modeJam === 'manual') {
                $rules = array_merge($rules, [
                    'jamTerpilih' => 'required|array|min:1',
                    'jamTerpilih.*' => 'array|min:1',
                    'jamTerpilih.*.*' => 'string',
                ]);
            }
        }


        return $this->validate($rules);
    }

    protected function checkPengajuanBookingMenunggu($laboratoriumId, $tanggal, $jamMulai, $jamSelesai)
    {
        return JadwalBooking::whereHas('pengajuanBooking', function ($q) {
            $q->where('user_id', auth()->id())
                ->where('status_pengajuan_booking', 'menunggu');
        })
            ->where('laboratorium_unpam_id', $laboratoriumId)
            ->where('tanggal_jadwal', $tanggal)
            ->where('jam_mulai', $jamMulai)
            ->where('jam_selesai', $jamSelesai)
            ->exists();
    }

    protected function resolveSlotTanggal($tanggal, $jamTerpilih)
    {
        \Log::debug("🕒 Jam Terpilih Tanggal $tanggal:", [
            'modeJam' => $this->modeJam,
            'jam' => $jamTerpilih[$tanggal] ?? null
        ]);

        $hari = Carbon::parse($tanggal)->dayOfWeek;

        if ($this->modeJam === 'manual') {
            return $jamTerpilih[$tanggal] ?? [];
        }

        // mode full
        return in_array($hari, [4, 6]) ? [
            ['07:40:00', '09:20:00'],
            ['09:20:00', '11:00:00'],
            ['11:00:00', '13:50:00'],
            ['13:50:00', '15:30:00'],
            ['16:00:00', '17:40:00'],
        ] : [
            ['07:10:00', '08:50:00'],
            ['08:50:00', '10:30:00'],
            ['10:30:00', '12:10:00'],
            ['13:00:00', '14:40:00'],
            ['14:40:00', '16:20:00'],
        ];
    }


    protected function formatJamToDb($jam)
    {
        $trimmed = trim($jam);

        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $trimmed)) {
            // Sudah dalam format H:i:s
            return $trimmed;
        }

        // Jika masih H:i
        return Carbon::createFromFormat('H:i', $trimmed)->format('H:i:s');
    }


    protected function parseJamSlot($jam, $tanggal)
    {
        $hari = Carbon::parse($tanggal)->dayOfWeek;

        if (is_string($jam)) {
            if (str_contains($jam, '/')) {
                [$jamSeninJumat, $jamKamisSabtu] = array_map('trim', explode('/', $jam));
                $jamFinal = in_array($hari, [4, 6]) ? $jamKamisSabtu : $jamSeninJumat;
            } else {
                $jamFinal = $jam;
            }

            // Pastikan format benar
            if (!str_contains($jamFinal, '-')) {
                \Log::warning("⚠️ Jam tidak valid: '$jamFinal' pada tanggal $tanggal");
                return [null, null];
            }

            [$mulai, $selesai] = array_map('trim', explode('-', $jamFinal));
        } else {
            [$mulai, $selesai] = $jam;
        }

        return [
            $this->formatJamToDb($mulai),
            $this->formatJamToDb($selesai),
        ];
    }



    protected function cekBentrok($labId, $tanggal, $mulai, $selesai, $lab, &$errors)
    {
        $bentrok = JadwalBooking::whereHas('pengajuanBooking', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->where('laboratorium_unpam_id', $labId)
            ->where('tanggal_jadwal', $tanggal)
            ->where('jam_mulai', $mulai)
            ->where('jam_selesai', $selesai)
            ->whereNot('status', 'dibatalkan')
            ->with('pengajuanBooking')
            ->first();

        if ($bentrok) {
            $tanggalFormatted = Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y');
            $status = $bentrok->pengajuanBooking->status_pengajuan_booking ?? '-';
            $errors[] = "Tanggal <b>{$tanggalFormatted}</b> Jam <b>{$mulai} - {$selesai}</b> di <b>{$lab->nama_laboratorium}</b> (<b>" . ucfirst($status) . "</b>)";
            return true;
        }

        return false;
    }


    protected function prosesSimpanPengajuanBooking($pengajuan, $laboratoriumIds, $tanggalList, $jamTerpilih)
    {
        $errors = [];

        foreach ($laboratoriumIds as $labId) {
            $lab = LaboratoriumUnpam::find($labId);

            foreach ($tanggalList as $tanggal) {
                if ($this->modeJam === 'manual' && empty($this->jamTerpilih[$tanggal])) {
                    session()->flash('error', "Jam belum dipilih untuk tanggal $tanggal");
                    return;
                }
                $slotTanggal = $this->resolveSlotTanggal($tanggal, $jamTerpilih);

                if (empty($slotTanggal))
                    continue;

                foreach ($slotTanggal as $jam) {
                    [$mulai, $selesai] = $this->parseJamSlot($jam, $tanggal);

                    if ($this->cekBentrok($labId, $tanggal, $mulai, $selesai, $lab, $errors)) {
                        continue;
                    }
                }
            }
        }

        if (!empty($errors)) {
            if ($this->modeJam === 'full') {
                // Ambil lab dan tanggal unik dari daftar error
                $labList = collect($errors)->map(function ($text) {
                    preg_match('/di <b>(.*?)<\/b>/', $text, $lab);
                    return $lab[1] ?? null;
                })->filter()->unique()->values()->all();

                $tanggalList = collect($errors)->map(function ($text) {
                    preg_match('/Tanggal <b>(.*?)<\/b>/', $text, $tgl);
                    return $tgl[1] ?? null;
                })->filter()->unique()->values()->all();

                $labStr = implode(', ', $labList);
                $tglStr = count($tanggalList) > 1
                    ? $tanggalList[0] . ' – ' . end($tanggalList)
                    : ($tanggalList[0] ?? '-');

                session()->flash('error', [
                    'Pengajuan tidak dapat diproses karena terdapat bentrok dengan jadwal aktif di <b>' . $labStr . '</b> pada tanggal <b>' . $tglStr . '</b>.'
                ]);
            } else {
                session()->flash('error', [
                    'Pengajuan Bentrok:',
                    ...$errors
                ]);
            }

            return false;
        }


        // Simpan ke DB
        foreach ($laboratoriumIds as $labId) {
            foreach ($tanggalList as $tanggal) {
                $slotTanggal = $this->resolveSlotTanggal($tanggal, $jamTerpilih);

                if (empty($slotTanggal))
                    continue;

                foreach ($slotTanggal as $jam) {
                    [$mulai, $selesai] = $this->parseJamSlot($jam, $tanggal);

                    JadwalBooking::create([
                        'pengajuan_booking_id' => $pengajuan->id,
                        'laboratorium_unpam_id' => $labId,
                        'tanggal_jadwal' => $tanggal,
                        'jam_mulai' => $mulai,
                        'jam_selesai' => $selesai,
                        'status' => 'menunggu',
                    ]);
                }
            }
        }

        return true;
    }


    public function simpanPengajuanBooking()
    {
        try {
            $data = $this->validatePengajuanBooking();
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'Validasi gagal: ' . json_encode($e->errors()));
            return;
        }

        DB::beginTransaction();

        try {
            $kodeBooking = 'Book-' . strtoupper(\Illuminate\Support\Str::random(8));

            $pengajuan = PengajuanBooking::create([
                'kode_booking' => $kodeBooking,
                'status_pengajuan_booking' => 'menunggu',
                'keperluan_pengajuan_booking' => $this->keperluanBooking,
                'mode_tanggal_pengajuan' => $this->modeTanggal,
                'lokasi_id' => $this->lokasiId,
                'user_id' => auth()->id(),
            ]);

            $tanggalList = $this->modeTanggal === 'multi' ? $this->tanggalMulti : $this->tanggalAktif;
            $result = $this->prosesSimpanPengajuanBooking($pengajuan, $this->laboratoriumIds, $tanggalList, $this->jamTerpilih);

            if ($result === false) {
                DB::rollBack();
                return;
            }

            DB::commit();

            // Reset form
            $this->reset(['laboratoriumIds', 'laboratoriumList', 'tanggalMulti', 'tanggalRange', 'hariTerpilih', 'jamOperasionalPerTanggal', 'jamTerpilih', 'keperluanBooking']);
            $this->modeTanggal = 'multi';
            $this->dispatch('resetLokasiSelect');
            $this->dispatch('resetLaboratoriumSelect');
            $this->dispatch('resetTanggalMultiFlatpickr');
            $this->dispatch('resetTanggalRangeFlatpickr');

            session()->flash('success', 'Pengajuan booking berhasil disimpan!');
            $this->showModal = false;
            $this->dispatch('bookingDisimpan');
            $this->refreshTable();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan pengajuan: ' . $e->getMessage());
        }
    }

    public function getHariAktifProperty()
    {
        return HariOperasional::where('lokasi_id', $this->lokasiId)
            ->where('is_disabled', false)
            ->pluck('hari_operasional')
            ->toArray();
    }

    public function refreshTable()
    {
        $this->dispatch('pg:eventRefresh-pengajuan_bookings');
    }

    public function render()
    {
        $listJam = $this->lokasiId ? $this->getListJamByLokasi() : [];
        $lokasis = Lokasi::select(['id', 'nama_lokasi'])->whereNot('nama_lokasi', 'fleksible')->get();

        return view('livewire.pengguna.booking.form-pengajuan-booking-create', [
            'lokasis' => $lokasis,
            'listJam' => $listJam,
            'tanggalAktif' => $this->tanggalAktif,
        ]);
    }
}