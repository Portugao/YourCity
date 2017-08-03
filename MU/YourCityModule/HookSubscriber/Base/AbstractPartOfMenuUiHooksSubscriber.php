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

namespace MU\YourCityModule\HookSubscriber\Base;

use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Bundle\HookBundle\HookSubscriberInterface;
use Zikula\Common\Translator\TranslatorInterface;

/**
 * Base class for ui hooks subscriber.
 */
abstract class AbstractPartOfMenuUiHooksSubscriber implements HookSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * PartOfMenuUiHooksSubscriber constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @inheritDoc
     */
    public function getOwner()
    {
        return 'MUYourCityModule';
    }
    
    /**
     * @inheritDoc
     */
    public function getCategory()
    {
        return UiHooksCategory::NAME;
    }
    
    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->translator->__('Part of menu ui hooks subscriber');
    }

    /**
     * @inheritDoc
     */
    public function getEvents()
    {
        return [
            // Display hook for view/display templates.
            UiHooksCategory::TYPE_DISPLAY_VIEW => 'muyourcitymodule.ui_hooks.partsofmenu.display_view',
            // Display hook for create/edit forms.
            UiHooksCategory::TYPE_FORM_EDIT => 'muyourcitymodule.ui_hooks.partsofmenu.form_edit',
            // Validate input from an item to be edited.
            UiHooksCategory::TYPE_VALIDATE_EDIT => 'muyourcitymodule.ui_hooks.partsofmenu.validate_edit',
            // Perform the final update actions for an edited item.
            UiHooksCategory::TYPE_PROCESS_EDIT => 'muyourcitymodule.ui_hooks.partsofmenu.process_edit',
            // Display hook for delete forms.
            UiHooksCategory::TYPE_FORM_DELETE => 'muyourcitymodule.ui_hooks.partsofmenu.form_delete',
            // Validate input from an item to be deleted.
            UiHooksCategory::TYPE_VALIDATE_DELETE => 'muyourcitymodule.ui_hooks.partsofmenu.validate_delete',
            // Perform the final delete actions for a deleted item.
            UiHooksCategory::TYPE_PROCESS_DELETE => 'muyourcitymodule.ui_hooks.partsofmenu.process_delete'
        ];
    }
}
