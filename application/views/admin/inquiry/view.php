<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s mtop5">
                    <div class="panel-body">

                        <table id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $key => $result) { ?>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td><?= $result['name'] ?></td>
                                        <td><?= $result['email'] ?></td>
                                        <td>
                                            <?php if (strlen($result['message']) > 53) : ?>
                                                <?= substr($result['message'], 0, 50) . '...' ?>
                                                <?php $message = str_replace('"', "", $result['message']) ?>
                                                <?php $message = str_replace("'", "", $message) ?>
                                                <a href="javascript:showInquiryMessageModal(' <?= $message ?>');">Read More</a>
                                            <?php else : ?>
                                                <? $result['message'] ?>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Inquiry Message Modal -->
<div class="modal fade" id="ShowMessageModal" tabindex="-1" role="dialog" aria-labelledby="ShowMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Inquiry Message </h4>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal_message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();

    });

    function showInquiryMessageModal(message) {
        $('.modal_message').text(message);
        console.log(message);
        $('#ShowMessageModal').modal('show');
    }
</script>