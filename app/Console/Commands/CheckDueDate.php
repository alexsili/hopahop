<?php

namespace App\Console\Commands;

use App\Models\Submission;
use App\Models\SubmissionReviewer;
use Illuminate\Console\Command;

class CheckDueDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckDueDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $unknownResponses = SubmissionReviewer::where('status', 0)->get();

        if ($unknownResponses) {
            foreach ($unknownResponses as $response) {
                $submissions = Submission::where('id', $response->submission_id)->get();
                if ($submissions) {
                    foreach ($submissions as $submission) {
                        if (strtotime($submission->due_date) - strtotime(now()) < 0) {
                            $submission->status = 0;
                            $submission->save();
                            $response->status = 2;
                            $response->save();
                        }
                    }
                }
            }
        }

        return 0;
    }
}
