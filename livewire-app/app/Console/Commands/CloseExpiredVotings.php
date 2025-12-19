<?php

namespace App\Console\Commands;

use App\Models\VotingPeriod;
use Illuminate\Console\Command;

class CloseExpiredVotings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voting:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close voting periods that have expired and determine winners';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all active voting periods that have ended
        $expiredVotings = VotingPeriod::where('status', 'activa')
            ->where('end_date', '<', now())
            ->get();

        if ($expiredVotings->isEmpty()) {
            $this->info('No expired voting periods to close.');
            return 0;
        }

        $count = 0;
        foreach ($expiredVotings as $voting) {
            try {
                $voting->closeVoting();
                $count++;
                
                $this->info("✓ Closed voting: {$voting->title} (ID: {$voting->id})");
                
                if ($voting->winner_book_id) {
                    $this->info("  Winner: {$voting->winnerBook->title}");
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed to close voting {$voting->id}: {$e->getMessage()}");
            }
        }

        $this->info("\nTotal closed: {$count} voting period(s)");
        return 0;
    }
}
