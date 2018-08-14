<?php

namespace App\Console\Commands\Testing;

use App\Models\Campus;
use Illuminate\Console\Command;

class PredefinedDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:testing-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add some testing data in School';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campus_id = $this->ask('Enter Campus ID: ');

        $campus = Campus::find($campus_id);

        if (!$campus) {
            $this->error('Campus is wrong');
            return;
        }

        $creator = $campus->creator;

        foreach ($this->getSubjects() as $info) {
            $subject = $campus->subjects()->create($info);
            $subject->created_by = $creator->id;
            $subject->save();
        }

        foreach ($this->getGrades() as $info) {

            $grade = $campus->grades()->create($info);
            $grade->created_by = $creator->id;
            $grade->save();

            if (isset($info['sections'])) {
                $sections = $info['sections'];

                foreach ($sections as $section) {

                    $section = $grade->sections()->create($section);
                    $section->created_by = $creator->id;
                    $section->save();

                    $section->subjects()->attach($campus->subjects->pluck('id'));
                }
            }
        }

    }

    protected function getSubjects()
    {
        return [
            [
                'name' => 'Math',
                'code' => 'math',
            ],
            [
                'name' => 'English',
                'code' => 'eng',
            ],
            [
                'name' => 'Urdu',
                'code' => 'ur',
            ],
            [
                'name' => 'Science',
                'code' => 'sci',
            ],
        ];
    }

    protected function getGrades()
    {
        return [
            [
                'name' => 'One',
                'code' => '1',
                'fee' => 500,
                'sections' => [
                    [
                        'name' => 'A',
                        'code' => 'a',
                    ],
                    [
                        'name' => 'B',
                        'code' => 'b',
                    ],
                    [
                        'name' => 'C',
                        'code' => 'c',
                    ],
                ]
            ],
            [
                'name' => 'Two',
                'code' => '2',
                'fee' => 540,
                'sections' => [
                    [
                        'name' => 'A',
                        'code' => 'a',
                    ],
                    [
                        'name' => 'B',
                        'code' => 'b',
                    ],
                ]
            ],
            [
                'name' => 'Three',
                'code' => '3',
                'fee' => 600,
                'sections' => [
                    [
                        'name' => 'A',
                        'code' => 'a',
                    ],
                    [
                        'name' => 'B',
                        'code' => 'b',
                    ],
                    [
                        'name' => 'C',
                        'code' => 'c',
                    ],
                ]
            ],
            [
                'name' => 'Four',
                'code' => '4',
                'fee' => 650,
                'sections' => [
                    [
                        'name' => 'A',
                        'code' => 'a',
                    ],
                ]
            ],
        ];
    }
}
