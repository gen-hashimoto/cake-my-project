<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Login Historys'), ['controller' => 'LoginHistorys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Login History'), ['controller' => 'LoginHistorys', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Account') ?></th>
            <td><?= h($user->account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created User') ?></th>
            <td><?= h($user->created_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified User') ?></th>
            <td><?= h($user->modified_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Login Historys') ?></h4>
        <?php if (!empty($user->login_historys)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Login Time') ?></th>
                <th scope="col"><?= __('Logout Time') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Created User') ?></th>
                <th scope="col"><?= __('Modified User') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->login_historys as $loginHistorys): ?>
            <tr>
                <td><?= h($loginHistorys->id) ?></td>
                <td><?= h($loginHistorys->user_id) ?></td>
                <td><?= h($loginHistorys->login_time) ?></td>
                <td><?= h($loginHistorys->logout_time) ?></td>
                <td><?= h($loginHistorys->created) ?></td>
                <td><?= h($loginHistorys->modified) ?></td>
                <td><?= h($loginHistorys->created_user) ?></td>
                <td><?= h($loginHistorys->modified_user) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'LoginHistorys', 'action' => 'view', $loginHistorys->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'LoginHistorys', 'action' => 'edit', $loginHistorys->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoginHistorys', 'action' => 'delete', $loginHistorys->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistorys->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
