<?php

namespace danielme85\LaravelLogToDB\Jobs;

use danielme85\LaravelLogToDB\Models\CreateLogFromRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveNewLogEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * @var object
     */
    protected $logToDb;

    /**
     * @var array
     */
    protected $record;

    /**
     * Create a new job instance.
     *
     * @param object $logToDb
     * @param  array $record
     * @return void
     */
    public function __construct($logToDb, $record)
    {
        $this->logToDb = $logToDb;
        $this->record = $record;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $model = $this->logToDb->getModel();
        $log = $model->generate(
            $this->record,
            $this->logToDb->getConfig('detailed')
        );

        $log->save();
    }
}