<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'Admin';
    case StaffGudang = 'Staff Gudang';
    case ManajerGudang = 'Manajer Gudang';
}
