<?php
/**
 * @package     RedRad
 * @subpackage  Layouts
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_REDRAD') or die;

RHelperAsset::stylesheet('media/redrad/css/component.css');

JFactory::getApplication()->input->set('redrad', true);

$data = $displayData;

// Do we have to display the sidebar ?
$displaySidebar = false;

if (isset($data['sidebar_display']))
{
	$displaySidebar = (bool) $data['sidebar_display'];
}

$sidebarLayout = '';

// The sidebar layout name.
if ($displaySidebar)
{
	if (!isset($data['sidebar_layout']))
	{
		throw new InvalidArgumentException('No sidebar layout specified in the component layout.');
	}

	$sidebarLayout = $data['sidebar_layout'];
}

$sidebarData = array();

if (isset($data['sidebar_data']))
{
	$sidebarData = $data['sidebar_data'];
}

// Do we have to display the topbar ?
$displayTopbar = false;

if (isset($data['topbar_display']))
{
	$displayTopbar = (bool) $data['topbar_display'];
}

$topbarLayout = '';

// The topbar layout name.
if ($displayTopbar)
{
	if (!isset($data['topbar_layout']))
	{
		throw new InvalidArgumentException('No topbar layout specified in the component layout.');
	}

	$topbarLayout = $data['topbar_layout'];
}

$topbarData = array();

if (isset($data['topbar_data']))
{
	$topbarData = $data['topbar_data'];
}

// The view to render.
if (!isset($data['view']))
{
	throw new InvalidArgumentException('No view specified in the component layout.');
}

/** @var RView $view */
$view = $data['view'];

if (!$view instanceof RView)
{
	throw new InvalidArgumentException(
		sprintf(
			'Invalid view %s specified for the component layout',
			get_class($view)
		)
	);
}

$toolbar = $view->getToolbar();

// Get the view template.
$tpl = $data['tpl'];

// Get the view render.
$result = $view->loadTemplate($tpl);

if ($result instanceof Exception)
{
	return $result;
}
?>

<?php if ($view->getLayout() === 'modal') : ?>
	<div class="container-fluid redrad">
		<div class="span12 content">
			<section id="component">
				<div class="row-fluid">
					<?php echo $result ?>
				</div>
			</section>
		</div>
	</div>
<?php else : ?>
<div class="container-fluid redrad">
	<?php if ($displayTopbar) : ?>
		<?php echo RLayoutHelper::render($topbarLayout, $topbarData) ?>
	<?php endif; ?>
	<div class="row-fluid">
		<?php if ($displaySidebar) : ?>
		<div class="span2 sidebar">
			<?php echo RLayoutHelper::render($sidebarLayout, $sidebarData) ?>
		</div>
		<div class="span10 content">
			<?php else : ?>
			<div class="span12 content">
				<?php endif; ?>
				<section id="component">
					<div class="row-fluid">
						<h1><?php echo $view->getTitle() ?></h1>
					</div>
					<div class="row-fuid">
						<hr />
						<?php echo $toolbar->render() ?>
						<hr />
					</div>
					<div class="row-fluid">
						<?php echo $result ?>
					</div>
				</section>
			</div>
		</div>
	</div>
<footer class="footer pagination-centered">
	Copyright 2013 redcomponent.com. All rights reserved.
</footer>
<?php endif; ?>