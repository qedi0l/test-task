<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Throwable;

class CleanOldRedisRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    /**
     * @throws \JsonException
     */
    public function handle(): void
    {
        $users = Redis::hgetall('users');

        if (empty($users)) {
            return;
        }

        $currentTime = now();
        $fiveMinutesAgo = $currentTime->subMinutes(5);

        foreach ($users as $userId => $userData) {
            $user = json_decode($userData, true, 512, JSON_THROW_ON_ERROR);

            if (isset($user['created_at'])) {
                $createdAt = Carbon::parse($user['created_at']);

                if ($createdAt < $fiveMinutesAgo) {
                    Redis::hdel('users', $userId);
                }
            }
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error($exception->getMessage());
    }
}
