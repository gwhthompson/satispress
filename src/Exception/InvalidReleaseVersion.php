<?php
/**
 * Invalid release version exception.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Exception;

/**
 * Invalid release version exception class.
 *
 * @since 0.3.0
 */
final class InvalidReleaseVersion extends \LogicException implements SatispressException
{
    /**
     * Create an exception for an invalid release version string.
     *
     * @since 0.3.0.
     *
     * @param string     $version      version string
     * @param string     $package_name package name
     * @param int        $code         Optional. The Exception code.
     * @param \Throwable $previous     Optional. The previous throwable used for the exception chaining.
     */
    public static function fromVersion(
        string $version,
        string $package_name,
        int $code = 0,
        \Throwable $previous = null
    ): InvalidReleaseVersion {
        $message = "Invalid release version for {$package_name}: {$version}";

        return new self($message, $code, $previous);
    }

    /**
     * Create an exception for a package that has no releases.
     *
     * @since 0.3.0.
     *
     * @param string     $package_name package name
     * @param int        $code         Optional. The Exception code.
     * @param \Throwable $previous     Optional. The previous throwable used for the exception chaining.
     */
    public static function hasNoReleases(
        string $package_name,
        int $code = 0,
        \Throwable $previous = null
    ): InvalidReleaseVersion {
        $message = "Package {$package_name} has no releases.";

        return new self($message, $code, $previous);
    }
}
