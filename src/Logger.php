<?php
/**
 * Default logger.
 *
 * Logs messages to error_log().
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.4.0
 */

declare(strict_types=1);

namespace SatisPress;

use Exception;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * Default logger class.
 *
 * @since 0.4.0
 */
final class Logger extends AbstractLogger
{
    /**
     * PSR log levels.
     *
     * @since 0.4.0
     *
     * @var array
     */
    protected $levels = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
        LogLevel::ALERT,
        LogLevel::EMERGENCY,
    ];

    /**
     * Minimum log level.
     *
     * @since 0.4.0
     *
     * @var int
     */
    protected $minimum_level_code;

    /**
     * Constructor method.
     *
     * @since 0.4.0
     *
     * @param string $minimum_level minimum level to log
     */
    public function __construct(string $minimum_level)
    {
        $this->minimum_level_code = $this->get_level_code($minimum_level);
    }

    /**
     * Log a message.
     *
     * @since 0.4.0
     *
     * @param mixed $level
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!$this->handle_level($level)) {
            return;
        }

        // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
        error_log(
            sprintf(
                'SATISPRESS.%s: %s',
                strtoupper($level),
                $this->format($message, $context)
            )
        );
    }

    /**
     * Format a message.
     *
     * - Interpolates context values into message placeholders.
     * - Appends additional context data as JSON.
     * - Appends exception data.
     *
     * @since 0.4.0
     *
     * @param string $message log message
     * @param array  $context additional data
     */
    protected function format(string $message, array $context = []): string
    {
        $search = [];
        $replace = [];

        // Extract exceptions from the context array.
        $exception = $context['exception'] ?? null;
        unset($context['exception']);

        foreach ($context as $key => $value) {
            $placeholder = '{'.$key.'}';

            if (!str_contains($message, $placeholder)) {
                continue;
            }

            $search[] = '{'.$key.'}';
            $replace[] = $this->to_string($value);
            unset($context[$key]);
        }

        $line = str_replace($search, $replace, $message);

        // Append additional context data.
        if ($context !== []) {
            $line .= ' '.wp_json_encode($context, \JSON_UNESCAPED_SLASHES);
        }

        // Append an exception.
        if (!empty($exception) && $exception instanceof \Exception) {
            $line .= ' '.$this->format_exception($exception);
        }

        return $line;
    }

    /**
     * Format an exception.
     *
     * @since 0.4.0
     *
     * @param \Exception $e exception
     */
    protected function format_exception(\Exception $e): string
    {
        return wp_json_encode(
            [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ],
            \JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Convert a value to a string.
     *
     * @since 0.4.0
     *
     * @param mixed $value message
     */
    protected function to_string(mixed $value): string
    {
        if (is_wp_error($value)) {
            $value = $value->get_error_message();
        } elseif (is_object($value) && method_exists($value, '__toString')) {
            $value = $value->__toString();
        } elseif (!is_scalar($value)) {
            $value = wp_json_encode($value, \JSON_UNESCAPED_SLASHES);
        }

        return $value;
    }

    /**
     * Whether a message with a given level should be logged.
     *
     * @since 0.4.0
     *
     * @param mixed $level PSR Log level
     */
    protected function handle_level(mixed $level): bool
    {
        return $this->minimum_level_code >= 0 && $this->minimum_level_code <= $this->get_level_code($level);
    }

    /**
     * Retrieve a numeric code for a given PSR log level.
     *
     * @since 0.4.0
     *
     * @param mixed $level PSR log level
     *
     * @return int
     */
    protected function get_level_code(mixed $level)
    {
        $code = array_search($level, $this->levels, true);

        return false === $code ? -1 : $code;
    }
}
