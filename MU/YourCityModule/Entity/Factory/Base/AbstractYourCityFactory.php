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

namespace MU\YourCityModule\Entity\Factory\Base;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;
use MU\YourCityModule\Entity\Factory\EntityInitialiser;

/**
 * Factory class used to create entities and receive entity repositories.
 */
abstract class AbstractYourCityFactory
{
    /**
     * @var ObjectManager The object manager to be used for determining the repository
     */
    protected $objectManager;

    /**
     * @var EntityInitialiser The entity initialiser for dynamical application of default values
     */
    protected $entityInitialiser;

    /**
     * YourCityFactory constructor.
     *
     * @param ObjectManager     $objectManager     The object manager to be used for determining the repositories
     * @param EntityInitialiser $entityInitialiser The entity initialiser for dynamical application of default values
     */
    public function __construct(ObjectManager $objectManager, EntityInitialiser $entityInitialiser)
    {
        $this->objectManager = $objectManager;
        $this->entityInitialiser = $entityInitialiser;
    }

    /**
     * Returns a repository for a given object type.
     *
     * @param string $objectType Name of desired entity type
     *
     * @return EntityRepository The repository responsible for the given object type
     */
    public function getRepository($objectType)
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\' . ucfirst($objectType) . 'Entity';

        return $this->objectManager->getRepository($entityClass);
    }

    /**
     * Creates a new branch instance.
     *
     * @return MU\YourCityModule\Entity\branchEntity The newly created entity instance
     */
    public function createBranch()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\BranchEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initBranch($entity);

        return $entity;
    }

    /**
     * Creates a new location instance.
     *
     * @return MU\YourCityModule\Entity\locationEntity The newly created entity instance
     */
    public function createLocation()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\LocationEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initLocation($entity);

        return $entity;
    }

    /**
     * Creates a new part instance.
     *
     * @return MU\YourCityModule\Entity\partEntity The newly created entity instance
     */
    public function createPart()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\PartEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initPart($entity);

        return $entity;
    }

    /**
     * Creates a new imageOfLocation instance.
     *
     * @return MU\YourCityModule\Entity\imageOfLocationEntity The newly created entity instance
     */
    public function createImageOfLocation()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\ImageOfLocationEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initImageOfLocation($entity);

        return $entity;
    }

    /**
     * Creates a new fileOfLocation instance.
     *
     * @return MU\YourCityModule\Entity\fileOfLocationEntity The newly created entity instance
     */
    public function createFileOfLocation()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\FileOfLocationEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initFileOfLocation($entity);

        return $entity;
    }

    /**
     * Creates a new offer instance.
     *
     * @return MU\YourCityModule\Entity\offerEntity The newly created entity instance
     */
    public function createOffer()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\OfferEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initOffer($entity);

        return $entity;
    }

    /**
     * Creates a new menuOfLocation instance.
     *
     * @return MU\YourCityModule\Entity\menuOfLocationEntity The newly created entity instance
     */
    public function createMenuOfLocation()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\MenuOfLocationEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initMenuOfLocation($entity);

        return $entity;
    }

    /**
     * Creates a new partOfMenu instance.
     *
     * @return MU\YourCityModule\Entity\partOfMenuEntity The newly created entity instance
     */
    public function createPartOfMenu()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\PartOfMenuEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initPartOfMenu($entity);

        return $entity;
    }

    /**
     * Creates a new dish instance.
     *
     * @return MU\YourCityModule\Entity\dishEntity The newly created entity instance
     */
    public function createDish()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\DishEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initDish($entity);

        return $entity;
    }

    /**
     * Creates a new event instance.
     *
     * @return MU\YourCityModule\Entity\eventEntity The newly created entity instance
     */
    public function createEvent()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\EventEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initEvent($entity);

        return $entity;
    }

    /**
     * Creates a new product instance.
     *
     * @return MU\YourCityModule\Entity\productEntity The newly created entity instance
     */
    public function createProduct()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\ProductEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initProduct($entity);

        return $entity;
    }

    /**
     * Creates a new specialOfLocation instance.
     *
     * @return MU\YourCityModule\Entity\specialOfLocationEntity The newly created entity instance
     */
    public function createSpecialOfLocation()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\SpecialOfLocationEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initSpecialOfLocation($entity);

        return $entity;
    }

    /**
     * Creates a new serviceofLocation instance.
     *
     * @return MU\YourCityModule\Entity\serviceofLocationEntity The newly created entity instance
     */
    public function createServiceofLocation()
    {
        $entityClass = 'MU\\YourCityModule\\Entity\\ServiceofLocationEntity';

        $entity = new $entityClass();

        $this->entityInitialiser->initServiceofLocation($entity);

        return $entity;
    }

    /**
     * Gets the list of identifier fields for a given object type.
     *
     * @param string $objectType The object type to be treated
     *
     * @return array List of identifier field names
     */
    public function getIdFields($objectType = '')
    {
        if (empty($objectType)) {
            throw new InvalidArgumentException('Invalid object type received.');
        }
        $entityClass = 'MUYourCityModule:' . ucfirst($objectType) . 'Entity';
    
        $meta = $this->getObjectManager()->getClassMetadata($entityClass);
    
        if ($this->hasCompositeKeys($objectType)) {
            $idFields = $meta->getIdentifierFieldNames();
        } else {
            $idFields = [$meta->getSingleIdentifierFieldName()];
        }
    
        return $idFields;
    }

    /**
     * Checks whether a certain entity type uses composite keys or not.
     *
     * @param string $objectType The object type to retrieve
     *
     * @return Boolean Whether composite keys are used or not
     */
    public function hasCompositeKeys($objectType)
    {
        return false;
    }

    /**
     * Returns the object manager.
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    
    /**
     * Sets the object manager.
     *
     * @param ObjectManager $objectManager
     *
     * @return void
     */
    public function setObjectManager($objectManager)
    {
        if ($this->objectManager != $objectManager) {
            $this->objectManager = $objectManager;
        }
    }
    

    /**
     * Returns the entity initialiser.
     *
     * @return EntityInitialiser
     */
    public function getEntityInitialiser()
    {
        return $this->entityInitialiser;
    }
    
    /**
     * Sets the entity initialiser.
     *
     * @param EntityInitialiser $entityInitialiser
     *
     * @return void
     */
    public function setEntityInitialiser($entityInitialiser)
    {
        if ($this->entityInitialiser != $entityInitialiser) {
            $this->entityInitialiser = $entityInitialiser;
        }
    }
    
}
