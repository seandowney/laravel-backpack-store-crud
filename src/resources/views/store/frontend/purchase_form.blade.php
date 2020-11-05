@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{{ $title }}} ::
@parent
@stop

@section('footer')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
  var stripe = Stripe('{{ config('services.stripe.key') }}');
    // Create an instance of elements
    var elements = stripe.elements();

    var style = {
        base: {
            fontWeight: 400,
            fontFamily: '"DM Sans", Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            lineHeight: '1.4',
            color: '#1b1642',
            padding: '.75rem 1.25rem',
            '::placeholder': {
                color: '#ccc',
            },
        },
        invalid: {
            color: '#dc3545',
        }
    };

    var cardElement = elements.create('cardNumber', {
        style: style
    });
    cardElement.mount('#card_number');

    var exp = elements.create('cardExpiry', {
        'style': style
    });
    exp.mount('#card_expiry');

    var cvc = elements.create('cardCvc', {
        'style': style
    });
    cvc.mount('#card_cvc');

    // Validate input of the card elements
    var resultContainer = document.getElementById('paymentResponse');
    cardElement.addEventListener('change', function (event) {
        if (event.error) {
            resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
        } else {
            resultContainer.innerHTML = '';
        }
    });

    // Get payment form element
    var form = document.getElementById('payment-form');

    // Create a token when the form is submitted.
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        createToken();
    });

    // Create single-use token to charge the user
    function createToken() {
        stripe.createToken(cardElement).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error
                resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
            } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    }

    // Callback to handle the response from stripe
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

    $('.pay-via-stripe-btn').on('click', function () {
        var payButton   = $(this);
        var name        = $('#name').val();
        var email       = $('#email').val();
        var phone       = $('#phone').val();

        if (name == '' || name == 'undefined') {
            $('.error-name').html('Name field required.');
            $('#name').focus();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#name").offset().top - 200
            }, 500);
            return false;
        } else {
          $('.error-name').html('');
        }

        if (email == '' || email == 'undefined') {
            $('.error-email').html('Email field required.');
            $('#email').focus();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#email").offset().top - 200
            }, 500);
            return false;
        } else {
          $('.error-email').html('');
        }

        if (phone == '' || phone == 'undefined') {
            $('.error-phone').html('Phone field required.');
            $('#phone').focus();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#phone").offset().top - 200
            }, 500);
            return false;
        } else {
          $('.error-phone').html('');
        }

        if(!$('#terms_conditions').prop('checked')){
            $('.error-terms').html('The terms conditions must be accepted.');
            return false;
        } else {
          $('.error-terms').html('');
        }
    });
</script>
@endsection

{{-- Page content --}}
@section('content')
<div class="page-title">
  <div class="overlay"></div>
  <h1>Shop</h1>
</div>

<div class="light-wrapper">
      <div class="container">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Checkout</h1>
    </div>
    
</div>
<!-- /.row -->

