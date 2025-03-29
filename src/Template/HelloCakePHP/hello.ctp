<div style="width: 500px; margin: 20px;">
    <?= $this->Form->create() ?>
    <?= $this->Form->input("name", ['label' => '名前を入力してください。', 'placeholder' => '名前']) ?>
    <?= $this->Form->button("送信") ?>
    <?= $this->Form->end() ?>
</div>
<?php if (isset($display_name)) { ?>
    <div style="text-align: center;">
        <h1>Hello<?= h($display_name) ?></h1>
    </div>
<?php } ?>


