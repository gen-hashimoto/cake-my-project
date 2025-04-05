<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoginHistory $loginHistory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Login History'), ['action' => 'edit', $loginHistory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Login History'), ['action' => 'delete', $loginHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Login Historys'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Login History'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="loginHistorys view large-9 medium-8 columns content">
    <h3><?= h($loginHistory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $loginHistory->has('user') ? $this->Html->link($loginHistory->user->name, ['controller' => 'Users', 'action' => 'view', $loginHistory->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created User') ?></th>
            <td><?= h($loginHistory->created_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified User') ?></th>
            <td><?= h($loginHistory->modified_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($loginHistory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Login Time') ?></th>
            <td><?= h($loginHistory->login_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Logout Time') ?></th>
            <td><?= h($loginHistory->logout_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($loginHistory->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($loginHistory->modified) ?></td>
        </tr>
    </table>
</div>
