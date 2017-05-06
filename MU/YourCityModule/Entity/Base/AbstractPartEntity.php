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
use MU\YourCityModule\Traits\StandardFieldsTrait;
use MU\YourCityModule\Validator\Constraints as YourCityAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for part entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractPartEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'part';
    
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
     * @YourCityAssert\ListEntry(entityName="part", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @var string $name
     */
    protected $name = '';
    
    /**
     * Only 170 characters.
     * @Gedmo\Translatable
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @var string $descriptionForGoogle
     */
    protected $descriptionForGoogle = '';
    
    /**
     * Only 2000 characters.
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=2000, nullable=true)
     * @Assert\Length(min="0", max="2000")
     * @var text $description
     */
    protected $description = '';
    
    /**
     * Image of part meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $imageOfPartMeta
     */
    protected $imageOfPartMeta = [];
    
    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"image/*"}
     * )
     * @Assert\Image(
     * )
     * @var string $imageOfPart
     */
    protected $imageOfPart = null;
    
    /**
     * Full image of part path as url.
     *
     * @Assert\Type(type="string")
     * @var string $imageOfPartUrl
     */
    protected $imageOfPartUrl = '';
    
    
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
     * Bidirectional - Many parts [parts] are linked by many locations [locations] (INVERSE SIDE).
     *
     * @ORM\ManyToMany(targetEntity="MU\YourCityModule\Entity\LocationEntity", mappedBy="parts")
     * @ORM\OrderBy({"letterForOrder" = "ASC"})
     * @var \MU\YourCityModule\Entity\LocationEntity[] $locations
     */
    protected $locations = null;
    
    /**
     * PartEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->locations = new ArrayCollection();
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
     * Returns the description for google.
     *
     * @return string
     */
    public function getDescriptionForGoogle()
    {
        return $this->descriptionForGoogle;
    }
    
    /**
     * Sets the description for google.
     *
     * @param string $descriptionForGoogle
     *
     * @return void
     */
    public function setDescriptionForGoogle($descriptionForGoogle)
    {
        if ($this->descriptionForGoogle !== $descriptionForGoogle) {
            $this->descriptionForGoogle = $descriptionForGoogle;
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
     * Returns the image of part.
     *
     * @return string
     */
    public function getImageOfPart()
    {
        return $this->imageOfPart;
    }
    
    /**
     * Sets the image of part.
     *
     * @param string $imageOfPart
     *
     * @return void
     */
    public function setImageOfPart($imageOfPart)
    {
        if ($this->imageOfPart !== $imageOfPart) {
            $this->imageOfPart = $imageOfPart;
        }
    }
    
    /**
     * Returns the image of part url.
     *
     * @return string
     */
    public function getImageOfPartUrl()
    {
        return $this->imageOfPartUrl;
    }
    
    /**
     * Sets the image of part url.
     *
     * @param string $imageOfPartUrl
     *
     * @return void
     */
    public function setImageOfPartUrl($imageOfPartUrl)
    {
        if ($this->imageOfPartUrl !== $imageOfPartUrl) {
            $this->imageOfPartUrl = $imageOfPartUrl;
        }
    }
    
    /**
     * Returns the image of part meta.
     *
     * @return array
     */
    public function getImageOfPartMeta()
    {
        return $this->imageOfPartMeta;
    }
    
    /**
     * Sets the image of part meta.
     *
     * @param array $imageOfPartMeta
     *
     * @return void
     */
    public function setImageOfPartMeta($imageOfPartMeta = [])
    {
        if ($this->imageOfPartMeta !== $imageOfPartMeta) {
            $this->imageOfPartMeta = $imageOfPartMeta;
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
     * Returns the locations.
     *
     * @return \MU\YourCityModule\Entity\LocationEntity[]
     */
    public function getLocations()
    {
        return $this->locations;
    }
    
    /**
     * Sets the locations.
     *
     * @param \MU\YourCityModule\Entity\LocationEntity[] $locations
     *
     * @return void
     */
    public function setLocations($locations)
    {
        foreach ($locations as $locationSingle) {
            $this->addLocations($locationSingle);
        }
    }
    
    /**
     * Adds an instance of \MU\YourCityModule\Entity\LocationEntity to the list of locations.
     *
     * @param \MU\YourCityModule\Entity\LocationEntity $location The instance to be added to the collection
     *
     * @return void
     */
    public function addLocations(\MU\YourCityModule\Entity\LocationEntity $location)
    {
        $this->locations->add($location);
        $location->addParts($this);
    }
    
    /**
     * Removes an instance of \MU\YourCityModule\Entity\LocationEntity from the list of locations.
     *
     * @param \MU\YourCityModule\Entity\LocationEntity $location The instance to be removed from the collection
     *
     * @return void
     */
    public function removeLocations(\MU\YourCityModule\Entity\LocationEntity $location)
    {
        $this->locations->removeElement($location);
        $location->removeParts($this);
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
        return 'muyourcitymodule.ui_hooks.parts';
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
        return 'Part ' . $this->getKey() . ': ' . $this->getName();
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
        $this->setImageOfPart(null);
        $this->setImageOfPartMeta([]);
        $this->setImageOfPartUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}
