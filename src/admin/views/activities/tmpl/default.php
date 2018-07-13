<?php
/**
 * @version    SVN: <svn_id>
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access to this file
defined('_JEXEC') or die;

JHtml::_('formbehavior.chosen', 'select');
$sortFields = $this->getSortFields();
$listOrder     = $this->escape($this->state->get('list.ordering'));
$listDirn      = $this->escape($this->state->get('list.direction'));
?>
<script type="text/javascript">

</script>

<?php

if (!empty($this->extra_sidebar))
{
	$this->sidebar .= $this->extra_sidebar;
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_activitystream&view=activities&client=' .
$this->input->get('client', '', 'STRING'));
?>"
		method="post" id="adminForm" name="adminForm">
<?php
if (!empty($this->sidebar))
{
	?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php
}
else
{?>
	<div id="j-main-container">
<?php
}?>




	<div id="filter-bar" class="btn-toolbar">
		<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	<div class="row-fluid">
		<div class="span6">
			<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>

		</div>
	</div>


	</div>
	<table class="table table-striped table-hover">
		<thead>
		<?php if (!empty($this->items) && empty($this->items['error'])) : ?>
			<tr>
				<th width="1%" class="hidden-phone">
					<input type="checkbox" name="checkall-toggle" value=""
					title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
				</th>
				<th width="2%">
					<?php echo JHtml::_('grid.sort', JText::_("COM_ACTIVITYSTREAM_ACTIVITY_ID"), 'id', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', JText::_("COM_ACTIVITYSTREAM_ACTIVITY_STATE"), 'state', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', JText::_("name"), 'name', $listDirn, $listOrder); ?>
				</th>
								<th width="5%">
					<?php echo JHtml::_('grid.sort', JText::_("COM_ACTIVITYSTREAM_ACTIVITY_TYPE"), 'type', $listDirn, $listOrder);?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_CREATED_DATE'), 'created_date', $listDirn, $listOrder);?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_UPDATED_DATE'), 'updated_date', $listDirn, $listOrder);?>
				</th>

			</tr>
		<?php endif;?>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</th>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items) && empty($this->items['error'])) : ?>
				<?php foreach ($this->items as $i => $row) :

					$link = JRoute::_('index.php?option=com_activitystream&task=activity.edit&id=' . $row->id);
				$obj = json_encode($row);

				?>

					<tr>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td align="center">
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('type'); ?>">
								<?php echo $row->id; ?>
							</a>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->state, $i, 'activities.', true, 'cb'); ?>
						</td>
						<td align="center">
							<?php print_r( $row->target['name']); ?>
						</td>
						<td align="center">
							<?php echo ucfirst(trim(strstr($row->type, '.'), '.')); ?>
						</td>
						<td align="center">
							<?php echo $row->created_date; ?>
						</td>
						<td align="center">
							<?php echo $row->updated_date; ?>
						</td>

					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<div>&nbsp;</div>
				<div class="alert alert-error">
					<div>
						<?php
						if (!empty($this->items['message']))
						{
							echo $this->items['message'];
						}
						?>
					</div>
				</div>
			<?php endif;?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

