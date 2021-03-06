<?php

namespace Illuminate\Bus;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Queue\Factory as QueueFactory;

class BatchFactory
{
    /**
     * The queue factory implementation.
     *
     * @var \Illuminate\Contracts\Queue\Factory
     */
    protected $queue;

    /**
     * Create a new batch factory instance.
     *
     * @param  \Illuminate\Contracts\Queue\Factory  $queue
     * @return void
     */
    public function __construct(QueueFactory $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Create a new batch instance.
     *
     * @param  \Illuminate\Bus\BatchRepository  $repository
     * @param  string  $id
     * @param  int  $totalJobs
     * @param  int  $pendingJobs
     * @param  int  $failedJobs
     * @param  array  $failedJobIds
     * @param  array  $options
     * @param  \Illuminate\Support\CarbonImmutable  $createdAt
     * @param  \Illuminate\Support\CarbonImmutable|null  $cancelledAt
     * @param  \Illuminate\Support\CarbonImmutable|null  $finishedAt
     * @return void
     */
    public function make(BatchRepository $repository,
                         string $id,
                         int $totalJobs,
                         int $pendingJobs,
                         int $failedJobs,
                         array $failedJobIds,
                         array $options,
                         CarbonImmutable $createdAt,
                         ?CarbonImmutable $cancelledAt,
                         ?CarbonImmutable $finishedAt)
    {
        return new Batch($this->queue, $repository, $id, $totalJobs, $pendingJobs, $failedJobs, $failedJobIds, $options, $createdAt, $cancelledAt, $finishedAt);
    }
}
