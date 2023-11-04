<?php
/**
 * Invalid package artifact exception.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.7.0
 */

declare(strict_types=1);

namespace SatisPress\Exception;

/**
 * Invalid package artifact exception class.
 *
 * @since 0.7.0
 */
final class InvalidPackageArtifact extends \RuntimeException implements SatispressException
{
    /**
     * Create an exception for artifact that is unreadable as a zip archive.
     *
     * @since 0.7.0
     *
     * @param string     $filename file name
     * @param int        $code     Optional. The Exception code.
     * @param \Throwable $previous Optional. The previous throwable used for the exception chaining.
     */
    public static function unreadableZip(
        string $filename,
        int $code = 0,
        \Throwable $previous = null
    ): InvalidPackageArtifact {
        $message = "Unable to parse {$filename} as a valid zip archive.";

        return new self($message, $code, $previous);
    }

    /**
     * Create an exception for artifact with a top level __MAXOSX directory.
     *
     * @since 0.7.0
     *
     * @param string     $filename file name
     * @param int        $code     Optional. The Exception code.
     * @param \Throwable $previous Optional. The previous throwable used for the exception chaining.
     */
    public static function containsMacOsxDirectory(
        string $filename,
        int $code = 0,
        \Throwable $previous = null
    ): InvalidPackageArtifact {
        $message = "Package artifact {$filename} has a top level __MACOSX directory.";

        return new self($message, $code, $previous);
    }
}
