<?php
$error = $this->session->flashdata('error');
?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="content">

        <div class="panel_s">

            <div class="panel-body">
                <?php if ($dispute) : ?>
                    <?php echo form_open('', ['enctype' => 'multipart/form-data']); ?>
                    <div class="row" style="margin :0;">
                        <!-- HEADER -->
                        <div class="col-12">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h3 style="margin: 0">Add Evidence</h3>
                                <h4>Submit Before : <?= date("d-M-Y H:i:s", $dispute->due_by) ?></h4>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cancellation_policy">Cancellation Policy</label>
                                    <input type="file" name="cancellation_policy" id="cancellation_policy" class="dropify">
                                </div>



                                <div class="form-group">
                                    <label for="customer_communication">Customer Communication</label>
                                    <input type="file" name="customer_communication" id="customer_communication" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="customer_signature">Customer Signature</label>
                                    <input type="file" name="customer_signature" id="customer_signature" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="duplicate_charge_documentation">Duplicate Charge Documentation</label>
                                    <input type="file" name="duplicate_charge_documentation" id="duplicate_charge_documentation" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="receipt">Receipt</label>
                                    <input type="file" name="receipt" id="receipt" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="refund_policy">Refund Policy</label>
                                    <input type="file" name="refund_policy" id="refund_policy" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="service_documentation">Service Documentation</label>
                                    <input type="file" name="service_documentation" id="service_documentation" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_documentation">Shipping Documentation</label>
                                    <input type="file" name="shipping_documentation" id="shipping_documentation" class="dropify">
                                </div>

                                <div class="form-group">
                                    <label for="uncategorized_file">Other File</label>
                                    <input type="file" name="uncategorized_file" id="uncategorized_file" class="dropify">
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="access_activity_log">Activity Log</label>
                                    <textarea name="access_activity_log" id="access_activity_log" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="billing_address">Billing Address</label>
                                    <input type="text" name="billing_address" id="billing_address" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="cancellation_policy_disclosure">Cancellation Policy Disclosure</label>
                                    <input type="text" name="cancellation_policy_disclosure" id="cancellation_policy_disclosure" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="cancellation_rebuttal">Cancellation Rebuttal</label>
                                    <input type="text" name="cancellation_rebuttal" id="cancellation_rebuttal" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="customer_email_address">Customer Email Address</label>
                                    <input type="text" name="customer_email_address" id="customer_email_address" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="customer_purchase_ip">Customer Purchase IP</label>
                                    <input type="text" name="customer_purchase_ip" id="customer_purchase_ip" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="duplicate_charge_explanation">Duplicate Charge Explanation</label>
                                    <input type="text" name="duplicate_charge_explanation" id="duplicate_charge_explanation" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="duplicate_charge_id">Duplicate Charge ID</label>
                                    <input type="text" name="duplicate_charge_id" id="duplicate_charge_id" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="product_description">Product Description</label>
                                    <textarea name="product_description" id="product_description" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="refund_policy_disclosure">Refund Policy Disclosure</label>
                                    <textarea name="refund_policy_disclosure" id="refund_policy_disclosure" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="refund_refusal_explanation">Refund Refusal Explanation</label>
                                    <textarea name="refund_refusal_explanation" id="refund_refusal_explanation" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="service_date">Service Date</label>
                                    <input type="date" name="service_date" id="service_date" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_address">Shipping Address</label>
                                    <input type="text" name="shipping_address" id="shipping_address" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_carrier">Shipping Carrier</label>
                                    <input type="text" name="shipping_carrier" id="shipping_carrier" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_date">Shipping Date</label>
                                    <input type="date" name="shipping_date" id="shipping_date" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="shipping_tracking_number">Shipping Tracking Number</label>
                                    <input type="text" name="shipping_tracking_number" id="shipping_tracking_number" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="uncategorized_text">Additional Information</label>
                                    <textarea name="uncategorized_text" id="uncategorized_text" class="form-control" rows="5"></textarea>
                                </div>


                            </div>
                        </div>

                        <button type="button" class="btn btn-success add_evidence">Submit</button>
                        <button type="submit" class="submit_evidence" style="display : none">Submit</button>
                        </form>
                    </div>

                <?php else : ?>
                    No Data Found
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/utilities/calendar_template'); ?>
</body>
<?php init_tail(); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();

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

        $('.add_evidence').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'This action is irreversible!',
                text: "You will not be able to submit any more evidence.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    $('.submit_evidence').click();
                }
            })
        });

        <?php if ($error) : ?>
            Toast.fire({
                icon: 'error',
                title: "<?= $error; ?>"
            })
        <?php endif; ?>
    })
</script>

</html>