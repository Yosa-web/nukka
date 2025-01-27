<!DOCTYPE html>
<html lang="en">
<?php

use App\Models\JenisInovasiModel;

$jenisInovasiModel = new JenisInovasiModel();
$jenis_inovasi = $jenisInovasiModel->findAll();
?>

<head>
	<meta charset="UTF-8" />
	<?= $this->renderSection('title'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="/assets/uploads/images/optionweb/logo.png" />
	<link
		href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap"
		rel="stylesheet" />
	<!-- DataTables -->
	<link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

	<!-- Responsive datatable examples -->
	<link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
	<!-- CSS Leaflet -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
	<div id="layout-wrapper">
		<!-- Topbar -->

		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg" id="mainNavbar">
			<div class="container-fluid justify-content-between">
				<a class="navbar-brand d-flex align-items-center" href="<?= base_url('beranda') ?>">
					<img src="/assets/uploads/images/optionweb/logo.png" alt="Logo Website" />
					<span style="color: #0077c2; font-weight: bold; font-size: 25px;">
						<span><?= esc(strip_tags($namaWebsite)) ?></span>
					</span>
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav mx-auto">
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url('beranda') ?>">Beranda</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url('tentang') ?>">Tentang</a>
						</li>
					</ul>

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
						src="/assets/uploads/images/optionweb/logo.png"
						alt="Logo Balitbang"
						class="footer-logo" />
				</div>
				<div class="col-md-5 text-md-start mb-4 mb-md-0 ps-4">
					<h3 class="fw-bold"><span><?= esc(strip_tags($namaWebsite)) ?></span></h3>
					<p>nukka@gmail.com</p>
					<p>+62 811-7970-855</p>
					<p>
						Jl. Pagar Alam No.23, Kedaton, Kec. Kedaton, Kota Bandar Lampung, Lampung 35148
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
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.1649313831335!2d105.23271299999999!3d-5.3918199!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40dbb335159f23%3A0xa09f7121e78026ca!2sNukka%20Carwash%20%26%20Cafe!5e0!3m2!1sid!2sid!4v1735218456059!5m2!1sid!2sid"
						width="400"
						height="300"
						style="border: 0"
						allowfullscreen=""
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade">
					</iframe>
				</div>
			</div>
			<div class="footer-bottom text-center">
				<p>
					Copyright &copy; 2024
					<a
						href="#"
						class="text-decoration-none"
						style="color: #0077c2">Nukka carwash &
						coffee shop</a>
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="/assets/libs/jquery/jquery.min.js"></script>
	<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/libs/node-waves/waves.min.js"></script>
	<script src="/assets/libs/feather-icons/feather.min.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", () => {
			const elements = document.querySelectorAll(".hidden");

			const observer = new IntersectionObserver(
				(entries, observer) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							// Menambahkan kelas animasi setiap kali elemen terlihat
							entry.target.classList.add("animate-on-scroll");
							// Elemen tetap diamati untuk animasi berikutnya
							entry.target.classList.remove("animate-on-scroll");
							void entry.target.offsetWidth; // Force reflow untuk reset animasi
							entry.target.classList.add("animate-on-scroll");
						}
					});
				}, {
					threshold: 0.2 // Persentase elemen yang terlihat di viewport
				}
			);

			elements.forEach(element => observer.observe(element));
		});
	</script>
	<!-- pace js -->
	<script src="/assets/libs/pace-js/pace.min.js"></script>
	<!-- Plugins js-->
	<script src="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
	<!-- Required datatable js -->
	<script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<!-- Responsive examples -->
	<script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<!-- Datatable init js -->
	<script src="/assets/js/pages/datatables.init.js"></script>
	<script>
		var $jq = jQuery.noConflict();
		$jq(document).ready(function() {
			$jq('#datatable').DataTable();
		});
	</script>
	<!-- Buttons examples -->
	<script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script>
		window.addEventListener("scroll", function() {
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
			caption.onclick = function() {
				openModal(images[index].src, caption.textContent);
			};
		});

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
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
		window.addEventListener("scroll", function() {
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
		document.addEventListener("DOMContentLoaded", function() {
			// Mendapatkan path URL saat ini tanpa query string
			const currentUrl = window.location.pathname;

			// Mendapatkan semua elemen nav-link
			const navLinks = document.querySelectorAll(".nav-link");

			navLinks.forEach((link) => {
				// Mendapatkan path dari atribut href
				const linkPath = new URL(link.href).pathname;

				// Memeriksa kecocokan URL
				if (currentUrl === linkPath) {
					link.classList.add("active");
				}
			});
		});
	</script>

</body>

</html>