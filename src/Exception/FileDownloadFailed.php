<?php
/**
 * Failed file download exception.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Exception;

/**
 * Failed file download exception class.
 *
 * @since 0.3.0
 */
final class FileDownloadFailed extends \RuntimeException implements SatispressException
{
    /**
     * Create an exception for artifact download failure.
     *
     * @since 0.3.0.
     *
     * @param string     $filename file name
     * @param int        $code     Optional. The Exception code.
     * @param \Throwable $previous Optional. The previous throwable used for the exception chaining.
     */
    public static function forFileName(
        string $filename,
        int $code = 0,
        \Throwable $previous = null
    ): FileDownloadFailed {
        $message = "Artifact download failed for file {$filename}.";

        return new self($message, $code, $previous);
    }
}
