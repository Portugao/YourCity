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
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\Core\Doctrine\EntityAccess;
use MU\YourCityModule\Traits\StandardFieldsTrait;
use MU\YourCityModule\Validator\Constraints as YourCityAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for special of location entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractSpecialOfLocationEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'specialOfLocation';
    
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
     * @YourCityAssert\ListEntry(entityName="specialOfLocation", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * Only 100 characters, better only 57.
     * @Gedmo\Translatable
     * @ORM\Column(length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="100")
     * @var string $name
     */
    protected $name = '';
    
    /**
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
     * Enter a bootstrap icon.
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="255")
     * @var string $iconForSpecial
     */
    protected $iconForSpecial = '';
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotNull()
     * @Assert\Regex(pattern="/\s/", match=false, message="This value must not contain space chars.")
     * @Assert\Length(min="0", max="255")
     * @Assert\Regex(pattern="/^#?(([a-fA-F0-9]{3}){1,2})$/", message="This value must be a valid html colour code [#123 or #123456].")
     * @var string $colorOfIcon
     */
    protected $colorOfIcon = '#ff0000';
    
    
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
     * Bidirectional - Many specialsOfLocation [specials of location] are linked by many locations [locations] (INVERSE SIDE).
     *
     * @ORM\ManyToMany(targetEntity="MU\YourCityModule\Entity\LocationEntity", mappedBy="specialsOfLocation")
     * @ORM\OrderBy({"letterForOrder" = "ASC"})
     * @var \MU\YourCityModule\Entity\LocationEntity[] $locations
     */
    protected $locations = null;
    
    /**
     * SpecialOfLocationEntity constructor.
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
     * Returns the icon for special.
     *
     * @return string
     */
    public function getIconForSpecial()
    {
        return $this->iconForSpecial;
    }
    
    /**
     * Sets the icon for special.
     *
     * @param string $iconForSpecial
     *
     * @return void
     */
    public function setIconForSpecial($iconForSpecial)
    {
        if ($this->iconForSpecial !== $iconForSpecial) {
            $this->iconForSpecial = isset($iconForSpecial) ? $iconForSpecial : '';
        }
    }
    
    /**
     * Returns the color of icon.
     *
     * @return string
     */
    public function getColorOfIcon()
    {
        return $this->colorOfIcon;
    }
    
    /**
     * Sets the color of icon.
     *
     * @param string $colorOfIcon
     *
     * @return void
     */
    public function setColorOfIcon($colorOfIcon)
    {
        if ($this->colorOfIcon !== $colorOfIcon) {
            $this->colorOfIcon = isset($colorOfIcon) ? $colorOfIcon : '';
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
        $location->addSpecialsOfLocation($this);
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
        $location->removeSpecialsOfLocation($this);
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
        return 'muyourcitymodule.ui_hooks.specialsoflocation';
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
        return 'Special of location ' . $this->getKey() . ': ' . $this->getName();
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
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}
