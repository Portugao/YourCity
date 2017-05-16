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

/**
 * The muyourcitymoduleObjectTypeSelector plugin provides items for a dropdown selector.
 *
 * Available parameters:
 *   - assign: If set, the results are assigned to the corresponding variable instead of printed out.
 *
 * @param  array            $params All attributes passed to this function from the template
 * @param  Zikula_Form_View $view   Reference to the view object
 *
 * @return string The output of the plugin
 */
function smarty_function_muyourcitymoduleObjectTypeSelector($params, $view)
{
    $dom = ZLanguage::getModuleDomain('MUYourCityModule');
    $result = [];

    $result[] = [
        'text' => __('Branches', $dom),
        'value' => 'branch'
    ];
    $result[] = [
        'text' => __('Locations', $dom),
        'value' => 'location'
    ];
    $result[] = [
        'text' => __('Parts', $dom),
        'value' => 'part'
    ];
    $result[] = [
        'text' => __('Images of location', $dom),
        'value' => 'imageOfLocation'
    ];
    $result[] = [
        'text' => __('Files of location', $dom),
        'value' => 'fileOfLocation'
    ];
    $result[] = [
        'text' => __('Offers', $dom),
        'value' => 'offer'
    ];
    $result[] = [
        'text' => __('Menus of location', $dom),
        'value' => 'menuOfLocation'
    ];
    $result[] = [
        'text' => __('Parts of menu', $dom),
        'value' => 'partOfMenu'
    ];
    $result[] = [
        'text' => __('Dishes', $dom),
        'value' => 'dish'
    ];
    $result[] = [
        'text' => __('Events', $dom),
        'value' => 'event'
    ];
    $result[] = [
        'text' => __('Products', $dom),
        'value' => 'product'
    ];
    $result[] = [
        'text' => __('Specials of location', $dom),
        'value' => 'specialOfLocation'
    ];
    $result[] = [
        'text' => __('Services of location', $dom),
        'value' => 'serviceOfLocation'
    ];
    $result[] = [
        'text' => __('Abonnements', $dom),
        'value' => 'abonnement'
    ];

    if (array_key_exists('assign', $params)) {
        $view->assign($params['assign'], $result);

        return;
    }

    return $result;
}
