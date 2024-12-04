<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body row">
                        <?php if (count($briefs)) : ?>
                            <?php foreach ($briefs as $key => $brief) : ?>
                            
                            <?php if(empty( $brief['value'])) {continue;} ?>
                                <dl>
                                    <dt><?= str_replace("_"," ",$brief['label']) ?></dt>
                                    <?php if (!$brief['is_media']) : ?>
                                        <dd>
                                            <h4><?= $brief['value'] ?></h4>
                                        </dd>
                                    <?php elseif (!$brief['is_multiple']) : ?>
                                        <br>
                                        <?php switch ($brief['media_type']):
                                            case 'image': ?>
                                                <img src="<?= site_url('uploads/' . $brief['value']) ?>" style="width: 200px; height: 200px;">
                                                <?php break; ?>
                                            <?php
                                            case 'audio': ?>
                                                <audio controls>
                                                    <source src="<?= site_url('uploads/' . $brief['value']) ?>" type="audio/ogg">
                                                </audio>
                                                <?php break; ?>
                                            <?php
                                            case 'video': ?>
                                                <video width="320" height="240" controls>
                                                    <source src="<?= site_url('uploads/' . $brief['value']) ?>" type="video/mp4">
                                                </video>
                                                <?php break; ?>
                                            <?php
                                            default: ?>
                                                <a href="<?= site_url('uploads/' . $brief['value']) ?>" target="_blank" class="btn btn-info">View Media</a>
                                                <?php break; ?>
                                        <?php endswitch; ?>

                                    <?php else : ?>
                                        <br>
                                        <?php switch ($brief['media_type']):
                                            case 'image': ?>
                                                <?php foreach (json_decode($brief['value']) as $key => $src) : ?>
                                                    <img src="<?= site_url('uploads/' . $src) ?>" style="width: 200px; height: 200px;">
                                                <?php endforeach; ?>
                                                <?php break; ?>
                                            <?php
                                            case 'audio': ?>
                                                <?php foreach (json_decode($brief['value']) as $key => $src) : ?>
                                                    <audio controls>
                                                        <source src="<?= site_url('uploads/' . $src) ?>" type="audio/mp3">
                                                    </audio>
                                                <?php endforeach; ?>
                                                <?php break; ?>
                                            <?php
                                            case 'video': ?>
                                                <?php foreach (json_decode($brief['value']) as $key => $src) : ?>
                                                    <video width="320" height="240" controls>
                                                        <source src="<?= site_url('uploads/' . $src) ?>" type="video/mp4">
                                                    </video>
                                                <?php endforeach; ?>
                                                <?php break; ?>

                                            <?php
                                            default: ?>

                                                <?php foreach (json_decode($brief['value']) as $key => $src) : ?>
                                                    <a href="<?= site_url('uploads/' . $src) ?>" target="_blank" class="btn btn-info">View Media</a>
                                                <?php endforeach; ?>
                                                <?php break; ?>
                                        <?php endswitch; ?>

                                    <?php endif; ?>
                                </dl>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>