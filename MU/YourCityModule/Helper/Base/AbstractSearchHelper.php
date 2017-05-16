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

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Composite;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Core\RouteUrl;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use Zikula\SearchModule\Entity\SearchResultEntity;
use Zikula\SearchModule\SearchableInterface;
use MU\YourCityModule\Entity\Factory\EntityFactory;
use MU\YourCityModule\Helper\ControllerHelper;
use MU\YourCityModule\Helper\EntityDisplayHelper;

/**
 * Search helper base class.
 */
abstract class AbstractSearchHelper implements SearchableInterface
{
    use TranslatorTrait;
    
    /**
     * @var PermissionApiInterface
     */
    protected $permissionApi;
    
    /**
     * @var SessionInterface
     */
    private $session;
    
    /**
     * @var Request
     */
    private $request;
    
    /**
     * @var EntityFactory
     */
    private $entityFactory;
    
    /**
     * @var ControllerHelper
     */
    private $controllerHelper;
    
    /**
     * @var EntityDisplayHelper
     */
    protected $entityDisplayHelper;
    
    /**
     * SearchHelper constructor.
     *
     * @param TranslatorInterface $translator          Translator service instance
     * @param PermissionApiInterface    $permissionApi   PermissionApi service instance
     * @param SessionInterface    $session             Session service instance
     * @param RequestStack        $requestStack        RequestStack service instance
     * @param EntityFactory       $entityFactory       EntityFactory service instance
     * @param ControllerHelper    $controllerHelper    ControllerHelper service instance
     * @param EntityDisplayHelper $entityDisplayHelper EntityDisplayHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        PermissionApiInterface $permissionApi,
        SessionInterface $session,
        RequestStack $requestStack,
        EntityFactory $entityFactory,
        ControllerHelper $controllerHelper,
        EntityDisplayHelper $entityDisplayHelper
    ) {
        $this->setTranslator($translator);
        $this->permissionApi = $permissionApi;
        $this->session = $session;
        $this->request = $requestStack->getCurrentRequest();
        $this->entityFactory = $entityFactory;
        $this->controllerHelper = $controllerHelper;
        $this->entityDisplayHelper = $entityDisplayHelper;
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
     * @inheritDoc
     */
    public function amendForm(FormBuilderInterface $builder)
    {
        if (!$this->permissionApi->hasPermission('MUYourCityModule::', '::', ACCESS_READ)) {
            return '';
        }
    
        $builder->add('active', HiddenType::class, [
            'data' => true
        ]);
    
        $searchTypes = $this->getSearchTypes();
    
        foreach ($searchTypes as $searchType => $typeInfo) {
            $builder->add('active_' . $searchType, CheckboxType::class, [
                'value' => $typeInfo['value'],
                'label' => $typeInfo['label'],
                'label_attr' => ['class' => 'checkbox-inline'],
                'required' => false
            ]);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function getResults(array $words, $searchType = 'AND', $modVars = null)
    {
        if (!$this->permissionApi->hasPermission('MUYourCityModule::', '::', ACCESS_READ)) {
            return [];
        }
    
        // initialise array for results
        $results = [];
    
        // retrieve list of activated object types
        $searchTypes = $this->getSearchTypes();
    
        foreach ($searchTypes as $searchTypeCode => $typeInfo) {
            $objectType = $typeInfo['value'];
            $isActivated = false;
            if ($this->request->isMethod('GET')) {
                $isActivated = $this->request->query->get('active_' . $searchTypeCode, false);
            } elseif ($this->request->isMethod('POST')) {
                $isActivated = $this->request->request->get('active_' . $searchTypeCode, false);
            }
            if (!$isActivated) {
                continue;
            }
            $whereArray = [];
            $languageField = null;
            switch ($objectType) {
                case 'branch':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.descriptionForGoogle';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.imageOfBranch';
                    break;
                case 'location':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.letterForOrder';
                    $whereArray[] = 'tbl.slogan';
                    $whereArray[] = 'tbl.logoOfYourLocation';
                    $whereArray[] = 'tbl.descriptionForGoogle';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.description2';
                    $whereArray[] = 'tbl.imageOfLocation';
                    $whereArray[] = 'tbl.street';
                    $whereArray[] = 'tbl.numberOfStreet';
                    $whereArray[] = 'tbl.zipCode';
                    $whereArray[] = 'tbl.city';
                    $whereArray[] = 'tbl.telefon';
                    $whereArray[] = 'tbl.mobil';
                    $whereArray[] = 'tbl.homepage';
                    $whereArray[] = 'tbl.bsagStop';
                    $whereArray[] = 'tbl.tram';
                    $whereArray[] = 'tbl.bus';
                    $whereArray[] = 'tbl.openingHours';
                    $whereArray[] = 'tbl.partOfCity';
                    break;
                case 'part':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.descriptionForGoogle';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.imageOfPart';
                    break;
                case 'imageOfLocation':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.image';
                    break;
                case 'fileOfLocation':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.fileOfFile';
                    break;
                case 'offer':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.urlToOfferOnHomepage';
                    $whereArray[] = 'tbl.imageOfOffer';
                    break;
                case 'menuOfLocation':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.imageOfMenu';
                    $whereArray[] = 'tbl.kindOfMenu';
                    $whereArray[] = 'tbl.additionalRemarks';
                    break;
                case 'partOfMenu':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    break;
                case 'dish':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.kindOfDish';
                    $whereArray[] = 'tbl.imageOfDish';
                    $whereArray[] = 'tbl.ingredients';
                    break;
                case 'event':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.imageOfEvent';
                    $whereArray[] = 'tbl.kindOfEvent';
                    $whereArray[] = 'tbl.street';
                    $whereArray[] = 'tbl.numberOfStreet';
                    $whereArray[] = 'tbl.zipCode';
                    $whereArray[] = 'tbl.city';
                    break;
                case 'product':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.kindOfProduct';
                    $whereArray[] = 'tbl.imageOfProduct';
                    $whereArray[] = 'tbl.today';
                    break;
                case 'specialOfLocation':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.descriptionForGoogle';
                    $whereArray[] = 'tbl.iconForSpecial';
                    $whereArray[] = 'tbl.colorOfIcon';
                    break;
                case 'serviceOfLocation':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.descriptionForGoogle';
                    $whereArray[] = 'tbl.iconForService';
                    break;
                case 'abonnement':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.name';
                    break;
            }
    
            $repository = $this->entityFactory->getRepository($objectType);
    
            // build the search query without any joins
            $qb = $repository->genericBaseQuery('', '', false);
    
            // build where expression for given search type
            $whereExpr = $this->formatWhere($qb, $words, $whereArray, $searchType);
            $qb->andWhere($whereExpr);
    
            $query = $qb->getQuery();
    
            // set a sensitive limit
            $query->setFirstResult(0)
                  ->setMaxResults(250);
    
            // fetch the results
            $entities = $query->getResult();
    
            if (count($entities) == 0) {
                continue;
            }
    
            $descriptionFieldName = $this->entityDisplayHelper->getDescriptionFieldName($objectType);
    
            $entitiesWithDisplayAction = ['branch', 'location', 'part', 'imageOfLocation', 'fileOfLocation', 'offer', 'menuOfLocation', 'partOfMenu', 'dish', 'event', 'product', 'specialOfLocation', 'serviceOfLocation'];
    
            foreach ($entities as $entity) {
                $urlArgs = $entity->createUrlArgs();
                $hasDisplayAction = in_array($objectType, $entitiesWithDisplayAction);
    
                // perform permission check
                if (!$this->permissionApi->hasPermission('MUYourCityModule:' . ucfirst($objectType) . ':', $entity->getKey() . '::', ACCESS_OVERVIEW)) {
                    continue;
                }
    
                $description = !empty($descriptionFieldName) ? $entity[$descriptionFieldName] : '';
                $created = isset($entity['createdDate']) ? $entity['createdDate'] : null;
    
                $urlArgs['_locale'] = (null !== $languageField && !empty($entity[$languageField])) ? $entity[$languageField] : $this->request->getLocale();
    
                $formattedTitle = $this->entityDisplayHelper->getFormattedTitle($entity);
                $displayUrl = $hasDisplayAction ? new RouteUrl('muyourcitymodule_' . $objectType . '_display', $urlArgs) : '';
    
                $result = new SearchResultEntity();
                $result->setTitle($formattedTitle)
                    ->setText($description)
                    ->setModule('MUYourCityModule')
                    ->setCreated($created)
                    ->setSesid($this->session->getId())
                    ->setUrl($displayUrl);
                $results[] = $result;
            }
        }
    
        return $results;
    }
    
    /**
     * Returns list of supported search types.
     *
     * @return array
     */
    protected function getSearchTypes()
    {
        $searchTypes = [
            'mUYourCityModuleBranches' => [
                'value' => 'branch',
                'label' => $this->__('Branches')
            ],
            'mUYourCityModuleLocations' => [
                'value' => 'location',
                'label' => $this->__('Locations')
            ],
            'mUYourCityModuleParts' => [
                'value' => 'part',
                'label' => $this->__('Parts')
            ],
            'mUYourCityModuleImagesOfLocation' => [
                'value' => 'imageOfLocation',
                'label' => $this->__('Images of location')
            ],
            'mUYourCityModuleFilesOfLocation' => [
                'value' => 'fileOfLocation',
                'label' => $this->__('Files of location')
            ],
            'mUYourCityModuleOffers' => [
                'value' => 'offer',
                'label' => $this->__('Offers')
            ],
            'mUYourCityModuleMenusOfLocation' => [
                'value' => 'menuOfLocation',
                'label' => $this->__('Menus of location')
            ],
            'mUYourCityModulePartsOfMenu' => [
                'value' => 'partOfMenu',
                'label' => $this->__('Parts of menu')
            ],
            'mUYourCityModuleDishes' => [
                'value' => 'dish',
                'label' => $this->__('Dishes')
            ],
            'mUYourCityModuleEvents' => [
                'value' => 'event',
                'label' => $this->__('Events')
            ],
            'mUYourCityModuleProducts' => [
                'value' => 'product',
                'label' => $this->__('Products')
            ],
            'mUYourCityModuleSpecialsOfLocation' => [
                'value' => 'specialOfLocation',
                'label' => $this->__('Specials of location')
            ],
            'mUYourCityModuleServicesOfLocation' => [
                'value' => 'serviceOfLocation',
                'label' => $this->__('Services of location')
            ],
            'mUYourCityModuleAbonnements' => [
                'value' => 'abonnement',
                'label' => $this->__('Abonnements')
            ]
        ];
    
        $allowedTypes = $this->controllerHelper->getObjectTypes('helper', ['helper' => 'search', 'action' => 'getSearchTypes']);
        $allowedSearchTypes = [];
        foreach ($searchTypes as $searchType => $typeInfo) {
            if (!in_array($typeInfo['value'], $allowedTypes)) {
                continue;
            }
            $allowedSearchTypes[$searchType] = $typeInfo;
        }
    
        return $allowedSearchTypes;
    }
    
    /**
     * @inheritDoc
     */
    public function getErrors()
    {
        return [];
    }
    
    /**
     * Construct a QueryBuilder Where orX|andX Expr instance.
     *
     * @param QueryBuilder $qb
     * @param array $words the words to query for
     * @param array $fields
     * @param string $searchtype AND|OR|EXACT
     *
     * @return null|Composite
     */
    protected function formatWhere(QueryBuilder $qb, array $words, array $fields, $searchtype = 'AND')
    {
        if (empty($words) || empty($fields)) {
            return null;
        }
    
        $method = ($searchtype == 'OR') ? 'orX' : 'andX';
        /** @var $where Composite */
        $where = $qb->expr()->$method();
        $i = 1;
        foreach ($words as $word) {
            $subWhere = $qb->expr()->orX();
            foreach ($fields as $field) {
                $expr = $qb->expr()->like($field, "?$i");
                $subWhere->add($expr);
                $qb->setParameter($i, '%' . $word . '%');
                $i++;
            }
            $where->add($subWhere);
        }
    
        return $where;
    }
}
