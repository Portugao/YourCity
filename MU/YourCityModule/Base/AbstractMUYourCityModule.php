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

namespace MU\YourCityModule\Base {

    use Zikula\Core\AbstractModule;
    
    /**
     * Module base class.
     */
    abstract class AbstractMUYourCityModule extends AbstractModule
    {
    }
}

namespace {

    if (!class_exists('Content_AbstractContentType')) {
        if (file_exists('modules/Content/lib/Content/AbstractContentType.php')) {
            require_once 'modules/Content/lib/Content/AbstractType.php';
            require_once 'modules/Content/lib/Content/AbstractContentType.php';
        } else {
            class Content_AbstractContentType {}
        }
    }

    class MUYourCityModule_ContentType_ItemList extends \MU\YourCityModule\ContentType\ItemList {
    }
    class MUYourCityModule_ContentType_Item extends \MU\YourCityModule\ContentType\Item {
    }
}
