@php
  $active = 'chatapp';
@endphp
@extends('admin.master')
@section('title')
  <title>Chat app</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/coursedesc.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/boxchat.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
  <style>
    .text-oneline {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>
@endsection
@section('content')
  <div class="search-result overflow-hidden w-100" style="height: calc(100vh - 50px)">
    <div class="box-chat d-flex">
      <div class="d-flex flex-column flex-grow-1" style=" padding-right:30px">
        <div class="d-flex shadow-sm p-2 flex-grow-0">
          <div class="nav-user-img p-0">
            <img src="/images/user.png" alt="">
          </div>
          <div><span class="fw-bold"><b>Guest {{ $visitor->unique_id }}</b> # {{ $conversation->id }}</div>
        </div>
        <div class="box-chat-content flex-grow-1">
        </div>
        <form class="guest-input" style="display: flex;" data-url="{{ route('chatapp.send') }}" action="#">
          <div class="guest-input-item">
            <input type="text" name="conversation_id" id="conversation_id" value="{{ $conversation->id }}" hidden>
            <input type="text" name="message-content" id="message-content">
            <span class="focus-input"></span>
          </div>
          <button class="button-guest-chat" type="submit"><i class="bi bi-send"></i> Send</button>
        </form>
      </div>
      <div class="box-chat-user flex-shrink-0 p-2" style="overflow-x: hidden; overflow-x: auto; width:280px">
        @foreach ($conversations as $item)
          <a class="d-flex p-2 search-filter-title " href="{{ route('chatapp.index', ['id' => $item->id]) }}">
            <div class="nav-user-img p-0 flex-shrink-0" style="width:50px; height:50px">
              <img src="/images/user.png" alt="">
            </div>
            <div class="text-truncate">
              <div class=""><b>ID {{ $item->visitor()->unique_id }}</b> # {{ $item->id }}</div>
              @if ($item->unreadMessages() > 0)
                <b><small>{{ $item->getLastMesssage()->content ?? '' }}</small></b>
              @else
                <small class="text-secondary">{{ $item->getLastMesssage()->content ?? '' }}</small>
              @endif
            </div>
          </a>
        @endforeach

      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
    var get_message = "{{ route('chatapp.get') }}";
  </script>
  <script>
    // Chat app
    $(".box-chat-content").scrollTop($(".box-chat-content")[0].scrollHeight);
    $(".guest-input").submit(function(e) {
      $(".box-chat-content").scrollTop($(".box-chat-content")[0].scrollHeight);
      e.preventDefault();
      let content = $("#message-content").val().trim();
      $("#message-content").val("");
      if (content !== "") {
        $(".box-chat-content").append(
          `<div class="guest-chat"><span>${content}</span></div>`
        );
      }
      let urlRequest = $(this).data("url");
      let conversation_id = $('#conversation_id').val();
      let data = {
        content: content,
        conversation_id: conversation_id
      };
      $.ajax({
        type: "get",
        url: urlRequest,
        data: data,
        success: function(response) {
          $(".box-chat-content").scrollTop(
            $(".box-chat-content")[0].scrollHeight
          );
        },
      });
    });

    //Loading chat
    function showHideBoxChat() {
      $(".box-chat").toggleClass("box-show box-hide");
      if ($(".box-chat").hasClass("box-show") && hasConversation) {
        loadingChat();
      } else {
        clearInterval(reloadChat);
      }
    }

    function loadingHello(employee) {
      watting(employee);
      setTimeout(() => {
        $(".box-chat-content").html(`<div class="admin-chat">
				<div class="admin-chat-avatar">
					<img src="${employee["thumbnail"]}" alt="">
				</div>
				<div class="admin-chat-content">
					Hello! My name is ${employee["name"]}. Can I help you?
				</div>
			</div>`);
      }, 1000);
    }

    function watting() {
      $(".box-chat-content").append(`<div class="admin-chat loading-chat-temp">
																		<div class="admin-chat-avatar">
																			<img src="/images/user.png" alt="">
																		</div>
																		<div class="admin-chat-content">
																			<div class="loading-chat">
																			<div>
																			<span></span>
																			<span></span>
																			<span></span>
																			</div>
																			</div>
																		</div>
																	</div>`);
      $(".box-chat-content").scrollTop($(".box-chat-content")[0].scrollHeight);
      setTimeout(() => {
        $(".loading-chat-temp").remove();
      }, 1000);
    }
    let reloadChat;

    function loadingChat() {
      $(".box-chat-button").css("display", "none");
      $(".guest-input").css("display", "flex");
      $(".box-chat-content-intro").hide();
      reloadChat = setInterval(() => {
        getAllMessage();
      }, 1000);
    }

    function getAllMessage() {
      let conversation_id = $('#conversation_id').val();
      let data = {
        conversation_id: conversation_id
      };
      $.ajax({
        type: "get",
        url: get_message,
        data: data,
        success: function(response) {
          let newMessage = response["newMessage"];
          let messsages = response["messages"];
          let visitor = response["visitor"];
          let htmlString = "";
          messsages.forEach((message) => {
            if (message["sender"] == visitor["unique_id"]) {
              htmlString += `<div class="admin-chat">
																<div class="admin-chat-avatar">
																	<img src="/images/user.png" alt="">
																</div>
																<div class="admin-chat-content">
																${message["content"]}
																</div>
															</div>`;
            } else {
              htmlString += `<div class="guest-chat"><span>${message["content"]}</span></div>`;
            }
          });
          if (newMessage > 0) {
            watting();
            setTimeout(() => {
              $(".box-chat-content").html(htmlString);
            }, 1000);
          } else {
            $(".box-chat-content").html(htmlString);
          }
        },
      });
    }
    loadingChat();
  </script>
@endsection
