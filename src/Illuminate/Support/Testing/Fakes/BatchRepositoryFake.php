<?php

namespace Illuminate\Support\Testing\Fakes;

use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Bus\BatchRepository;
use Illuminate\Bus\PendingBatch;
use Illuminate\Bus\UpdatedBatchJobCounts;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class BatchRepositoryFake implements BatchRepository
{
    /**
     * Retrieve a list of batches.
     *
     * @param  int  $limit
     * @param  mixed  $before
     * @return \Illuminate\Bus\Batch[]
     */
    public function get($limit, $before)
    {
        return [];
    }

    /**
     * Retrieve information about an existing batch.
     *
     * @param  string  $batchId
     * @return \Illuminate\Bus\Batch|null
     */
    public function find(string $batchId)
    {
        //
    }

    /**
     * Store a new pending batch.
     *
     * @param  \Illuminate\Bus\PendingBatch  $pendingBatch
     * @return \Illuminate\Support\Testing\Fakes\BatchFake
     */
    public function store(PendingBatch $pendingBatch)
    {
        return tap(new BatchFake(
            new QueueFake(Facade::getFacadeApplication()),
            $this,
            (string) Str::orderedUuid(),
            $pendingBatch->name,
            count($pendingBatch->jobs),
            count($pendingBatch->jobs),
            0,
            [],
            $pendingBatch->options,
            CarbonImmutable::now(),
            null,
            null
        ), function (BatchFake $batch) use ($pendingBatch) {
            $batch->setBus($pendingBatch->bus());
        });
    }

    /**
     * Increment the total number of jobs within the batch.
     *
     * @param  string  $batchId
     * @param  int  $amount
     * @return void
     */
    public function incrementTotalJobs(string $batchId, int $amount)
    {
        //
    }

    /**
     * Decrement the total number of pending jobs for the batch.
     *
     * @param  string  $batchId
     * @param  string  $jobId
     * @return \Illuminate\Bus\UpdatedBatchJobCounts
     */
    public function decrementPendingJobs(string $batchId, string $jobId)
    {
        return new UpdatedBatchJobCounts;
    }

    /**
     * Increment the total number of failed jobs for the batch.
     *
     * @param  string  $batchId
     * @param  string  $jobId
     * @return \Illuminate\Bus\UpdatedBatchJobCounts
     */
    public function incrementFailedJobs(string $batchId, string $jobId)
    {
        return new UpdatedBatchJobCounts;
    }

    /**
     * Mark the batch that has the given ID as finished.
     *
     * @param  string  $batchId
     * @return void
     */
    public function markAsFinished(string $batchId)
    {
        //
    }

    /**
     * Cancel the batch that has the given ID.
     *
     * @param  string  $batchId
     * @return void
     */
    public function cancel(string $batchId)
    {
        //
    }

    /**
     * Delete the batch that has the given ID.
     *
     * @param  string  $batchId
     * @return void
     */
    public function delete(string $batchId)
    {
        //
    }

    /**
     * Execute the given Closure within a storage specific transaction.
     *
     * @param  \Closure  $callback
     * @return mixed
     */
    public function transaction(Closure $callback)
    {
        return $callback();
    }
}
