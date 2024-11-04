$("#password-addon").on("click", function () {
	0 < $(this).siblings("input").length &&
		("password" == $(this).siblings("input").attr("type")
			? $(this).siblings("input").attr("type", "input")
			: $(this).siblings("input").attr("type", "password"));
});

$("#repassword-addon").on("click", function () {
	0 < $(this).siblings("input").length &&
		("password" == $(this).siblings("input").attr("type")
			? $(this).siblings("input").attr("type", "input")
			: $(this).siblings("input").attr("type", "password"));
});

function validateForm() {
    // Ambil elemen input
    var password = document.getElementById('userpassword');
    var repassword = document.getElementById('repassword');
    
    // Ambil elemen invalid-feedback untuk menampilkan pesan error
    var passwordError = document.getElementById('password-error');
    var repasswordError = document.getElementById('repassword-error');
    
    // Reset pesan error
    passwordError.textContent = '';
    repasswordError.textContent = '';

    // Variabel untuk mengecek validitas
    var valid = true;

    // Validasi jika password tidak diisi
    if (password.value === '') {
        passwordError.textContent = 'Please enter password';
        password.classList.add('is-invalid');
        valid = false;
    } else if (password.value.length < 8) {
        // Validasi panjang password minimal 8 karakter
        passwordError.textContent = 'Password must be at least 8 characters long';
        password.classList.add('is-invalid');
        valid = false;
    } else {
        password.classList.remove('is-invalid');
        password.classList.add('is-valid');
    }

    // Validasi jika re-password tidak diisi
    if (repassword.value === '') {
        repasswordError.textContent = 'Please confirm password';
        repassword.classList.add('is-invalid');
        valid = false;
    } else if (password.value !== repassword.value) {
        // Validasi jika password dan re-password tidak sama
        repasswordError.textContent = 'Passwords do not match';
        repassword.classList.add('is-invalid');
        valid = false;
    } else {
        repassword.classList.remove('is-invalid');
        repassword.classList.add('is-valid');
    }

    // Return valid (false jika ada error, form tidak akan dikirim)
    return valid;
}