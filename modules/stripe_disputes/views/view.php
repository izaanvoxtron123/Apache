<?php
$success = $this->session->flashdata('success');
?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="content">
        <div class="panel_s">
            <div class="panel-body">
                <div class="row" style="margin :0;">
                    <div class="col-12" style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    ">
                        <h3>All Stripe Disputes</h3>
                        <!-- <a href="<?= admin_url('dynamic_form/manage/add') ?>" class="btn btn-xs btn-info">Add New <i class="fa fa-plus"></i></a> -->
                    </div>

                    <hr>

                    <div class="col-12">
                        <table class="table table-clients dataTable no-footer">
                            <thead>
                                <tr class="">
                                    <th scope="col">#</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Has Evidence</th>
                                    <th scope="col">Is Refundable</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <?php if (count($disputes)) : ?>
                                <tbody>
                                    <?php foreach ($disputes->data as $key => $dispute) { ?>
                                        <tr>
                                            <th scope="row"><?= $key += 1 ?></th>
                                            <td class="text-uppercase"><?= $dispute->currency . " " . number_format($dispute->amount / 100, 2) ?></td>

                                            <?php if ($dispute->evidence_details->has_evidence) { ?>
                                                <td><span class="badge" style="padding: 5px 10px;color: white; background-color:#28a745">Yes</span> </td>
                                            <?php } else { ?>
                                                <td><span class="badge" style="padding: 5px 10px;color: white; background-color:#dc3545">No</span> </td>
                                            <?php } ?>

                                            <?php if ($dispute->evidence_details->has_evidence) { ?>
                                                <td><span class="badge" style="padding: 5px 10px;color: white; background-color:#28a745">Yes</span> </td>
                                            <?php } else { ?>
                                                <td><span class="badge" style="padding: 5px 10px;color: white; background-color:#dc3545">No</span> </td>
                                            <?php } ?>

                                            <td><?= date("d-M-Y H:i:s", $dispute->created) ?></td>
                                            <td class="text-capitalize"><?= str_replace('_', ' ', $dispute->reason) ?></td>
                                            <td class="text-capitalize 
                                        <?= $dispute->status == "won" ? "bg-success" : "" ?> 
                                        <?= $dispute->status == "lost" ? "bg-danger" : "" ?>">
                                                <?= str_replace('_', ' ', $dispute->status) ?></td>
                                            <td>
                                                <a href="<?= admin_url('stripe_disputes/manage/view/') . $dispute->id ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                <?php if (!$dispute->evidence_details->has_evidence && !$dispute->evidence_details->past_due) : ?>
                                                    <a href="<?= admin_url('stripe_disputes/manage/add_evidence/') . $dispute->id ?>" class="btn btn-sm btn-success"><i class="fa fa-gavel"></i></a>
                                                <?php endif; ?>

                                                <?php if ($dispute->status != "won" && $dispute->status != "lost") : ?>
                                                    <a href="#" class="btn btn-sm btn-danger close_dispute" data-dispute_id="<?= $dispute->id ?>"><i class="fa fa-close"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <?php if ($disputes->has_more) : ?>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <a href="?starting_after=<?= $disputes->data[count($disputes->data) - 1]->id ?>" class="btn btn-sm btn-info">Next Page <i class="fa fa-arrow-right"></i></a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>

                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/utilities/calendar_template'); ?>
<!-- <?php $this->load->view('admin/dashboard/dashboard_js'); ?> -->
</body>

<?php init_tail(); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
    $(document).ready(function() {

        $('.close_dispute').click(function(e) {
            e.preventDefault();
            let dispute_id = $(this).data('dispute_id');
            let url = '<?= admin_url('stripe_disputes/manage/close/') ?>' + "_dispute_id_"
            url = url.replace('_dispute_id_', dispute_id);
            Swal.fire({
                title: 'This action is irreversible!',
                text: "You will lose this dispute!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        dataType: 'json',
                        success: function(result) {
                            if (result.status) {
                                Toast.fire({
                                    icon: 'success',
                                    title: result.message
                                })
                                window.location.reload();
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: result.message
                                })
                            }
                        }
                    });

                }
            })
        });

        <?php if ($success) : ?>
            Toast.fire({
                icon: 'success',
                title: "<?= $success; ?>"
            })
        <?php endif; ?>
    });
</script>

</html>