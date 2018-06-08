<html data-bootstrap="app" data-migrate-mute="true">
  <head>
    <title>Dashboard</title>
    
    <script   src="https://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
    
		<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
		<script type="text/javascript">
		  Stripe.setPublishableKey('pk_test_BV9XG0NzMZykrWcmumOg8nRd');
		  
		  
		  $(function() {
				  var $form = $('#payment-form');
				  $form.submit(function(event) {
				    // Отключим кнопку, чтобы предотвратить повторные клики
				    $form.find('.submit').prop('disabled', true);
				
				    // Запрашиваем token у Stripe
				    Stripe.card.createToken($form, stripeResponseHandler);
				     
				    // Запретим форме submit
				    return false;
				  });
				});
				
				function stripeResponseHandler(status, response) {
				  // Получим форму:
				  var $form = $('#payment-form');
				
				  if (response.error) { // Problem!
				
				    // Показываем ошибки в форме:
				    $form.find('.payment-errors').text(response.error.message);
				    $form.find('.submit').prop('disabled', false); // Разрешим submit
				
				  } else { // Token был создан
				
				    // Получаем token id:
				    var token = response.id;    console.log( token ); alert( token );
				
				    // Вставим token в форму, чтобы при submit он пришел на сервер:
				    $form.append($('<input type="hidden" name="stripeToken">').val(token));
				
				    // Сабмитим форму:
				    // $form.get(0).submit();
				  }
				};

		</script>
		
		
		
  </head>

<body>

	<form action="stripe.php" method="POST" id="payment-form">
	    <span class="payment-errors"></span>
	    <label>Card Number</label>
	    <input type="text" size="20" data-stripe="number">
	    <label>Expiration (MM/YY)</label>     
	    <input type="text" size="2" data-stripe="exp_month">
	    <input type="text" size="2" data-stripe="exp_year">
	    <label>CVC</label>
	    <input type="text" size="4" data-stripe="cvc">
	    <input type="submit" class="submit" value="Submit">
	</form>

</body>