<?php

namespace App\Contracts;

/**
 * Interface UserRoleModelInterface
 *
 * This interface defines the contract for a User Role model.
 * Any model that implements this interface is considered a User Role
 * and must adhere to the methods and properties defined in this contract.
 */
interface UserRoleModelInterface
{
    // The Model which implements this is a User Role.

    public function user();
}
