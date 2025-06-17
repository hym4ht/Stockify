<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class UserExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * Return a collection of users to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('id', 'name', 'email', 'role')->get();
    }

    /**
     * Return the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
        ];
    }
}
