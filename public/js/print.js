$("#print-bill").click(function () {
    var divContentTop = $(".print").html();
    var divContentBody = $(".course-in-cart").html();
    var divContentBot = $(".pay-payment").html();

    var a = window.open("", "", "height=500, width=500");
    a.document.write("<html>");
    a.document.write(
        `<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Star Classes - Payment</title>
		<link rel="icon" type="image/x-icon" href="http://127.0.0.1:8000/x-icon.ico" />
		<link rel="stylesheet" href="http://127.0.0.1:8000/css/style.css" />
		<link rel="stylesheet" href="http://127.0.0.1:8000/css/checkout.css" />
		<link rel="stylesheet" href="http://127.0.0.1:8000/css/print.css" />
  </head>`
    );
    a.document.write(
        `<main>
      <div class="pay-wrapper">`
    );
    a.document.write(divContentTop);
    a.document.write(divContentBody);
    a.document.write(`<div class="pay-item pay-payment">`);
    a.document.write(divContentBot);
    a.document.write(`</div>`);

    a.document.write(
        `</div>
    </main>`
    );
    a.document.write("</html>");
    a.document.close();
    a.focus();

    setTimeout(function () {
        a.print();
    }, 1000);
    return true;
});

var time = new Date().toLocaleString("vi-VI");
$("#bill-date").html(`Date: <b>${time}</b>`);
