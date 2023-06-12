<?php


declare(strict_types=1);

/*
 * This file is part of the drewlabs namespace.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\Envoyer\Utils;

use Drewlabs\Envoyer\Contracts\ClientInterface;
use Drewlabs\Envoyer\Contracts\DriverFactoryInterface;
use Drewlabs\Envoyer\DriverRegistryFacade;

class StringDriverFactory implements DriverFactoryInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * Creates class instance
     * 
     * @param string $name 
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function create(): ClientInterface
    {
        return DriverRegistryFacade::create($this->name);
    }
}
