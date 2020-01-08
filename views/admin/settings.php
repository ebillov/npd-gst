<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

?>
<style>
    #tabs a.nav-tab:focus {
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
    }
    #tabs .form_group {
        margin-bottom: 20px;
    }
    #tabs .form_group:last-child {
        margin-bottom: 0;
    }
    #tabs label {
        font-weight: bold;
    }
    #tabs label.field {
        margin-bottom: 10px;
        display: block;
    }
    span.checkbox_desc {
        margin-top: 10px;
        display: block;
    }
</style>
<div class="wrap">

    <div id="tabs">

        <h2 class="nav-tab-wrapper">
            <?php
            $counter_id = 1;
            foreach($tabs as $key => $tab): ?>

            <a href="#tab-<?php echo $counter_id; ?>" class="nav-tab"><?php echo $key; ?></a>

            <?php $counter_id++; endforeach; ?>
        </h2>

        <?php
            $counter_content = 1;
            foreach($tabs as $key => $tab): ?>
            <div id="tab-<?php echo $counter_content; ?>" class="tab-content">
                <h2><?php echo $key; ?></h2>
                <form method="post">
                    <?php echo $this->render_fields($tab); ?>
                </form>
            </div>

        <?php $counter_content++; endforeach; ?>
        
    </div>
    
</div>
<script>
    jQuery('#tabs .tab-content').hide();
    jQuery('#tabs .tab-content:first').show();
    jQuery('.nav-tab-wrapper a:first').addClass('nav-tab-active');

    jQuery('.nav-tab-wrapper').on('click', '.nav-tab', function(e) {
        e.preventDefault();
        jQuery('.nav-tab').removeClass('nav-tab-active');
        jQuery('#npd_gst_notice_success').remove();
        jQuery('.tab-content').hide();
        jQuery(this).addClass('nav-tab-active');
        jQuery(jQuery(this).attr('href')).show();
    });
</script>