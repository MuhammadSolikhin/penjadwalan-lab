@php
    use Carbon\Carbon;
@endphp

<div>
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);" aria-modal="true"
            role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pengajuan Booking</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Kode Booking:</strong> {{ $pengajuan->kode_booking ?? '-' }}</p>
                        <p><strong>Pengajuan Oleh:</strong> {{ $pengajuan->user->nama_pengguna ?? '-' }}</p>
                        <p><strong>Prioritas:</strong> {{ $pengajuan->user->role->prioritas_peran ?? '-' }}</p>
                        <p><strong>Lokasi:</strong> {{ $pengajuan->lokasi->nama_lokasi ?? '-' }}</p>
                        <p><strong>Keperluan:</strong> {{ $pengajuan->keperluan_pengajuan_booking ?? '-' }}</p>
                        <p><strong>Balasan:</strong> {{ $pengajuan->balasan_pengajuan_booking ?? '-' }}</p>

                        <hr>
                        <p><strong>Detail Jadwal Booking:</strong></p>
                        <div style="max-height:300px;overflow:auto">
                            <table class="table table-bordered table-sm" style="font-size: 0.9em">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Status</th>
                                        <th>Lab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengajuan->jadwalBookings as $jadwal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_jadwal)->format('Y-m-d') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} s/d
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                            <td
                                                style="color: {{ $jadwal->status === 'menunggu' ? '#9ca3af' : ($jadwal->status === 'diterima' ? 'green' : 'red') }}">
                                                ● {{ ucfirst($jadwal->status) }}
                                            </td>
                                            <td>{{ $jadwal->laboratoriumUnpam->nama_laboratorium ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">Tidak ada jadwal booking.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    @endif
</div>