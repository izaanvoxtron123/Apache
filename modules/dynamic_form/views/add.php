<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="content">

        <div class="panel_s">

            <div class="panel-body">
                <div class="row" style="margin :0;">
                    <!-- HEADER -->
                    <div class="col-12">
                        <h3>Add Brief Form</h3>
                    </div>

                    <hr>

                    <!-- FORM FIELDS -->
                    <div class="col-12">

                        <?php echo form_open(''); ?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="">
                            <b class="text-danger b"><?php echo form_error('name'); ?> </b>
                        </div>


                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            <b class="text-danger b"><?php echo form_error('description'); ?> </b>
                        </div>

                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" checked>Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0">Inactive
                        </label>
                        <br>
                        <br>
                        <button class="btn btn-success"> Submit </button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>