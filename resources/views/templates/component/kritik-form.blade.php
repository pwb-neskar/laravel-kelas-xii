@if (session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif

@auth
  @if (auth()->user()->hasRole('user'))
    <form action="{{ route('kritik.store', $film) }}" method="post">
      @csrf
      <select name="rating" required>
        <option value="">Rating</option>
        @for ($i = 5; $i >= 1; $i--)
          <option value="{{ $i }}" {{ (string) old('rating') === (string) $i ? 'selected' : '' }}>{{ $i }} / 5</option>
        @endfor
      </select>
      @error('rating') <p style="color:red">{{ $message }}</p> @enderror
      <textarea name="comment" rows="4" maxlength="1000" required
        placeholder="Tulis kritik atau komentar...">{{ old('comment') }}</textarea>
      @error('comment') <p style="color:red">{{ $message }}</p> @enderror
      <input type="submit" value="Kirim">
    </form>
  @endif
@else
  <p><a href="#" data-toggle="modal" data-target="#myModal">Login</a> untuk memberi kritik.</p>
@endauth