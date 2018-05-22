<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

/**
 * Values for CIE Illuminant standard values
 *
 * All values are taken as 2 degree observer
 *
 * @see https://en.wikipedia.org/wiki/Standard_illuminant
 */
final class CIEIlluminant
{
    const A = [0.44757, 0.40745];
    const B = [0.34842, 0.35161];
    const C = [0.31006, 0.31616];
    const D50 = [0.34567, 0.35850];
    const D55 = [0.33242, 0.34743];
    const D65 = [0.31271, 0.32902];
    const D75 = [0.29902, 0.31485];
    const E = [1/3, 1/3];
    const F1 = [0.31310, 0.33727];
    const F2 = [0.37208, 0.37529];
    const F3 = [0.40910, 0.39430];
    const F4 = [0.44018, 0.40329];
    const F5 = [0.31379, 0.34531];
    const F6 = [0.37790, 0.38835];
    const F7 = [0.31292, 0.32933];
    const F8 = [0.34588, 0.35875];
    const F9 = [0.37417, 0.37281];
    const F10 = [0.34609, 0.35986];
    const F11 = [0.38052, 0.37713];
    const F12 = [0.43695, 0.40441];
}
