<?php require_once "app/views/layout/header.php"; ?>

<?php require_once "app/views/layout/sidebar.php"; ?>

<div class="content flex-grow-1">

    <div class="container-fluid mt-4">

        <?php
            if (isset($content)) {
                require_once $content;
            }
            ?>

    </div>


</div>

<?php require_once "app/views/layout/footer.php"; ?>