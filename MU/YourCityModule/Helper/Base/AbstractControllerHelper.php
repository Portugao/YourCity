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

namespace MU\YourCityModule\Helper\Base;

use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Component\SortableColumns\SortableColumns;
use Zikula\Core\RouteUrl;
use Zikula\ExtensionsModule\Api\VariableApi;
use Zikula\UsersModule\Api\CurrentUserApi;
use Zikula\UsersModule\Entity\UserEntity;
use MU\YourCityModule\Entity\Factory\EntityFactory;
use MU\YourCityModule\Helper\ArchiveHelper;
use MU\YourCityModule\Helper\CollectionFilterHelper;
use MU\YourCityModule\Helper\FeatureActivationHelper;
use MU\YourCityModule\Helper\ImageHelper;
use MU\YourCityModule\Helper\ModelHelper;

/**
 * Helper base class for controller layer methods.
 */
abstract class AbstractControllerHelper
{
    use TranslatorTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var VariableApi
     */
    protected $variableApi;

    /**
     * @var CurrentUserApi
     */
    protected $currentUserApi;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @var CollectionFilterHelper
     */
    protected $collectionFilterHelper;

    /**
     * @var ModelHelper
     */
    protected $modelHelper;

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @var FeatureActivationHelper
     */
    protected $featureActivationHelper;

