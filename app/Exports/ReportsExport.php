<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Order::with(['user', 'orderItems.product']);
        
        if (!empty($this->filters['from_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }
        
        if (!empty($this->filters['to_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }
        
        if (!empty($this->filters['product_id'])) {
            $query->whereHas('orderItems', function ($q) {
                $q->where('product_id', $this->filters['product_id']);
            });
        }
        
        if (!empty($this->filters['customer_id'])) {
            $query->where('user_id', $this->filters['customer_id']);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Customer Name',
            'Customer Email',
            'Order Date',
            'Status',
            'Total Amount',
            'Items Count',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->user->name,
            $order->user->email,
            $order->created_at->format('Y-m-d H:i:s'),
            ucfirst($order->status),
            '$' . number_format($order->total_amount, 2),
            $order->orderItems->count(),
        ];
    }
}
