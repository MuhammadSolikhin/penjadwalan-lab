@php
    use \Carbon\Carbon;
@endphp

<div>
    <!-- Button trigger modal -->
    <button type="button" class="mybtn mybtn-primary p-2" wire:click="$dispatchSelf('openModalCreate')">
        Buat Pengajuan
    </button>

    <!-- Modal -->
    @if ($showModal)
        <div class="modal fade show d-block" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <form wire:submit.prevent="simpanPengajuanBooking">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Buat Pengajuan Booking</h1>
                            <button type="button" class="btn-close" wire:click="$dispatchSelf('closeModalCreate')" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @php $errors = (array) session('error'); @endphp
                                    @if (count($errors) > 1)
                                        <div class="fw-bold mb-1">{!! $errors[0] !!}</div>
                                        <ul class="mb-0">
                                            @foreach ($errors as $i => $err)
                                                @if ($i === 0) @continue @endif
                                                <li>{!! $err !!}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div>{!! $errors[0] !!}</div>
                                    @endif
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(!empty($laboratoriumList))
                                <div class="mb-3" x-data x-init="initFuncInput.initLaboratoriumSelect2($el.querySelector('select'), $wire)" wire:key="laboratorium-list-{{ md5(json_encode($laboratoriumList)) }}" wire:ignore>
                                    <label for="laboratoriumId" class="form-label">Laboratorium</label>
                                    <select id="laboratoriumid" class="form-select select2-fit" multiple style="width: 100%">
                                        @foreach ($laboratoriumList as $lab)
                                            <option value="{{ $lab->id }}">{{ $lab->nama_laboratorium }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="form-label">Mode Tanggal</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="modeMulti" value="multi" wire:model.live="modeTanggal">
                                            <label class="form-check-label" for="modeMulti">Manual</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="modeRange" value="range" wire:model.live="modeTanggal">
                                            <label class="form-check-label" for="modeRange">Rentang</label>
                                        </div>
                                    </div>
                                </div>

                                @if ($modeTanggal === "multi")
                                    <div class="mb-3" wire:key="tanggal-multi-{{ $lokasiId }}" x-data x-init="initFuncInput.initTanggalMultiFlatpickr($refs.tanggalMulti, $wire, @js($this->hariAktif))" wire:ignore>
                                        <label for="tanggalMulti" class="form-label">Tanggal (Manual)</label>
                                        <input type="text" x-ref="tanggalMulti" class="form-control">
                                    </div>

                                    @if (!empty($jamOperasionalPerTanggal))
                                        @foreach ($jamOperasionalPerTanggal as $tanggal => $jams)
                                            <div class="mb-3" wire:key="jam-{{ $tanggal }}" x-data x-init="initFuncInput.initJamOperasionalSelect2($el.querySelector('select'), $wire, '{{ $tanggal }}')" wire:ignore>
                                                <label class="form-label">
                                                    {{ Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                                </label>
                                                <select id="jamSelect{{ $tanggal }}" class="form-select" multiple>
                                                    @foreach ($jams as $jam)
                                                        @php
                                                            $bagianJam = explode('/', $jam);
                                                            $hari = Carbon::parse($tanggal)->dayOfWeek;

                                                            if (in_array($hari, [4, 6])) {
                                                                // Kamis (4) atau Sabtu (6): pakai bagian kedua
                                                                $jamYangDicek = trim($bagianJam[1] ?? $bagianJam[0]);
                                                            } else {
                                                                // Hari lainnya: pakai bagian pertama
                                                                $jamYangDicek = trim($bagianJam[0]);
                                                            }

                                                            $disabled = in_array($jamYangDicek, $jadwalSudahDibooking[$tanggal] ?? []);
                                                        @endphp

                                                        <option value="{{ $jam }}"
                                                            @if (in_array($jam, $jamTerpilih[$tanggal] ?? [])) selected @endif
                                                            @if ($disabled) disabled @endif>
                                                            {{ $jam }} @if ($disabled) (Sudah dibooking) @endif
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        @endforeach
                                    @endif

                                @elseif ($modeTanggal === "range")
                                    <div class="mb-3" x-data x-init="initFuncInput.initTanggalRangeFlatpickr($refs.tanggalRange, $wire)" wire:ignore>
                                        <label for="tanggalRange" class="form-label">Tanggal (Rentang)</label>
                                        <input type="text" x-ref="tanggalRange" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jam Operasional</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jamManual" value="manual" wire:model.live="modeJam">
                                                <label class="form-check-label" for="jamManual">Manual (Pilih Jam)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jamFull" value="full" wire:model="modeJam">
                                                <label class="form-check-label" for="jamFull">Full Day (07:00 - 17:00)</label>
                                            </div>
                                        </div>
                                    </div>

                                    @if (in_array($modeJam, ['manual', 'full']))
                                       <div
                                            x-data
                                            x-show="$wire.modeJam === 'manual'"
                                            wire:ignore
                                            wire:key="jam-manual-select2-{{ implode('-', $tanggalAktif) }}"
                                            x-init="initFuncInput.initJamOperasionalSelect2($el.querySelector('select'), $wire, 'rentang', @js($jamRentangTerpilih));">
                                            <label class="form-label">Pilih Jam (berlaku untuk semua tanggal)</label>
                                            @php
                                                $hariIndex = isset($tanggalAktif[0])
                                                    ? Carbon::parse($tanggalAktif[0])->dayOfWeek
                                                    : now()->dayOfWeek;

                                                $jamListForHari = $listJam[$hariIndex] ?? [
                                                    '07:10 - 08:50', '08:50 - 10:30', '10:30 - 12:10',
                                                    '13:00 - 14:40', '14:40 - 16:20', '18:20 - 20:00', '20:00 - 21:40'
                                                ];
                                            @endphp

                                            <select id="jam-rentang" class="form-select" multiple>
                                                @foreach ($jamListForHari as $jam)
                                                    @php
                                                         // Ambil bagian pertama sebelum slash
                                                        $jamUtama = explode('/', $jam)[0] ?? $jam;
                                                        $jamUtama = trim($jamUtama);

                                                        $disabledGlobal = false;
                                                        foreach ($tanggalAktif as $tgl) {
                                                            if (in_array($jamUtama, $jadwalSudahDibooking[$tgl] ?? [])) {
                                                                $disabledGlobal = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <option value="{{ $jam }}"
                                                        @selected(in_array($jam, $jamRentangTerpilih ?? []))
                                                        @if ($disabledGlobal) disabled @endif>
                                                        {{ $jam }} @if ($disabledGlobal) (Sudah dibooking di salah satu hari) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @elseif ($modeJam === 'full')
                                        <div class="text-muted mb-3">Jam: Full Day (07:00 - 17:00 berlaku untuk semua tanggal)</div>
                                    @endif

                                @endif

                                <div class="mb-3">
                                    <label for="keperluanBooking">Keperluan</label>
                                    <textarea id="keperluanBooking" class="form-control" wire:model.defer="keperluanBooking" style="resize:none; max-height:100px; min-height:100px;"></textarea>
                                </div>

                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$dispatchSelf('closeModalCreate')">Tutup</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