    /**
     * ControllerHelper constructor.
     *
     * @param TranslatorInterface $translator      Translator service instance
     * @param RequestStack        $requestStack    RequestStack service instance
     * @param ArchiveHelper       $archiveHelper   ArchiveHelper service instance
     * @param LoggerInterface     $logger          Logger service instance
     * @param FormFactoryInterface $formFactory    FormFactory service instance
     * @param VariableApi         $variableApi     VariableApi service instance
     * @param CurrentUserApi      $currentUserApi  CurrentUserApi service instance
     * @param EntityFactory       $entityFactory   EntityFactory service instance
     * @param CollectionFilterHelper $collectionFilterHelper CollectionFilterHelper service instance
     * @param ModelHelper         $modelHelper     ModelHelper service instance
     * @param ImageHelper         $imageHelper     ImageHelper service instance
     * @param FeatureActivationHelper $featureActivationHelper FeatureActivationHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        ArchiveHelper $archiveHelper,
        LoggerInterface $logger,
        FormFactoryInterface $formFactory,
        VariableApi $variableApi,
        CurrentUserApi $currentUserApi,
        EntityFactory $entityFactory,
        CollectionFilterHelper $collectionFilterHelper,
        ModelHelper $modelHelper,
        ImageHelper $imageHelper,
        FeatureActivationHelper $featureActivationHelper
    ) {
        $this->setTranslator($translator);
        $this->request = $requestStack->getCurrentRequest();
        $this->logger = $logger;
        $this->formFactory = $formFactory;
        $this->variableApi = $variableApi;
        $this->currentUserApi = $currentUserApi;
        $this->entityFactory = $entityFactory;
        $this->collectionFilterHelper = $collectionFilterHelper;
        $this->modelHelper = $modelHelper;
        $this->imageHelper = $imageHelper;
        $this->featureActivationHelper = $featureActivationHelper;

        $archiveHelper->archiveObsoleteObjects();
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns an array of all allowed object types in MUYourCityModule.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, helper, actionHandler, block, contentType, util)
     * @param array  $args    Additional arguments
     *
     * @return array List of allowed object types
     */
    public function getObjectTypes($context = '', array $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'helper', 'actionHandler', 'block', 'contentType', 'util'])) {
            $context = 'controllerAction';
        }
    
        $allowedObjectTypes = [];
        $allowedObjectTypes[] = 'branch';
        $allowedObjectTypes[] = 'location';
        $allowedObjectTypes[] = 'part';
        $allowedObjectTypes[] = 'imageOfLocation';
        $allowedObjectTypes[] = 'fileOfLocation';
        $allowedObjectTypes[] = 'offer';
        $allowedObjectTypes[] = 'menuOfLocation';
        $allowedObjectTypes[] = 'partOfMenu';
        $allowedObjectTypes[] = 'dish';
        $allowedObjectTypes[] = 'event';
        $allowedObjectTypes[] = 'product';
        $allowedObjectTypes[] = 'specialOfLocation';
        $allowedObjectTypes[] = 'serviceOfLocation';
        $allowedObjectTypes[] = 'abonnement';
    
        return $allowedObjectTypes;
    }

    /**
     * Returns the default object type in MUYourCityModule.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, helper, actionHandler, block, contentType, util)
     * @param array  $args    Additional arguments
     *
     * @return string The name of the default object type
     */
    public function getDefaultObjectType($context = '', array $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'helper', 'actionHandler', 'block', 'contentType', 'util'])) {
            $context = 'controllerAction';
        }
    
        return 'location';
    }

    /**
     * Create nice permalinks.
     *
     * @param string $name The given object title
     *
     * @return string processed permalink
     * @deprecated made obsolete by Doctrine extensions
     */
    public function formatPermalink($name)
    {
        $name = str_replace(
            ['�', '�', '�', '�', '�', '�', '�', '.', '?', '"', '/', ':', '�', '�', '�'],
            ['ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '', '', '', '-', '-', 'e', 'e', 'a'],
            $name
        );
        $name = preg_replace("#(\s*\/\s*|\s*\+\s*|\s+)#", '-', strtolower($name));
    
        return $name;
    }

    /**
     * Processes the parameters for a view action.
     * This includes handling pagination, quick navigation forms and other aspects.
     *
     * @param string          $objectType         Name of treated entity type
     * @param SortableColumns $sortableColumns    Used SortableColumns instance
     * @param array           $templateParameters Template data
     * @param boolean         $supportsHooks      Whether hooks are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processViewActionParameters($objectType, SortableColumns $sortableColumns, array $templateParameters = [], $supportsHooks = false)
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'view'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new Exception($this->__('Error! Invalid object type received.'));
        }
    
        $request = $this->request;
        $repository = $this->entityFactory->getRepository($objectType);
    
        // parameter for used sorting field
        $sort = $request->query->get('sort', '');
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
            $request->query->set('sort', $sort);
            // set default sorting in route parameters (e.g. for the pager)
            $routeParams = $request->attributes->get('_route_params');
            $routeParams['sort'] = $sort;
            $request->attributes->set('_route_params', $routeParams);
        }
    
        $templateParameters['all'] = 'csv' == $request->getRequestFormat() ? 1 : $request->query->getInt('all', 0);
        $templateParameters['own'] = $request->query->getInt('own', $this->variableApi->get('MUYourCityModule', 'showOnlyOwnEntries', 0));
    
        $resultsPerPage = 0;
        if ($templateParameters['all'] != 1) {
            // the number of items displayed on a page for pagination
            $resultsPerPage = $request->query->getInt('num', 0);
            if (in_array($resultsPerPage, [0, 10])) {
                $resultsPerPage = $this->variableApi->get('MUYourCityModule', $objectType . 'EntriesPerPage', 10);
            }
        }
        $templateParameters['num'] = $resultsPerPage;
        $templateParameters['tpl'] = $request->query->getAlnum('tpl', '');
    
        $templateParameters = $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    
        $quickNavForm = $this->formFactory->create('MU\YourCityModule\Form\Type\QuickNavigation\\' . ucfirst($objectType) . 'QuickNavType', $templateParameters);
        if ($quickNavForm->handleRequest($request) && $quickNavForm->isSubmitted()) {
            $quickNavData = $quickNavForm->getData();
            foreach ($quickNavData as $fieldName => $fieldValue) {
                if ($fieldName == 'routeArea') {
                    continue;
                }
                if (in_array($fieldName, ['all', 'own', 'num'])) {
                    $templateParameters[$fieldName] = $fieldValue;
                } else {
                    // set filter as query argument, fetched inside repository
                    if ($fieldValue instanceof UserEntity) {
                        $fieldValue = $fieldValue->getUid();
                    }
                    $request->query->set($fieldName, $fieldValue);
                }
            }
        }
    
        $urlParameters = $templateParameters;
        foreach ($urlParameters as $parameterName => $parameterValue) {
            if (false !== stripos($parameterName, 'thumbRuntimeOptions')) {
                unset($urlParameters[$parameterName]);
            }
        }
    
        $sort = $sortableColumns->getSortColumn()->getName();
        $sortdir = $sortableColumns->getSortDirection();
        $sortableColumns->setAdditionalUrlParameters($urlParameters);
    
        $where = '';
        if ($templateParameters['all'] == 1) {
            // retrieve item list without pagination
            $entities = $repository->selectWhere($where, $sort . ' ' . $sortdir);
        } else {
            // the current offset which is used to calculate the pagination
            $currentPage = $request->query->getInt('pos', 1);
    
            // retrieve item list with pagination
            list($entities, $objectCount) = $repository->selectWherePaginated($where, $sort . ' ' . $sortdir, $currentPage, $resultsPerPage);
    
            $templateParameters['currentPage'] = $currentPage;
            $templateParameters['pager'] = [
                'amountOfItems' => $objectCount,
                'itemsPerPage' => $resultsPerPage
            ];
        }
    
        $templateParameters['sort'] = $sort;
        $templateParameters['sortdir'] = $sortdir;
        $templateParameters['items'] = $entities;
    
    
        if (true === $supportsHooks) {
            // build RouteUrl instance for display hooks
            $urlParameters['_locale'] = $request->getLocale();
            $templateParameters['currentUrlObject'] = new RouteUrl('muyourcitymodule_' . $objectType . '_' . /*$templateParameters['routeArea'] . */'view', $urlParameters);
        }
    
        $templateParameters['sort'] = $sortableColumns->generateSortableColumns();
        $templateParameters['quickNavForm'] = $quickNavForm->createView();
    
        $templateParameters['canBeCreated'] = $this->modelHelper->canBeCreated($objectType);
    
        return $templateParameters;
    }

    /**
     * Processes the parameters for a display action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     * @param boolean $supportsHooks      Whether hooks are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processDisplayActionParameters($objectType, array $templateParameters = [], $supportsHooks = false)
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'display'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new Exception($this->__('Error! Invalid object type received.'));
        }
    
        if (true === $supportsHooks) {
            // build RouteUrl instance for display hooks
            $entity = $templateParameters[$objectType];
            $urlParameters = $entity->createUrlArgs();
            $urlParameters['_locale'] = $this->request->getLocale();
            $templateParameters['currentUrlObject'] = new RouteUrl('muyourcitymodule_' . $objectType . '_' . /*$templateParameters['routeArea'] . */'display', $urlParameters);
        }
    
        return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }

    /**
     * Processes the parameters for an edit action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processEditActionParameters($objectType, array $templateParameters = [])
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'edit'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new Exception($this->__('Error! Invalid object type received.'));
        }
    
        return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }

    /**
     * Processes the parameters for a delete action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     * @param boolean $supportsHooks      Whether hooks are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processDeleteActionParameters($objectType, array $templateParameters = [], $supportsHooks = false)
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'delete'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new Exception($this->__('Error! Invalid object type received.'));
        }
    
        return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }

    /**
     * Returns an array of additional template variables which are specific to the object type treated by this repository.
     *
     * @param string $objectType Name of treated entity type
     * @param array  $parameters Given parameters to enrich
     * @param string $context    Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args       Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    public function addTemplateParameters($objectType = '', array $parameters = [], $context = '', array $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'])) {
            $context = 'controllerAction';
        }
    
        if ($context == 'controllerAction') {
            if (!isset($args['action'])) {
                $routeName = $this->request->get('_route');
                $routeNameParts = explode('_', $routeName);
                $args['action'] = end($routeNameParts);
            }
            if (in_array($args['action'], ['index', 'view'])) {
                $parameters = array_merge($parameters, $this->collectionFilterHelper->getViewQuickNavParameters($objectType, $context, $args));
            }
    
            // initialise Imagine runtime options
            if ($objectType == 'branch') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfBranch'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfBranch', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'location') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'LogoOfYourLocation'] = $this->imageHelper->getRuntimeOptions($objectType, 'logoOfYourLocation', $context, $args);
                $thumbRuntimeOptions[$objectType . 'ImageOfLocation'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfLocation', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'part') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfPart'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfPart', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'imageOfLocation') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'Image'] = $this->imageHelper->getRuntimeOptions($objectType, 'image', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'fileOfLocation') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'FileOfFile'] = $this->imageHelper->getRuntimeOptions($objectType, 'fileOfFile', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'offer') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfOffer'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfOffer', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'menuOfLocation') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfMenu'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfMenu', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'dish') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfDish'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfDish', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'event') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfEvent'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfEvent', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'product') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'ImageOfProduct'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfProduct', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if (in_array($args['action'], ['display', 'edit', 'view'])) {
                // use separate preset for images in related items
                $parameters['relationThumbRuntimeOptions'] = $this->imageHelper->getCustomRuntimeOptions('', '', 'MUYourCityModule_relateditem', $context, $args);
            }
        }
    
        $parameters['featureActivationHelper'] = $this->featureActivationHelper;
    
        return $parameters;
    }

    /**
     * Example method for performing geo coding in PHP.
     * To use this please customise it to your needs in the concrete subclass.
     * Also you have to call this method in a PrePersist-Handler of the
     * corresponding entity class.
     * There is also a method on JS level available in Resources/public/js/MUYourCityModule.EditFunctions.js.
     *
     * @param string $address The address input string
     *
     * @return Array The determined coordinates
     */
    public function performGeoCoding($address)
    {
        $lang = $this->request->getLocale();
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . $this->variableApi->get('MUYourCityModule', 'googleMapsApiKey', '') . '&address=' . urlencode($address);
        $url .= '&region=' . $lang . '&language=' . $lang . '&sensor=false';
    
        $json = '';
    
        // we can either use Snoopy if available
        //require_once('modules/MU/YourCityModule/vendor/Snoopy/Snoopy.class.php');
        //$snoopy = new Snoopy();
        //$snoopy->fetch($url);
        //$json = $snoopy->results;
    
        // we can also use curl
        if (function_exists('curl_version')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // can cause problems with open_basedir
            curl_setopt($ch, CURLOPT_URL, $url);
            $json = curl_exec($ch);
            curl_close($ch);
        } else {
            // or we can use the plain file_get_contents method
            // requires allow_url_fopen = true in php.ini which is NOT good for security
            $json = file_get_contents($url);
        }
    
        // create the result array
        $result = [
            'latitude' => 0,
            'longitude' => 0
        ];
    
        if ($json != '') {
            $data = json_decode($json);
    
            if (json_last_error() == JSON_ERROR_NONE && $data->status == 'OK') {
                $jsonResult = reset($data->results);
                $location = $jsonResult->geometry->location;
    
                $result['latitude'] = str_replace(',', '.', $location->lat);
                $result['longitude'] = str_replace(',', '.', $location->lng);
            } else {
                $logArgs = ['app' => 'MUYourCityModule', 'user' => $this->currentUserApi->get('uname'), 'field' => $field, 'address' => $address];
                $this->logger->warning('{app}: User {user} tried geocoding for address "{address}", but failed.', $logArgs);
            }
        }
    
        return $result;
    }
}
