@extends('master')
@section('title')
  <title>Star Classes</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
@endsection
@section('main')
  <!-- main - start -->
  <main>
    <div class="about-us-top">
      <div class="about-us-top-title">
        <div>We are</div>
        <div>Star Classes</div>
      </div>
      <p>
        Star classes will help you hone your knowledge and skills
        effectively. The site specializes in providing short-term courses of
        fields such as information technology, marketing, foreign languages,
        etc. The channel currently gathers more than 1000 lecturers in
        different teaching fields. All the instructors have rich experience,
        enthusiasm, help you study methodically, consolidate solid
        knowledge.
      </p>
    </div>
    <div class="about-us-body">
      <div class="about-us-body-title">My team</div>
      <div class="about-us-body-wrapper">
        <div>
          @for ($i = 0; $i < 5; $i++)
            <div class="about-us-item">
              <div class="about-us-item-img">
                <img src="{{ asset('images/Quy.jpg') }}" alt="" />
              </div>
              <div class="about-us-info-wrapper">
                <div>
                  <div class="about-us-item-name">Nguyễn Văn Quý</div>
                  <div class="about-us-item-job">Admin</div>
                </div>
                <div class="about-us-item-social">
                  <i class="bi bi-facebook"></i>
                </div>
              </div>
              <div class="read-more">
                <span>Read more</span>
              </div>
            </div>
          @endfor
        </div>
      </div>
      <div class="about-us-address">
        <div class="about-us-address-map">
          <div class="map-container">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14896.032942106198!2d105.767340879581!3d21.032356475941235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab86cece9ac1%3A0xa9bc04e04602dd85!2zRlBUIEFwdGVjaCBIw6AgTuG7mWkgLSBI4buHIFRo4buRbmcgxJDDoG8gVOG6oW8gTOG6rXAgVHLDrG5oIFZpw6puIFF14buRYyBU4bq_IChTaW5jZSAxOTk5KQ!5e0!3m2!1svi!2s!4v1667072495971!5m2!1svi!2s"
              width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade" width="600" height="450" style="border: 0"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="about-address-desc">
          <div class="about-address-desc-city">In Ha Noi</div>
          <div class="about-address-desc-center">
            Scientific Facilities Center
          </div>
          <p>No. 8 Ton That Thuyet, My Dinh, Hanoi.</p>
          <div class="about-address-desc-center">Office</div>
          <p>
            Thai Hoa Primary School, National Highway 39B, Thai Hoa Commune,
            Thai Thuy District, Thai Binh Province.
          </p>
          <a class="about-desc-phone" href="tel:+84 986295956">
            Tel : <span>+84 986295956</span>
          </a>
          <a class="about-desc-phone" href="fax:+84 986295956">
            Fax: <span>+84 986295956</span>
          </a>
        </div>
      </div>
      <div class="about-us-address">
        <div class="about-us-address-column-55">
          <div class="about-address-desc">
            <div class="about-address-desc-city">In Hanoi</div>
            <p>No. 8 Ton That Thuyet, My Dinh, Hanoi.</p>
            <a class="about-desc-phone" href="tel:+84 986295956">
              Tel: <span>+84 986295956</span>
            </a>
          </div>
        </div>
        <div class="about-us-address-column-45">
          <div class="about-us-address-img">
            <img src="{{ asset('images/center-hanoi.jpg') }}" alt="" />
          </div>
        </div>
      </div>
      <div class="about-us-address">
        <div class="about-us-address-column-45">
          <div class="about-us-address-img">
            <img src="{{ asset('images/center-thaibinh.jpg') }}" alt="" />
          </div>
        </div>
        <div class="about-us-address-column-55">
          <div class="about-address-desc">
            <div class="about-address-desc-city">In Thai Binh</div>
            <p>Thai Hoa Commune, Thai Thuy District, Thai Binh Province.</p>
            <a class="about-desc-phone" href="tel:+84 986295956">
              Tel: <span>+84 986295956</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div class="popup-admin">
    <div class="popup-admin-box">
      <div class="popup-admin-avatar">
        <img src="{{ asset('images/Quy.jpg') }}" alt="" />
      </div>
      <div class="popup-admin-close"><i class="bi bi-x-lg"></i></div>
      <div class="popup-admin-name">Nguyễn Văn Quý</div>
      <div class="popup-admin-job">Free</div>
      <p class="popup-admin-desc">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum facere
        laboriosam magnam quaerat natus minus corporis assumenda, et quo
        autem nam, eius laudantium beatae. Qui illum unde exercitationem
        nobis nisi?
      </p>
      <p class="popup-admin-desc">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum facere
        laboriosam magnam quaerat natus minus corporis assumenda, et quo
        autem nam, eius laudantium beatae. Qui illum unde exercitationem
        nobis nisi?
      </p>
    </div>
  </div>
@endsection
@section('js')
  <script src="{{ asset('js/about-us.js') }}"></script>
@endsection
