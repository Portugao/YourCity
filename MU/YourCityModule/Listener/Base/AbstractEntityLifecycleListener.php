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

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\File;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Core\Doctrine\EntityAccess;
use MU\YourCityModule\YourCityEvents;
use MU\YourCityModule\Event\FilterBranchEvent;
use MU\YourCityModule\Event\FilterLocationEvent;
use MU\YourCityModule\Event\FilterPartEvent;
use MU\YourCityModule\Event\FilterImageOfLocationEvent;
use MU\YourCityModule\Event\FilterFileOfLocationEvent;
use MU\YourCityModule\Event\FilterOfferEvent;
use MU\YourCityModule\Event\FilterMenuOfLocationEvent;
use MU\YourCityModule\Event\FilterPartOfMenuEvent;
use MU\YourCityModule\Event\FilterDishEvent;
use MU\YourCityModule\Event\FilterEventEvent;
use MU\YourCityModule\Event\FilterProductEvent;
use MU\YourCityModule\Event\FilterSpecialOfLocationEvent;
use MU\YourCityModule\Event\FilterServiceofLocationEvent;
use MU\YourCityModule\Event\FilterAbonnementEvent;

/**
 * Event subscriber base class for entity lifecycle events.
 */
abstract class AbstractEntityLifecycleListener implements EventSubscriber, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * EntityLifecycleListener constructor.
     *
     * @param ContainerInterface       $container
     * @param EventDispatcherInterface $eventDispatcher EventDispatcher service instance
     * @param LoggerInterface          $logger          Logger service instance
     * @param TranslatorInterface      $translator      Translator service instance
     */
    public function __construct(
        ContainerInterface $container,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger,
        TranslatorInterface $translator)
    {
        $this->setContainer($container);
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * Returns list of events to subscribe.
     *
     * @return array list of events
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preRemove,
            Events::postRemove,
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate,
            Events::postLoad
        ];
    }

    /**
     * The preRemove event occurs for a given entity before the respective EntityManager
     * remove operation for that entity is executed. It is not called for a DQL DELETE statement.
     *
     * @param LifecycleEventArgs $args Event arguments
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($entity->get_objectType()) . '_PRE_REMOVE'), $event);
        if ($event->isPropagationStopped()) {
            return false;
        }
        
        // delete workflow for this entity
        $workflowHelper = $this->container->get('mu_yourcity_module.workflow_helper');
        $workflowHelper->normaliseWorkflowData($entity);
        $workflow = $entity['__WORKFLOW__'];
        if ($workflow['id'] > 0) {
            $result = true;
            try {
                $entityManager = $args->getEntityManager();
                $workflow = $entityManager->find('Zikula\Core\Doctrine\Entity\WorkflowEntity', $workflow['id']);
                $entityManager->remove($workflow);
                $entityManager->flush();
            } catch (\Exception $e) {
                $result = false;
            }
            if (false === $result) {
                $session = $this->container->get('session');
                $session->getFlashBag()->add('error', $this->translator->__('Error! Could not remove stored workflow. Deletion has been aborted.'));
        
                return false;
            }
        }
    }

    /**
     * The postRemove event occurs for an entity after the entity has been deleted. It will be
     * invoked after the database delete operations. It is not called for a DQL DELETE statement.
     *
     * Note that the postRemove event or any events triggered after an entity removal can receive
     * an uninitializable proxy in case you have configured an entity to cascade remove relations.
     * In this case, you should load yourself the proxy in the associated pre event.
     *
     * @param LifecycleEventArgs $args Event arguments
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        $objectType = $entity->get_objectType();
        $objectId = $entity->createCompositeIdentifier();
        
        $uploadFields = $this->getUploadFields($objectType);
        if (count($uploadFields) > 0) {
            $uploadHelper = $this->container->get('mu_yourcity_module.upload_helper');
            foreach ($uploadFields as $uploadField) {
                if (empty($entity[$uploadField])) {
                    continue;
                }
        
                // remove upload file
                $uploadHelper->deleteUploadFile($entity, $uploadField);
            }
        }
        
        $currentUserApi = $this->container->get('zikula_users_module.current_user');
        $logArgs = ['app' => 'MUYourCityModule', 'user' => $currentUserApi->get('uname'), 'entity' => $objectType, 'id' => $objectId];
        $this->logger->debug('{app}: User {user} removed the {entity} with id {id}.', $logArgs);
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($objectType) . '_POST_REMOVE'), $event);
    }

    /**
     * The prePersist event occurs for a given entity before the respective EntityManager
     * persist operation for that entity is executed. It should be noted that this event
     * is only triggered on initial persist of an entity (i.e. it does not trigger on future updates).
     *
     * Doctrine will not recognize changes made to relations in a prePersist event.
     * This includes modifications to collections such as additions, removals or replacement.
     *
     * @param LifecycleEventArgs $args Event arguments
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        $uploadFields = $this->getUploadFields($entity->get_objectType());
        foreach ($uploadFields as $uploadField) {
            if (empty($entity[$uploadField])) {
                continue;
            }
        
            if (!($entity[$uploadField] instanceof File)) {
                $entity[$uploadField] = new File($entity[$uploadField]);
            }
            $entity[$uploadField] = $entity[$uploadField]->getFilename();
        }
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($entity->get_objectType()) . '_PRE_PERSIST'), $event);
        if ($event->isPropagationStopped()) {
            return false;
        }
    }

    /**
     * The postPersist event occurs for an entity after the entity has been made persistent.
     * It will be invoked after the database insert operations. Generated primary key values
     * are available in the postPersist event.
     *
     * @param LifecycleEventArgs $args Event arguments
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        $objectId = $entity->createCompositeIdentifier();
        $currentUserApi = $this->container->get('zikula_users_module.current_user');
        $logArgs = ['app' => 'MUYourCityModule', 'user' => $currentUserApi->get('uname'), 'entity' => $entity->get_objectType(), 'id' => $objectId];
        $this->logger->debug('{app}: User {user} created the {entity} with id {id}.', $logArgs);
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($entity->get_objectType()) . '_POST_PERSIST'), $event);
    }

    /**
     * The preUpdate event occurs before the database update operations to entity data.
     * It is not called for a DQL UPDATE statement nor when the computed changeset is empty.
     *
     * @see http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#preupdate
     *
     * @param PreUpdateEventArgs $args Event arguments
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        $uploadFields = $this->getUploadFields($entity->get_objectType());
        foreach ($uploadFields as $uploadField) {
            if (empty($entity[$uploadField])) {
                continue;
            }
        
            if (!($entity[$uploadField] instanceof File)) {
                $entity[$uploadField] = new File($entity[$uploadField]);
            }
            $entity[$uploadField] = $entity[$uploadField]->getFilename();
        }
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($entity->get_objectType()) . '_PRE_UPDATE'), $event);
        if ($event->isPropagationStopped()) {
            return false;
        }
    }

    /**
     * The postUpdate event occurs after the database update operations to entity data.
     * It is not called for a DQL UPDATE statement.
     *
     * @param LifecycleEventArgs $args Event arguments
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        $objectId = $entity->createCompositeIdentifier();
        $currentUserApi = $this->container->get('zikula_users_module.current_user');
        $logArgs = ['app' => 'MUYourCityModule', 'user' => $currentUserApi->get('uname'), 'entity' => $entity->get_objectType(), 'id' => $objectId];
        $this->logger->debug('{app}: User {user} updated the {entity} with id {id}.', $logArgs);
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($entity->get_objectType()) . '_POST_UPDATE'), $event);
    }

    /**
     * The postLoad event occurs for an entity after the entity has been loaded into the current
     * EntityManager from the database or after the refresh operation has been applied to it.
     *
     * Note that, when using Doctrine\ORM\AbstractQuery#iterate(), postLoad events will be executed
     * immediately after objects are being hydrated, and therefore associations are not guaranteed
     * to be initialized. It is not safe to combine usage of Doctrine\ORM\AbstractQuery#iterate()
     * and postLoad event handlers.
     *
     * @param LifecycleEventArgs $args Event arguments
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$this->isEntityManagedByThisBundle($entity) || !method_exists($entity, 'get_objectType')) {
            return;
        }
        
        // prepare helper fields for uploaded files
        $uploadFields = $this->getUploadFields($entity->get_objectType());
        if (count($uploadFields) > 0) {
            $uploadHelper = $this->container->get('mu_yourcity_module.upload_helper');
            $request = $this->container->get('request_stack')->getCurrentRequest();
            $baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
            foreach ($uploadFields as $fieldName) {
                $uploadHelper->initialiseUploadField($entity, $fieldName, $baseUrl);
            }
        }
        
        // create the filter event and dispatch it
        $event = $this->createFilterEvent($entity);
        $this->eventDispatcher->dispatch(constant('\\MU\\YourCityModule\\YourCityEvents::' . strtoupper($entity->get_objectType()) . '_POST_LOAD'), $event);
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
     * Returns a filter event instance for the given entity.
     *
     * @param EntityAccess $entity The given entity
     *
     * @return Event The created event instance
     */
    protected function createFilterEvent($entity)
    {
        $filterEventClass = '\\MU\\YourCityModule\\Event\\Filter' . ucfirst($entity->get_objectType()) . 'Event';
        $event = new $filterEventClass($entity);

        return $event;
    }

    /**
     * Returns list of upload fields for the given object type.
     *
     * @param string $objectType The object type
     *
     * @return array List of upload fields
     */
    protected function getUploadFields($objectType = '')
    {
        $uploadFields = [];
        switch ($objectType) {
            case 'branch':
                $uploadFields = ['imageofBranch'];
                break;
            case 'location':
                $uploadFields = ['logoOfYourLocation', 'imageOfLocation'];
                break;
            case 'part':
                $uploadFields = ['imageOfPart'];
                break;
            case 'imageOfLocation':
                $uploadFields = ['image'];
                break;
            case 'fileOfLocation':
                $uploadFields = ['fileOfFile'];
                break;
            case 'offer':
                $uploadFields = ['imageOfOffer'];
                break;
            case 'menuOfLocation':
                $uploadFields = ['imageOfMenu'];
                break;
            case 'dish':
                $uploadFields = ['imageOfDish'];
                break;
            case 'event':
                $uploadFields = ['imageOfEvent'];
                break;
        }

        return $uploadFields;
    }
}
