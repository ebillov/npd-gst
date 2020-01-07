<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

?>
<div class="wrap">

    <div id="tabs">

        <form method="post">

            <h2 class="nav-tab-wrapper">
                <?php
                $counter_id = 1;
                foreach($tabs as $key => $tab): ?>

                <a href="#tab-<?php echo $counter_id; ?>" class="nav-tab"><?php echo $key; ?></a>

                <?php $counter_id++; endforeach; ?>
            </h2>

            <?php
                $counter_content = 1;
                foreach($tabs as $tab): ?>

                <div id="tab-<?php echo $counter_content; ?>" class="tab-content">
                    <?php echo self::render_fields($tab); ?>
                </div>

            <?php $counter_content++; endforeach; ?>

        </form>
        
    </div>
    
</div>