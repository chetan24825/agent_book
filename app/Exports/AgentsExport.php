<?php
namespace App\Exports;

use App\Models\Agent;  // Adjust according to your model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AgentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $agents;

    public function __construct($agents)
    {
        $this->agents = $agents;
    }

    // Map the data to specific columns (only those you want)
    public function map($agent): array
    {
        return [
            $agent->name,
            $agent->agent_code,
            $agent->email,
            $agent->phone,
            // $agent->status == 1 ? 'Active' : 'Inactive',
            $agent->created_at->format('d M, Y'),
        ];
    }

    // Define the headings for the export
    public function headings(): array
    {
        return [
            'Name',
            'Agent Code',
            'Email',
            'Phone',
            // 'Status',
            'Created',
        ];
    }

    public function collection()
    {
        return $this->agents;
    }
}
