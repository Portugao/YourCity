<?php
/**
 * YourCity.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
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
use MU\YourCityModule\Traits\StandardFieldsTrait;
use MU\YourCityModule\Validator\Constraints as YourCityAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for menu of location entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractMenuOfLocationEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'menuOfLocation';
    
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
     * @YourCityAssert\ListEntry(entityName="menuOfLocation", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * For example evening menu.
     Maximum 100 characters, better ony 57 characters.
     Please do not enter your location name. It will get added automaticly.
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
     * Image of menu meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageOfMenuMeta
     */
    protected $imageOfMenuMeta = [];
    
    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $imageOfMenu
     */
    protected $imageOfMenu = null;
    
    /**
     * Full image of menu path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageOfMenuUrl
     */
    protected $imageOfMenuUrl = '';
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var integer $positionOfMenu
     */
    protected $positionOfMenu = 0;
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="menuOfLocation", propertyName="kindOfMenu", multiple=false)
     * @var string $kindOfMenu
     */
    protected $kindOfMenu = '1';
    
    /**
     * Here you can enter additional informations.
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=2000, nullable=true)
     * @Assert\Length(min="0", max="2000")
     * @var text $additionalRemarks
     */
    protected $additionalRemarks = '';
    
    /**
     * Here you can create complete menus for your location and special mnus like the menu of the day and more.
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @var DateTime $effectivFrom
     */
    protected $effectivFrom;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @var DateTime $effectivUntil
     */
    protected $effectivUntil;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @var DateTime $inViewFrom
     */
    protected $inViewFrom;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @Assert\Expression("!value or value > this.getInViewFrom()")
     * @var DateTime $inViewUntil
     */
    protected $inViewUntil;
    
    /**
     * If you have more than one location, select the correct one!
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="menuOfLocation", propertyName="myLocation", multiple=false)
     * @var string $myLocation
     */
    protected $myLocation = '';
    
    
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
     * Bidirectional - Many menusOfLocation [menus of location] have many dishes [dishes] (OWNING SIDE).
     *
     * @ORM\ManyToMany(targetEntity="MU\YourCityModule\Entity\DishEntity", inversedBy="menusOfLocation")
     * @ORM\JoinTable(name="mu_yourcity_menuoflocation_dish")
     * @ORM\OrderBy({"positionOfDish" = "ASC"})
     * @var \MU\YourCityModule\Entity\DishEntity[] $dishes
     */
    protected $dishes = null;
    /**
     * Bidirectional - Many menusOfLocation [menus of location] have many partsOfMenu [parts of menu] (OWNING SIDE).
     *
     * @ORM\ManyToMany(targetEntity="MU\YourCityModule\Entity\PartOfMenuEntity", inversedBy="menusOfLocation")
     * @ORM\JoinTable(name="mu_yourcity_menuoflocation_partofmenu")
     * @ORM\OrderBy({"positionOfPart" = "ASC"})
     * @var \MU\YourCityModule\Entity\PartOfMenuEntity[] $partsOfMenu
     */
    protected $partsOfMenu = null;
    
    /**
     * MenuOfLocationEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->dishes = new ArrayCollection();
        $this->partsOfMenu = new ArrayCollection();
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
     * Returns the image of menu.
     *
     * @return string
     */
    public function getImageOfMenu()
    {
        return $this->imageOfMenu;
    }
    
    /**
     * Sets the image of menu.
     *
     * @param string $imageOfMenu
     *
     * @return void
     */
    public function setImageOfMenu($imageOfMenu)
    {
        if ($this->imageOfMenu !== $imageOfMenu) {
            $this->imageOfMenu = $imageOfMenu;
        }
    }
    
    /**
     * Returns the image of menu url.
     *
     * @return string
     */
    public function getImageOfMenuUrl()
    {
        return $this->imageOfMenuUrl;
    }
    
    /**
     * Sets the image of menu url.
     *
     * @param string $imageOfMenuUrl
     *
     * @return void
     */
    public function setImageOfMenuUrl($imageOfMenuUrl)
    {
        if ($this->imageOfMenuUrl !== $imageOfMenuUrl) {
            $this->imageOfMenuUrl = $imageOfMenuUrl;
        }
    }
    
    /**
     * Returns the image of menu meta.
     *
     * @return array
     */
    public function getImageOfMenuMeta()
    {
        return $this->imageOfMenuMeta;
    }
    
    /**
     * Sets the image of menu meta.
     *
     * @param array $imageOfMenuMeta
     *
     * @return void
     */
    public function setImageOfMenuMeta($imageOfMenuMeta = [])
    {
        if ($this->imageOfMenuMeta !== $imageOfMenuMeta) {
            $this->imageOfMenuMeta = $imageOfMenuMeta;
        }
    }
    
    /**
     * Returns the position of menu.
     *
     * @return integer
     */
    public function getPositionOfMenu()
    {
        return $this->positionOfMenu;
    }
    
    /**
     * Sets the position of menu.
     *
     * @param integer $positionOfMenu
     *
     * @return void
     */
    public function setPositionOfMenu($positionOfMenu)
    {
        if (intval($this->positionOfMenu) !== intval($positionOfMenu)) {
            $this->positionOfMenu = intval($positionOfMenu);
        }
    }
    
    /**
     * Returns the kind of menu.
     *
     * @return string
     */
    public function getKindOfMenu()
    {
        return $this->kindOfMenu;
    }
    
    /**
     * Sets the kind of menu.
     *
     * @param string $kindOfMenu
     *
     * @return void
     */
    public function setKindOfMenu($kindOfMenu)
    {
        if ($this->kindOfMenu !== $kindOfMenu) {
            $this->kindOfMenu = isset($kindOfMenu) ? $kindOfMenu : '';
        }
    }
    
    /**
     * Returns the additional remarks.
     *
     * @return text
     */
    public function getAdditionalRemarks()
    {
        return $this->additionalRemarks;
    }
    
    /**
     * Sets the additional remarks.
     *
     * @param text $additionalRemarks
     *
     * @return void
     */
    public function setAdditionalRemarks($additionalRemarks)
    {
        if ($this->additionalRemarks !== $additionalRemarks) {
            $this->additionalRemarks = $additionalRemarks;
        }
    }
    
    /**
     * Returns the effectiv from.
     *
     * @return DateTime
     */
    public function getEffectivFrom()
    {
        return $this->effectivFrom;
    }
    
    /**
     * Sets the effectiv from.
     *
     * @param DateTime $effectivFrom
     *
     * @return void
     */
    public function setEffectivFrom($effectivFrom)
    {
        if ($this->effectivFrom !== $effectivFrom) {
            if (is_object($effectivFrom) && $effectivFrom instanceOf \DateTime) {
                $this->effectivFrom = $effectivFrom;
            } elseif (null === $effectivFrom || empty($effectivFrom)) {
                $this->effectivFrom = null;
            } else {
                $this->effectivFrom = new \DateTime($effectivFrom);
            }
        }
    }
    
    /**
     * Returns the effectiv until.
     *
     * @return DateTime
     */
    public function getEffectivUntil()
    {
        return $this->effectivUntil;
    }
    
    /**
     * Sets the effectiv until.
     *
     * @param DateTime $effectivUntil
     *
     * @return void
     */
    public function setEffectivUntil($effectivUntil)
    {
        if ($this->effectivUntil !== $effectivUntil) {
            if (is_object($effectivUntil) && $effectivUntil instanceOf \DateTime) {
                $this->effectivUntil = $effectivUntil;
            } elseif (null === $effectivUntil || empty($effectivUntil)) {
                $this->effectivUntil = null;
            } else {
                $this->effectivUntil = new \DateTime($effectivUntil);
            }
        }
    }
    
    /**
     * Returns the in view from.
     *
     * @return DateTime
     */
    public function getInViewFrom()
    {
        return $this->inViewFrom;
    }
    
    /**
     * Sets the in view from.
     *
     * @param DateTime $inViewFrom
     *
     * @return void
     */
    public function setInViewFrom($inViewFrom)
    {
        if ($this->inViewFrom !== $inViewFrom) {
            if (is_object($inViewFrom) && $inViewFrom instanceOf \DateTime) {
                $this->inViewFrom = $inViewFrom;
            } elseif (null === $inViewFrom || empty($inViewFrom)) {
                $this->inViewFrom = null;
            } else {
                $this->inViewFrom = new \DateTime($inViewFrom);
            }
        }
    }
    
    /**
     * Returns the in view until.
     *
     * @return DateTime
     */
    public function getInViewUntil()
    {
        return $this->inViewUntil;
    }
    
    /**
     * Sets the in view until.
     *
     * @param DateTime $inViewUntil
     *
     * @return void
     */
    public function setInViewUntil($inViewUntil)
    {
        if ($this->inViewUntil !== $inViewUntil) {
            if (is_object($inViewUntil) && $inViewUntil instanceOf \DateTime) {
                $this->inViewUntil = $inViewUntil;
            } elseif (null === $inViewUntil || empty($inViewUntil)) {
                $this->inViewUntil = null;
            } else {
                $this->inViewUntil = new \DateTime($inViewUntil);
            }
        }
    }
    
    /**
     * Returns the my location.
     *
     * @return string
     */
    public function getMyLocation()
    {
        return $this->myLocation;
    }
    
    /**
     * Sets the my location.
     *
     * @param string $myLocation
     *
     * @return void
     */
    public function setMyLocation($myLocation)
    {
        if ($this->myLocation !== $myLocation) {
            $this->myLocation = isset($myLocation) ? $myLocation : '';
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
     * Returns the dishes.
     *
     * @return \MU\YourCityModule\Entity\DishEntity[]
     */
    public function getDishes()
    {
        return $this->dishes;
    }
    
    /**
     * Sets the dishes.
     *
     * @param \MU\YourCityModule\Entity\DishEntity[] $dishes
     *
     * @return void
     */
    public function setDishes($dishes)
    {
        foreach ($this->dishes as $dishSingle) {
            $this->removeDishes($dishSingle);
        }
        foreach ($dishes as $dishSingle) {
            $this->addDishes($dishSingle);
        }
    }
    
    /**
     * Adds an instance of \MU\YourCityModule\Entity\DishEntity to the list of dishes.
     *
     * @param \MU\YourCityModule\Entity\DishEntity $dish The instance to be added to the collection
     *
     * @return void
     */
    public function addDishes(\MU\YourCityModule\Entity\DishEntity $dish)
    {
        $this->dishes->add($dish);
    }
    
    /**
     * Removes an instance of \MU\YourCityModule\Entity\DishEntity from the list of dishes.
     *
     * @param \MU\YourCityModule\Entity\DishEntity $dish The instance to be removed from the collection
     *
     * @return void
     */
    public function removeDishes(\MU\YourCityModule\Entity\DishEntity $dish)
    {
        $this->dishes->removeElement($dish);
    }
    
    /**
     * Returns the parts of menu.
     *
     * @return \MU\YourCityModule\Entity\PartOfMenuEntity[]
     */
    public function getPartsOfMenu()
    {
        return $this->partsOfMenu;
    }
    
    /**
     * Sets the parts of menu.
     *
     * @param \MU\YourCityModule\Entity\PartOfMenuEntity[] $partsOfMenu
     *
     * @return void
     */
    public function setPartsOfMenu($partsOfMenu)
    {
        foreach ($this->partsOfMenu as $partOfMenuSingle) {
            $this->removePartsOfMenu($partOfMenuSingle);
        }
        foreach ($partsOfMenu as $partOfMenuSingle) {
            $this->addPartsOfMenu($partOfMenuSingle);
        }
    }
    
    /**
     * Adds an instance of \MU\YourCityModule\Entity\PartOfMenuEntity to the list of parts of menu.
     *
     * @param \MU\YourCityModule\Entity\PartOfMenuEntity $partOfMenu The instance to be added to the collection
     *
     * @return void
     */
    public function addPartsOfMenu(\MU\YourCityModule\Entity\PartOfMenuEntity $partOfMenu)
    {
        $this->partsOfMenu->add($partOfMenu);
    }
    
    /**
     * Removes an instance of \MU\YourCityModule\Entity\PartOfMenuEntity from the list of parts of menu.
     *
     * @param \MU\YourCityModule\Entity\PartOfMenuEntity $partOfMenu The instance to be removed from the collection
     *
     * @return void
     */
    public function removePartsOfMenu(\MU\YourCityModule\Entity\PartOfMenuEntity $partOfMenu)
    {
        $this->partsOfMenu->removeElement($partOfMenu);
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
        return [
            'id' => $this->getId()
        ];
    }
    
    /**
     * Returns the primary key.
     *
     * @return integer The identifier
     */
    public function getKey()
    {
        return $this->getId();
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
        return 'muyourcitymodule.ui_hooks.menusoflocation';
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
        return 'Menu of location ' . $this->getKey() . ': ' . $this->getName();
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
        if (!$this->id) {
            return;
        }
    
        // otherwise proceed
    
        // unset identifier
        $this->setId(0);
    
        // reset workflow
        $this->setWorkflowState('initial');
    
        // reset upload fields
        $this->setImageOfMenu(null);
        $this->setImageOfMenuMeta([]);
        $this->setImageOfMenuUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}
