<?php
/**
 * Invalid release source exception.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Exception;

use SatisPress\Release;

/**
 * Invalid release source exception class.
 *
 * @since 0.3.0
 */
final class InvalidReleaseSource extends \LogicException implements SatispressException
{
    /**
     * Create an exception for an invalid release source.
     *
     * @since 0.3.0.
     *
     * @param Release    $release  release instance
     * @param int        $code     Optional. The Exception code.
     * @param \Throwable $previous Optional. The previous throwable used for the exception chaining.
     */
    public static function forRelease(
        Release $release,
        int $code = 0,
        \Throwable $previous = null
    ): InvalidReleaseSource {
        $name = $release->get_package()->get_name();

        $message = "Unable to create release artifact for {$name}; source could not be determined.";

        return new self($message, $code, $previous);
    }
}
