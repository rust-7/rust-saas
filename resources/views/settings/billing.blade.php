@extends('app')

@section('title', 'Billing')

@section('content')
    <div class="bg-gray-100 min-h-screen pb-24">
        
        @include('partials.dashboard-header')

        <div class="container mx-auto max-w-3xl mt-8">

        @if (session('alert'))
            <p>{{ session('alert') }}</p>
        @endif

            <h1 class="text-2xl font-bold text-gray-700 px-6 md:px-0">Billing Settings</h1>
            
            @include('settings.nav')

            @if (auth()->user()->subscribed('main'))
                <div id="switch-plans-modal" class="fixed w-full h-full inset-0 z-50">
                    <div class="fixed opacity-50 bg-black inset-0 w-full h-full"></div>
                    
                    <form method="POST" action="{{ route('billing.switch_plan') }}" class="absolute bg-white rounded-lg p-5" id="switch-plans">
                        @csrf
                        <div id="switch-plans-close" class="absolute right-0 top-0 -mt-4 -mr-4 w-8 h-8 rounded-full shadow bg-white text-center flex justify-center align-center text-xl text-red-600 font-bold cursor-pointer bg-red-100">
                            &times;
                        </div>
                        
                        <p class="text-normal text-gray-600 mb-4">Switch Plan</p>

                        @include('partials.plans')

                        <button class="bg-green-500 text-white mt-2 text-sm font-medium px-6 py-2 rounded float-right cursor-pointer">
                            Switch Plan
                        </button>
                    </form>
                </div>
            @endif

            <form action="{{ route('billing.save') }}" method="POST" id="billing-form" enctype="multipart/form-data">
                @csrf
                <div class="w-full bg-white rounded-lg mx-auto mt-8 flex overflow-hidden rounded-b-none">
                    <div class="w-1/3 bg-gray-100 p-8 hidden md:inline-block">
                        <h2 class="font-medium text-md text-gray-700 mb-4 tracking-wide">Billing Settings</h2>
                        <p class="text-xs text-gray-500">Update your payment informations</p>
                    </div>
                    
                    <div class="md:w-2/3 w-full">
                        @if(auth()->user()->subscribed('main'))
                                <div class="py-8 px-10">
                                    <div class="flex">
                                        <img src="/img/plans/{{ auth()->user()->plan->name }}.png" alt="plans" class="w-16 h-16 mr-3">
                                        
                                        <div>
                                            <span class="block">Current : {{ ucfirst(auth()->user()->plan->name) }} Plan</span>
                                            <span class="text-xs text-gray-600">{{ auth()->user()->plan->description }}</span>
                                        </div>
                                    </div>
                                    
                                    @if (auth()->user()->subscription('main')->onGracePeriod())
                                        <div class="flex items-center bg-blue-700 rounded-lg text-white mt-4 text-sm font-bold px-4 py-3 mb-4" role="alert"><svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                                            You cancelled your grace period, until: {{auth()->user()->subscription('main')->ends_at->toFormattedDateString()}}
                                        </div>
                                        <div class="flex justify-end items-end">
                                            <p class="text-sm text-black mr-2 mb-2">or, you can also</p>
                                            <a href="{{ route('resume') }}" class="bg-purple-500 text-white text-sm font-medium px-5 py-2 rounded shadow cursor-pointer">
                                                Resume Plan
                                            </a>
                                        </div>
                                    @else 
                                        <div class="flex justify-between items-center mt-4">
                                            <div id="switch-plan-btn" class="bg-green-600 text-white text-sm font-medium px-6 py-2 rounded shadow cursor-pointer inline-block">
                                                Switch Plan
                                            </div>
                                            <a href="{{ route('cancel') }}" class="bg-red-600 text-white text-sm font-medium px-6 py-2 rounded shadow cursor-pointer">Cancel Plan</a>
                                        </div>
                                    @endif
                                </div>

                                <hr class="border-gray-200">

                                <div class="py-8 px-16">
                                    <div class="mb-2 text-normal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 mr-2 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10" class="text-green-200 fill-current"></circle>
                                            <path d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z" class="text-green-600 fill-current"></path>
                                        </svg>
                                    </div>
                                    <div class="text-normal text-blue-600 mb-1">Last 4 Digits: **** <b>{{ auth()->user()->card_last_four }}</b></div>
                                    <div class="text-normal text-blue-600 mb-1">Credit Card Brand: <b> {{ auth()->user()->card_brand }}</b></div>
                                    <div class="text-xs text-gray-500">To update your default payment method, Add a new card below</div>
                                </div>
                            <hr class="border-gray-200">
                        @endif

                        @if (auth()->user()->onTrial())
                            
                            @include('partials.trial_notification')
                            
                        @endif
                        
                        <div class="py-8 px-16">
                            <label for="card-holder-name" class="text-sm text-gray-600">Name on your Credit Card </label>
                            <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-indigo-500" id="card-holder-name" type="text">
                        </div>
                        <hr class="border-gray-200">

                        <div class="py-8 px-16">
                            <label for="cc" class="text-sm text-gray-600">Credit Card</label>
                            <div id="card-element" class="mt-2 border-2 border-gray-200 px-3 py-4 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-indigo-500"></div>
                            <div id="card-errors" class="text-red-400 text-bold mt-2 text-sm font-medium"></div>
                        </div>
                        
                        @if(!auth()->user()->subscribed('main'))
                        <hr class="border-gray-200">
                            <div class="py-8 px-16">
                                @include('partials.plans')
                            </div>
                        @endif
                        <hr class="border-gray-200">
                    </div>
                </div>

                <div class="p-16 py-8 bg-white clearfix rounded-b-lg border-t border-gray-200">
                    <p class="float-left text-sm text-gray-500 tracking-tight mt-2">Click on Save to update your Billing Settings</p>
                    <button id="card-button" data-secret="{{ auth()->user()->createSetupIntent()->client_secret }}" class="bg-green-500 text-white text-sm font-medium px-6 py-2 rounded float-right cursor-pointer">Update Payment Method</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        const cardError = document.getElementById('card-errors');

        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                cardError.textContent = event.error.message;
            } else {
                cardError.textContent = '';
            }
        });

        var form = document.getElementById('billing-form');
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const { setupIntent, error } = await stripe.handleCardSetup(
                    clientSecret, cardElement, {
                        payment_method_data: {
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                if (error) {
                    // Display "error.message" to the user...
                    
                    cardError.textContent = error.message;
                    
                    console.log(error);
                } else {
                    // The card has been verified successfully...
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'payment_method');
                    hiddenInput.setAttribute('value', setupIntent.payment_method);
                    form.appendChild(hiddenInput);
                    // Submit the form
                    form.submit();
            }
        });
    </script>
@endsection