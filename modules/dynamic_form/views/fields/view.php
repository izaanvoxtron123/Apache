<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="content">
        <?php
        // echo "<pre>";
        // print_r($data);
        ?>
        <div class="panel_s">
            <div class="panel-body">
                <div class="row" style="margin :0;">
                    <div class="col-12" style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    ">
                        <h3>All Form Fields</h3>
                        <a href="<?= admin_url('dynamic_form/manage_fields/add/') . $form_id ?>" class="btn btn-xs btn-info">Add New <i class="fa fa-plus"></i></a>
                    </div>

                    <hr>

                    <div class="col-12">
                        <table class="table table-clients dataTable no-footer" style="cursor: grab;">
                            <thead>
                                <tr class="">
                                    <th scope="col">#</th>
                                    <th scope="col">Label</th>
                                    <th scope="col">Field Type</th>
                                    <th scope="col">Input Type</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">

                                <?php foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="sequence[]" value="<?= $value['id'] ?>">
                                            <?= $key += 1 ?>
                                        </td>
                                        <td><?= $value['label'] ?></td>
                                        <td><?= $value['field_type'] ?></td>
                                        <td><?= $value['input_type'] ?></td>
                                        <td><?= $value['name'] ?></td>
                                        <?php if ($value['status']) { ?>
                                            <td><span class="badge" style="padding:5px ;background-color:#28a745">Active</span> </td>
                                        <?php } else { ?>
                                            <td><span class="badge" style="padding:5px ;background-color:#dc3545">Inactive</span> </td>
                                        <?php } ?>
                                        <td>
                                            <a href="<?= admin_url('dynamic_form/manage_fields/edit/') . $form_id . "/" . $value['id'] ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                        <?php if (count($data)) : ?>
                            <button type="button" class="btn btn-xs btn-info update_sequence">
                                Update <i class="fa fa-save"></i>
                            </button>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    $(function() {
        $("#sortable").sortable({
            revert: true
        });
    });

    $('.update_sequence').click(async function(e) {
        e.preventDefault();
        var sequence = $('#sortable :input').serializeArray().reduce(function(acc, ele) {
            acc.push(ele.value);
            return acc;
        }, []);
        await $.ajax({
            url: "<?= current_url() ?>",
            type: "POST",
            data: {
                <?= $this->security->get_csrf_token_name() ?>: "<?= $this->security->get_csrf_hash() ?>",
                sequence
            },
            error: function() {
                window.location.reload();
            }
        })

        window.location.reload();
    })
</script>


</body>

</html>