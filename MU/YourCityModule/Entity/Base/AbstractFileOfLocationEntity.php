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
 * This is the base entity class for file of location entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 *
 * @abstract
 */
abstract class AbstractFileOfLocationEntity extends EntityAccess implements Translatable
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
    protected $_objectType = 'fileOfLocation';
    
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
     * @YourCityAssert\ListEntry(entityName="fileOfLocation", propertyName="workflowState", multiple=false)
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
     * @ORM\Column(type="text", length=2000)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="2000")
     * @var text $description
     */
    protected $description = '';
    
    /**
     * File of file meta data array.
     *
     * @ORM\Column(type="array")
     * @Assert\Type(type="array")
     * @var array $fileOfFileMeta
     */
    protected $fileOfFileMeta = [];
    
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @Assert\File(
     *    mimeTypes = {"application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel"}
     * )
     * @var string $fileOfFile
     */
    protected $fileOfFile = null;
    
    /**
     * Full file of file path as url.
     *
     * @Assert\Type(type="string")
     * @var string $fileOfFileUrl
     */
    protected $fileOfFileUrl = '';
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var integer $positionOfFile
     */
    protected $positionOfFile = 0;
    
    
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
     * Bidirectional - Many filesOfLocation [files of location] are linked by one location [location] (OWNING SIDE).
     *
     * @ORM\ManyToOne(targetEntity="MU\YourCityModule\Entity\LocationEntity", inversedBy="filesOfLocation")
     * @ORM\JoinTable(name="mu_yourcity_location")
     * @Assert\Type(type="MU\YourCityModule\Entity\LocationEntity")
     * @var \MU\YourCityModule\Entity\LocationEntity $location
     */
    protected $location;
    
    
    /**
     * FileOfLocationEntity constructor.
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
            $this->description = isset($description) ? $description : '';
        }
    }
    
    /**
     * Returns the file of file.
     *
     * @return string
     */
    public function getFileOfFile()
    {
        return $this->fileOfFile;
    }
    
    /**
     * Sets the file of file.
     *
     * @param string $fileOfFile
     *
     * @return void
     */
    public function setFileOfFile($fileOfFile)
    {
        if ($this->fileOfFile !== $fileOfFile) {
            $this->fileOfFile = isset($fileOfFile) ? $fileOfFile : '';
        }
    }
    
    /**
     * Returns the file of file url.
     *
     * @return string
     */
    public function getFileOfFileUrl()
    {
        return $this->fileOfFileUrl;
    }
    
    /**
     * Sets the file of file url.
     *
     * @param string $fileOfFileUrl
     *
     * @return void
     */
    public function setFileOfFileUrl($fileOfFileUrl)
    {
        if ($this->fileOfFileUrl !== $fileOfFileUrl) {
            $this->fileOfFileUrl = isset($fileOfFileUrl) ? $fileOfFileUrl : '';
        }
    }
    
    /**
     * Returns the file of file meta.
     *
     * @return array
     */
    public function getFileOfFileMeta()
    {
        return $this->fileOfFileMeta;
    }
    
    /**
     * Sets the file of file meta.
     *
     * @param array $fileOfFileMeta
     *
     * @return void
     */
    public function setFileOfFileMeta($fileOfFileMeta = [])
    {
        if ($this->fileOfFileMeta !== $fileOfFileMeta) {
            $this->fileOfFileMeta = isset($fileOfFileMeta) ? $fileOfFileMeta : '';
        }
    }
    
    /**
     * Returns the position of file.
     *
     * @return integer
     */
    public function getPositionOfFile()
    {
        return $this->positionOfFile;
    }
    
    /**
     * Sets the position of file.
     *
     * @param integer $positionOfFile
     *
     * @return void
     */
    public function setPositionOfFile($positionOfFile)
    {
        if (intval($this->positionOfFile) !== intval($positionOfFile)) {
            $this->positionOfFile = intval($positionOfFile);
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
        return 'muyourcitymodule.ui_hooks.filesoflocation';
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
        return 'File of location ' . $this->createCompositeIdentifier() . ': ' . $this->getName();
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
        $this->setFileOfFile(null);
        $this->setFileOfFileMeta([]);
        $this->setFileOfFileUrl('');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    }
}