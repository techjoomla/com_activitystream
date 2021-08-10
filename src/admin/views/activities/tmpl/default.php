<?php
/**
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access to this file
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

JHtml::_('formbehavior.chosen', 'select');
$sortFields = $this->getSortFields();
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_activitystream&view=activities&client=' . $this->input->get('client', '', 'STRING')); ?>" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span12">
			<?php
				echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
			?>
		</div>
	</div>
	<?php
	if (empty($this->items))
	{
		?>
		<div class="clearfix">&nbsp;</div>

		<div class="alert alert-no-items">
			<?php echo Text::_('COM_ACTIVITYSTREAM_NO_ACTIVITY');?>
		</div>
		<?php
	}
	elseif (!empty($this->items) && empty($this->items['error']))
	{
		?>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
						title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<th width="5%">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_STATE'), 'state', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_TYPE'), 'type', $listDirn, $listOrder);?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_CREATED_DATE'), 'created_date', $listDirn, $listOrder);?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_UPDATED_DATE'), 'updated_date', $listDirn, $listOrder);?>
					</th>
					<th width="2%">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_ID'), 'id', $listDirn, $listOrder); ?>
					</th>
				</tr>
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
				<?php foreach ($this->items as $i => $row) :
					$link = JRoute::_('index.php?option=com_activitystream&task=activity.edit&id=' . $row->id);
				?>
					<tr>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->state, $i, 'activities.', true, 'cb'); ?>
						</td>
						<td>
							<?php echo $row->type; ?>
						</td>
						<td align="center">
							<?php echo $row->created_date; ?>
						</td>
						<td align="center">
							<?php echo $row->updated_date; ?>
						</td>
						<td align="center">
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('type'); ?>">
								<?php echo $row->id; ?>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php
	}
	?>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

