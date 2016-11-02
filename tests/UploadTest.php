<?php

use App\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadTest extends TestCase
{
    use DatabaseTransactions;

    protected $logo;

    public function setUp()
    {
        parent::setUp();

        $this->logo = base_path('tests/resources/styde.jpg');
    }

    function test_upload_through_form()
    {
        $this->visit(route('images.create'))
            ->type('Logo', 'title')
            ->attach($this->logo, 'image')
            ->press('Upload the image');

        $this->assertions();
    }

    function test_upload_with_call()
    {
        // "true" means it is a file for testing (not a user uploaded file).
        $files = [
            'image' => new UploadedFile($this->logo, $this->logo, null, null, null, true),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->call(
            'POST', route('images.store'),
            ['title' => 'Logo'], [], $files,
            $this->transformHeadersToServerVars($headers)
        );

        $this->assertions();
    }

    protected function assertions()
    {
        $this->see('Done!');

        $this->seeInDatabase('images', [
            'title' => 'Logo',
        ]);

        $image = Image::first();

        $file = storage_path('app/' . $image->image);

        $this->assertFileExists($file);

        //todo: use a virtual file system instead of deleting the file
        unlink($file);
    }
}
