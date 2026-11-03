<?php
$groups = include CONFIG . 'sidebar_master.php';
$currentController = $this->request->getParam('controller');
?>
<li class="has-sub">
    <a href="javascript:;">
        <b class="caret"></b>
        <i class="fa fa-database"></i>
        <span>Master</span>
    </a>
    <ul class="sub-menu">
        <?php foreach ($groups as $groupName => $group):
            $controllers = array_column($group['items'], 'controller');
            $groupActive = in_array($currentController, $controllers, true);
        ?>
            <li class="has-sub <?= $groupActive ? 'active expand' : '' ?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <span><?= h($groupName) ?></span>
                </a>
                <ul class="sub-menu" <?= $groupActive ? 'style="display:block"' : '' ?>>
                    <?php foreach ($group['items'] as $item): ?>
                        <li class="<?= $currentController === $item['controller'] ? 'active' : '' ?>">
                            <?= $this->Html->link($item['label'], [
                                'prefix'     => $item['prefix'],
                                'controller' => $item['controller'],
                                'action'     => $item['action'],
                            ]) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
</li>