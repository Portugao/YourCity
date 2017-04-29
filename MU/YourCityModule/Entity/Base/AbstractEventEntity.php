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

namespace MU\YourCityModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\Core\Doctrine\EntityAccess;
use MU\YourCityModule\Traits\EntityWorkflowTrait;
use MU\YourCityModule\Traits\GeographicalTrait;
use MU\YourCityModule\Traits\StandardFieldsTrait;
use MU\YourCityModule\Validator\Constraints as YourCityAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for event entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractEventEntity extends EntityAccess implements Translatable
{
    /**
     * Hook entity workflow field and behaviour.
     */
    use EntityWorkflowTrait;

    /**
     * Hook geographical behaviour embedding latitude and longitude fields.
     */
    use GeographicalTrait;

    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'event';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     * @var integer $id
     */
    protected $id = 0;
    
    /**
     * the current workflow state
     * @ORM\Column(length=20)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="event", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="100")
     * @var string $name
     */
    protected $name = '';
    
    /**
     * Maximum 2000 characters.
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=2000, nullable=true)
     * @Assert\Length(min="0", max="2000")
     * @var text $description
     */
    protected $description = '';
    
    /**
     * Image of event meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageOfEventMeta
     */
    protected $imageOfEventMeta = [];
    
    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $imageOfEvent
     */
    protected $imageOfEvent = null;
    
    /**
     * Full image of event path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageOfEventUrl
     */
    protected $imageOfEventUrl = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="255")
     * @var string $street
     */
    protected $street = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="255")
     * @var string $numberOfStreet
     */
    protected $numberOfStreet = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @var string $zipCode
     */
    protected $zipCode = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @var string $city
     */
    protected $city = '';
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @var DateTime $startDate
     */
    protected $startDate;
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @var DateTime $endDate
     */
    protected $endDate;
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     * @var DateTime $start2Date
     */
    protected $start2Date;
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     * @var DateTime $end2Date
     */
    protected $end2Date;
    
    
    /**
     * Used locale to override Translation listener's locale.
     * this is not a mapped field of entity metadata, just a simple property.
     *
     * @Assert\Locale()
     * @Gedmo\Locale
     * @var string $locale
     */
    protected $locale;
    
    /**
     * @ORM\OneToMany(targetEntity="\MU\YourCityModule\Entity\EventCategoryEntity", 
     *                mappedBy="entity", cascade={"all"}, 
     *                orphanRemoval=true)
     * @var \MU\YourCityModule\Entity\EventCategoryEntity
     */
    protected $categories = null;
    
    /**
     * Bidirectional - Many events [events] are linked by one location [location] (OWNING SIDE).
     *
     * @ORM\ManyToOne(targetEntity="MU\YourCityModule\Entity\LocationEntity", inversedBy="events")
     * @ORM\JoinTable(name="mu_yourcity_location")
     * @Assert\Type(type="MU\YourCityModule\Entity\LocationEntity")
     * @var \MU\YourCityModule\Entity\LocationEntity $location
     */
    protected $location;
    
    
    /**
     * EventEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->initWorkflow();
        $this->categories = new ArrayCollection();
    }
    
    /**
     * Returns the _object type.
     *
     * @return string
     */
    public function get_objectType()
    {
        return $this->_objectType;
    }
    
    /**
     * Sets the _object type.
     *
     * @param string $_objectType
     *
     * @return void
     */
    public function set_objectType($_objectType)
    {
        if ($this->_objectType != $_objectType) {
            $this->_objectType = $_objectType;
        }
    }
    
    
    /**
     * Returns the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the id.
     *
     * @param integer $id
     *
     * @return void
     */
    public function setId($id)
    {
        if (intval($this->id) !== intval($id)) {
            $this->id = intval($id);
        }
    }
    
    /**
     * Returns the workflow state.
     *
     * @return string
     */
    public function getWorkflowState()
    {
        return $this->workflowState;
    }
    
    /**
     * Sets the workflow state.
     *
     * @param string $workflowState
     *
     * @return void
     */
    public function setWorkflowState($workflowState)
    {
        if ($this->workflowState !== $workflowState) {
            $this->workflowState = isset($workflowState) ? $workflowState : '';
        }
    }
    
    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        if ($this->name !== $name) {
            $this->name = isset($name) ? $name : '';
        }
    }
    
    /**
     * Returns the description.
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description.
     *
     * @param text $description
     *
     * @return void
     */
    public function setDescription($description)
    {
        if ($this->description !== $description) {
            $this->description = $description;
        }
    }
    
    /**
     * Returns the image of event.
     *
     * @return string
     */
    public function getImageOfEvent()
    {
        return $this->imageOfEvent;
    }
    
    /**
     * Sets the image of event.
     *
     * @param string $imageOfEvent
     *
     * @return void
     */
    public function setImageOfEvent($imageOfEvent)
    {
        if ($this->imageOfEvent !== $imageOfEvent) {
            $this->imageOfEvent = $imageOfEvent;
        }
    }
    
    /**
     * Returns the image of event url.
     *
     * @return string
     */
    public function getImageOfEventUrl()
    {
        return $this->imageOfEventUrl;
    }
    
    /**
     * Sets the image of event url.
     *
     * @param string $imageOfEventUrl
     *
     * @return void
     */
    public function setImageOfEventUrl($imageOfEventUrl)
    {
        if ($this->imageOfEventUrl !== $imageOfEventUrl) {
            $this->imageOfEventUrl = $imageOfEventUrl;
        }
    }
    
    /**
     * Returns the image of event meta.
     *
     * @return array
     */
    public function getImageOfEventMeta()
    {
        return $this->imageOfEventMeta;
    }
    
    /**
     * Sets the image of event meta.
     *
     * @param array $imageOfEventMeta
     *
     * @return void
     */
    public function setImageOfEventMeta($imageOfEventMeta = [])
    {
        if ($this->imageOfEventMeta !== $imageOfEventMeta) {
            $this->imageOfEventMeta = $imageOfEventMeta;
        }
    }
    
    /**
     * Returns the street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }
    
    /**
     * Sets the street.
     *
     * @param string $street
     *
     * @return void
     */
    public function setStreet($street)
    {
        if ($this->street !== $street) {
            $this->street = isset($street) ? $street : '';
        }
    }
    
    /**
     * Returns the number of street.
     *
     * @return string
     */
    public function getNumberOfStreet()
    {
        return $this->numberOfStreet;
    }
    
    /**
     * Sets the number of street.
     *
     * @param string $numberOfStreet
     *
     * @return void
     */
    public function setNumberOfStreet($numberOfStreet)
    {
        if ($this->numberOfStreet !== $numberOfStreet) {
            $this->numberOfStreet = isset($numberOfStreet) ? $numberOfStreet : '';
        }
    }
    
    /**
     * Returns the zip code.
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    /**
     * Sets the zip code.
     *
     * @param string $zipCode
     *
     * @return void
     */
    public function setZipCode($zipCode)
    {
        if ($this->zipCode !== $zipCode) {
            $this->zipCode = isset($zipCode) ? $zipCode : '';
        }
    }
    
    /**
     * Returns the city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Sets the city.
     *
     * @param string $city
     *
     * @return void
     */
    public function setCity($city)
    {
        if ($this->city !== $city) {
            $this->city = isset($city) ? $city : '';
        }
    }
    
    /**
     * Returns the start date.
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    /**
     * Sets the start date.
     *
     * @param DateTime $startDate
     *
     * @return void
     */
    public function setStartDate($startDate)
    {
        if ($this->startDate !== $startDate) {
            if (is_object($startDate) && $startDate instanceOf \DateTime) {
                $this->startDate = $startDate;
            } else {
                $this->startDate = new \DateTime($startDate);
            }
        }
    }
    
    /**
     * Returns the end date.
     *
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * Sets the end date.
     *
     * @param DateTime $endDate
     *
     * @return void
     */
    public function setEndDate($endDate)
    {
        if ($this->endDate !== $endDate) {
            if (is_object($endDate) && $endDate instanceOf \DateTime) {
                $this->endDate = $endDate;
            } else {
                $this->endDate = new \DateTime($endDate);
            }
        }
    }
    
    /**
     * Returns the start 2 date.
     *
     * @return DateTime
     */
    public function getStart2Date()
    {
        return $this->start2Date;
    }
    
    /**
     * Sets the start 2 date.
     *
     * @param DateTime $start2Date
     *
     * @return void
     */
    public function setStart2Date($start2Date)
    {
        if ($this->start2Date !== $start2Date) {
            if (is_object($start2Date) && $start2Date instanceOf \DateTime) {
                $this->start2Date = $start2Date;
            } else {
                $this->start2Date = new \DateTime($start2Date);
            }
        }
    }
    
    /**
     * Returns the end 2 date.
     *
     * @return DateTime
     */
    public function getEnd2Date()
    {
        return $this->end2Date;
    }
    
    /**
     * Sets the end 2 date.
     *
     * @param DateTime $end2Date
     *
     * @return void
     */
    public function setEnd2Date($end2Date)
    {
        if ($this->end2Date !== $end2Date) {
            if (is_object($end2Date) && $end2Date instanceOf \DateTime) {
                $this->end2Date = $end2Date;
            } else {
                $this->end2Date = new \DateTime($end2Date);
            }
        }
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Sets the locale.
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        if ($this->locale != $locale) {
            $this->locale = $locale;
        }
    }
    
    /**
     * Returns the categories.
     *
     * @return ArrayCollection[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    
    /**
     * Sets the categories.
     *
     * @param ArrayCollection $categories
     *
     * @return void
     */
    public function setCategories(ArrayCollection $categories)
    {
        foreach ($this->categories as $category) {
            if (false === $key = $this->collectionContains($categories, $category)) {
                $this->categories->removeElement($category);
            } else {
                $categories->remove($key);
            }
        }
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }
    
    /**
     * Checks if a collection contains an element based only on two criteria (categoryRegistryId, category).
     *
     * @param ArrayCollection $collection
     * @param \MU\YourCityModule\Entity\EventCategoryEntity $element
     *
     * @return bool|int
     */
    private function collectionContains(ArrayCollection $collection, \MU\YourCityModule\Entity\EventCategoryEntity $element)
    {
        foreach ($collection as $key => $category) {
            /** @var \MU\YourCityModule\Entity\EventCategoryEntity $category */
            if ($category->getCategoryRegistryId() == $element->getCategoryRegistryId()
                && $category->getCategory() == $element->getCategory()
            ) {
                return $key;
            }
        }
    
        return false;
    }
    
    /**
     * Returns the location.
     *
     * @return \MU\YourCityModule\Entity\LocationEntity
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * Sets the location.
     *
     * @param \MU\YourCityModule\Entity\LocationEntity $location
     *
     * @return void
     */
    public function setLocation($location = null)
    {
        $this->location = $location;
    }
    
    
    
    /**
     * Return entity data in JSON format.
     *
     * @return string JSON-encoded data
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
    
    /**
     * Creates url arguments array for easy creation of display urls.
     *
     * @return array The resulting arguments list
     */
    public function createUrlArgs()
    {
        $args = [];
    
        $args['id'] = $this['id'];
    
        if (property_exists($this, 'slug')) {
            $args['slug'] = $this['slug'];
        }
    
        return $args;
    }
    
    /**
     * Create concatenated identifier string (for composite keys).
     *
     * @return String concatenated identifiers
     */
    public function createCompositeIdentifier()
    {
        $itemId = $this['id'];
    
        return $itemId;
    }
    
    /**
     * Determines whether this entity supports hook subscribers or not.
     *
     * @return boolean
     */
    public function supportsHookSubscribers()
    {
        return true;
    }
    
    /**
     * Return lower case name of multiple items needed for hook areas.
     *
     * @return string
     */
    public function getHookAreaPrefix()
    {
        return 'muyourcitymodule.ui_hooks.events';
    }
    
    /**
     * Returns an array of all related objects that need to be persisted after clone.
     * 
     * @param array $objects The objects are added to this array. Default: []
     * 
     * @return array of entity objects
     */
    public function getRelatedObjectsToPersist(&$objects = []) 
    {
        return [];
    }
    
    /**
     * ToString interceptor implementation.
     * This method is useful for debugging purposes.
     *
     * @return string The output string for this entity
     */
    public function __toString()
    {
        return 'Event ' . $this->createCompositeIdentifier() . ': ' . $this->getName();
    }
    
    /**
     * Clone interceptor implementation.
     * This method is for example called by the reuse functionality.
     * Performs a quite simple shallow copy.
     *
     * See also:
     * (1) http://docs.doctrine-project.org/en/latest/cookbook/implementing-wakeup-or-clone.html
     * (2) http://www.php.net/manual/en/language.oop5.cloning.php
     * (3) http://stackoverflow.com/questions/185934/how-do-i-create-a-copy-of-an-object-in-php
     */
    public function __clone()
    {
        // if the entity has no identity do nothing, do NOT throw an exception
        if (!($this->id)) {
            return;
        }
    
        // otherwise proceed
    
        // unset identifiers
        $this->setId(0);
    
        // reset workflow
        $this->resetWorkflow();
    
        // reset upload fields
        $this->setImageOfEvent(null);
        $this->setImageOfEventMeta([]);
        $this->setImageOfEventUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    
        // clone categories
        $categories = $this->categories;
        $this->categories = new ArrayCollection();
        foreach ($categories as $c) {
            $newCat = clone $c;
            $this->categories->add($newCat);
            $newCat->setEntity($this);
        }
    }
}
