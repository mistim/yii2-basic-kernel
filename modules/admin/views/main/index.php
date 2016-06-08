<?php

use mistim\theme\adminlte\widgets\Box;

?>

<div class="row">
    <div class="col-sm-12">
        <?php Box::begin(
            [
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'grid' => 'order-chart'
            ]
        ); ?>
        <div class="jumbotron text-center">
            <h1>Congratulations!</h1>

            <p class="lead">You have successfully entered to Admin Panel.</p>

        </div>
        <?php Box::end(); ?>
    </div>
</div>

