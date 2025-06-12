@if(session('success'))
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

@if(session('error'))
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

@if ($errors->any())
<script>
    let mensagens = {!! json_encode($errors->all()) !!};
    Swal.fire({
        icon: 'warning',
        title: 'Erros no formulário',
        html: mensagens.join('<br>'),
        confirmButtonText: 'OK'
    });
</script>
@endif
