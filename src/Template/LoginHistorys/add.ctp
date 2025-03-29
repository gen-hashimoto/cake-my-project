<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoginHistory $loginHistory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Login Historys'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="loginHistorys form large-9 medium-8 columns content">
    <?= $this->Form->create($loginHistory) ?>
    <fieldset>
        <legend><?= __('Add Login History') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('login_time');
            echo $this->Form->control('logout_time');
            echo $this->Form->control('created_user');
            echo $this->Form->control('modified_user');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
