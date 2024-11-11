<!DOCTYPE html>
<html lang="en">

@include('templates.component.head')

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<body>
<!-- header -->
@include('templates.component.header')
<!-- //header -->
<!-- bootstrap-pop-up -->
@include('templates.component.login')
<!-- //bootstrap-pop-up -->
<!-- nav -->
@include('templates.component.navbar')
<!-- //nav -->
<div class="general_social_icons">
	<nav class="social">
		<ul>
			<li class="w3_twitter"><a href="#">Twitter <i class="fa fa-twitter"></i></a></li>
			<li class="w3_facebook"><a href="#">Facebook <i class="fa fa-facebook"></i></a></li>
			<li class="w3_dribbble"><a href="#">Dribbble <i class="fa fa-dribbble"></i></a></li>
			<li class="w3_g_plus"><a href="#">Google+ <i class="fa fa-google-plus"></i></a></li>				  
		</ul>
	</nav>
</div>
<!-- /w3l-medile-movies-grids -->
<div class="container mt-5">
	<h1 class="text-center mb-4">Form Create</h1>
    <form id="filmForm" action="{{ route('film.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
		<div class="form-group">
			<label for="title">Masukan Judul</label>
			<input type="text" class="form-control" name="title" id="title" placeholder="MASUKAN JUDUL">
		</div>
		<div class="form-group">
			<label for="sinopsis">Sinopsis</label>
			<textarea name="sinopsis" id="sinopsis" class="form-control" cols="30" rows="10"></textarea>
		</div>
		<div class="form-group">
			<label for="year">Masukan Tahun</label>
			<input type="number" class="form-control" name="year" id="year" placeholder="MASUKAN TAHUN">
		</div>
		<div class="form-group">
			<label for="poster">Upload Poster</label>
			<input type="file" class="form-control" name="poster" id="poster" accept="image/*" required>
		</div>		
		<div class="form-group">
			<label for="genre_id">Pilih Genre</label>
			<select name="genre_id" id="genre_id" class="form-control @error('genre_id') is-invalid @enderror" required>
				<option value="">Pilih Genre</option>
				@foreach($genres as $genre)
					<option value="{{ $genre->id }}">{{ $genre->name }}</option>
				@endforeach
			</select> 
		</div>
		<button type="submit" class="btn btn-primary">Tambah Data</button>
	</form>
</div>
<!-- //comedy-w3l-agileits -->
<!-- footer -->
@include('templates.component.footer')
<!-- //footer -->

<!-- sweet alert2 js  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
	$(document).ready(function(){
		$(".dropdown").hover(            
			function() {
				$('.dropdown-menu', this).stop(true, true).slideDown("fast");
				$(this).toggleClass('open');        
			},
			function() {
				$('.dropdown-menu', this).stop(true, true).slideUp("fast");
				$(this).toggleClass('open');       
			}
		);

		$('#filmForm').on('submit', function(e) {
    e.preventDefault(); // Mencegah pengiriman form secara default
    var isValid = true;
    var errors = [];

    if ($('#title').val().trim() === '') {
        isValid = false;
        errors.push("Judul");
    }
    if ($('#sinopsis').val().trim() === '') {
        isValid = false;
        errors.push("Sinopsis");
    }
    if ($('#year').val().trim() === '') {
        isValid = false;
        errors.push("Tahun");
    }
    if ($('#poster').val().trim() === '') {
        isValid = false;
        errors.push("Poster");
    }
    if ($('#genre_id').val().trim() === '') {
        isValid = false;
        errors.push("Genre");
    }

    if (!isValid) {
        var errorText = "Tolong isi kolom:\n" + errors.join(", ");
        Swal.fire({
            title: 'Peringatan!',
            text: errorText,
            icon: 'error',
            confirmButtonText: 'Tutup'
        });
    } else {
        var formData = new FormData(this); // Menggunakan FormData untuk menangani form dengan file

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false, // Penting: jangan ubah konten tipe
            processData: false, // Penting: jangan proses data
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Film berhasil ditambahkan!',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('film.index') }}"; // Redirect ke halaman film.index
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menambahkan film.',
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    }
});

	});
	
</script>

<!-- here stars scrolling icon -->
<script type="text/javascript">
	$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
	});
	@stack('script')
</script>
<!-- //here ends scrolling icon -->
</body>
</html>