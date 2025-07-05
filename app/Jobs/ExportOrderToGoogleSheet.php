<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomerOrders;
use App\Helpers\GoogleSheetsHelper; // سنحتفظ بالـ Helper للمنطق النظيف

class ExportOrderToGoogleSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\CustomerOrders $order
     * @return void
     */
    public function __construct(CustomerOrders $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // استدعاء الدالة التي تقوم بالتصدير الفعلي
        GoogleSheetsHelper::exportOrder($this->order);
    }
}