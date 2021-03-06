<?php

/**
 * @package     Firedrive
 * @author      Giovanni Mansillo
 * @license     GNU General Public License version 2 or later; see LICENSE.md
 * @copyright   Firedrive
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 * @since   5.2.1
 */
class FiredriveViewDocumentform extends JViewLegacy
{

	protected $state;
	protected $item;
	protected $form;
	protected $params;

	/**
	 * Display the view
	 * @since   5.2.1
	 */
	public function display($tpl = null)
	{

		$this->state  = $this->get('State');
		$this->item   = $this->get('Data');
		$this->form   = $this->get('Form');
		$this->params = $this->state->get('params');

		$this->item->params = $this->params;

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 * @since   5.2.1
	 */
	protected function _prepareDocument()
	{

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}

}
