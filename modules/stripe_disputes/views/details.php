<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="content">

        <div class="panel_s">

            <div class="panel-body">
                <?php if ($dispute) : ?>
                    <div class="row" style="margin :0;">
                        <!-- HEADER -->
                        <div class="col-12">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h3>Dispute Details</h3>
                                <h4><?= date("d-M-Y H:i:s", $dispute->created) ?></h4>
                            </div>
                            <h4>USD <?= number_format($dispute->amount / 100, 2) ?></h4>
                            <p class="text-capitalize" style="margin-bottom: 0px;">Reason : <?= str_replace('_', ' ', $dispute->reason) ?></p>
                            <p style="margin-bottom: 0px;" class="text-capitalize
                        <?= $dispute->status == "won" ? "text-success" : "" ?> 
                        <?= $dispute->status == "lost" ? "text-danger" : "" ?>">
                                Status : <?= str_replace('_', ' ', $dispute->status) ?></p>
                            <p style="margin-bottom: 0px;">Refundable : <?= $dispute->is_charge_refundable ? "Yes" : "No" ?></p>
                            <?php if (!$dispute->evidence_details->has_evidence && !$dispute->evidence_details->past_due) :  ?>
                                <p>Submit Evidence Before : <?= date("d-M-Y H:i:s", $dispute->evidence_details->due_by) ?></p>
                                <a href="<?= admin_url('stripe_disputes/manage/add_evidence/') . $dispute->id ?>" class="btn btn-info">Submit Evidence <span class="fa fa-arrow-right"></span></a>
                            <?php endif; ?>
                        </div>

                        <hr>

                        <?php if ($dispute->evidence_details->has_evidence) :  ?>
                            <div class="col-12">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <h3>Evidence Details</h3>
                                </div>

                                <dl class="row">
                                    <dt class="col-sm-3">Activity Log</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->access_activity_log ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Billing Address</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->billing_address ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Cancellation Policy</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->cancellation_policy) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Cancellation Policy Disclosure</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->cancellation_policy_disclosure ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Cancellation Rebuttal</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->cancellation_rebuttal ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Customer Communication</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->customer_communication) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Customer Email Address</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->customer_email_address ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Customer Name</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->customer_name ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Customer Purchase IP</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->customer_purchase_ip ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Customer Signature</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->customer_signature) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Duplicate Charge Documentation</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->duplicate_charge_documentation) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Duplicate Charge Explanation</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->duplicate_charge_explanation ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Duplicate Charge ID</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->duplicate_charge_id ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Product Description</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->product_description ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Receipt</dt>
                                    <dd class="col-sm-9"> <?= getStripeMedia($dispute->evidence->receipt) ?> </dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Refund Policy</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->refund_policy) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Refund Policy Disclosure</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->refund_policy_disclosure ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Refund Refusal Explanation</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->refund_refusal_explanation ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Service Date</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->service_date ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Service Documentation</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->service_documentation) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Shipping Address</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->shipping_address ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Shipping Carrier</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->shipping_carrier ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Shipping Date</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->shipping_date ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Shipping Documentation</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->shipping_documentation) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Shipping Tracking Number</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->shipping_tracking_number ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Other File</dt>
                                    <dd class="col-sm-9"><?= getStripeMedia($dispute->evidence->uncategorized_file) ?></dd>
                                </dl>

                                <dl class="row">
                                    <dt class="col-sm-3">Additional Information</dt>
                                    <dd class="col-sm-9"><?= $dispute->evidence->uncategorized_text ?></dd>
                                </dl>


                            </div>
                        <?php endif; ?>

                    </div>

                <?php else : ?>
                    No Data Found
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>