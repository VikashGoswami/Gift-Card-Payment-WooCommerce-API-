<!-- resources/views/payment.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Gift Card Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container m-auto">

        <h1>Gift Card Payment</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button class="btn btn-outline-success" type="button" name="giftCardBtn" data-bs-toggle="modal"
            data-bs-target="#giftCardModal">
            Gift Card
        </button>

        <!-- Modal -->


        @if (session('balance') || session('error') || session('giftError'))
            <div class="modal fade show" id="giftCardModal" tabindex="-1" aria-labelledby="giftCardLabel"
                style="display: block;" aria-modal="true" aria-hidden="false" role="dialog">
            @else
                <div class="modal fade" id="giftCardModal" tabindex="-1" aria-labelledby="giftCardLabel"
                    aria-hidden="true">
        @endif


        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="giftCardLabel">Redeem Gift Card</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    @csrf
                    {{-- <div class="form-group"> --}}

                    <form method="POST" action="{{ route('payment') }}">
                        <div class="row mb-3">
                            @csrf
                            <div class="col-md-8">
                                <label for="gift_card_number">Gift Card Number:</label>
                                <input type="text" id="gift_card_number" class="form-control" name="gift_card_number"
                                    value="{{ session('gift_card_number') ?? session('gift_card_number') }}" required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <input type="submit" value="Check" class="btn btn-primary">
                            </div>

                        </div>
                    </form>
                    <hr>
                    <form method="POST" action="{{ route('applyPayment') }}">
                        @csrf
                        @if (session('balance'))
                            <div class="alert alert-info mb-3">
                                {{-- Gift Card Balance: {{ session('balance') }} --}}
                                <div class="row">
                                    <div class="col-md-7">
                                        Gift Card Balance: {{ session('balance') }}
                                    </div>
                                    <div class="col-md-5">
                                        @if (session('giftSuccess'))
                                            <span class="text-success">
                                                {{ session('giftSuccess') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (session('giftError'))
                            <div class="alert alert-danger">
                                {{ session('giftError') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <label for="customer_number">Customer Number:</label>
                                <input type="text" id="customer_number" class="form-control" name="customer_number"
                                    required>
                            </div>
                            <div class="col-md-6 mt-4">
                                <button type="submit" class="btn btn-success mt-10 pull-right">Apply
                                    Payment</button>
                            </div>
                        </div>
                        {{-- </div> --}}
                    </form>
                </div>
                {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
            </div>
        </div>
    </div>
    </div>


    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
    <script src="{{ url('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
