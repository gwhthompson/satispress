<?php
/**
 * API Key.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Authentication\ApiKey;

/**
 * API Key class.
 *
 * @since 0.3.0
 */
final class ApiKey implements \ArrayAccess
{
    /**
     * API key length.
     *
     * @var int
     */
    public const TOKEN_LENGTH = 32;

    /**
     * API key data.
     *
     * @var array
     */
    private $data;

    /**
     * Initialize an API key.
     *
     * @since 0.3.0
     *
     * @param \WP_User $user  wordPress user
     * @param string   $token API key token
     * @param array    $data  Optional. Additional data associated with the key.
     */
    public function __construct(/**
  * User associated with the API key.
  */
        private readonly \WP_User $user, /**
  * API key token.
  */
        private readonly string $token,
        array $data = null
    ) {
        $this->data = $data ?? [];
    }

    /**
     * Retrieve the data associated with the API key.
     *
     * @since 0.3.0
     */
    public function get_data(): array
    {
        return $this->data;
    }

    /**
     * Retrieve and format a date field.
     *
     * @since 0.3.0
     *
     * @param string $name   field name
     * @param string $format Optional. Date format.
     *
     * @return mixed
     */
    public function get_date(string $name, string $format = null)
    {
        if (empty($this->data[$name])) {
            return '';
        }

        return $this->format_date($this->data[$name], $format);
    }

    /**
     * Retrieve the API Key name.
     *
     * @since 0.3.0
     */
    public function get_name(): string
    {
        return $this->data['name'] ?? '';
    }

    /**
     * Retrieve the API Key token.
     *
     * @since 0.3.0
     */
    public function get_token(): string
    {
        return $this->token;
    }

    /**
     * Retrieve the user associated with the API Key.
     *
     * @since 0.3.0
     */
    public function get_user(): \WP_User
    {
        return $this->user;
    }

    /**
     * Convert the API Key to an array.
     *
     * @since 0.3.0
     */
    public function to_array(): array
    {
        return [
            'created' => $this->get_date('created'),
            'last_used' => $this->get_date('last_used'),
            'name' => $this->get_name(),
            'token' => $this->get_token(),
            'user' => $this->get_user()->ID,
            'user_login' => $this->get_user()->user_login,
        ];
    }

    /**
     * Whether a field exists.
     *
     * @since 0.3.0
     *
     * @param string $name field name
     */
    public function offsetExists($name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Retrieve a field value.
     *
     * @since 0.3.0
     *
     * @param string $name field name
     */
    public function offsetGet($name): mixed
    {
        $method = "get_{$name}";

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return $this->data[$name] ?? null;
    }

    /**
     * Set a field value.
     *
     * @since 0.3.0
     *
     * @param string $name  field name
     * @param array  $value field value
     */
    public function offsetSet($name, $value): void
    {
        if (!$this->is_protected_field($name)) {
            $this->data[$name] = $value;
        }
    }

    /**
     * Remove a field.
     *
     * @since 0.3.0
     *
     * @param string $name field name
     */
    public function offsetUnset($name): void
    {
        if (!$this->is_protected_field($name)) {
            unset($this->data[$name]);
        }
    }

    /**
     * Format a date.
     *
     * @since 0.3.0
     *
     * @param int    $timestamp unix timestamp
     * @param string $format    Optional. Date format.
     */
    private function format_date(int $timestamp, string $format = null): string
    {
        $format = $format ?: get_option('date_format');
        $timezone_id = get_option('timezone_string');
        $datetime = new \DateTime();

        // Handle manual offsets, like "UTC+2".
        if (empty($timezone_id)) {
            $offset = (int) get_option('gmt_offset', 0);
            $formatted_offset = 0 <= $offset ? '+'.(string) $offset : (string) $offset;
            $timezone_id = str_replace(
                ['.25', '.5', '.75'],
                [':15', ':30', ':45'],
                $formatted_offset
            );
        }

        $datetime->setTimezone(new \DateTimeZone($timezone_id));
        $datetime->setTimestamp($timestamp);

        return $datetime->format($format);
    }

    /**
     * Whether a field is protected.
     *
     * @since 0.3.0
     *
     * @param string $name field name
     */
    private function is_protected_field($name): bool
    {
        $protected = ['created', 'created_by'];

        return \in_array($name, $protected, true);
    }
}
