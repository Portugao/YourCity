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

namespace MU\YourCityModule\Helper\Base;

use IntlDateFormatter;
use NumberFormatter;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Common\Translator\TranslatorInterface;
use MU\YourCityModule\Entity\BranchEntity;
use MU\YourCityModule\Entity\LocationEntity;
use MU\YourCityModule\Entity\PartEntity;
use MU\YourCityModule\Entity\OfferEntity;
use MU\YourCityModule\Entity\MenuOfLocationEntity;
use MU\YourCityModule\Entity\PartOfMenuEntity;
use MU\YourCityModule\Entity\DishEntity;
use MU\YourCityModule\Entity\EventEntity;
use MU\YourCityModule\Entity\ProductEntity;
use MU\YourCityModule\Entity\SpecialOfLocationEntity;
use MU\YourCityModule\Entity\ServiceOfLocationEntity;
use MU\YourCityModule\Entity\AbonnementEntity;
use MU\YourCityModule\Helper\ListEntriesHelper;

/**
 * Entity display helper base class.
 */
abstract class AbstractEntityDisplayHelper
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var ListEntriesHelper Helper service for managing list entries
     */
    protected $listEntriesHelper;

    /**
     * @var IntlDateFormatter Formatter for dates
     */
    protected $dateFormatter;

    /**
     * @var NumberFormatter Formatter for numbers
     */
    protected $numberFormatter;

    /**
     * @var NumberFormatter Formatter for currencies
     */
    protected $currencyFormatter;

    /**
     * EntityDisplayHelper constructor.
     *
     * @param TranslatorInterface $translator        Translator service instance
     * @param RequestStack        $requestStack      RequestStack service instance
     * @param ListEntriesHelper   $listEntriesHelper Helper service for managing list entries
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        ListEntriesHelper $listEntriesHelper
    ) {
        $this->translator = $translator;
        $this->listEntriesHelper = $listEntriesHelper;
        $locale = null !== $requestStack->getCurrentRequest() ? $requestStack->getCurrentRequest()->getLocale() : null;
        $this->dateFormatter = new IntlDateFormatter($locale, null, null);
        $this->numberFormatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $this->currencyFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    }

    /**
     * Returns the formatted title for a given entity.
     *
     * @param object $entity The given entity instance
     *
     * @return string The formatted title
     */
    public function getFormattedTitle($entity)
    {
        if ($entity instanceof BranchEntity) {
            return $this->formatBranch($entity);
        }
        if ($entity instanceof LocationEntity) {
            return $this->formatLocation($entity);
        }
        if ($entity instanceof PartEntity) {
            return $this->formatPart($entity);
        }
        if ($entity instanceof OfferEntity) {
            return $this->formatOffer($entity);
        }
        if ($entity instanceof MenuOfLocationEntity) {
            return $this->formatMenuOfLocation($entity);
        }
        if ($entity instanceof PartOfMenuEntity) {
            return $this->formatPartOfMenu($entity);
        }
        if ($entity instanceof DishEntity) {
            return $this->formatDish($entity);
        }
        if ($entity instanceof EventEntity) {
            return $this->formatEvent($entity);
        }
        if ($entity instanceof ProductEntity) {
            return $this->formatProduct($entity);
        }
        if ($entity instanceof SpecialOfLocationEntity) {
            return $this->formatSpecialOfLocation($entity);
        }
        if ($entity instanceof ServiceOfLocationEntity) {
            return $this->formatServiceOfLocation($entity);
        }
        if ($entity instanceof AbonnementEntity) {
            return $this->formatAbonnement($entity);
        }
    
        return '';
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param BranchEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatBranch(BranchEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param LocationEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatLocation(LocationEntity $entity)
    {
        return $this->translator->__f('%name% %zipCode% %city% %street% %numberOfStreet%', [
            '%name%' => $entity->getName(),
            '%zipCode%' => $entity->getZipCode(),
            '%city%' => $entity->getCity(),
            '%street%' => $entity->getStreet(),
            '%numberOfStreet%' => $entity->getNumberOfStreet()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param PartEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatPart(PartEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param OfferEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatOffer(OfferEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param MenuOfLocationEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatMenuOfLocation(MenuOfLocationEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param PartOfMenuEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatPartOfMenu(PartOfMenuEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param DishEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatDish(DishEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param EventEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatEvent(EventEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param ProductEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatProduct(ProductEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param SpecialOfLocationEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatSpecialOfLocation(SpecialOfLocationEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param ServiceOfLocationEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatServiceOfLocation(ServiceOfLocationEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param AbonnementEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatAbonnement(AbonnementEntity $entity)
    {
        return $this->translator->__f('%name%', [
            '%name%' => $entity->getName()
        ]);
    }
    
    /**
     * Returns name of the field used as title / name for entities of this repository.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used as title
     */
    public function getTitleFieldName($objectType)
    {
        if ($objectType == 'branch') {
            return 'name';
        }
        if ($objectType == 'location') {
            return 'name';
        }
        if ($objectType == 'part') {
            return 'name';
        }
        if ($objectType == 'offer') {
            return 'name';
        }
        if ($objectType == 'menuOfLocation') {
            return 'name';
        }
        if ($objectType == 'partOfMenu') {
            return 'name';
        }
        if ($objectType == 'dish') {
            return 'name';
        }
        if ($objectType == 'event') {
            return 'name';
        }
        if ($objectType == 'product') {
            return 'name';
        }
        if ($objectType == 'specialOfLocation') {
            return 'name';
        }
        if ($objectType == 'serviceOfLocation') {
            return 'name';
        }
        if ($objectType == 'abonnement') {
            return 'name';
        }
    
        return '';
    }
    
    /**
     * Returns name of the field used for describing entities of this repository.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used as description
     */
    public function getDescriptionFieldName($objectType)
    {
        if ($objectType == 'branch') {
            return 'description';
        }
        if ($objectType == 'location') {
            return 'description';
        }
        if ($objectType == 'part') {
            return 'description';
        }
        if ($objectType == 'offer') {
            return 'description';
        }
        if ($objectType == 'menuOfLocation') {
            return 'description';
        }
        if ($objectType == 'partOfMenu') {
            return 'description';
        }
        if ($objectType == 'dish') {
            return 'description';
        }
        if ($objectType == 'event') {
            return 'description';
        }
        if ($objectType == 'product') {
            return 'description';
        }
        if ($objectType == 'specialOfLocation') {
            return 'description';
        }
        if ($objectType == 'serviceOfLocation') {
            return 'description';
        }
        if ($objectType == 'abonnement') {
            return 'name';
        }
    
        return '';
    }
    
    /**
     * Returns name of first upload field which is capable for handling images.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used for preview images
     */
    public function getPreviewFieldName($objectType)
    {
        if ($objectType == 'branch') {
            return 'imageOfBranch';
        }
        if ($objectType == 'location') {
            return 'logoOfYourLocation';
        }
        if ($objectType == 'part') {
            return 'imageOfPart';
        }
        if ($objectType == 'offer') {
            return 'imageOfOffer';
        }
        if ($objectType == 'menuOfLocation') {
            return 'imageOfMenu';
        }
        if ($objectType == 'dish') {
            return 'imageOfDish';
        }
        if ($objectType == 'event') {
            return 'imageOfEvent';
        }
        if ($objectType == 'product') {
            return 'imageOfProduct';
        }
    
        return '';
    }
    
    /**
     * Returns name of the date(time) field to be used for representing the start
     * of this object. Used for providing meta data to the tag module.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used as date
     */
    public function getStartDateFieldName($objectType)
    {
        if ($objectType == 'branch') {
            return 'createdDate';
        }
        if ($objectType == 'location') {
            return 'createdDate';
        }
        if ($objectType == 'part') {
            return 'createdDate';
        }
        if ($objectType == 'offer') {
            return 'inViewFrom';
        }
        if ($objectType == 'menuOfLocation') {
            return 'inViewFrom';
        }
        if ($objectType == 'partOfMenu') {
            return 'createdDate';
        }
        if ($objectType == 'dish') {
            return 'createdDate';
        }
        if ($objectType == 'event') {
            return 'inViewFrom';
        }
        if ($objectType == 'product') {
            return 'createdDate';
        }
        if ($objectType == 'specialOfLocation') {
            return 'createdDate';
        }
        if ($objectType == 'serviceOfLocation') {
            return 'createdDate';
        }
        if ($objectType == 'abonnement') {
            return 'createdDate';
        }
    
        return '';
    }
}
