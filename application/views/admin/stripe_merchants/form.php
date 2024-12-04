<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <?php echo form_open($this->uri->uri_string(), array('id' => 'article-form')); ?>
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="panel_s">
               <div class="panel-body">
                  <h4 class="no-margin">
                     <?php echo $title; ?>
                  </h4>
                  <hr class="hr-panel-heading" />
                  <div class="clearfix"></div>

                  <?php $value = (isset($result) ? $result->publishable_key : ''); ?>
                  <?php $attrs = (isset($result) ? array('required' => true) : array('autofocus' => true, 'required' => true)); ?>
                  <?php echo render_input('publishable_key', 'Publishable Key', $value, 'text', $attrs); ?>


                  <?php $value = (isset($result) ? $this->encryption->decrypt($result->secret_key) : ''); ?>
                  <?php echo render_input('secret_key', 'Secret Key', $value, 'text'); ?>


                  <!-- 
                  <div class="form-group">
                     <p>Is Active</p>

                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1" />
                        <label class="form-check-label" for="is_active_true">Active</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0" />
                        <label class="form-check-label" for="is_active_false">Not-Active</label>
                     </div>

                  </div> -->

                  <div class="form-group">

                     <?php if ($result) {
                        $trueChecked = $result->status == '1' ? "checked" : "";
                        $falseChecked = $result->status == '0' ? "checked" : "";
                     } else {
                        $trueChecked = "checked";
                        $falseChecked = "";
                     } ?>

                     <p>Status</p>

                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="true" value="1" <?= $trueChecked ?> />
                        <label class="form-check-label" for="true">Enabled</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="false" value="0" <?= $falseChecked ?> />
                        <label class=" form-check-label" for="false">Disabled</label>
                     </div>

                  </div>




               </div>
            </div>
         </div>
      </div>
      <?php if ((has_permission('stripe_merchants', '', 'add'))) { ?>
         <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
            <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
         </div>
      <?php } ?>
   </div>
   <?php echo form_close(); ?>
</div>
</div>
</body>

</html>