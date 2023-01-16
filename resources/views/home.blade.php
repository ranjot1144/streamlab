@extends('layouts.app')

@section('content')

@php $braintree = new \App\Services\Braintree(); @endphp
<div class="container">
    <div class="row justify-content-center p-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Advanced Stream Stats') }}</div>
                <!--<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!--{{ __('You are logged in!') }}-->
                <!--</div>-->
            </div>
        </div>
    </div>

    <div class="row p-5">
      <div class="col-sm-12">
            <h2 class="text-center"><strong><u>{{ __('SELECT YOUR PLAN') }}</u></strong></h2>
      </div>
    </div>

<div class="row section-plans">
  <div class="col-sm-6">
    <div class="card">
        <div class="card-header"><strong>{{ __('6 months plan') }} of <span>&#163;</span>100 </strong></div>
        <p class="card-body">Save your <span>&#163;</span>15 per month, if you pay the 6 month full amount.</p>
        <a href="#" class="btn btn-primary get-package" data-amount="100" data-plan_id="1">Proceed to Pay</a>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
        <div class="card-header"><strong>{{ __('12 months plan') }} of <span>&#163;</span>200 </strong></div>
        <p class="card-body">Save your <span>&#163;</span>40 per month, if you pay the 12 months full amount.</p>
        <a href="#" class="btn btn-primary get-package" data-amount="200" data-plan_id="12">Proceed to Pay</a>
    </div>
  </div>
</div>

<div class="checkout-form" style="display: none">
    <form method="post" id="payment-form">
        <section>
            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>
        </section>

        <input id="nonce" name="payment_method_nonce" type="hidden" />
        <button class="btn btn-primary bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-primary-900" type="submit"><span>Submit</span></button>
    </form>
</div>


<script src="https://js.braintreegateway.com/web/dropin/1.33.5/js/dropin.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function (){
        $('body').on('click','.get-package', function (){
            $('.section-plans').hide();
            $('.checkout-form').show();
            let amount = $(this).attr('data-amount');
            let planId = $(this).attr('data-plan_id');
            let client_token = '{{$braintree->generateClientToken()}}';
            braintree.dropin.create({
                authorization: client_token,
                selector: '#bt-dropin',
                paypal: {
                    flow: 'vault'
                }
            }, function (createErr, instance) {
                if (createErr) {
                    console.log('Create Error', createErr);
                    return;
                }
                $('body').on('submit','#payment-form', function (e){
                    e.preventDefault();
                    instance.requestPaymentMethod(function (err, payload) {
                        if (err) {
                            console.log('Request Payment Method Error', err);
                            return;
                        }
                        $.ajax({
                            type:'post',
                            url:"{{route('checkout.store')}}",
                            data        :   {
                                amount: amount,
                                planId: planId,
                                paymentMethodNonce: payload.nonce,
                                _token: $('meta[name=csrf-token]').attr("content")
                            },
                            success:function(data) {
                                $('.checkout-form').hide();
                                $('.success-page').show();

                            },
                        });
                    });

                })

            });
        })
    });


</script>

</div>

@endsection
