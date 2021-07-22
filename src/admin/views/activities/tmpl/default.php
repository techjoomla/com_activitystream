<?php
/**
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access to this file
defined('_JEXEC') or die;

JHtml::_('formbehavior.chosen', 'select');
$sortFields = $this->getSortFields();
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));

$document = JFactory::getDocument();
$document->addScript(JUri::root() . 'media/com_activitystream/scripts/mustache.min.js');
$document->addScript(JUri::root() . 'media/com_activitystream/scripts/activities.jQuery.js');

$languageTag = JFactory::getLanguage()->get('tag', 'en-GB');

// Load theme related CSS
if (!empty($this->items))
{
	foreach ($this->items as $item)
	{
		$document->addStyleSheet(JUri::root() . 'media/com_jgive/themes/' . $item->default_theme . '/css/theme.css');
	}
}
?>
<form action="<?php echo JRoute::_('index.php?option=com_activitystream&view=activities&client=' . $this->input->get('client', '', 'STRING')); ?>" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span12">
			<?php
				echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
			?>
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
				<th width="5%">
					<?php echo JHtml::_('searchtools.sort', JText::_('COM_ACTIVITYSTREAM_ACTIVITY_STATE'), 'state', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_ACTIVITYSTREAM_ACTIVITY'); ?>
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
					?>
					<tr>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->state, $i, 'activities.', true, 'cb'); ?>
						</td>
						<td align="center">
							<div tj-activitystream-single-activity-widget tj-activitystream-theme="<?php echo $row->default_theme;?>" tj-activitystream-bs="bs3" tj-activitystream-language="<?php echo $languageTag;?>" tj-activitystream-single-activity-data='<?php echo json_encode($row);?>'>
							</div>
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
	<?php echo JHtml::_('form.token'); ?>
</form>

