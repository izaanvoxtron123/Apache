<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body row">
                        <?php if (!empty($lead) && isset($lead->brief)) { ?>
                            <?php $lead->brief = json_decode($lead->brief) ?>
                            <?php foreach ($lead->brief as $heading => $value) { ?>

                                <div class="col-md-3">
                                    <?php echo str_replace('_', ' ', $heading)  ?> :
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    if (isset($value) && !empty($value) && $value != ' ') {
                                        echo $value;
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>