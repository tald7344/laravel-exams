@extends('style.index')

@section('content')

    @if (!Auth::user()->isExamined)
        @include('style.exam.exam', compact('exam'))
    @else
        @include('style.exam.result', compact('exam'))
    @endif

@endsection
@section('scripts')
    <script>
        function exportTasks(_this) {
            let _url = $(_this).data('href');
            window.location.href = _url;
        }
    </script>
@endsection
