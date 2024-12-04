<head>
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 120px;
            height: 120px;
            margin: -76px 0 0 -76px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }


        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Add animation to "page content" */
        .animate-bottom {
            position: relative;
            -webkit-animation-name: animatebottom;
            -webkit-animation-duration: 1s;
            animation-name: animatebottom;
            animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0px;
                opacity: 1
            }
        }

        @keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }
    </style>

</head>




<body>
    <div id="loader" style="display: none;"></div>
    <div class="overlay">
        <?php if (has_permission('payment_options', '', 'view')) { ?>
            <div class="row mx-2">
                <h5 class="ml-2">Available Payment Options</h5>
                <div class="col-12">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Ending With</th>
                                <th scope="col">Expiry</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($payment_methods) > 0) { ?>
                                <?php foreach ($payment_methods['data'] as $key => $payment_method) { ?>
                                    <tr>
                                        <th scope="row"><?= $key + 1 ?></th>
                                        <td><?= strtoupper($payment_method['card']['brand']) ?></td>
                                        <td>**** <?= $payment_method['card']['last4'] ?></td>
                                        <td><?= $payment_method['card']['exp_month'] . "/" . $payment_method['card']['exp_year'] ?></td>
                                        <td><a href="<?= base_url('invoice/pay/' . $invoice->id . '/' . $invoice->hash . '/' . $payment_method['id']) ?>" class="btn btn-sm btn-outline-success pay_button">PAY</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
        <?php } ?>



        <form id="payment-form">
            <div id="payment-element">
                <!-- Elements will create form elements here -->
            </div>
            <br>
            <button id="submit" class="btn btn-outline-success w-100">PAY ($<?= number_format($invoice->total, 2) ?>)</button>
            <div id="error-message" class="text-danger font-weight-bold">
                <!-- Display error message to your customers here -->
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.pay_button', function(e) {
            e.preventDefault();
            $('.overlay').fadeOut('fast');
            $('#loader').fadeIn('fast');
            let url = $(this).attr('href');
            window.location.href = url;
            // alert(url);
        })
    })

    // document.addEventListener("DOMContentLoaded", () => {
    //     console.log("Hello World!");
    // });
    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/apikeys
    const stripe = Stripe("<?= $stripe_publishable_key ?>");

    const options = {
        clientSecret: "<?= $client_secret ?>",
        // Fully customizable with appearance API.
        appearance: {
            labels: 'floating',
            rules: {
                '.TermsText': {
                    color: '#ffffff00',
                    cursor : 'default'
                },
            },
        },
    };

    // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 3
    const elements = stripe.elements(options);

    // Create and mount the Payment Element
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');



    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const {
            error
        } = await stripe.confirmSetup({
            //`Elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: '<?= $return_url ?>',
            }
        });

        if (error) {
            // This point will only be reached if there is an immediate error when
            // confirming the payment. Show error to your customer (for example, payment
            // details incomplete)
            const messageContainer = document.querySelector('#error-message');
            messageContainer.textContent = error.message;
        } else {
            // Your customer will be redirected to your `return_url`. For some payment
            // methods like iDEAL, your customer will be redirected to an intermediate
            // site first to authorize the payment, then redirected to the `return_url`.
        }
    });
</script>