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

namespace MU\YourCityModule\Helper\Base;

use Gedmo\Sluggable\Util\Urlizer;

/**
 * Custom slug transliterator for proper handling of umlauts and accents during permalink generation.
 *
 * @see https://github.com/Atlantic18/DoctrineExtensions/pull/1504
 */
abstract class AbstractSlugTransliterator
{
    public static function transliterate($text, $separator = '-')
    {
        $text = Urlizer::unaccent($text);

        return Urlizer::urlize($text, $separator);
    }
}
