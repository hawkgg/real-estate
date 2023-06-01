<?php

namespace App\Console\Commands;

use App\Classes\Services\CBR;
use App\Models\{Currency, House, Price, Rate};
use Exception;
use Illuminate\Console\Command;

class UpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update price amount of the houses';

    /**
     * List of the acceptable currencies.
     *
     * @var array
     */
    protected $acceptable_currencies = [
        'USD',
//        'EUR',
//        'GEL'
    ];

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $rates = CBR::getRates();
        if (!count($rates)) {
            throw new Exception('Error: currency rates have not been received.');
        }
        Rate::truncate();

        $rate = new Rate;
        $rate->currency()->associate(Currency::where('name', 'RUB')->first());
        $rate->val = 1;
        $rate->save();

        foreach($rates as $currency_label => $rate_val) {
            if (in_array($currency_label, $this->acceptable_currencies)) {
                $currency = Currency::where('name', $currency_label)->first();
                if (!$currency) {
                    $currency = Currency::create([
                        'name' => $currency_label,
                    ]);
                }
                $rate = new Rate;
                $rate->currency()->associate($currency);
                $rate->val = $rate_val;
                $rate->save();
            }
        }

        $rates = Rate::all();
        $houses = House::all();
        foreach($houses as $house) {
            $default_rate = $rates->where('currency_id', $house->default_currency->id)->first();
            foreach($rates as $rate) {
                if ($rate === $default_rate) continue;

                $price = Price::where([['house_id', $house->id], ['currency_id', $rate->currency->id]])->first();
                if (!$price) {
                    $price = new Price;
                    $price->currency()->associate($rate->currency);
                    $price->house()->associate($house);
                }
                $price->val = $rate->val / $default_rate->val * $house->default_price->val;

                $price->save();
            }
        }

        return Command::SUCCESS;
    }
}