<!-- Portfolio Item Row -->
<div class="row">
  <div class="col-sm-8 content">
    <div class="form-container">
    <form action="{{ url('/'.config('seandowney.storecrud.route_prefix', 'store').'/pay') }}" method="POST" id="payment-form">
        {{ csrf_field() }}
      <div id="card-errors" class="payment-errors" role="alert"></div>

      <div class="form-row">
        <label>
          <span>Your Name</span>
          <input type="text" name="name" id="name" size="100" value="{{ old('name') }}">
          {{-- @if($errors->first('name')) --}}
            <div class="text-danger font-italic error-name">{{ $errors->first('name') }}</div>
          {{-- @endif --}}
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>Your Email</span>
          <input type="email" name="email" id="email" size="100" value="{{ old('email') }}">
          {{-- @if($errors->first('email')) --}}
            <div class="text-danger font-italic error-email">{{ $errors->first('email') }}</div>
          {{-- @endif --}}
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>Your Phone</span>
          <input type="tel" id="phone" name="phone" pattern="(00|\+)[0-9]{9,15}" size="100" value="{{ old('phone') }}" placeholder="eg 00353871111111">
          {{-- @if($errors->first('phone')) --}}
            <div class="text-danger font-italic error-phone">{{ $errors->first('phone') }}</div>
          {{-- @endif --}}
        </label>
      </div>

      <div class="form-row">
        <br>
      </div>
      <div class="form-row">
        <h2>Delivery Address</h2>
      </div>

      <div class="form-row">
        <label>
          <span>Address Lime 1</span>
          <input type="text" name="address1" size="200" value="{{ old('address1') }}">
          <div class="text-danger font-italic error-address1">{{ $errors->first('address1') }}</div>
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>Address Line 2</span>
          <input type="text" name="address2" size="200" value="{{ old('address2') }}">
          <div class="text-danger font-italic error-address2">{{ $errors->first('address2') }}</div>
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>Town/City</span>
          <input type="text" name="address_city" size="200" value="{{ old('address_city') }}">
          <div class="text-danger font-italic error-address_city">{{ $errors->first('address_city') }}</div>
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>County/State</span>
          <input type="text" name="address_state" size="200" value="{{ old('address_state') }}">
          <div class="text-danger font-italic error-address_state">{{ $errors->first('address_state') }}</div>
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>Country</span>
          <select name="country" id="country" class="form-control">
            @foreach($countries as $code => $name)
            <option value="{{ $code }}" {{ (old('country') == $code ? "selected":"") }}>{{ $name }}</option>
            @endforeach
          </select>
          <div class="text-danger font-italic error-country">{{ $errors->first('country') }}</div>
        </label>
      </div>

      <div class="form-row">
        <label>
          <span>Postal Code</span>
          <input type="text" name="postcode" size="6" value="{{ old('postcode') }}">
          <div class="text-danger font-italic error-postcode">{{ $errors->first('postcode') }}</div>
        </label>
      </div>

      <div class="form-row">
        <br>
      </div>
      <div class="form-row">
        <h2>Final Costs</h2>
      </div>
        <div class="col-lg-12">
        <p>Sub Total: <span id="subtotal">{{ $subTotal }}</span></p>
        <p>Delivery: <span id="deliveryCost">{{ $standardDelivery }}</span></p>
        <p>Total: <span id="totalCost">{{ $total }}</span></p>
      </div>

      <div class="form-row">
        <br>
      </div>
      <div class="form-row">
        <h2>Card Details</h2>
        <p><strong>Note:</strong> Your card details are not passed to us. The purchase is handled by Stripe was we receive a token to confirm the purchase.
      </div>

      <div id="paymentForm">

        <div class="row form-group">
          <div class="col-md-12">
              <!-- Display errors returned by createToken -->
              <label>Card Number</label>
              <div id="paymentResponse" class="text-danger font-italic"></div>
              <div id="card_number" class="field form-control"></div>
          </div>
      </div>
      <div class="row form-group">
          <div class="col-md-3">
              <label>Expiry Date</label>
              <div id="card_expiry" class="field form-control"></div>
          </div>
          <div class="col-md-3">
              <label>CVC Code</label>
              <div id="card_cvc" class="field form-control"></div>
          </div>
      </div>
      <div class="row form-group">
          <div class="col-md-12">
              <div class="form-check form-check-inline custom-control custom-checkbox">
                  <label for="terms_conditions" class="custom-control-label">
                      <input type="checkbox" name="terms_conditions" id="terms_conditions" class="custom-control-input">
                      I agree to terms & conditions
                    </label>
              </div>
              {{-- @if($errors->first('terms_conditions')) --}}
              <div class="text-danger font-italic error-terms">{{ $errors->first('terms_conditions') }}</div>
              {{-- @endif --}}
          </div>
      </div>

        <button type="submit" class="btn pay-via-stripe-btn">Submit Payment</button>
      </div>
    </form>
    </div>
  </div>
  <aside class="col-sm-4 sidebar lp30">
      <h2>Delivery Details</h2>
      <h4>Ireland</h4>
      <p>Free delivery in Ireland</p>

      <h4>Outside Ireland</h4>
      <p>E5 for Mounts, E10 for Framed</p>

      <h4>
  </aside>
</div>
      </div>
</div>
@endsection
