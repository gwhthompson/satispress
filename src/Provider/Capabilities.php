<?php
/**
 * Capabilities provider.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Provider;

use Cedaro\WP\Plugin\AbstractHookProvider;
use SatisPress\Capabilities as Caps;

/**
 * Capabilities provider class.
 *
 * @since 0.3.0
 */
class Capabilities extends AbstractHookProvider
{
    /**
     * Register hooks.
     *
     * @since 0.3.0
     */
    public function register_hooks()
    {
        add_filter('map_meta_cap', $this->map_meta_cap(...), 10, 2);
    }

    /**
     * Map meta capabilities to primitive capabilities.
     *
     * @since 0.3.0
     *
     * @param array  $caps returns the user's actual capabilities
     * @param string $cap  capability name
     */
    public function map_meta_cap(array $caps, string $cap): array
    {
        return match ($cap) {
            Caps::DOWNLOAD_PACKAGE => [Caps::DOWNLOAD_PACKAGES],
            Caps::VIEW_PACKAGE => [Caps::VIEW_PACKAGES],
            default => $caps,
        };
    }
}
