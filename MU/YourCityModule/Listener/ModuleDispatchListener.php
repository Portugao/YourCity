<?php
/**
 * YourCity.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link http://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */

namespace MU\YourCityModule\Listener;

use MU\YourCityModule\Listener\Base\AbstractModuleDispatchListener;
use Zikula\Core\Event\GenericEvent;

/**
 * Event handler implementation class for dispatching modules.
 */
class ModuleDispatchListener extends AbstractModuleDispatchListener
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents();
    }
    
    /**
     * @inheritDoc
     */
    public function serviceLinks(GenericEvent $event)
    {
        parent::serviceLinks($event);
    
        // Inject router and translator services and format data like this:
        // $event->data[] = [
        //     'url' => $router->generate('muyourcitymodule_user_index'),
        //     'text' => $translator->__('Link text')
        // ];
    
        // you can access general data available in the event
        
        // the event name
        // echo 'Event: ' . $event->getName();
        
        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }
        
        // kernel instance handling the current request
        // $kernel = $event->getKernel();
        
        // the currently handled request
        // $request = $event->getRequest();
    }
}
