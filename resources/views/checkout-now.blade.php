@extends('master')
@section('title')
  <title>Star Classes - Checkout</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection
@section('main')
  <main>
    <div class="pay-wrapper">
      <div class="pay-title">Courses you want to pay for</div>
      <div class="course-in-cart">
        <a class="course-profile-item" href="{{ route('course', ['slug' => $course->slug]) }}">
          <div class="course-profile-img">
            <img src="{{ $course->thumbnail }}" alt="">
          </div>
          <div class="course-profile-wrapper">
            <div class="course-profile-info">
              <div class="course-profile-name">{{ $course->name }}</div>
              <div class="course-profile-teacher">
                <div class="course-profile-teacher-img">
                  <img src="{{ $course->user->thumbnail }}" alt="">
                </div>
                <div class="course-profile-teacher-name">{{ $course->user->name }}</div>
              </div>
            </div>
            <div class="course-profile-price">
              <div>{{ $course->discount }}$</div>
              <div>{{ $course->price }}$</div>
            </div>
            <div class="course-profile-delele">
              <i class="bi bi-x-lg"></i>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="pay-wrapper">
      <div class="pay-title">Select a payment method</div>
      <div class="pay-item pay-item-menu">
        <div class="pay-item-logo">
          <img src="{{ asset('images/momo_logo.png') }}" alt="" />
        </div>
        <div class="pay-item-title">Momo e-wallet</div>
      </div>
      <div class="pay-item pay-item-bank show-pay-item-bank">
        <div class="pay-item-top">
          <ul>
            <li>Step 1: Scan the QR code below using the Momo app.</li>
            <li>Step 2: Enter the amount and press pay.</li>
            <li>Step 3: You can learn after successful payment.</li>
          </ul>
        </div>
        <div class="pay-item-body">
          <div class="pay-item-column">
            <div class="pay-item-qr">
              <img src="{{ asset('images/QR_momo.jpg') }}" alt="" />
            </div>
          </div>
          <div class="pay-item-column">
            <div class="pay-item-bank-logo">
              <img src="{{ asset('images/mono_logo_bank.png') }}" alt="" />
            </div>
            <div class="pay-item-bank-name">MOMO - E-wallet</div>
            <div>Account holder: <b>Nguyen Van Quy</b></div>
            <div>Tel: <b>+84 986295956</b></div>
          </div>
        </div>
      </div>
      <div class="pay-item pay-item-menu">
        <div class="pay-item-logo">
          <img src="{{ asset('images/bank.png') }}" alt="" />
        </div>
        <div class="pay-item-title">
          Transfer money via bank account or scan QR code
        </div>
      </div>
      <div class="pay-item pay-item-bank">
        <div class="pay-item-top">
          <ul>
            <li>
              Step 1: Scan the QR code or transfer money directly to the
              bank account number below.
            </li>
            <li>Step 2: Enter the amount and press pay.</li>
            <li>Step 3: You can learn after successful payment.</li>
          </ul>
        </div>
        <div class="pay-item-body">
          <div class="pay-item-column">
            <div class="pay-item-qr">
              <img src="{{ asset('images/QR.png') }}" alt="" />
            </div>
          </div>
          <div class="pay-item-column">
            <div class="pay-item-bank-logo">
              <img src="{{ asset('images/bank_logo.png') }}" alt="" />
            </div>
            <div class="pay-item-bank-name">
              MB - Military Commercial Joint Stock Bank
            </div>
            <div>Account Holder: <b>NGUYEN VAN QUY</b></div>
            <div>Account number: <b>0560118908002</b></div>
          </div>
        </div>
      </div>
      <div class="pay-item pay-payment">
        <div style="margin-left: auto">
          <div style="font-weight: bold; font-size: 18px">
            Total payment amount:
          </div>
          <div style="text-decoration: line-through; color: #999">
            Cost:
          </div>
          <div>Sale:</div>
        </div>
        <div style="margin-left: 20px; text-align: right">
          <div class="pay-total-price-sale">{{ $course->discount }} $</div>
          <div class="pay-total-price-old">{{ $course->price }} $</div>
          <div class="pay-total-price-percent">{{ $course->discountPercent() }}%</div>
        </div>
      </div>
      <div style="text-align: right; margin-top: 10px">
        <button class="button" id="print-bill">
          <i class="bi bi-printer-fill"></i>Print Bill
        </button>
        <button class="button" id="finish-pay" data-url={{ route('checkout.payment.now') }}>Complete
          payment</button>
      </div>
      <div class="print">
        <div class="print-company">
          <a href="{{ route('index') }}" class="logo logo-animation">
            <div class="logo-inner">
              <img src="{{ asset('images/logo.png') }}" alt="" />
            </div>
          </a>
          <div>
            <div>Company:</div>
            <div>Address:</div>
            <div>Tel:</div>
            <div>Fax:</div>
          </div>
          <div>
            <div>Star Classes Joint Stock Company</div>
            <div>No. 8 Ton That Thuyet, My Dinh, Hanoi</div>
            <div>+84 986295956</div>
            <div>+84 986295956</div>
          </div>
          <div>
            <div id="bill-date">Date:</div>
          </div>
        </div>
        <div class="print-title">LIST OF BILL PAYMENT COURSES</div>
        <div class="print-user">
          <div>
            <div class="print-user-name">User:</div>
            <div class="print-user-fullname">Full name:</div>
            <div class="print-user-mail">Email:</div>
            <div class="print-user-phone">Tel:</div>
          </div>
          <div>
            <div class="print-user-name">q5nguyenn</div>
            <div class="print-user-fullname">Nguyen Van Quy</div>
            <div class="print-user-mail">q5nguyenn@gmail.com</div>
            <div class="print-user-phone">+84 986295956</div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- main - end -->
  <!-- Popup Pay success -->
  <div class="popup-pay-success">
    <div class="popup-pay-wrapper">
      <div class="popup-pay-img">
        <img src="{{ asset('images/study.png') }}" alt="" />
      </div>
      <div class="popup-pay-content">
        Payment <b>successful</b> now you can learn!
        <br />
        The browser will automatically go to the Your Learning in 2 seconds!
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
    let course_id = {{ $course->id }};
  </script>
  <script type="module" src="{{ asset('js/checkout-now.js') }}"></script>
  <script type="module" src="{{ asset('js/print.js') }}"></script>
@endsection
