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
  <br>
	<h1 class="text-center mb-4">Form Create</h1>
  <br>
	<form action="{{ route('peran.store') }}" method="POST" id="quickForm">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="actor">Peran:</label>
                    <input type="text" id="actor" name="actor" class="form-control" placeholder="Masukkan Peran" maxlength="255" required>
                  </div>
                  <div class="form-group">
                    <label for="cast_id">Cast ID:</label>
                    <input type="number" id="cast_id" name="cast_id" class="form-control" placeholder="Masukkan Cast_id" required>
                  </div>
                  <div class="form-group">
                    <label for="film_id">Film ID:</label>
                    <input type="number" id="film_id" class="form-control" placeholder="Masukkan Film_id" name="film_id" required>
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Buat</button>
                  <br>
                </div>
              </form>
            </div>
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

		// Validasi form peran
		$('#quickForm').on('submit', function(e) {
			e.preventDefault(); // Mencegah pengiriman form secara default
			var isValid = true;
			var errors = [];

			// Validasi input kosong
			if ($('#actor').val().trim() === '') {
				isValid = false;
				errors.push("Aktor");
			}
			if ($('#cast_id').val().trim() === '') {
				isValid = false;
				errors.push("Cast ID");
			}
			if ($('#film_id').val().trim() === '') {
				isValid = false;
				errors.push("Film ID");
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
				var formData = new FormData(this);

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						Swal.fire({
							title: 'Berhasil!',
							text: 'Data Peran berhasil ditambahkan!',
							icon: 'success',
							confirmButtonText: 'Tutup'
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = "{{ route('peran.index') }}";
							}
						});
					},
					error: function(xhr) {
						let errorMessage = 'Terjadi kesalahan saat menambahkan peran.';
						
						if (xhr.responseJSON && xhr.responseJSON.message) {
							errorMessage = xhr.responseJSON.message;
						}
						
						Swal.fire({
							title: 'Error!',
							text: errorMessage,
							icon: 'error',
							confirmButtonText: 'Tutup'
						});
					}
				});
			}
		});
	});
</script>


<!-- //here ends scrolling icon -->
</body>
</html>