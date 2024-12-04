<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $company_name ?> - Credit Card Payment</title>

    <link href="<?= site_url('modules/nmi_payment/assets/cc_validator_plugin/card-js.min.css') ?>" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- <script src="<?= site_url('modules/nmi_payment/assets/js/cc_validator.js') ?>" type="text/javascript"></script> -->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700&display=swap');
        @import url('https://fonts.cdnfonts.com/css/roboto');

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: grey;
            opacity: 0.6;
            z-index: 100;
        }

        #loader {
            background: url(http://localhost:8080/alliedCrm/modules/nmi_payment/assets/images/loading.gif);
            width: 40px !important;
            height: 40px !important;
            background-position: center;
            background-size: contain !important;
            background-repeat: no-repeat !important;
            margin: auto !important;
            position: sticky !important;
            top: 50% !important;
            bottom: 50% !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 101 !important;
            display: none;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            font-family: 'Open Sans', sans-serif;
            color: rgb(33, 33, 33);
        }

        body {
            padding: 0px;
        }

        p {
            margin: 0%;
        }

        .container {
            margin: 30px auto;
            padding: 60px;
            overflow: hidden;
            max-width: 1000px;
        }

        #one:checked~label.first,
        #two:checked~label.second,
        #three:checked~label.third {
            border-color: #dc4243;
        }

        #one:checked~label.first .circle,
        #two:checked~label.second .circle,
        #three:checked~label.third .circle {
            border-color: #dc4243;
            background-color: #fff;
        }

        .brand-image {
            width: 40px;
            height: 40px;
            border-radius: 100%;
            overflow: hidden;
            box-shadow: 0px 0px 2px rgb(68, 68, 68);
            display: inline-block;
        }

        .brand-image img {
            width: 100%;
            height: inherit;
            object-fit: cover;
            display: block;
        }

        .brand-name {
            display: inline-block;
            font-size: 16px;
            margin-left: 8px;
            font-weight: 600;
        }

        .package {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .price {
            font-size: 18px;
        }

        .price p {
            color: #dc4243;
            font-weight: 600;
            font-size: 40px;
            margin-bottom: 15px;
        }

        .invoice-link {
            font-size: 14px;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
        }

        .description {
            font-size: 13px;
            margin-top: 4px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        label {
            font-size: 13px;
            margin-top: 25px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        input,
        select {
            border-radius: 6px !important;
            font-size: 14px !important;
        }

        .disclaimer {
            font-size: 11px;
            text-align: left;
            color: rgb(111, 111, 111);
            text-align: center;
            font-weight: 500;
        }

        .btn {
            font-size: 16px;
            width: 100%;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            margin-top: 35px;
            margin-bottom: 15px;
            background-color: #dc4243;
            border-color: #dc4243;
        }

        .address-box>select {
            border-radius: 6px 6px 0px 0px !important;
        }

        .address-box input {
            border-radius: 0px 0px 6px 6px !important;
            border-top: none;
        }

        .card-box>input {
            border-radius: 6px 6px 0px 0px !important;
        }

        .card-box div input {
            width: 50%;
            float: left;
            border-top: none;
        }

        .card-box div input:first-child {
            border-radius: 0px 0px 0px 6px !important;
        }

        .card-box div input:nth-child(2) {
            border-radius: 0px 0px 6px 0px !important;
            border-left: none;
        }

        .clear {
            clear: both;
        }

        .cards-placer {
            position: relative;
        }

        .cards-placer:after {
            background-image: url('cards.png');
            background-size: 90px 14px;
            content: "";
            position: absolute;
            width: 90px;
            height: 14px;
            top: 10px;
            right: 10px;
            background-repeat: no-repeat;
        }

        /* .card_type_box {
            font-weight: 700;
            text-align: right;
            position: absolute;
            bottom: 40px;
            right: 15px;
            font-size: 16px;
            text-transform: uppercase;
        } */
        .card_type_box {
            font-weight: 700;
            text-align: right;
            position: absolute !important;
            bottom: 0px !important;
            right: 8px !important;
            top: 8px !important;
            left: 346px !important;
            text-transform: uppercase;
        }

        input.form-control.full-email {
            padding: 7px;
        }

        .card-nn {
            border: 1px solid #d5d3d3 !important;
        }

        form#ticketForm {
            width: 92%;
        }

        label {
            font-size: 13px;
            margin-top: 25px;
            font-weight: 500;
            margin-bottom: 5px;
            font-family: 'Open Sans';
        }

        .btn-submit {
            font-size: 16px;
            width: 100%;
            color: rgb(255 255 255 / 80%);
            font-weight: 600;
            margin-top: 35px;
            margin-bottom: 15px;
            background-color: #0d6efd;
            border-color: #0D6EFE;
        }

        input.form-control.card-nm {
            padding: 7px;
        }

        .card_type_box {
            font-weight: 700;
            text-align: right;
            position: absolute !important;
            bottom: 0px !important;
            right: 12px !important;
            top: 7px !important;
            left: 240px !important;
            text-transform: uppercase;
        }

        .price p {
            color: #000000;
            font-weight: 600;
            font-size: 40px;
            margin-bottom: 15px;
        }

        .invoice-link p {
            font-family: 'Open Sans';
            font-size: 17px;
            font-weight: 500;
            color: #666666;
        }

        /* .col-md-6.newnn {
            box-shadow: -3px 0px 11px 0px rgba(0, 0, 0, 0.2);
        } */

        .new_card {
            padding: 16px;
        }

        .App-Footer {
            display: flex;
        }

        .App-Footer img {
            width: 77% !important;
            max-width: 42% !important;
            margin: 0px 05px !important;
        }

        .Footer-PoweredBy {
            width: 17% !important;
        }

        .App-Footer a {
            text-decoration: none !important;
            font-family: 'Open Sans' !important;
            font-weight: 300;
            font-size: 13px !important;
            color: grey;
        }

        .Footer-Links a {
            padding: 05px !important;
        }
    </style>
</head>
<div id="loader"> </div>

<body>

    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 30px;">
                        <div class="brand-image align-middle">
                            <img src="<?= base_url('uploads/company/' . $company_logo) ?>" alt="">
                        </div>
                        <p class="brand-name align-middle"><?= $company_name ?></p>
                    </div>

                    <div style="margin-top:0px;" class="col-md-12 col-sm-12 align-middle" style="text-align: right;">
                        <div class="invoice-link">
                            <p>Payment for Invoice <?= $invoice_number ?></p>
                        </div>
                        <div class="price">
                            <p>$<?= number_format($amount, 2) ?></p>
                        </div>
                    </div>

                    <?php if (count($client_existing_cards) && is_admin()) : ?>
                        <div class="existing_cards">

                            <?php foreach ($client_existing_cards as $key => $card) : ?>
                                <div class="card bg-transparent my-1">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="text-<?= $card['card_type'] == "mastercard" ? "danger" : "primary" ?> fa fa-cc-<?= $card['card_type'] ?>"> </i>
                                            **** **** **** <?= $card['ending_with'] ?>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-muted my-1"><?= substr_replace($card['expiry'], '/', 2, 0) ?> <span><?= $card['cvv'] ?></span></h6>
                                        <a href="#" class="btn btn-submit btn-xs my-0 pay_using_existing_card" data-card_id="<?= $card['id'] ?>" data-amount="<?= $amount ?>">
                                            Pay
                                            <i class="text-white fa fa-arrow-right"> </i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- <div class="card bg-transparent my-1">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Didn't find your card?
                                    </h5>
                                    <span class="btn btn-xs my-0 other_card">
                                        Pay Using Other Card
                                        <i class="text-white fa fa-arrow-right"> </i>
                                    </span>
                                </div>
                            </div> -->
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6 newnn">
                <div class="new_card">
                    <!-- 
                    <div class="existing_card_div mb-3" style="display : <?= !count($client_existing_cards) ? "none" : "block" ?>">
                        <div class="card bg-transparent my-1">
                            <div class="card-body">
                                <span class="btn btn-xs my-0 existing_card">
                                    <i class="text-white fa fa-arrow-left"> </i>
                                    Pay Using Existing Card
                                </span>
                            </div>
                        </div>
                    </div> -->



                    <div class="">
                        <p class="title">Pay with Card</p>
                        <p class="description">Complete your purchase by providing your payment details</p>
                    </div>

                    <?php echo form_open('', array('id' => 'ticketForm', 'class' => 'disable-on-submit needs-validation', 'novalidate' => 'true')); ?>
                    <input type="hidden" name="invoice_id" value="<?= $invoice->id ?>">
                    <input type="hidden" name="amount" value="<?= $amount ?>">

                    <div>
                        <label name="Email">Email</label>
                        <input class="form-control full-email" name="email" type="email" value="" required>
                    </div>
                    <div>
                        <label name="Email">Card Information</label>
                        <div class="card-box cards-placer">

                            <!-- <div class="card-js" id="example"></div> -->

                            <!-- <div class="card-js">
                                <input class="card-number my-custom-class" name="card-number" required>
                                <input class="expiry-month exp" name="expiry-month" required>
                                <input class="expiry-year exp" name="expiry-year" required>
                                <input class="cvc" name="cvc" required>
                            </div> -->

                            <div class="card-js">
                                <input class="form-control card-number my-custom-class" required name="card-number">
                                <input class="form-control expiry-month" id="expiry-month" required name="expiry-month">
                                <input class="form-control expiry-year" id="expiry-year" required name="expiry-year">
                                <input class="form-control cvc" required name="cvc">
                            </div>



                            <!-- <span class="card_type_box"></span>
                            <input type="text" class="form-control card-nn" data-validation="required" maxlength="16" required name="cardnumber" placeholder="1234123412341234" id="cardnumber" onblur="validate_cc(this)" onkeyup=" validate_cc(this)" required>
                            <span class="text-danger font-weight-bold"></span>
                            <strong class="text-danger cc_number_error_div"></strong> -->


                            <!-- <div>
                                <input type="text" class="form-control" id="exp" name="exp" maxlength="05" required placeholder="MM/YY">
                                <input type="text" class="form-control" name="cvv" id="cvv" maxlength="04" required placeholder="CVV" onkeyup="validate_cc(this)" required>
                                <strong class="text-danger invalid-date" style="display:none">Invalid Date</strong>
                                <strong class="text-danger cvv_exp_error_div"></strong>
                                <div class="clear"></div>
                            </div> -->



                        </div>
                    </div>
                    <div>
                        <label>Name on Card</label>
                        <input class="form-control card-nm" name="cardname" required type="text">
                    </div>
                    <div>
                        <label>Billing Address</label>
                        <div class="address-box">
                            <select class="form-select" aria-label="Default select example" name="billing_country">
                                <option selected hidden>United States</option>
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="CA">Canada</option>
                            </select>
                            <input class="form-control" name="zip" type="text" maxlength="10" required placeholder="ZIP">
                        </div>
                    </div>

                    <div class="pay">
                        <button type="submit" id="submit_btn" class="btn btn-primary">Pay</button>
                    </div>
                </div>
                <div class="disclaimer">
                    Notwithstanding the logo displayed above, when paying with a co-branded eftpos debit card, your payment may be processed through either card network.<br><br>By confirming your payment, you allow <?= $company_name ?> to charge your card
                    for this payment
                </div>

                <?php echo form_close(); ?>

            </div>
            <footer class="App-Footer Footer">
                <div class="Footer-PoweredBy"><a class="Link Link--primary" href="https://stripe.com" target="_blank" rel="noopener"><span class="Text Text-color--gray400 Text-fontSize--12 Text-fontWeight--400">Powered by </span><img src="<?= base_url('modules/nmi_payment/assets/images/maverick.png') ?>"></a></div>
                <div class="Footer-Links">
                    <a class="Link Link--primary" href="https://maverickpayments.com/terms.html" target="_blank" rel="noopener">
                        <span class="Text Text-color--gray400 Text-fontSize--12 Text-fontWeight--400">
                            Terms
                        </span>
                    </a>
                    <!-- <a class="Link Link--primary" href="https://stripe.com/privacy" target="_blank" rel="noopener">
                        <span class="Text Text-color--gray400 Text-fontSize--12 Text-fontWeight--400">
                            Privacy</span>
                    </a> -->
                </div>
            </footer>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="<?= site_url('modules/nmi_payment/assets/cc_validator_plugin/card-js.min.js') ?>" type="text/javascript"></script>

    <script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>

    <!-- <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        $(document).on('change', '#expiry-year', function(e) {
            e.preventDefault();
            let expiry_year = $('.expiry-year').val()
            alert(expiry_year)
            $('#submit_btn').attr('disabled', true);
        })
        $(document).on('change', '#expiry-month', function(e) {
            e.preventDefault();
            let expiry_month = $('.expiry-month').val()
            alert(expiry_month)
            $('#submit_btn').attr('disabled', true);
        })


        function check_expiry() {

        }


        $('#exp').focusout(function(e) {
            let value = $(this).val();

            let dated_value = new moment(value, 'MM/YY')
            let current_date = new moment()

            if (value == "" || !dated_value.isValid() || dated_value.isBefore(current_date)) {
                $('.invalid-date').fadeIn();
                $('#submit_btn').attr('disabled', true);
            } else {
                $('.invalid-date').fadeOut();
                $('#submit_btn').attr('disabled', false);
            }
        })

        $('.other_card').click(function(e) {
            e.preventDefault();
            $('.existing_cards').slideUp();
            $('.new_card').slideDown();
            window.scrollTo(0, 50);
        })

        $('.existing_card').click(function(e) {
            e.preventDefault();
            $('.new_card').slideUp();
            $('.existing_cards').slideDown();
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $(document).on('click', '.pay_using_existing_card', async function(e) {
            const id = $(this).data('card_id');

            $("body ").append('<div id="overlay"></div>');
            $("#loader").show();

            // GET CARD INFORMATION
            let cardData;
            cardData = await $.ajax({
                url: "<?= base_url('nmi_payment/process_payment/get_card_info/') ?>" + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    return JSON.parse(JSON.stringify(response));
                }
            })

            // POST REQUEST TO REPLICATE PAYMENT
            $.ajax({
                url: "<?= current_url() ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    "<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>",
                    "ajax_call": true,
                    "invoice_id": "<?= $invoice->id ?>",
                    "amount": "<?= $amount ?>",
                    "cardnumber": cardData.data.card_number,
                    "exp": cardData.data.expiry,
                    "cvv": cardData.data.cvv,
                    "cardname": cardData.data.card_name
                },
                success: function(response) {
                    response = JSON.parse(JSON.stringify(response));
                    if (response.status == true) {
                        Toast.fire({
                            icon: 'success',
                            title: "Transaction Successful"
                        })
                        setTimeout(
                            function() {
                                window.location = response.redirection_url
                            }, 2000);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.code + ", " + response.message
                        })
                        $('#overlay').remove();
                        $("#loader").hide();
                    }
                }
            })

        });

        // $(":input").inputmask();
        // $("#exp").inputmask({
        //     "mask": "99/99"
        // });
        // $("#cardnumber").inputmask({
        //     "mask": "9999 9999 9999 9999"
        // });



        <?php if ($this->session->flashdata('nmi_cc_error')) : ?>
            let code = '<?= $this->session->flashdata('nmi_cc_error')['code'] ?>'
            let message = '<?= $this->session->flashdata('nmi_cc_error')['message'] ?>'
            let data = '<?= $this->session->flashdata('nmi_cc_error')['data'] ?>'
            data = JSON.parse(data)
            $('input[name=email]').val(data.email);
            $('input[name=cardname]').val(data.cardname);
            $('input[name=cardnumber]').val(data.cardnumber);
            $('input[name=cvv]').val(data.cvv);
            $('input[name=exp]').val(data.exp);
            $('input[name=zip]').val(data.zip);
            $('#submit_btn').attr('disabled', false);
            console.log(message)
            console.log(data)
            handle_payment_errors(code, message);
        <?php endif; ?>

        function handle_payment_errors(code, message) {
            cc_number_selector = $('.cc_number_error_div')
            exp_selector = $('.cvv_exp_error_div')
            cvv_selector = $('.cvv_exp_error_div')
            console.log(message)
            switch (code) {
                case '300':
                    exp_selector.text(message)
                    break;
                default:
                    Toast.fire({
                        icon: 'error',
                        title: message
                    })
                    break;
            };
        }
        // Self-executing function
        new(function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>