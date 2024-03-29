<?php
/**
 * YourCity.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\YourCityModule\Block\Base;

use Zikula\BlocksModule\AbstractBlockHandler;

/**
 * Moderation block base class.
 */
abstract class AbstractModerationBlock extends AbstractBlockHandler
{
    /**
     * Display the block content.
     *
     * @param array $properties The block properties array
     *
     * @return array|string
     */
    public function display(array $properties)
    {
        // only show block content if the user has the required permissions
        if (!$this->hasPermission('MUYourCityModule:ModerationBlock:', "$properties[title]::", ACCESS_OVERVIEW)) {
            return false;
        }
    
        $currentUserApi = $this->get('zikula_users_module.current_user');
        if (!$currentUserApi->isLoggedIn()) {
            return false;
        }
    
        $template = $this->getDisplayTemplate();
    
        $workflowHelper = $this->get('mu_yourcity_module.workflow_helper');
        $amounts = $workflowHelper->collectAmountOfModerationItems();
    
        // set a block title
        if (empty($properties['title'])) {
            $properties['title'] = $this->__('Moderation');
        }
    
        return $this->renderView($template, ['moderationObjects' => $amounts]);
    }
    
    /**
     * Returns the template used for output.
     *
     * @return string the template path
     */
    protected function getDisplayTemplate()
    {
        return '@MUYourCityModule/Block/moderation.html.twig';
    }
}
