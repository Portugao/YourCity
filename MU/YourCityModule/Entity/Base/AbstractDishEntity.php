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
 * This is the base entity class for dish entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractDishEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'dish';
    
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
     * @YourCityAssert\ListEntry(entityName="dish", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
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
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="dish", propertyName="kindOfDish", multiple=true)
     * @var string $kindOfDish
     */
    protected $kindOfDish = 'other';
    
    /**
     * Image of dish meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageOfDishMeta
     */
    protected $imageOfDishMeta = [];
    
    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $imageOfDish
     */
    protected $imageOfDish = null;
    
    /**
     * Full image of dish path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageOfDishUrl
     */
    protected $imageOfDishUrl = '';
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Type(type="numeric")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=10000000000)
     * @var decimal $priceOfDish
     */
    protected $priceOfDish = 0.00;
    
    /**
     * Enter the numbers of ingredients, that you entered in the additional remarks of your menu!
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @var string $ingredients
     */
    protected $ingredients = '';
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var integer $positionOfDish
     */
    protected $positionOfDish = 0;
    
    /**
     * If you have more than one location, select the correct one!
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="dish", propertyName="myLocation", multiple=false)
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
     * DishEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
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
     * Returns the kind of dish.
     *
     * @return string
     */
    public function getKindOfDish()
    {
        return $this->kindOfDish;
    }
    
    /**
     * Sets the kind of dish.
     *
     * @param string $kindOfDish
     *
     * @return void
     */
    public function setKindOfDish($kindOfDish)
    {
        if ($this->kindOfDish !== $kindOfDish) {
            $this->kindOfDish = isset($kindOfDish) ? $kindOfDish : '';
        }
    }
    
    /**
     * Returns the image of dish.
     *
     * @return string
     */
    public function getImageOfDish()
    {
        return $this->imageOfDish;
    }
    
    /**
     * Sets the image of dish.
     *
     * @param string $imageOfDish
     *
     * @return void
     */
    public function setImageOfDish($imageOfDish)
    {
        if ($this->imageOfDish !== $imageOfDish) {
            $this->imageOfDish = $imageOfDish;
        }
    }
    
    /**
     * Returns the image of dish url.
     *
     * @return string
     */
    public function getImageOfDishUrl()
    {
        return $this->imageOfDishUrl;
    }
    
    /**
     * Sets the image of dish url.
     *
     * @param string $imageOfDishUrl
     *
     * @return void
     */
    public function setImageOfDishUrl($imageOfDishUrl)
    {
        if ($this->imageOfDishUrl !== $imageOfDishUrl) {
            $this->imageOfDishUrl = $imageOfDishUrl;
        }
    }
    
    /**
     * Returns the image of dish meta.
     *
     * @return array
     */
    public function getImageOfDishMeta()
    {
        return $this->imageOfDishMeta;
    }
    
    /**
     * Sets the image of dish meta.
     *
     * @param array $imageOfDishMeta
     *
     * @return void
     */
    public function setImageOfDishMeta($imageOfDishMeta = [])
    {
        if ($this->imageOfDishMeta !== $imageOfDishMeta) {
            $this->imageOfDishMeta = $imageOfDishMeta;
        }
    }
    
    /**
     * Returns the price of dish.
     *
     * @return decimal
     */
    public function getPriceOfDish()
    {
        return $this->priceOfDish;
    }
    
    /**
     * Sets the price of dish.
     *
     * @param decimal $priceOfDish
     *
     * @return void
     */
    public function setPriceOfDish($priceOfDish)
    {
        if (floatval($this->priceOfDish) !== floatval($priceOfDish)) {
            $this->priceOfDish = floatval($priceOfDish);
        }
    }
    
    /**
     * Returns the ingredients.
     *
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
    
    /**
     * Sets the ingredients.
     *
     * @param string $ingredients
     *
     * @return void
     */
    public function setIngredients($ingredients)
    {
        if ($this->ingredients !== $ingredients) {
            $this->ingredients = $ingredients;
        }
    }
    
    /**
     * Returns the position of dish.
     *
     * @return integer
     */
    public function getPositionOfDish()
    {
        return $this->positionOfDish;
    }
    
    /**
     * Sets the position of dish.
     *
     * @param integer $positionOfDish
     *
     * @return void
     */
    public function setPositionOfDish($positionOfDish)
    {
        if (intval($this->positionOfDish) !== intval($positionOfDish)) {
            $this->positionOfDish = intval($positionOfDish);
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
        return 'muyourcitymodule.ui_hooks.dishes';
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
        return 'Dish ' . $this->getKey() . ': ' . $this->getName();
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
        $this->setImageOfDish(null);
        $this->setImageOfDishMeta([]);
        $this->setImageOfDishUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}
