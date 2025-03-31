<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Login Historys'), ['controller' => 'LoginHistorys', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Login History'), ['controller' => 'LoginHistorys', 'action' => 'add']) ?></li>
    </ul>
</nav>
<fieldset>
    <?= $this->Form->create('', ['name' => 'upload_form', 'type' => 'file']) ?>
    <div>
        <?= $this->Form->label(__('Please select an upload file.')) ?>
    </div>
    <div>
        <?= $this->Form->file('upload_file', ['id' => 'upload_file']) ?>
        <?= $this->Form->button(__("upload"), ['onClick' => 'upload()', 'type' => 'button']) ?>
    </div>
    <?= $this->Form->end() ?>
    <?php if (isset($errors)) { ?>
        <div>
            <?php foreach ($errors as $error) { ?>
                <div><?= empty($error['LINE_NO']) ? $error['DESCRIPTION'] : 'L' . $error['LINE_NO'] . ':' . $error['DESCRIPTION'] ?></div>
            <?php } ?>
        </div>
    <?php } ?>
</fieldset>
<script type="text/javascript">
    function upload() {
        if (document.getElementById("upload_file").files.length == 0) {
            alert("<?= __('upload File Not selected.') ?>")
        } else {
            if (!confirm("<?= __('Are you sure you want to upload file?') ?>")) {
                return false;
            }
            document.upload_form.submit();
        }
    }
</script>