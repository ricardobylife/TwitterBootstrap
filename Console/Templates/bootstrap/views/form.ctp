<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="row-fluid">
	<div class="span9">
		<?php echo "<?php echo \$this->BootstrapForm->create('{$modelClass}');?>\n";?>
			<fieldset>
				<legend><?php echo "<?php echo __('" . Inflector::humanize($action) . " %s', __('" . $singularHumanName . "')); ?>"; ?></legend>
<?php
				echo "\t\t\t\t<?php\n";
				$id = null;
				foreach ($fields as $field) {
					if (strpos($action, 'add') !== false && $field == $primaryKey) {
						continue;
					} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
						if ($field == $primaryKey) {
							$id = "\t\t\t\techo \$this->BootstrapForm->hidden('{$field}');\n";
						} else {
							echo "\t\t\t\techo \$this->BootstrapForm->input('{$field}');\n";
						}
					}
				}
				echo $id;
				unset($id);
				if (!empty($associations['hasAndBelongsToMany'])) {
					foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
						echo "\t\t\t\techo \$this->BootstrapForm->input('{$assocName}');\n";
					}
				}
				echo "\t\t\t\t?>\n";
				echo "\t\t\t\t<?php echo \$this->BootstrapForm->submit(__('Submit'));?>\n";
?>
			</fieldset>
		<?php
			echo "<?php echo \$this->BootstrapForm->end();?>\n";
		?>
	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo "<?php echo __('Actions'); ?>"; ?></li>
<?php if (strpos($action, 'add') === false): ?>
			<li><?php echo "<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), null, __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>";?></li>
<?php endif;?>
			<li><?php echo "<?php echo \$this->Html->link(__('List %s', __('" . $pluralHumanName . "')), array('action' => 'index'));?>";?></li>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t<li><?php echo \$this->Html->link(__('List %s', __('" . Inflector::humanize($details['controller']) . "')), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
				echo "\t\t<li><?php echo \$this->Html->link(__('New %s', __('" . Inflector::humanize(Inflector::underscore($alias)) . "')), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
		</ul>
	</div>
</div>