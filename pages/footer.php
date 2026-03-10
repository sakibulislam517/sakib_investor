    <!-- ===== Footer Section ===== -->
    <footer class="footer-section text-white mt-5">
      <div class="footer-top py-5">
        <div class="container">
          <div class="row gy-4">
            <!-- Logo + About -->
            <div class="col-md-4">
              <h5 class="fw-bold mb-3">📚 BookStore</h5>
              <p class="small mb-3">বাংলাদেশের অন্যতম অনলাইন বুকশপ — যেখানে ইসলামী, একাডেমিক ও সাহিত্য বই একসাথে পাওয়া যায়। আপনার প্রিয় বই এখন ঘরে বসেই!</p>
              <div class="d-flex gap-2">
                <a href="https://tanvirulislm.github.io/nafiuun/index.html#" class="social-icon"><i class="bi bi-facebook"></i></a>
                <a href="https://tanvirulislm.github.io/nafiuun/index.html#" class="social-icon"><i class="bi bi-instagram"></i></a>
                <a href="https://tanvirulislm.github.io/nafiuun/index.html#" class="social-icon"><i class="bi bi-youtube"></i></a>
                <a href="https://tanvirulislm.github.io/nafiuun/index.html#" class="social-icon"><i class="bi bi-twitter"></i></a>
              </div>
            </div>

            <!-- Quick Links -->
            <div class="col-6 col-md-2">
              <h6 class="fw-bold mb-3">দ্রুত লিংক</h6>
              <ul class="list-unstyled small">
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">হোম</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">বই</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">লেখক</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">প্রকাশক</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">যোগাযোগ</a></li>
              </ul>
            </div>

            <!-- Categories -->
            <div class="col-6 col-md-2">
              <h6 class="fw-bold mb-3">বিষয়</h6>
              <ul class="list-unstyled small">
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">ইসলামী</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">একাডেমিক</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">আরবি বই</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">সাহিত্য</a></li>
                <li><a href="https://tanvirulislm.github.io/nafiuun/index.html#">শিশুতোষ</a></li>
              </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-4">
              <h6 class="fw-bold mb-3">যোগাযোগ</h6>
              <ul class="list-unstyled small">
                <li><i class="bi bi-telephone-fill me-2"></i> +880 1234 567890</li>
                <li><i class="bi bi-envelope-fill me-2"></i> info@bookstore.com</li>
                <li><i class="bi bi-geo-alt-fill me-2"></i> ঢাকা, বাংলাদেশ</li>
              </ul>
              <a href="https://tanvirulislm.github.io/nafiuun/index.html#" class="btn btn-light text-deep-purple btn-sm mt-2 fw-semibold">আমাদের সাথে যোগাযোগ করুন</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="footer-bottom text-center py-3">
        <p class="small mb-0">© ২০২৫ BookStore. সর্বস্বত্ব সংরক্ষিত। তৈরি করেছেন 💜 <strong>HikmaTech</strong></p>
      </div>
    </footer>

    <script src="<?php domain;?>assets/js/swiper-bundle.min.js"></script>
    <script>
      // Hero slider
      var heroSwiper = new Swiper('.heroSwiper', {
        slidesPerView: 1,
        loop: true,
        effect: 'fade',
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.hero-pagination',
          clickable: true,
        },
      });

      // New published books slider
      var booksSwiper = new Swiper('.newBooksSwiper', {
        slidesPerView: 6,
        spaceBetween: 20,
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        breakpoints: {
          0: { slidesPerView: 2 },
          576: { slidesPerView: 3 },
          768: { slidesPerView: 4 },
          992: { slidesPerView: 5 },
          1200: { slidesPerView: 6 },
        },
      });
    </script>
    <script src="<?php domain;?>assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./index_files/bootstrap-icons.css">
  

</body></html>