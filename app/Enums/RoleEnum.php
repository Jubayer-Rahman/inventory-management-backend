<?php

namespace App\Enums;

enum RoleEnum: string
{
    // Rule value max length 32
    case OWNER = 'owner';
    case ADMIN = 'admin';
    case CENTRAL_INVENTORY_MANAGER = 'central_inventory_manager';
    case STORE_INVENTORY_MANAGER = 'store_inventory_manager';
    case STORE_REPRESENTATIVE = 'store_representative';

    /**
     * Get all role values
     */
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

}
