<div class="alert alert-<?= isset($status) ? $status : 'info' ?> alert-dismissable">
    <button class="close" data-dismiss="alert">
        <span>×</span>
    </button>
    
    <?php if (isset($title)) { ?>
    <div class="alert-title">Danger</div>
    <?php } ?>


    <?= isset($message) ? $message : null ?>
</div>
