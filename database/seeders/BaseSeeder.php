<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{
    protected $class = Model::class;

    protected $info = [];

    protected ?string $uniqueKey = null;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $progress = $this->command->getOutput()->createProgressBar(count($this->info));

        foreach ($this->getInfos() as $info) {
            if ($this->addOne($info)) {
                $progress->advance();
            }
        }

        $progress->finish();

        $this->command->getOutput()->writeln('');
    }

    public function getInfos(): array
    {
        return $this->info;
    }

    public function addOne(array $info): bool
    {
        if ($this->uniqueKey && isset($info[$this->uniqueKey])) {
            $item = $this->class::where($this->uniqueKey, $info[$this->uniqueKey])->first();
            if (! $item) {
                $item = new $this->class;
            }
            $item->fill($info);
            $item->save();

            return (bool) $item;
        }

        return (bool) $this->class::create($info);
    }
}
