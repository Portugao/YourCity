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
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\Core\Doctrine\EntityAccess;
use MU\YourCityModule\Traits\EntityWorkflowTrait;
use MU\YourCityModule\Traits\StandardFieldsTrait;
use MU\YourCityModule\Validator\Constraints as YourCityAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for offer entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractOfferEntity extends EntityAccess implements Translatable
{
    /**
     * Hook entity workflow field and behaviour.
     */
    use EntityWorkflowTrait;

    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'offer';
    
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
     * @YourCityAssert\ListEntry(entityName="offer", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * Only 100 characters; better only 57.
     * @Gedmo\Translatable
     * @ORM\Column(length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="100")
     * @var string $name
     */
    protected $name = '';
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=4000, nullable=true)
     * @Assert\Length(min="0", max="4000")
     * @var text $text
     */
    protected $text = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="255")
     * @Assert\Url(checkDNS=false)
     * @var string $urlToOfferOnHomepage
     */
    protected $urlToOfferOnHomepage = '';
    
    /**
     * Image of offer meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageOfOfferMeta
     */
    protected $imageOfOfferMeta = [];
    
    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $imageOfOffer
     */
    protected $imageOfOffer = null;
    
    /**
     * Full image of offer path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageOfOfferUrl
     */
    protected $imageOfOfferUrl = '';
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Type(type="numeric")
     * @Assert\NotNull()
     * @Assert\LessThan(value=10000000000)
     * @var decimal $priceOfOffer
     */
    protected $priceOfOffer = 0.00;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Type(type="numeric")
     * @Assert\NotNull()
     * @Assert\LessThan(value=10000000000)
     * @var decimal $normalPrice
     */
    protected $normalPrice = 0.00;
    
    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Type(type="integer")
     * @Assert\LessThan(value=1000)
     * @var integer $percentOfOffer
     */
    protected $percentOfOffer = 0;
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @var DateTime $effectivFrom
     */
    protected $effectivFrom;
    
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @var DateTime $effectivUntil
     */
    protected $effectivUntil;
    
    /**
     * On this date the offer will get put into the archive.
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @var DateTime $enddate
     */
    protected $enddate;
    
    
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
     * Bidirectional - Many offers [offers] are linked by one location [location] (OWNING SIDE).
     *
     * @ORM\ManyToOne(targetEntity="MU\YourCityModule\Entity\LocationEntity", inversedBy="offers")
     * @ORM\JoinTable(name="mu_yourcity_location")
     * @Assert\Type(type="MU\YourCityModule\Entity\LocationEntity")
     * @var \MU\YourCityModule\Entity\LocationEntity $location
     */
    protected $location;
    
    
    /**
     * OfferEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->initWorkflow();
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
     * Returns the text.
     *
     * @return text
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Sets the text.
     *
     * @param text $text
     *
     * @return void
     */
    public function setText($text)
    {
        if ($this->text !== $text) {
            $this->text = $text;
        }
    }
    
    /**
     * Returns the url to offer on homepage.
     *
     * @return string
     */
    public function getUrlToOfferOnHomepage()
    {
        return $this->urlToOfferOnHomepage;
    }
    
    /**
     * Sets the url to offer on homepage.
     *
     * @param string $urlToOfferOnHomepage
     *
     * @return void
     */
    public function setUrlToOfferOnHomepage($urlToOfferOnHomepage)
    {
        if ($this->urlToOfferOnHomepage !== $urlToOfferOnHomepage) {
            $this->urlToOfferOnHomepage = isset($urlToOfferOnHomepage) ? $urlToOfferOnHomepage : '';
        }
    }
    
    /**
     * Returns the image of offer.
     *
     * @return string
     */
    public function getImageOfOffer()
    {
        return $this->imageOfOffer;
    }
    
    /**
     * Sets the image of offer.
     *
     * @param string $imageOfOffer
     *
     * @return void
     */
    public function setImageOfOffer($imageOfOffer)
    {
        if ($this->imageOfOffer !== $imageOfOffer) {
            $this->imageOfOffer = $imageOfOffer;
        }
    }
    
    /**
     * Returns the image of offer url.
     *
     * @return string
     */
    public function getImageOfOfferUrl()
    {
        return $this->imageOfOfferUrl;
    }
    
    /**
     * Sets the image of offer url.
     *
     * @param string $imageOfOfferUrl
     *
     * @return void
     */
    public function setImageOfOfferUrl($imageOfOfferUrl)
    {
        if ($this->imageOfOfferUrl !== $imageOfOfferUrl) {
            $this->imageOfOfferUrl = $imageOfOfferUrl;
        }
    }
    
    /**
     * Returns the image of offer meta.
     *
     * @return array
     */
    public function getImageOfOfferMeta()
    {
        return $this->imageOfOfferMeta;
    }
    
    /**
     * Sets the image of offer meta.
     *
     * @param array $imageOfOfferMeta
     *
     * @return void
     */
    public function setImageOfOfferMeta($imageOfOfferMeta = [])
    {
        if ($this->imageOfOfferMeta !== $imageOfOfferMeta) {
            $this->imageOfOfferMeta = $imageOfOfferMeta;
        }
    }
    
    /**
     * Returns the price of offer.
     *
     * @return decimal
     */
    public function getPriceOfOffer()
    {
        return $this->priceOfOffer;
    }
    
    /**
     * Sets the price of offer.
     *
     * @param decimal $priceOfOffer
     *
     * @return void
     */
    public function setPriceOfOffer($priceOfOffer)
    {
        if (floatval($this->priceOfOffer) !== floatval($priceOfOffer)) {
            $this->priceOfOffer = floatval($priceOfOffer);
        }
    }
    
    /**
     * Returns the normal price.
     *
     * @return decimal
     */
    public function getNormalPrice()
    {
        return $this->normalPrice;
    }
    
    /**
     * Sets the normal price.
     *
     * @param decimal $normalPrice
     *
     * @return void
     */
    public function setNormalPrice($normalPrice)
    {
        if (floatval($this->normalPrice) !== floatval($normalPrice)) {
            $this->normalPrice = floatval($normalPrice);
        }
    }
    
    /**
     * Returns the percent of offer.
     *
     * @return integer
     */
    public function getPercentOfOffer()
    {
        return $this->percentOfOffer;
    }
    
    /**
     * Sets the percent of offer.
     *
     * @param integer $percentOfOffer
     *
     * @return void
     */
    public function setPercentOfOffer($percentOfOffer)
    {
        if (intval($this->percentOfOffer) !== intval($percentOfOffer)) {
            $this->percentOfOffer = intval($percentOfOffer);
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
            } else {
                $this->effectivUntil = new \DateTime($effectivUntil);
            }
        }
    }
    
    /**
     * Returns the enddate.
     *
     * @return DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }
    
    /**
     * Sets the enddate.
     *
     * @param DateTime $enddate
     *
     * @return void
     */
    public function setEnddate($enddate)
    {
        if ($this->enddate !== $enddate) {
            if (is_object($enddate) && $enddate instanceOf \DateTime) {
                $this->enddate = $enddate;
            } else {
                $this->enddate = new \DateTime($enddate);
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
        return 'muyourcitymodule.ui_hooks.offers';
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
        return 'Offer ' . $this->createCompositeIdentifier() . ': ' . $this->getName();
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
        $this->setImageOfOffer(null);
        $this->setImageOfOfferMeta([]);
        $this->setImageOfOfferUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}
