{{-- ALERTAS SWEETALERT --}}

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if (session('status'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Atenção',
        text: '{{ session('status') }}',
        timer: 4000,
        showConfirmButton: false
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Erros no formulário',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonText: 'OK'
    });
</script>
@endif

{{-- ALERTAS VISUAIS BACKUP (caso SweetAlert não carregue) --}}
<noscript>
<div style="margin-top: 10px; text-align: center;">
    @if (session('status'))
        <div style="color: #00ff88;">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: #ff8080;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
</div>
</noscript>

