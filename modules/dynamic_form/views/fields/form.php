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
                        <h3><?= $id ? "Edit" : "Add" ?> Form Field</h3>
                    </div>

                    <hr>

                    <!-- FORM FIELDS -->
                    <div class="col-12">
                        <?php echo form_open(''); ?>

                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" class="form-control" id="label" name="label" value="<?= $data->label ?? "" ?>" placeholder="">
                            <b class="text-danger b"><?php echo form_error('label'); ?> </b>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $data->description ?? "" ?></textarea>
                            <b class="text-danger b"><?php echo form_error('description'); ?> </b>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="field_type">Field Type</label>
                            <select id="field_type" name="field_type" class="form-control form-select">
                                <option value="input" <?php  if(isset($data->field_type) && $data->field_type == "input") {echo "selected";}  ?> >Input</option>
                                <option value="textarea" <?php  if(isset($data->field_type) && $data->field_type == "textarea") {echo "selected";}  ?> >Textarea</option>
                                <option value="dropdown" <?php  if(isset($data->field_type) && $data->field_type == "dropdown") {echo "selected";}  ?> >Dropdown</option>
                                <option value="radio" <?php  if(isset($data->field_type) && $data->field_type == "radio") {echo "selected";}  ?> >Radio Button</option>
                                <option value="checkbox" <?php  if(isset($data->field_type) && $data->field_type == "checkbox") {echo "selected";}  ?> >Checkbox</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="input_type">Element Type</label>
                            <input type="text" class="form-control" id="input_type" name="input_type" value="<?= $data->input_type ?? "" ?>" placeholder="">
                            <b class="text-danger b"><?php echo form_error('input_type'); ?> </b>
                        </div>


                        <div class="form-group">
                            <label for="options">Options</label>
                            <textarea class="form-control" id="options" name="options" rows="3"><?= $data->options ?? "" ?></textarea>
                            <b class="text-danger b"><?php echo form_error('options'); ?> </b>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $data->name ?? "" ?>" placeholder="">
                            <b class="text-danger b"><?php echo form_error('name'); ?> </b>
                        </div>

                        <div class="form-group">
                            <label for="html_params">Html Params</label>
                            <textarea class="form-control" id="html_params" name="html_params" rows="3"><?= $data->html_params ?? "" ?></textarea>
                            <b class="text-danger b"><?php echo form_error('html_params'); ?> </b>
                        </div>


                        <div class="form-group">
                            <label for="classes">Classes</label>
                            <textarea class="form-control" id="classes" name="classes" rows="3"><?= $data->classes ?? "" ?></textarea>
                            <b class="text-danger b"><?php echo form_error('classes'); ?> </b>
                        </div>

                        <div class="form-group">
                            <label for="id_tag">Element ID</label>
                            <input type="text" class="form-control" id="id_tag" name="id_tag" value="<?= $data->id_tag ?? "" ?>" placeholder="">
                            <b class="text-danger b"><?php echo form_error('id_tag'); ?> </b>
                        </div>


                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?= isset($data) ? $data->status ? "checked" : "" : "checked" ?>>Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" <?= isset($data) ? !$data->status ? "checked" : "" : "" ?>>Inactive
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