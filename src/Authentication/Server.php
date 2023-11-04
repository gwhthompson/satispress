<?php
/**
 * Authentication server interface.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress\Authentication;

use SatisPress\Exception\AuthenticationException;
use SatisPress\HTTP\Request;

/**
 * Authentication server interface.
 *
 * @since 0.3.0
 */
interface Server
{
    /**
     * Check if the server should handle the current request.
     *
     * @since 0.4.0
     *
     * @param Request $request request instance
     */
    public function check_scheme(Request $request): bool;

    /**
     * Handle authentication.
     *
     * @since 0.3.0
     *
     * @param Request $request request instance
     *
     * @return int a user ID
     *
     * @throws AuthenticationException if authentications fails
     */
    public function authenticate(Request $request): int;
}
