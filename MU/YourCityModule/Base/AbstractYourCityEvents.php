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

namespace MU\YourCityModule\Base;

/**
 * Events definition base class.
 */
abstract class AbstractYourCityEvents
{
    /**
     * The muyourcitymodule.branch_post_load event is thrown when branches
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const BRANCH_POST_LOAD = 'muyourcitymodule.branch_post_load';
    
    /**
     * The muyourcitymodule.branch_pre_persist event is thrown before a new branch
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const BRANCH_PRE_PERSIST = 'muyourcitymodule.branch_pre_persist';
    
    /**
     * The muyourcitymodule.branch_post_persist event is thrown after a new branch
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const BRANCH_POST_PERSIST = 'muyourcitymodule.branch_post_persist';
    
    /**
     * The muyourcitymodule.branch_pre_remove event is thrown before an existing branch
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const BRANCH_PRE_REMOVE = 'muyourcitymodule.branch_pre_remove';
    
    /**
     * The muyourcitymodule.branch_post_remove event is thrown after an existing branch
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const BRANCH_POST_REMOVE = 'muyourcitymodule.branch_post_remove';
    
    /**
     * The muyourcitymodule.branch_pre_update event is thrown before an existing branch
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const BRANCH_PRE_UPDATE = 'muyourcitymodule.branch_pre_update';
    
    /**
     * The muyourcitymodule.branch_post_update event is thrown after an existing new branch
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterBranchEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const BRANCH_POST_UPDATE = 'muyourcitymodule.branch_post_update';
    
    /**
     * The muyourcitymodule.location_post_load event is thrown when locations
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const LOCATION_POST_LOAD = 'muyourcitymodule.location_post_load';
    
    /**
     * The muyourcitymodule.location_pre_persist event is thrown before a new location
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const LOCATION_PRE_PERSIST = 'muyourcitymodule.location_pre_persist';
    
    /**
     * The muyourcitymodule.location_post_persist event is thrown after a new location
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const LOCATION_POST_PERSIST = 'muyourcitymodule.location_post_persist';
    
    /**
     * The muyourcitymodule.location_pre_remove event is thrown before an existing location
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const LOCATION_PRE_REMOVE = 'muyourcitymodule.location_pre_remove';
    
    /**
     * The muyourcitymodule.location_post_remove event is thrown after an existing location
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const LOCATION_POST_REMOVE = 'muyourcitymodule.location_post_remove';
    
    /**
     * The muyourcitymodule.location_pre_update event is thrown before an existing location
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const LOCATION_PRE_UPDATE = 'muyourcitymodule.location_pre_update';
    
    /**
     * The muyourcitymodule.location_post_update event is thrown after an existing new location
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const LOCATION_POST_UPDATE = 'muyourcitymodule.location_post_update';
    
    /**
     * The muyourcitymodule.part_post_load event is thrown when parts
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const PART_POST_LOAD = 'muyourcitymodule.part_post_load';
    
    /**
     * The muyourcitymodule.part_pre_persist event is thrown before a new part
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const PART_PRE_PERSIST = 'muyourcitymodule.part_pre_persist';
    
    /**
     * The muyourcitymodule.part_post_persist event is thrown after a new part
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const PART_POST_PERSIST = 'muyourcitymodule.part_post_persist';
    
    /**
     * The muyourcitymodule.part_pre_remove event is thrown before an existing part
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const PART_PRE_REMOVE = 'muyourcitymodule.part_pre_remove';
    
    /**
     * The muyourcitymodule.part_post_remove event is thrown after an existing part
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const PART_POST_REMOVE = 'muyourcitymodule.part_post_remove';
    
    /**
     * The muyourcitymodule.part_pre_update event is thrown before an existing part
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const PART_PRE_UPDATE = 'muyourcitymodule.part_pre_update';
    
    /**
     * The muyourcitymodule.part_post_update event is thrown after an existing new part
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const PART_POST_UPDATE = 'muyourcitymodule.part_post_update';
    
    /**
     * The muyourcitymodule.offer_post_load event is thrown when offers
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const OFFER_POST_LOAD = 'muyourcitymodule.offer_post_load';
    
    /**
     * The muyourcitymodule.offer_pre_persist event is thrown before a new offer
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const OFFER_PRE_PERSIST = 'muyourcitymodule.offer_pre_persist';
    
    /**
     * The muyourcitymodule.offer_post_persist event is thrown after a new offer
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const OFFER_POST_PERSIST = 'muyourcitymodule.offer_post_persist';
    
    /**
     * The muyourcitymodule.offer_pre_remove event is thrown before an existing offer
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const OFFER_PRE_REMOVE = 'muyourcitymodule.offer_pre_remove';
    
    /**
     * The muyourcitymodule.offer_post_remove event is thrown after an existing offer
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const OFFER_POST_REMOVE = 'muyourcitymodule.offer_post_remove';
    
    /**
     * The muyourcitymodule.offer_pre_update event is thrown before an existing offer
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const OFFER_PRE_UPDATE = 'muyourcitymodule.offer_pre_update';
    
    /**
     * The muyourcitymodule.offer_post_update event is thrown after an existing new offer
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterOfferEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const OFFER_POST_UPDATE = 'muyourcitymodule.offer_post_update';
    
    /**
     * The muyourcitymodule.menuoflocation_post_load event is thrown when menus of location
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const MENUOFLOCATION_POST_LOAD = 'muyourcitymodule.menuoflocation_post_load';
    
    /**
     * The muyourcitymodule.menuoflocation_pre_persist event is thrown before a new menu of location
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const MENUOFLOCATION_PRE_PERSIST = 'muyourcitymodule.menuoflocation_pre_persist';
    
    /**
     * The muyourcitymodule.menuoflocation_post_persist event is thrown after a new menu of location
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const MENUOFLOCATION_POST_PERSIST = 'muyourcitymodule.menuoflocation_post_persist';
    
    /**
     * The muyourcitymodule.menuoflocation_pre_remove event is thrown before an existing menu of location
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const MENUOFLOCATION_PRE_REMOVE = 'muyourcitymodule.menuoflocation_pre_remove';
    
    /**
     * The muyourcitymodule.menuoflocation_post_remove event is thrown after an existing menu of location
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const MENUOFLOCATION_POST_REMOVE = 'muyourcitymodule.menuoflocation_post_remove';
    
    /**
     * The muyourcitymodule.menuoflocation_pre_update event is thrown before an existing menu of location
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const MENUOFLOCATION_PRE_UPDATE = 'muyourcitymodule.menuoflocation_pre_update';
    
    /**
     * The muyourcitymodule.menuoflocation_post_update event is thrown after an existing new menu of location
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterMenuOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const MENUOFLOCATION_POST_UPDATE = 'muyourcitymodule.menuoflocation_post_update';
    
    /**
     * The muyourcitymodule.partofmenu_post_load event is thrown when parts of menu
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const PARTOFMENU_POST_LOAD = 'muyourcitymodule.partofmenu_post_load';
    
    /**
     * The muyourcitymodule.partofmenu_pre_persist event is thrown before a new part of menu
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const PARTOFMENU_PRE_PERSIST = 'muyourcitymodule.partofmenu_pre_persist';
    
    /**
     * The muyourcitymodule.partofmenu_post_persist event is thrown after a new part of menu
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const PARTOFMENU_POST_PERSIST = 'muyourcitymodule.partofmenu_post_persist';
    
    /**
     * The muyourcitymodule.partofmenu_pre_remove event is thrown before an existing part of menu
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const PARTOFMENU_PRE_REMOVE = 'muyourcitymodule.partofmenu_pre_remove';
    
    /**
     * The muyourcitymodule.partofmenu_post_remove event is thrown after an existing part of menu
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const PARTOFMENU_POST_REMOVE = 'muyourcitymodule.partofmenu_post_remove';
    
    /**
     * The muyourcitymodule.partofmenu_pre_update event is thrown before an existing part of menu
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const PARTOFMENU_PRE_UPDATE = 'muyourcitymodule.partofmenu_pre_update';
    
    /**
     * The muyourcitymodule.partofmenu_post_update event is thrown after an existing new part of menu
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterPartOfMenuEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const PARTOFMENU_POST_UPDATE = 'muyourcitymodule.partofmenu_post_update';
    
    /**
     * The muyourcitymodule.dish_post_load event is thrown when dishes
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const DISH_POST_LOAD = 'muyourcitymodule.dish_post_load';
    
    /**
     * The muyourcitymodule.dish_pre_persist event is thrown before a new dish
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const DISH_PRE_PERSIST = 'muyourcitymodule.dish_pre_persist';
    
    /**
     * The muyourcitymodule.dish_post_persist event is thrown after a new dish
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const DISH_POST_PERSIST = 'muyourcitymodule.dish_post_persist';
    
    /**
     * The muyourcitymodule.dish_pre_remove event is thrown before an existing dish
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const DISH_PRE_REMOVE = 'muyourcitymodule.dish_pre_remove';
    
    /**
     * The muyourcitymodule.dish_post_remove event is thrown after an existing dish
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const DISH_POST_REMOVE = 'muyourcitymodule.dish_post_remove';
    
    /**
     * The muyourcitymodule.dish_pre_update event is thrown before an existing dish
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const DISH_PRE_UPDATE = 'muyourcitymodule.dish_pre_update';
    
    /**
     * The muyourcitymodule.dish_post_update event is thrown after an existing new dish
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterDishEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const DISH_POST_UPDATE = 'muyourcitymodule.dish_post_update';
    
    /**
     * The muyourcitymodule.event_post_load event is thrown when events
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const EVENT_POST_LOAD = 'muyourcitymodule.event_post_load';
    
    /**
     * The muyourcitymodule.event_pre_persist event is thrown before a new event
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const EVENT_PRE_PERSIST = 'muyourcitymodule.event_pre_persist';
    
    /**
     * The muyourcitymodule.event_post_persist event is thrown after a new event
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const EVENT_POST_PERSIST = 'muyourcitymodule.event_post_persist';
    
    /**
     * The muyourcitymodule.event_pre_remove event is thrown before an existing event
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const EVENT_PRE_REMOVE = 'muyourcitymodule.event_pre_remove';
    
    /**
     * The muyourcitymodule.event_post_remove event is thrown after an existing event
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const EVENT_POST_REMOVE = 'muyourcitymodule.event_post_remove';
    
    /**
     * The muyourcitymodule.event_pre_update event is thrown before an existing event
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const EVENT_PRE_UPDATE = 'muyourcitymodule.event_pre_update';
    
    /**
     * The muyourcitymodule.event_post_update event is thrown after an existing new event
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterEventEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const EVENT_POST_UPDATE = 'muyourcitymodule.event_post_update';
    
    /**
     * The muyourcitymodule.product_post_load event is thrown when products
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const PRODUCT_POST_LOAD = 'muyourcitymodule.product_post_load';
    
    /**
     * The muyourcitymodule.product_pre_persist event is thrown before a new product
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const PRODUCT_PRE_PERSIST = 'muyourcitymodule.product_pre_persist';
    
    /**
     * The muyourcitymodule.product_post_persist event is thrown after a new product
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const PRODUCT_POST_PERSIST = 'muyourcitymodule.product_post_persist';
    
    /**
     * The muyourcitymodule.product_pre_remove event is thrown before an existing product
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const PRODUCT_PRE_REMOVE = 'muyourcitymodule.product_pre_remove';
    
    /**
     * The muyourcitymodule.product_post_remove event is thrown after an existing product
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const PRODUCT_POST_REMOVE = 'muyourcitymodule.product_post_remove';
    
    /**
     * The muyourcitymodule.product_pre_update event is thrown before an existing product
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const PRODUCT_PRE_UPDATE = 'muyourcitymodule.product_pre_update';
    
    /**
     * The muyourcitymodule.product_post_update event is thrown after an existing new product
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterProductEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const PRODUCT_POST_UPDATE = 'muyourcitymodule.product_post_update';
    
    /**
     * The muyourcitymodule.specialoflocation_post_load event is thrown when specials of location
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const SPECIALOFLOCATION_POST_LOAD = 'muyourcitymodule.specialoflocation_post_load';
    
    /**
     * The muyourcitymodule.specialoflocation_pre_persist event is thrown before a new special of location
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const SPECIALOFLOCATION_PRE_PERSIST = 'muyourcitymodule.specialoflocation_pre_persist';
    
    /**
     * The muyourcitymodule.specialoflocation_post_persist event is thrown after a new special of location
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const SPECIALOFLOCATION_POST_PERSIST = 'muyourcitymodule.specialoflocation_post_persist';
    
    /**
     * The muyourcitymodule.specialoflocation_pre_remove event is thrown before an existing special of location
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const SPECIALOFLOCATION_PRE_REMOVE = 'muyourcitymodule.specialoflocation_pre_remove';
    
    /**
     * The muyourcitymodule.specialoflocation_post_remove event is thrown after an existing special of location
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const SPECIALOFLOCATION_POST_REMOVE = 'muyourcitymodule.specialoflocation_post_remove';
    
    /**
     * The muyourcitymodule.specialoflocation_pre_update event is thrown before an existing special of location
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const SPECIALOFLOCATION_PRE_UPDATE = 'muyourcitymodule.specialoflocation_pre_update';
    
    /**
     * The muyourcitymodule.specialoflocation_post_update event is thrown after an existing new special of location
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterSpecialOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const SPECIALOFLOCATION_POST_UPDATE = 'muyourcitymodule.specialoflocation_post_update';
    
    /**
     * The muyourcitymodule.serviceoflocation_post_load event is thrown when services of location
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const SERVICEOFLOCATION_POST_LOAD = 'muyourcitymodule.serviceoflocation_post_load';
    
    /**
     * The muyourcitymodule.serviceoflocation_pre_persist event is thrown before a new service of location
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const SERVICEOFLOCATION_PRE_PERSIST = 'muyourcitymodule.serviceoflocation_pre_persist';
    
    /**
     * The muyourcitymodule.serviceoflocation_post_persist event is thrown after a new service of location
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const SERVICEOFLOCATION_POST_PERSIST = 'muyourcitymodule.serviceoflocation_post_persist';
    
    /**
     * The muyourcitymodule.serviceoflocation_pre_remove event is thrown before an existing service of location
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const SERVICEOFLOCATION_PRE_REMOVE = 'muyourcitymodule.serviceoflocation_pre_remove';
    
    /**
     * The muyourcitymodule.serviceoflocation_post_remove event is thrown after an existing service of location
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const SERVICEOFLOCATION_POST_REMOVE = 'muyourcitymodule.serviceoflocation_post_remove';
    
    /**
     * The muyourcitymodule.serviceoflocation_pre_update event is thrown before an existing service of location
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const SERVICEOFLOCATION_PRE_UPDATE = 'muyourcitymodule.serviceoflocation_pre_update';
    
    /**
     * The muyourcitymodule.serviceoflocation_post_update event is thrown after an existing new service of location
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterServiceOfLocationEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const SERVICEOFLOCATION_POST_UPDATE = 'muyourcitymodule.serviceoflocation_post_update';
    
    /**
     * The muyourcitymodule.abonnement_post_load event is thrown when abonnements
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postLoad()
     * @var string
     */
    const ABONNEMENT_POST_LOAD = 'muyourcitymodule.abonnement_post_load';
    
