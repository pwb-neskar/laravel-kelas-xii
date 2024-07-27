@extends('templates.index')

@push('style')
  <link rel="stylesheet" type="text/css" href="{{ asset('template/list-css/table-style.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('template/list-css/basictable.css') }}" />
@endpush

@push('scripts')
  <script type="text/javascript" src="{{ asset('template/list-js/jquery.basictable.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();
      $('#table-breakpoint').basictable({
        breakpoint: 768
      });
    });
  </script>
@endpush

@section('content')
    <div class="container">
        <h1>Create a New Peran</h1>
        <form action="{{ route('perans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <!-- Example of using $perans -->
            <div class="form-group">
                <label for="peran">Peran:</label>
                <select class="form-control" id="peran" name="peran_id">
                    @forelse($perans as $value)
                        <option value="{{ $value->id }}">{{ $value->actor }}</option>
                    @empty
                        <option value="">No data available</option>
                    @endforelse
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
    <!-- Your custom scripts can go here -->
@endpush
