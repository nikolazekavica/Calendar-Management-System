<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 17.4.2022.
 * Time: 15:38
 */
namespace Database\Factories;

use App\Helpers\Constants;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityFactory extends Factory
{
    protected $model = Availability::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dateNow = Carbon::now()->setTimezone(config('app.timezone'));

        return [
            'title'                  => $this->faker->text(20),
            'start_date'             => $this->faker->date($dateNow->addDays(1)->format(Constants::DATE_FORMAT_PROJECT)),
            'end_date'               => $this->faker->date($dateNow->addDays(5)->format(Constants::DATE_FORMAT_PROJECT)),
            'start_time'             => $this->faker->time($dateNow->addMinutes(10)->format('H:i')),
            'end_time'               => $this->faker->time($dateNow->addMinutes(20)->format('H:i')),
            'availability_status'    => $this->faker->randomElement($array = ['busy','free']),
            'description'            => $this->faker->text(100),
            'start_date_recurrences' => $this->faker->date($dateNow->addDays(10)->format(Constants::DATE_FORMAT_PROJECT)),
            'end_date_recurrences'   => $this->faker->date($dateNow->addDays(15)->format(Constants::DATE_FORMAT_PROJECT))
        ];
    }
}