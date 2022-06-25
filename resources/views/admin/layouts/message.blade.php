@if ($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger my-2">{{ $error }}</div>
    @endforeach
@endif

{{-- Check For Session Messages --}}
@if (session('success'))
    <div class="alert alert-success my-2">{{session('success')}}</div> 
@endif

{{-- Check For Session Error Messages--}}
@if (session('error'))
    <div class="alert alert-danger my-2">{{ session('error') }}</div>
@endif