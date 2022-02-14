<?php

namespace Tests\Feature\TaskTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Task;
use App\Setting;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void // this setup is called whenever a test is instantiated
    {
        parent::setUp();
        $task = factory(Setting::class)->create();
    }
    /**
     * Test that an error will occur if labal field is empty.
     *
     * @return void
     */
    public function testItValidatesLabelParamIsRequired(): void
    {
        $response = $this->json('POST', 'api/tasks/add-task', ['label' => '']);
        $errors = ["label"];
        $response->assertStatus(422)
            ->assertExactJson(
                [
                    "errors" => [
                        "label" => [
                            "The label field is required."
                        ]
                    ],
                    "message" => "The given data was invalid.",
                ]
            )->assertJsonValidationErrors($errors);
    }

    /**
     * Test that an error will occur if labal field is more than 191 chars.
     *
     * @return void
     */
    public function testItValidatesLabelParamIsNotMoreThanSpecifiedCharacterLength(): void
    {
        $label = "The 'composer install' process failed with an error. The cause 
        !     may be the download or installation of packages, or a pre- or
        !     post-install hook (e.g. a 'post-install-cmd' item in 'scripts')
        !     in your 'composer.json'.";
        $response = $this->json('POST', 'api/tasks/add-task', ['label' => $label]);
        $errors = ["label"];
        $response->assertStatus(422)
            ->assertExactJson(
                [
                    "errors" => [
                        "label" => [
                            "The label may not be greater than 191 characters."
                        ]
                    ],
                    "message" => "The given data was invalid.",
                ]
            )->assertJsonValidationErrors($errors);
    }

    /**
     * Test that an error will occur if we want to add duplicate task when setting "allow_duplicates" is set to "0".
     * This test also shows that every label value stored into the database is first trimmed and
     * turned to lower case before being saved into the database
     *
     * @return void
     */
    public function testItDoesntAllowDuplicateTask(): void
    {
        $task = factory(Task::class)->create(['label' => 'new label']);
        $response = $this->json('POST', 'api/tasks/add-task', ['label' => '  NeW laBel  ']);
        $response->assertStatus(422);
    }

    /**
     * Test that if the label param follows all validation rules and there is no duplicate then a task will be created
     *
     * @return void
     */
    public function testCreatesATaskIfNoValidationErrorOccursAndThereIsNoDuplicateOfTask(): void
    {
        $response = $this->json('POST', 'api/tasks/add-task', ['label' => '  NeW laBel  ']);
        $response->assertStatus(201)->assertCreated();
    }
}
