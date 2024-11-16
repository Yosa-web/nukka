<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <?= $this->renderSection('title'); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- App favicon -->
		<link rel="shortcut icon" href="/assets/images/logo_litbang.png" />
		<link
			href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap"
			rel="stylesheet" />
		<!-- Bootstrap Css -->
		<link
			href="/assets/css/bootstrap.css"
			id="bootstrap-style"
			rel="stylesheet"
			type="text/css" />
		<!-- Icons Css -->
		<link
			href="/assets/css/icons.min.css"
			rel="stylesheet"
			type="text/css" />
		<link rel="stylesheet" href="/assets/css/slick.css" />
		<link rel="stylesheet" href="/assets/css/homepage.css" />
	</head>
	<body>
		<div id="layout-wrapper">
			<!-- Topbar -->
			<div class="topbar">
				<span>Kabupaten Pesawaran</span>
				<div class="topbar-social">
					<a href="#"><i class="fab fa-facebook"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-youtube"></i></a>
				</div>
			</div>
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg" id="mainNavbar">
				<div class="container-fluid justify-content-between">
					<a class="navbar-brand d-flex align-items-center" href="#">
						<img
							src="/assets/images/logo_litbang.png"
							alt="Logo Balitbang Pesawaran" />
						<span
							style="
								color: #0077c2;
								font-weight: bold;
								font-size: 25px;
							"
							>Balitbang</span
						>
					</a>
					<button
						class="navbar-toggler"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#navbarNav"
						aria-controls="navbarNav"
						aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav mx-auto">
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('beranda') ?>"
									>Beranda</a
								>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('tentang') ?>"
									>Tentang</a
								>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('visi-misi') ?>"
									>Visi & Misi</a
								>
							</li>
							<li class="nav-item dropdown">
								<a
									class="nav-link dropdown-toggle"
									href="#"
									id="databaseInovasiDropdown"
									role="button"
									data-bs-toggle="dropdown"
									aria-expanded="false">
									Database Inovasi
									<i class="bx bxs-chevron-down ms-1"></i>
								</a>
								<div
									class="dropdown-menu"
									aria-labelledby="databaseInovasiDropdown">
									<a
										class="dropdown-item"
										href="database-riset.html"
										>Riset</a
									>
									<a
										class="dropdown-item"
										href="database-inovasi.html"
										>Inovasi</a
									>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('peta-inovasi') ?>"
									>Peta Inovasi</a
								>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('regulasi') ?>"
									>Regulasi</a
								>
							</li>
						</ul>
						<button
							type="button"
							class="btn btn-light btn-rounded waves-effect"
							onclick="window.location.href='login.html'">
							<i
								class="fas fa-user font-size-16 align-middle me-2"></i
							>Masuk
						</button>
					</div>
				</div>
			</nav>

			<!-- Content -->
            <?= $this->renderSection('content'); ?>

			<!-- Footer Section -->
			<footer class="footer">
				<div class="row align-items-center">
					<div class="col-md-3 text-center mb-4 mb-md-0">
						<img
							src="/assets/images/logo_litbang.png"
							alt="Logo Balitbang"
							class="footer-logo" />
					</div>
					<div class="col-md-5 text-md-start mb-4 mb-md-0 ps-4">
						<h3 class="fw-bold">Balitbang.</h3>
						<p>balitbangpesawaran@gmail.com</p>
						<p>(0733) 4540000</p>
						<p>
							Komplek Perkantoran Pemerintah Kabupaten Pesawaran,
							Jalan Raya Kedondong, Way Layap, Kecamatan Gedong
							Tataan, Kabupaten Pesawaran, Provinsi Lampung
						</p>
						<div class="social-links">
							<a href="#"><i class="fab fa-facebook"></i></a>
							<a href="#"><i class="fab fa-twitter"></i></a>
							<a href="#"><i class="fab fa-instagram"></i></a>
							<a href="#"><i class="fab fa-youtube"></i></a>
						</div>
					</div>
					<div class="col-md-4 text-center text-md-end">
						<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3523.8254389374856!2d105.07081024431248!3d-5.400336996834666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40d2f093d4a027%3A0x35fedef26ffe058a!2sDEPARTMENT%20OF%20COMMUNICATION%20AND%20INFORMATION%20kab.%20Pesawaran!5e0!3m2!1sen!2sid!4v1730910571089!5m2!1sen!2sid"
							width="400"
							height="300"
							style="border: 0"
							allowfullscreen=""
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
				<div class="footer-bottom text-center">
					<p>
						Copyright &copy; 2024
						<a
							href="#"
							class="text-decoration-none"
							style="color: #0077c2"
							>Badan Penelitian dan Pengembangan Kabupaten
							Pesawaran</a
						>
						| All Rights Reserved
					</p>
				</div>
			</footer>
		</div>

		<!-- Modal Images -->
		<div id="myModal" class="modal-foto">
			<!-- The Close Button -->
			<span class="close">&times;</span>

			<!-- Modal Content (The Image) -->
			<img class="modal-foto-content" id="img01" />

			<!-- Modal Caption (Image Text) -->
			<div id="caption"></div>
		</div>

		<!-- JAVASCRIPT -->
		<script src="/assets/libs/jquery/jquery.min.js"></script>
		<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="/assets/libs/node-waves/waves.min.js"></script>
		<script src="/assets/libs/feather-icons/feather.min.js"></script>
		<script>
			window.addEventListener("scroll", function () {
				const navbar = document.querySelector(".navbar");
				if (window.scrollY > 0) {
					navbar.classList.add("scrolled");
				} else {
					navbar.classList.remove("scrolled");
				}
			});
		</script>
		<!-- Jquery, Popper, Bootstrap -->
		<script src="/assets/js/vendor/jquery-1.12.4.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
		<script src="/assets/js/slick.min.js"></script>

		<!-- Jquery Plugins, main Jquery -->
		<script src="/assets/js/main.js"></script>
		<script>
			// Get the modal
			var modal = document.getElementById("myModal");
			var modalImg = document.getElementById("img01");
			var captionText = document.getElementById("caption");

			// Get all images and captions
			var images = document.querySelectorAll(".myImg");
			var captions = document.querySelectorAll(".captionClick");

			// Function to open the modal with the specific image and caption
			function openModal(imgSrc, caption) {
				modal.style.display = "block";
				modalImg.src = imgSrc;
				captionText.innerHTML = caption;
			}

			// Add click events to each caption
			captions.forEach((caption, index) => {
				caption.onclick = function () {
					openModal(images[index].src, caption.textContent);
				};
			});

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on <span> (x), close the modal
			span.onclick = function () {
				modal.style.display = "none";
			};
		</script>
		<script>
			function goToDetail(url) {
				window.open(url, "_blank");
			}
		</script>
		<script>
			document.querySelectorAll(".video-card").forEach((card) => {
				// Mengambil nilai atribut onclick
				const onclickAttr = card.getAttribute("onclick");

				// Ekstraksi URL YouTube dari onclick
				const urlMatch = onclickAttr.match(
					/https:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/,
				);

				if (urlMatch) {
					const videoId = urlMatch[1]; // Ambil ID video dari hasil regex
					const img = card.querySelector("img");

					// Set thumbnail src jika img dan videoId ditemukan
					if (img && videoId) {
						img.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
					}
				}
			});
		</script>
		<script>
			window.addEventListener("scroll", function () {
				const navbar = document.getElementById("mainNavbar");
				const navbarContainer = document.querySelector(".navbar-bg");

				if (window.scrollY === 0) {
					// Jika di posisi paling atas, tambahkan div dengan class navbar-bg
					if (!navbarContainer) {
						const wrapper = document.createElement("div");
						wrapper.className = "navbar-bg";
						navbar.parentNode.insertBefore(wrapper, navbar);
						wrapper.appendChild(navbar);
					}
				} else if (navbarContainer) {
					// Jika discroll ke bawah, hapus div navbar-bg
					navbarContainer.parentNode.insertBefore(
						navbar,
						navbarContainer,
					);
					navbarContainer.remove();
				}
			});
		</script>
		<script>
			document.addEventListener("DOMContentLoaded", function () {
				const currentUrl = window.location.pathname; // Mendapatkan URL path saat ini
				const navLinks = document.querySelectorAll(".nav-link"); // Mendapatkan semua elemen nav-link

				// Menambahkan kelas active pada setiap nav-link yang cocok dengan halaman saat ini
				navLinks.forEach((link) => {
					if (currentUrl.includes(link.getAttribute("href"))) {
						link.classList.add("active");
					}
				});

				// Menangani kasus khusus untuk dropdown 'Database Inovasi'
				const dropdownMenu = document.getElementById(
					"databaseInovasiDropdown",
				);
				if (dropdownMenu) {
					if (currentUrl.includes("database-riset")) {
						dropdownMenu.classList.add("active");
						document
							.querySelector('a[href="database-riset.html"]')
							.classList.add("active");
					} else if (currentUrl.includes("database-inovasi")) {
						dropdownMenu.classList.add("active");
						document
							.querySelector('a[href="database-inovasi.html"]')
							.classList.add("active");
					}
				}
			});
		</script>
	</body>
</html>
