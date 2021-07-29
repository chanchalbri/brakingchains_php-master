<head>
  <title>Checkout</title>
  <script src="https://js.stripe.com/v3/"></script>
  <link rel="stylesheet" href="StripeElements.css">
    <style>
    /**
* Shows how you can use CSS to style your Element's container.
*/
.MyCardElement {
  height: 40px;
  padding: 10px 12px;
  width: 80%;
  color: #32325d;
  background-color: grey;
  border: 1px solid transparent;
  border-radius: 4px;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.MyCardElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.MyCardElement--invalid {
  border-color: #fa755a;
}

.MyCardElement--webkit-autofill {
  background-color: #fefde5 !important;
}
    
    </style>
</head>

<!-- Use the CSS tab above to style your Element's container. -->
<body>
  <form id="subscription-form">
    <div id="card-element" class="MyCardElement">
      <!-- Elements will create input elements here -->
    </div>

    <!-- We'll put the error messages in this element -->
    <div id="card-errors" role="alert"></div>
    <button type="submit">Subscribe</button>
  </form>
</body>

<script>
// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
var stripe = Stripe('pk_test_51H5mLbGkFLnj68yKgpskD2lKjsVJxyOb9wHPFcg8JJMHogctlF47NP1K1rZXIY7GXpKnUQjsXZCzll1E15KkoMlR0099Lzr0go');
var elements = stripe.elements();    
    
// Set up Stripe.js and Elements to use in checkout form
var style = {
  base: {
    color: "#32325d",
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#aab7c4"
    }
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a"
  }
};

var cardElement = elements.create("card", { style: style });
cardElement.mount("#card-element");
    
cardElement.on('change', showCardError);

function showCardError(event) {
  let displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
}
</script>