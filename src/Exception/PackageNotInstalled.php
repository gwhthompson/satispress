<?php
/**
 * Package not installed exception.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Exception;

use SatisPress\Package;

/**
 * Package not installed exception class.
 *
 * @since 0.3.0
 */
final class PackageNotInstalled extends \RuntimeException implements SatispressException
{
    /**
     * Create an exception for an invalid method call.
     *
     * @since 0.3.0.
     *
     * @param string     $method   method name
     * @param Package    $package  package
     * @param int        $code     Optional. The Exception code.
     * @param \Throwable $previous Optional. The previous throwable used for the exception chaining.
     */
    public static function forInvalidMethodCall(
        string $method,
        Package $package,
        int $code = 0,
        \Throwable $previous = null
    ): PackageNotInstalled {
        $name = $package->get_name();
        $message = "Cannot call method {$method} for a package that is not installed; Package: {$name}.";

        return new self($message, $code, $previous);
    }

    /**
     * Create an exception for being unable to archive a package from source.
     *
     * @since 0.3.0.
     *
     * @param Package    $package  package
     * @param int        $code     Optional. The Exception code.
     * @param \Throwable $previous Optional. The previous throwable used for the exception chaining.
     */
    public static function unableToArchiveFromSource(
        Package $package,
        int $code = 0,
        \Throwable $previous = null
    ): PackageNotInstalled {
        $name = $package->get_name();
        $message = "Unable to archive {$name}; source does not exist.";

        return new self($message, $code, $previous);
    }
}
