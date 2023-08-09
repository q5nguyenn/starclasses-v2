@extends('master')
@section('title')
  <title>Star Classes - Teacher</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/combo.css') }}">
@endsection
@section('main')
  <!-- main - start -->
  <main style="margin-top: 50px">
    <div class="combo-top">
      <div class="combo-wrapper flex combo-wrapper-mobile">
        <div>
          <div class="combo-wrapper-top" id="combo-name">
            {{ $combo->name }}
          </div>
          <div class="combo-wrapper-top-for">For beginners</div>
          <div class="course-combo">
            <div class="teacher-wrapper-top">
              <div class="teacher-avatar">
                <img src="{{ $user->thumbnail }}" alt="" />
              </div>
              <div class="teacher-info">
                <div class="teacher-info-top">
                  <div class="teacher-info-item">
                    <div class="teacher-info-count" id="combo-course">
                      {{ count($user->courses) < 10 ? '0' . count($user->courses) : count($user->courses) }}
                    </div>
                    <div class="teacher-info-count-name">
                      <i class="bi bi-book-fill"></i> Courses
                    </div>
                  </div>
                  <div class="teacher-info-item">
                    <div class="teacher-info-count" id="combo-student">
                      {{ $user->students() }}
                    </div>
                    <div class="teacher-info-count-name">
                      <i class="bi bi-people-fill"></i> Students
                    </div>
                  </div>
                  <div class="teacher-info-item">
                    <div class="teacher-info-count" id="combo-rating">
                      {{ $user->byRate() }}
                    </div>
                    <div class="teacher-info-count-name">
                      <span class="course-star">
                        <i class="bi bi-star-fill"></i>
                      </span>
                      Average rating
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="teacher-name">
              <span></span>
              <a class="teacher-social" href="https://vi-vn.facebook.com/">
                <i class="bi bi-facebook"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="combo-problem-wrapper">
          <div class="combo-problem-title">You are having problems?</div>
          <div class="combo-problem">
            {!! $combo->problem_solving !!}
          </div>
        </div>
      </div>
    </div>
    <div class="combo-body">
      <div class="combo-box flex combo-box-mobile">
        <div class="combo-box-colum" style="padding-right: 20px">
          <div class="combo-box-colum-title">Introduce</div>
          <p class="combo-box-colum-desc">
            {!! $combo->introduce !!}
          </p>
        </div>
        <div class="combo-box-colum">
          <div class="video-container">
            <iframe width="956" height="538" src="https://www.youtube.com/embed/jfKfPfyJRdk"
              title="lofi hip hop radio - beats to relax/study to" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
      </div>
      <div class="combo-box flex">
        <div class="combo-box-top">
          <div class="combo-box-top-item">
            <div class="combo-box-top-title">{{ count($combo->courses) }}</div>
            <div>Courses</div>
          </div>
          <div class="combo-box-top-item">
            <div class="combo-box-top-title" id="combo-lesson">{{ $combo->allChapters() }}</div>
            <div>Lessons</div>
          </div>
          <div class="combo-box-top-item">
            <div class="combo-box-top-title" id="combo-time">
              {{ round(($combo->allChapters() * (5 * 60 + 30)) / 60 / 60, 1) }}</div>
            <div>Hours</div>
          </div>
        </div>
      </div>
      <div class="combo-box">
        <div class="combo-box-title">Courses details</div>
        <div class="combo-box-wrapper flex-justify">
          <div class="combo-box-colum-3">
            <div class="combo-box-colum-img">
              <img src="{{ asset('images/listening.png') }}" alt="" />
            </div>
            <div class="combo-box-colum-3-title">
              Good at comprehensive English: Listening, Speaking, Reading
              and Writing
            </div>
            <div class="combo-box-colum-desc">
              <div>
                <span>1.</span><span>Increase 3000 common English vocabulary words in 30
                  days</span>
              </div>
              <div>
                <span>2.</span><span>Master the 10 most common English grammars in
                  communication</span>
              </div>
              <div>
                <span>3.</span><span>Standard pronunciation learning strategies</span>
              </div>
              <div>
                <span>4.</span><span>English Listening Strategies</span>
              </div>
              <div>
                <span>5.</span><span>Strategies for learning English speaking reflexes</span>
              </div>
              <div>
                <span>6.</span><span>English reading comprehension strategies</span>
              </div>
              <div>
                <span>7.</span><span>English writing techniques for busy people</span>
              </div>
            </div>
          </div>
          <div class="combo-box-colum-3">
            <div class="combo-box-colum-img">
              <img src="{{ asset('/images/conversation.png') }}" alt="" />
            </div>
            <div class="combo-box-colum-3-title">
              Communicative English for beginners
            </div>
            <div class="combo-box-colum-desc">
              <div>
                <span>1.</span><span>English communication lessons</span>
              </div>
            </div>
          </div>
          <div class="combo-box-colum-3">
            <div class="combo-box-colum-img">
              <img src="{{ asset('images/writing.png') }}" alt="" />
            </div>
            <div class="combo-box-colum-3-title">
              Practice English reflexes to communicate super effectively
            </div>
            <div class="combo-box-colum-desc">
              <div>
                <span>1.</span><span>English communication reflex exercises</span>
              </div>
              <div><span>2.</span><span>Course summary</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="combo-box">
        <div class="combo-box-title">Companion teacher</div>
        <div class="combo-box-wrapper">
          <div>
            <ul>
              <li>Master's degree in Linguistics, Curtin University.</li>
              <li>
                Lecturer in English department at Hanoi University of
                Education and member of the Executive Committee of Hanoi
                English Research and Teaching Association.
              </li>
              <li>Founder of English English Master Center</li>
              <li>
                Co-founder of the Sinhvienkhoaanh.net forum for students of
                English Faculty, Hanoi National University of Education.
              </li>
              <li>
                Member of Executive Committee of Hanoi Association for
                Research and Teaching of English
              </li>
              <li>
                2009, 2010, 2011: Received Lawrence S. Ting Scholarship for
                the best students in universities & Scholarship of Ha Noi
                City Study Promotion Association
              </li>
              <li>
                2008: 3rd prize in the national competition for excellent
                students in English for 12th graders
              </li>
            </ul>
          </div>
          <div class="teacher-combo">
            <div class="teacher-avatar teacher-avatar-2">
              <img src="{{ $user->thumbnail }}" alt="" />
            </div>
            <div class="teacher-name teacher-name-2">{{ $user->name }}</div>
          </div>
        </div>
      </div>
      <div class="combo-box combo-review">
        <div class="combo-box-title">Student comments</div>
        <div class="combo-box-wrapper">
          <div>
            <div>
              <b>Nguyen Mai An - </b><span>Student at Academy of Journalism and Propaganda</span>
            </div>
            <p>
              My English ability has improved markedly. The enthusiasm of
              the teachers makes me easy to absorb. The course also helped
              me get used to the way of learning "Learning goes hand in
              hand" and now I can communicate in English quite well and more
              naturally. Give it a try and this course won't let you down.
            </p>
          </div>
          <div class="student-avatar">
            <div class="teacher-avatar">
              <img src="{{ asset('images/user-comment-01.jpg') }}" alt="" />
            </div>
          </div>
        </div>
        <div class="combo-box-wrapper">
          <div class="student-avatar">
            <div class="teacher-avatar">
              <img src="{{ asset('images/user-comment-02.jpg') }}" alt="" />
            </div>
          </div>
          <div>
            <div><b>Tran Tien Minh - </b><span>Office staff</span></div>
            <p>
              I was exposed to and practiced English from my high school
              year to the time I went to work, but during that time, I only
              learned well in reading and grammar skills. My knowledge of
              business English, specifically listening and speaking skills
              at work, is still quite poor and only uses simple sentences in
              daily communication. After the course I was more confident in
              English. If compared with my previous study time, it is clear
              that my results now are much superior. My listening and
              speaking skills at work have improved markedly.
            </p>
          </div>
        </div>
        <div class="combo-box-wrapper">
          <div>
            <div><b>Hoang Phuong Hoa - </b><span>Marketer</span></div>
            <p>
              Although it is an online course, I feel that the learning is
              extremely effective and useful. I think you don't need to
              spend too much money and time to study outside centers is not
              effective, not to mention encountering poor quality centers.
              Instead, you can self-study online courses at home while
              training concentration and exchanging with teachers for a long
              time. The teachers in this course, I think teach very well,
              have many years of experience, so they have developed tips so
              that my English learning is no longer boring.
            </p>
          </div>
          <div class="student-avatar">
            <div class="teacher-avatar">
              <img src="{{ asset('images/user-comment-03.jpg') }}" alt="" />
            </div>
          </div>
        </div>
      </div>
      <div class="combo-box combo-sale-price">
        <div class="combo-box-title">
          BUY THE FULL COURSE NOW TO GET DISCOUNTS
          <span id="combo-percent">{{ $discount }}%</span>
        </div>
        <div class="combo-price-box-wrapper">
          <div class="combo-price-box">
            <div class="price-old">{{ $primaryPrice }}$</div>
            <div class="price-sale">
              <div>Only</div>
              <div id="price-sale">{{ $combo->price }}$</div>
            </div>
          </div>
        </div>
        <div class="combo-count-down">
          <div class="count-down-timmer">
            <div class="count-down-timmer-title">
              Hurry, this offer ends in:
            </div>
            <div class="count-down-item">
              <div class="count-down-time date-time">11</div>
              <div>Days</div>
            </div>
            <span>:</span>
            <div class="count-down-item">
              <div class="count-down-time hour-time">11</div>
              <div>Hours</div>
            </div>
            <span>:</span>
            <div class="count-down-item">
              <div class="count-down-time minute-time">11</div>
              <div>Minutes</div>
            </div>
            <span>:</span>
            <div class="count-down-item">
              <div class="count-down-time second-time">11</div>
              <div>Seconds</div>
            </div>
          </div>
        </div>
        <div class="buy-now-wrapper">
          <a class="button-buy-now" href="/checkout/now/combo/{{ $combo->slug }}">Buy now</a>
        </div>
      </div>
    </div>
  </main>
  <!-- Count-down-fixed -->
  <div class="combo-count-down count-down-fixed">
    <div class="count-down-timmer">
      <div class="count-down-timmer-title">Hurry, this offer ends in:</div>
      <div class="count-down-item">
        <div class="count-down-time date-time"></div>
        <div>Days</div>
      </div>
      <span>:</span>
      <div class="count-down-item">
        <div class="count-down-time hour-time"></div>
        <div>Hours</div>
      </div>
      <span>:</span>
      <div class="count-down-item">
        <div class="count-down-time minute-time"></div>
        <div>Minutes</div>
      </div>
      <span>:</span>
      <div class="count-down-item">
        <div class="count-down-time second-time"></div>
        <div>Seconds</div>
      </div>
    </div>
    <div class="buy-now-wrapper buy-now-wrapper-alert">
      <div id="combo-percent-2">-{{ $discount }}%</div>
      <div>
        <a class="button-buy-now" href="/checkout/now/combo/{{ $combo->slug }}">Buy now</a>
      </div>
    </div>
  </div>
  <!-- main - end -->
@endsection
@section('js')
  <script>
    let dateString = '{{ $combo->expiration_date }}';
    const end = new Date(dateString);
    const countdownElements = $('.count-down-time');

    function updateCountdown() {
      let now = new Date();
      var timeSale = Math.floor((end - now.getTime()) / 1000);

      var day = Math.floor(timeSale / (24 * 60 * 60));
      var hour = Math.floor((timeSale / 60 / 60) % 24);
      var minute = Math.floor((timeSale / 60) % 60);
      var second = Math.floor(timeSale % 60);

      countdownElements.each(function() {
        displayTime($(this), $(this).hasClass('date-time') ? day : $(this).hasClass('hour-time') ? hour : $(this)
          .hasClass('minute-time') ? minute : second);
      });
    }

    function displayTime(item, value) {
      item.text(value < 10 ? '0' + value : value);
    }

    updateCountdown();

    setInterval(updateCountdown, 1000);
  </script>
@endsection
