<?php if($items->count() > 0):?>
	<?php foreach($items as $column) :?>
	<tr>
		<td><?php echo $column->id;?></td>
		<td><?php echo $column->name;?></td>
		<td>Otto</td>
		<td>@mdo</td>
		<td><span class="label">Not activated</span> <span class="label label-important">No card</span></td>
		<td>
			<a class="btn btn-small btn-info disabled" rel="tooltip" title="<?=_('Show');?>"><i class="icon-zoom-in icon-white"></i></a>
			<a class="btn btn-small btn-primary disabled" rel="tooltip" title="<?=_('Edit');?>"><i class="icon-pencil icon-white"></i></a>
			<a class="btn btn-small btn-primary btn-danger disabled" rel="tooltip" title="<?=_('Remove');?>"><i class="icon-remove icon-white top1"></i></a>
		</td>
	</tr>
	<?php endforeach;?>
<?php else: ?>
	<?php echo View::factory('helpers/norecords')->set('message', _('No users found'));?>
<?php endif;?>