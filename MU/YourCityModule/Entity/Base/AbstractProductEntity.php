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
 * This is the base entity class for product entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractProductEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'product';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     * @Assert\Type(type="integer")
     * @Assert\NotNull()
     * @Assert\LessThan(value=1000000000)
     * @var integer $id
     */
    protected $id = 0;
    
    /**
     * the current workflow state
     * @ORM\Column(length=20)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="product", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * Maximum 100 characters, better only 57.
     * @Gedmo\Translatable
     * @ORM\Column(length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="100")
     * @var string $name
     */
    protected $name = '';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="255")
     * @var string $keywordsForProduct
     */
    protected $keywordsForProduct = '';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=2000, nullable=true)
     * @Assert\Length(min="0", max="2000")
     * @var text $description
     */
    protected $description = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="product", propertyName="kindOfProduct", multiple=true)
     * @var string $kindOfProduct
     */
    protected $kindOfProduct = 'other';
    
    /**
     * Image of product meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageOfProductMeta
     */
    protected $imageOfProductMeta = [];
    
    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    maxSize = "200k",
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $imageOfProduct
     */
    protected $imageOfProduct = null;
    
    /**
     * Full image of product path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageOfProductUrl
     */
    protected $imageOfProductUrl = '';
    
    /**
     * Enter, how often your product is available today. If you leave empty your customer will see, that there is no information for today.
     * @ORM\Column(length=255, nullable=true)
     * @YourCityAssert\ListEntry(entityName="product", propertyName="today", multiple=false)
     * @var string $today
     */
    protected $today = null;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $monday
     */
    protected $monday = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $tuesday
     */
    protected $tuesday = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $wednesday
     */
    protected $wednesday = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $thursday
     */
    protected $thursday = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $friday
     */
    protected $friday = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $saturday
     */
    protected $saturday = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @var boolean $sunday
     */
    protected $sunday = false;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Type(type="numeric")
     * @Assert\NotNull()
     * @Assert\LessThan(value=10000000000)
     * @var decimal $priceOfProduct
     */
    protected $priceOfProduct = 0.00;
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @YourCityAssert\ListEntry(entityName="product", propertyName="priceAdditional", multiple=false)
     * @var string $priceAdditional
     */
    protected $priceAdditional = '';
    
    /**
     * If you have more than one location, select the correct one!
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @YourCityAssert\ListEntry(entityName="product", propertyName="myLocation", multiple=false)
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
     * ProductEntity constructor.
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
     * Returns the keywords for product.
     *
     * @return string
     */
    public function getKeywordsForProduct()
    {
        return $this->keywordsForProduct;
    }
    
    /**
     * Sets the keywords for product.
     *
     * @param string $keywordsForProduct
     *
     * @return void
     */
    public function setKeywordsForProduct($keywordsForProduct)
    {
        if ($this->keywordsForProduct !== $keywordsForProduct) {
            $this->keywordsForProduct = isset($keywordsForProduct) ? $keywordsForProduct : '';
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
     * Returns the kind of product.
     *
     * @return string
     */
    public function getKindOfProduct()
    {
        return $this->kindOfProduct;
    }
    
    /**
     * Sets the kind of product.
     *
     * @param string $kindOfProduct
     *
     * @return void
     */
    public function setKindOfProduct($kindOfProduct)
    {
        if ($this->kindOfProduct !== $kindOfProduct) {
            $this->kindOfProduct = isset($kindOfProduct) ? $kindOfProduct : '';
        }
    }
    
    /**
     * Returns the image of product.
     *
     * @return string
     */
    public function getImageOfProduct()
    {
        return $this->imageOfProduct;
    }
    
    /**
     * Sets the image of product.
     *
     * @param string $imageOfProduct
     *
     * @return void
     */
    public function setImageOfProduct($imageOfProduct)
    {
        if ($this->imageOfProduct !== $imageOfProduct) {
            $this->imageOfProduct = $imageOfProduct;
        }
    }
    
    /**
     * Returns the image of product url.
     *
     * @return string
     */
    public function getImageOfProductUrl()
    {
        return $this->imageOfProductUrl;
    }
    
    /**
     * Sets the image of product url.
     *
     * @param string $imageOfProductUrl
     *
     * @return void
     */
    public function setImageOfProductUrl($imageOfProductUrl)
    {
        if ($this->imageOfProductUrl !== $imageOfProductUrl) {
            $this->imageOfProductUrl = $imageOfProductUrl;
        }
    }
    
    /**
     * Returns the image of product meta.
     *
     * @return array
     */
    public function getImageOfProductMeta()
    {
        return $this->imageOfProductMeta;
    }
    
    /**
     * Sets the image of product meta.
     *
     * @param array $imageOfProductMeta
     *
     * @return void
     */
    public function setImageOfProductMeta($imageOfProductMeta = [])
    {
        if ($this->imageOfProductMeta !== $imageOfProductMeta) {
            $this->imageOfProductMeta = $imageOfProductMeta;
        }
    }
    
    /**
     * Returns the today.
     *
     * @return string
     */
    public function getToday()
    {
        return $this->today;
    }
    
    /**
     * Sets the today.
     *
     * @param string $today
     *
     * @return void
     */
    public function setToday($today)
    {
        if ($this->today !== $today) {
            $this->today = $today;
        }
    }
    
    /**
     * Returns the monday.
     *
     * @return boolean
     */
    public function getMonday()
    {
        return $this->monday;
    }
    
    /**
     * Sets the monday.
     *
     * @param boolean $monday
     *
     * @return void
     */
    public function setMonday($monday)
    {
        if (boolval($this->monday) !== boolval($monday)) {
            $this->monday = boolval($monday);
        }
    }
    
    /**
     * Returns the tuesday.
     *
     * @return boolean
     */
    public function getTuesday()
    {
        return $this->tuesday;
    }
    
    /**
     * Sets the tuesday.
     *
     * @param boolean $tuesday
     *
     * @return void
     */
    public function setTuesday($tuesday)
    {
        if (boolval($this->tuesday) !== boolval($tuesday)) {
            $this->tuesday = boolval($tuesday);
        }
    }
    
    /**
     * Returns the wednesday.
     *
     * @return boolean
     */
    public function getWednesday()
    {
        return $this->wednesday;
    }
    
    /**
     * Sets the wednesday.
     *
     * @param boolean $wednesday
     *
     * @return void
     */
    public function setWednesday($wednesday)
    {
        if (boolval($this->wednesday) !== boolval($wednesday)) {
            $this->wednesday = boolval($wednesday);
        }
    }
    
    /**
     * Returns the thursday.
     *
     * @return boolean
     */
    public function getThursday()
    {
        return $this->thursday;
    }
    
    /**
     * Sets the thursday.
     *
     * @param boolean $thursday
     *
     * @return void
     */
    public function setThursday($thursday)
    {
        if (boolval($this->thursday) !== boolval($thursday)) {
            $this->thursday = boolval($thursday);
        }
    }
    
    /**
     * Returns the friday.
     *
     * @return boolean
     */
    public function getFriday()
    {
        return $this->friday;
    }
    
    /**
     * Sets the friday.
     *
     * @param boolean $friday
     *
     * @return void
     */
    public function setFriday($friday)
    {
        if (boolval($this->friday) !== boolval($friday)) {
            $this->friday = boolval($friday);
        }
    }
    
    /**
     * Returns the saturday.
     *
     * @return boolean
     */
    public function getSaturday()
    {
        return $this->saturday;
    }
    
    /**
     * Sets the saturday.
     *
     * @param boolean $saturday
     *
     * @return void
     */
    public function setSaturday($saturday)
    {
        if (boolval($this->saturday) !== boolval($saturday)) {
            $this->saturday = boolval($saturday);
        }
    }
    
    /**
     * Returns the sunday.
     *
     * @return boolean
     */
    public function getSunday()
    {
        return $this->sunday;
    }
    
    /**
     * Sets the sunday.
     *
     * @param boolean $sunday
     *
     * @return void
     */
    public function setSunday($sunday)
    {
        if (boolval($this->sunday) !== boolval($sunday)) {
            $this->sunday = boolval($sunday);
        }
    }
    
    /**
     * Returns the price of product.
     *
     * @return decimal
     */
    public function getPriceOfProduct()
    {
        return $this->priceOfProduct;
    }
    
    /**
     * Sets the price of product.
     *
     * @param decimal $priceOfProduct
     *
     * @return void
     */
    public function setPriceOfProduct($priceOfProduct)
    {
        if (floatval($this->priceOfProduct) !== floatval($priceOfProduct)) {
            $this->priceOfProduct = floatval($priceOfProduct);
        }
    }
    
    /**
     * Returns the price additional.
     *
     * @return string
     */
    public function getPriceAdditional()
    {
        return $this->priceAdditional;
    }
    
    /**
     * Sets the price additional.
     *
     * @param string $priceAdditional
     *
     * @return void
     */
    public function setPriceAdditional($priceAdditional)
    {
        if ($this->priceAdditional !== $priceAdditional) {
            $this->priceAdditional = isset($priceAdditional) ? $priceAdditional : '';
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
        return 'muyourcitymodule.ui_hooks.products';
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
        return 'Product ' . $this->getKey() . ': ' . $this->getName();
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
        $this->setImageOfProduct(null);
        $this->setImageOfProductMeta([]);
        $this->setImageOfProductUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}
