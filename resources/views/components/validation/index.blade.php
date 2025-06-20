<<<<<<< HEAD
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {!! session('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! session('error') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Periksa kembali inputan Anda!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
=======
<div aria-live="polite" aria-atomic="true" class="position-absolute p-3 top-3 start-50 translate-middle-x" style="z-index: 2; max-width: 20rem;">
    {{-- Success --}}
    @if (session('success'))
        <div class="toast bg-white border-0 show mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto d-flex align-items-center"> <i data-feather="check-circle" width="20" class="me-1"></i> Berhasil</strong>
                <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {!! session('success') !!}
            </div>
        </div>
    @endif

    {{-- Error --}}
    @if (session('error'))
        <div class="toast bg-white border-0 show mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto d-flex align-items-center"> <i data-feather="alert-octagon" width="20" class="me-1"></i> Gagal</strong>
                <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {!! session('error') !!}
            </div>
        </div>
    @endif
</div>
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
