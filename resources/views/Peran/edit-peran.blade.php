<!DOCTYPE html>
<html lang="en">

@include('templates.component.head')

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
	<h1 class="text-center mb-4">Edit Peran</h1>
	<form id="peranEditForm" action="{{ route('peran.update', $peran->id) }}" method="POST">
		@csrf
		@method('PUT')
		
		<div class="form-group">
			<label for="aktor">Masukan Peran</label>
			<input type="text" class="form-control" name="aktor" id="aktor" value="{{ $peran->id }} - {{ $peran->actor }}">
		</div>
		
		<div class="form-group">
			<label for="cast_id">Masukkan Cast</label>
			<input type="number" class="form-control" name="cast_id" id="cast_id" value="{{ $peran->cast ? $peran->cast->id : '' }}">
		</div>
					

		<div class="form-group">
			<label for="film_id">Pilih Film</label>
			<input type="number" name="film_id" id="film_id" class="form-control" value="{{ $peran->film ? $peran->film->id : '' }} ">
		</div>

		<button type="submit" class="btn btn-primary">Update Peran</button>
	</form>
</div>
<!-- //comedy-w3l-agileits -->
<!-- footer -->
@include('templates.component.footer')
<!-- //footer -->

<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
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

		$('#peranEditForm').on('submit', function(e) {
			e.preventDefault(); // Mencegah pengiriman form secara default
			var isValid = true;
			var errors = [];

			if ($('#aktor').val().trim() === '') {
				isValid = false;
				errors.push("Nama Aktor");
			}
			if ($('#cast_id').val().trim() === '') {
				isValid = false;
				errors.push("Cast");
			}
			if ($('#film_id').val().trim() === '') {
				isValid = false;
				errors.push("Film");
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
					contentType: false,
					processData: false,
					success: function(response) {
						if (response.success) {
							Swal.fire({
								title: 'Berhasil!',
								text: response.success,
								icon: 'success',
								confirmButtonText: 'Tutup'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = "{{ route('peran.index') }}"; 
								}
							});
						} else {
							Swal.fire({
								title: 'Error!',
								text: response.error,
								icon: 'error',
								confirmButtonText: 'Tutup'
							});
						}
					},
					error: function(xhr) {
						Swal.fire({
							title: 'Error!',
							text: 'Terjadi kesalahan saat memperbarui peran.',
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