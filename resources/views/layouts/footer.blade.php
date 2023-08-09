<!-- footer - start -->
<footer>
  <div class="footer-container">
    <div class="footer-social">
      <a href="{{ route('index') }}" class="logo logo-animation">
        <div class="logo-inner">
          <img src="{{ asset('images/logo.png') }}" alt="" />
        </div>
        <span class="logo-title">Star Classes</span>
      </a>
      <div class="social-links">
        <a href="https://www.youtube.com/starclasses" class="social-link"><i class="bi bi-youtube"></i></a>
        <a href="https://www.facebook.com/" class="social-link"><i class="bi bi-facebook"></i></a>
        <a href="https://twitter.com/" class="social-link"><i class="bi bi-twitter"></i></a>
        <a href="https://github.com/" class="social-link"><i class="bi bi-github"></i></a>
        <a href="https://discord.com/" class="social-link"><i class="bi bi-discord"></i></a>
      </div>
    </div>
    <div class="footer-column">
      <div class="footer-column-title">Link:</div>
      <div class="footer-column-item">
        <a href="https://www.facebook.com/">
          <i class="bi bi-facebook"></i>
          <span>Star Classes Community on Facebook</span>
        </a>
      </div>
      <div class="footer-column-item">
        <a href="{{ route('about.us') }}">
          <i class="bi bi-building"></i>
          <span>Star Classes Joint Stock Company</span>
        </a>
      </div>
      <div class="footer-column-item">
        <a href="{{ route('term') }}">
          <i class="bi bi-list-stars"></i>
          <span>Our terms and conditions</span>
        </a>
      </div>
    </div>
    <div class="footer-column">
      <div class="footer-column-title">Contact:</div>
      <div class="footer-column-item">
        <div>
          <i class="bi bi-cursor-fill"></i>
          <span>Address: No. 8 Ton That Thuyet, My Dinh, Hanoi</span>
        </div>
      </div>
      <div class="footer-column-item">
        <a href="mailto: q5nguyenn@gmail.com">
          <i class="bi bi-envelope"></i>
          <span>Email: starclasses@edu.vn</span>
        </a>
      </div>
      <div class="footer-column-item">
        <a href="tel: 0986295956">
          <i class="bi bi-telephone-fill"></i>
          <span>Tel: +84986295956</span>
        </a>
      </div>
    </div>
  </div>
  <div class="footer-subtle">
    <span>© 2023 copyright, q5nguyenn@gmail.com®</span>
    <div class="footer-subtitle-links">
      <a href="{{ route('term') }}" class="footer-subtitle-link">Privacy</a>
      |
      <a href="{{ route('term') }}" class="footer-subtitle-link">Terms Of Services</a>
    </div>
  </div>
</footer>
<!-- footer - end -->