    /**
     * The muyourcitymodule.abonnement_pre_persist event is thrown before a new abonnement
     * is created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::prePersist()
     * @var string
     */
    const ABONNEMENT_PRE_PERSIST = 'muyourcitymodule.abonnement_pre_persist';
    
    /**
     * The muyourcitymodule.abonnement_post_persist event is thrown after a new abonnement
     * has been created in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postPersist()
     * @var string
     */
    const ABONNEMENT_POST_PERSIST = 'muyourcitymodule.abonnement_post_persist';
    
    /**
     * The muyourcitymodule.abonnement_pre_remove event is thrown before an existing abonnement
     * is removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preRemove()
     * @var string
     */
    const ABONNEMENT_PRE_REMOVE = 'muyourcitymodule.abonnement_pre_remove';
    
    /**
     * The muyourcitymodule.abonnement_post_remove event is thrown after an existing abonnement
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postRemove()
     * @var string
     */
    const ABONNEMENT_POST_REMOVE = 'muyourcitymodule.abonnement_post_remove';
    
    /**
     * The muyourcitymodule.abonnement_pre_update event is thrown before an existing abonnement
     * is updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::preUpdate()
     * @var string
     */
    const ABONNEMENT_PRE_UPDATE = 'muyourcitymodule.abonnement_pre_update';
    
    /**
     * The muyourcitymodule.abonnement_post_update event is thrown after an existing new abonnement
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\YourCityModule\Event\FilterAbonnementEvent instance.
     *
     * @see MU\YourCityModule\Listener\EntityLifecycleListener::postUpdate()
     * @var string
     */
    const ABONNEMENT_POST_UPDATE = 'muyourcitymodule.abonnement_post_update';
    
}
