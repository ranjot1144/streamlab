@extends('layouts.app')

@section('content')
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
            <h2 class="text-center"><strong>{{ __('SELECT YOUR PLAN') }}</strong></h2>
      </div>
    </div>

<div class="row">
  <div class="col-sm-6">
    <div class="card">
        <div class="card-header">{{ __('6 months plan') }} of <span>&#163;</span>100 </div>
        <p class="card-body">Save your <span>&#163;</span>15 per month, if you pay the 6 month full amount.</p>
        <a href="#" class="btn btn-primary">Proceed to Pay</a>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
        <div class="card-header">{{ __('12 months plan') }} of <span>&#163;</span>200 </div>
        <p class="card-body">Save your <span>&#163;</span>40 per month, if you pay the 12 months full amount.</p>
        <a href="#" class="btn btn-primary">Proceed to Pay</a>
    </div>
  </div>
</div>


</div>

@endsection
