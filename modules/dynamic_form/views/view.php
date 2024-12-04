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
                        <h3>All Brief Forms</h3>
                        <a href="<?= admin_url('dynamic_form/manage/add') ?>" class="btn btn-xs btn-info">Add New <i class="fa fa-plus"></i></a>
                    </div>

                    <hr>

                    <div class="col-12">
                        <table class="table table-clients dataTable no-footer">
                            <thead>
                                <tr class="">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $value) { ?>
                                    <tr>
                                        <th scope="row"><?= $key += 1 ?></th>
                                        <td><?= $value['name'] ?></td>
                                        <td><?= $value['description'] ?></td>
                                        <?php if ($value['status']) { ?>
                                            <td><span class="badge" style="padding:5px ;background-color:#28a745">Active</span> </td>
                                        <?php } else { ?>
                                            <td><span class="badge" style="padding:5px ;background-color:#dc3545">Inactive</span> </td>
                                        <?php } ?>
                                        <td>
                                            <a href="<?= admin_url('dynamic_form/manage/edit/') . $value['id'] ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
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
<?php init_tail(); ?>
<?php $this->load->view('admin/utilities/calendar_template'); ?>
<?php $this->load->view('admin/dashboard/dashboard_js'); ?>
</body>

</html>