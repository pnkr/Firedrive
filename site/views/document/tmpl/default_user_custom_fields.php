<?php
/**
 * @package     Simple File Manager
 * @author      Giovanni Mansillo
 * @license     GNU General Public License version 2 or later; see LICENSE.md
 */
defined('_JEXEC') or die;

$params             = $this->item->params;
$presentation_style = $params->get('presentation_style');

$displayGroups   = $params->get('show_user_custom_fields');
$userFieldGroups = array();
?>

<?php if (!$displayGroups || !$this->docUser) : ?>
    <?php return; ?>
<?php endif; ?>

<?php foreach ($this->docUser->jcfields as $field) : ?>
    <?php if (!in_array('-1', $displayGroups) && (!$field->group_id || !in_array($field->group_id, $displayGroups))) : ?>
        <?php continue; ?>
    <?php endif; ?>
    <?php if (!key_exists($field->group_title, $userFieldGroups)) : ?>
        <?php $userFieldGroups[$field->group_title] = array(); ?>
    <?php endif; ?>
    <?php $userFieldGroups[$field->group_title][] = $field; ?>
<?php endforeach; ?>

<?php foreach ($userFieldGroups as $groupTitle => $fields) : ?>
    <?php $id = JApplicationHelper::stringURLSafe($groupTitle); ?>
    <?php if ($presentation_style == 'sliders') : ?>
        <?php echo JHtml::_('bootstrap.addSlide', 'slide-document', $groupTitle ?: JText::_('COM_SIMPLEFILEMANAGER_USER_FIELDS'), 'display-' . $id); ?>
    <?php elseif ($presentation_style == 'tabs') : ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'display-profile', $groupTitle ?: JText::_('COM_SIMPLEFILEMANAGER_USER_FIELDS')); ?>
    <?php elseif ($presentation_style == 'plain') : ?>
        <?php echo '<h3>' . ($groupTitle ?: JText::_('COM_SIMPLEFILEMANAGER_USER_FIELDS')) . '</h3>'; ?>
    <?php endif; ?>

    <div class="document-profile" id="user-custom-fields-<?php echo $id; ?>">
        <dl class="dl-horizontal">
            <?php foreach ($fields as $field) : ?>
                <?php if (!$field->value) : ?>
                    <?php continue; ?>
                <?php endif; ?>

                <?php if ($field->params->get('showlabel')) : ?>
                    <?php echo '<dt>' . JText::_($field->label) . '</dt>'; ?>
                <?php endif; ?>

                <?php echo '<dd>' . $field->value . '</dd>'; ?>
            <?php endforeach; ?>
        </dl>
    </div>

    <?php if ($presentation_style == 'sliders') : ?>
        <?php echo JHtml::_('bootstrap.endSlide'); ?>
    <?php elseif ($presentation_style == 'tabs') : ?>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
    <?php endif; ?>
<?php endforeach; ?>