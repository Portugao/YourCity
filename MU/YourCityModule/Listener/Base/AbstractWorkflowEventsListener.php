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

namespace MU\YourCityModule\Listener\Base;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;
use Zikula\Core\Doctrine\EntityAccess;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use MU\YourCityModule\Helper\NotificationHelper;

/**
 * Event handler implementation class for workflow events.
 *
 * @see /src/docs/Core-2.0/Workflows/WorkflowEvents.md
 */
abstract class AbstractWorkflowEventsListener implements EventSubscriberInterface
{
    /**
     * @var PermissionApiInterface
     */
    protected $permissionApi;
    
    /**
     * @var NotificationHelper
     */
    protected $notificationHelper;
    
    /**
     * WorkflowEventsListener constructor.
     *
     * @param PermissionApiInterface $permissionApi      PermissionApi service instance
     * @param NotificationHelper     $notificationHelper NotificationHelper service instance
     */
    public function __construct(PermissionApiInterface $permissionApi, NotificationHelper $notificationHelper)
    {
        $this->permissionApi = $permissionApi;
        $this->notificationHelper = $notificationHelper;
    }
    
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return [
            'workflow.guard' => ['onGuard', 5],
            'workflow.leave' => ['onLeave', 5],
            'workflow.transition' => ['onTransition', 5],
            'workflow.enter' => ['onEnter', 5]
        ];
    }
    
    /**
     * Listener for the `workflow.guard` event.
     *
     * Occurs just before a transition is started and when testing which transitions are available.
     * Allows to define that the transition is not allowed by calling `$event->setBlocked(true);`.
     *
     * This event is also triggered for each workflow individually, so you can react only to the events
     * of a specific workflow by listening to `workflow.<workflow_name>.guard` instead.
     * You can even listen to some specific transitions or states for a specific workflow
     * using `workflow.<workflow_name>.guard.<transition_name>`.
     *
     * @param GuardEvent $event The event instance
     */
    public function onGuard(GuardEvent $event)
    {
        $entity = $event->getSubject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
    
        $objectType = $entity->get_objectType();
        $permissionLevel = ACCESS_READ;
        $transitionName = $event->getTransition()->getName();
        if (substr($transitionName, 0, 6) == 'update') {
            $transitionName = 'update';
        }
        $targetState = $event->getTransition()->getTos()[0];
        $hasApproval = in_array($objectType, ['location']);
    
        switch ($transitionName) {
            case 'defer':
            case 'submit':
                $permissionLevel = $hasApproval ? ACCESS_COMMENT : ACCESS_EDIT;
                break;
            case 'update':
            case 'reject':
            case 'accept':
            case 'publish':
            case 'unpublish':
            case 'archive':
            case 'trash':
            case 'recover':
                $permissionLevel = ACCESS_EDIT;
                break;
            case 'approve':
            case 'demote':
                $permissionLevel = ACCESS_ADD;
                break;
            case 'delete':
                $permissionLevel = ACCESS_DELETE;
                break;
        }
    
        if (!$this->permissionApi->hasPermission('MUYourCityModule:' . ucfirst($objectType) . ':', $entity->getKey() . '::', $permissionLevel)) {
            // no permission for this transition, so disallow it
            $event->setBlocked(true);
    
            return;
        }
    
        if ($transitionName == 'delete') {
            // check if deleting the entity would break related child entities
            if ($objectType == 'location') {
                $isBlocked = false;
                if (count($entity->getImagesOfLocation()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getFilesOfLocation()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getBranches()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getParts()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getOffers()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getMenuOfLocation()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getEvents()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getProducts()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getDishes()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getSpecialsOfLocation()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getServicesOfLocation()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getAbonnements()) > 0) {
                    $isBlocked = true;
                }
                $event->setBlocked($isBlocked);
            }
            if ($objectType == 'menuOfLocation') {
                $isBlocked = false;
                if (count($entity->getDishes()) > 0) {
                    $isBlocked = true;
                }
                if (count($entity->getPartsOfMenu()) > 0) {
                    $isBlocked = true;
                }
                $event->setBlocked($isBlocked);
            }
            if ($objectType == 'partOfMenu') {
                $isBlocked = false;
                if (count($entity->getDishes()) > 0) {
                    $isBlocked = true;
                }
                $event->setBlocked($isBlocked);
            }
        }
    }
    
    /**
     * Listener for the `workflow.leave` event.
     *
     * Occurs just after an object has left it's current state.
     * Carries the marking with the initial places.
     *
     * This event is also triggered for each workflow individually, so you can react only to the events
     * of a specific workflow by listening to `workflow.<workflow_name>.leave` instead.
     * You can even listen to some specific transitions or states for a specific workflow
     * using `workflow.<workflow_name>.leave.<state_name>`.
     *
     * @param Event $event The event instance
     */
    public function onLeave(Event $event)
    {
        $entity = $event->getSubject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
    }
    
    /**
     * Listener for the `workflow.transition` event.
     *
     * Occurs just before starting to transition to the new state.
     * Carries the marking with the current places.
     *
     * This event is also triggered for each workflow individually, so you can react only to the events
     * of a specific workflow by listening to `workflow.<workflow_name>.transition` instead.
     * You can even listen to some specific transitions or states for a specific workflow
     * using `workflow.<workflow_name>.transition.<transition_name>`.
     *
     * @param Event $event The event instance
     */
    public function onTransition(Event $event)
    {
        $entity = $event->getSubject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
    }
    
    /**
     * Listener for the `workflow.enter` event.
     *
     * Occurs just after the object has entered into the new state.
     * Carries the marking with the new places.
     *
     * This event is also triggered for each workflow individually, so you can react only to the events
     * of a specific workflow by listening to `workflow.<workflow_name>.enter` instead.
     * You can even listen to some specific transitions or states for a specific workflow
     * using `workflow.<workflow_name>.enter.<state_name>`.
     *
     * @param Event $event The event instance
     */
    public function onEnter(Event $event)
    {
        $entity = $event->getSubject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
    
        $workflowShortName = 'none';
        if (in_array($entity->get_objectType(), ['location'])) {
            $workflowShortName = 'standard';
        } elseif (in_array($entity->get_objectType(), [''])) {
            $workflowShortName = 'enterprise';
        }
        if ($workflowShortName != 'none') {
            $this->sendNotifications($entity, $event->getTransition()->getName(), $workflowShortName);
        }
    }
    
    /**
     * Checks whether this listener is responsible for the given entity or not.
     *
     * @param EntityAccess $entity The given entity
     *
     * @return boolean True if entity is managed by this listener, false otherwise
     */
    protected function isEntityManagedByThisBundle($entity)
    {
        if (!($entity instanceof EntityAccess)) {
            return false;
        }
    
        $entityClassParts = explode('\\', get_class($entity));
    
        return ($entityClassParts[0] == 'MU' && $entityClassParts[1] == 'YourCityModule');
    }
    
    /**
     * Sends email notifications.
     *
     * @param object $entity            Processed entity
     * @param string $actionId          Name of performed transition
     * @param string $workflowShortName Name of workflow (none, standard, enterprise)
     */
    protected function sendNotifications($entity, $actionId, $workflowShortName)
    {
        $newState = $entity->getWorkflowState();
    
        // by default send only to creator
        $sendToCreator = true;
        $sendToModerator = false;
        $sendToSuperModerator = false;
        if ($actionId == 'submit' && $newState == 'waiting'
            || $actionId == 'demote' && $newState == 'accepted') {
            // only to moderator
            $sendToCreator = false;
            $sendToModerator = true;
        } elseif ($actionId == 'accept' && $newState == 'accepted') {
            // to creator and super moderator
            $sendToSuperModerator = true;
        } elseif ($actionId == 'approve' && $newState == 'approved' && $workflowShortName == 'enterprise') {
            // to creator and moderator
            $sendToModerator = true;
        }
        $recipientTypes = [];
        if (true === $sendToCreator) {
            $recipientTypes[] = 'creator';
        }
        if (true === $sendToModerator) {
            $recipientTypes[] = 'moderator';
        }
        if (true === $sendToSuperModerator) {
            $recipientTypes[] = 'superModerator';
        }
    
        foreach ($recipientTypes as $recipientType) {
            $notifyArgs = [
                'recipientType' => $recipientType,
                'action' => $actionId,
                'entity' => $entity
            ];
            $result = $this->notificationHelper->process($notifyArgs);
        }
    
        // example for custom recipient type using designated entity fields:
        // recipientType => 'field-email^lastname'
    }
}
