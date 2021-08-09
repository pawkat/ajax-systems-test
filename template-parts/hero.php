<?php

use AjaxSystems\DeferCSS;
use AjaxSystems\DeferJS;

?>

<div class="hero">
    <?php
    DeferCSS::enqueue('hero');
    DeferJS::enqueue('order-form');
    ?>


</div>
