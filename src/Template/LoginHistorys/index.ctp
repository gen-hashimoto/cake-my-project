<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoginHistory[]|\Cake\Collection\CollectionInterface $loginHistorys
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Login History'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="loginHistorys index large-9 medium-8 columns content">
    <h3><?= __('Login Historys') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('login_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('logout_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_user') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loginHistorys as $loginHistory): ?>
            <tr>
                <td><?= $this->Number->format($loginHistory->id) ?></td>
                <td><?= $loginHistory->has('user') ? $this->Html->link($loginHistory->user->name, ['controller' => 'Users', 'action' => 'view', $loginHistory->user->id]) : '' ?></td>
                <td><?= h($loginHistory->login_time) ?></td>
                <td><?= h($loginHistory->logout_time) ?></td>
                <td><?= h($loginHistory->created) ?></td>
                <td><?= h($loginHistory->modified) ?></td>
                <td><?= h($loginHistory->created_user) ?></td>
                <td><?= h($loginHistory->modified_user) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $loginHistory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loginHistory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loginHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loginHistory->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
