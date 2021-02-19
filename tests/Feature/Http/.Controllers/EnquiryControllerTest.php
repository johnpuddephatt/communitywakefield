<?php

namespace Tests\Feature\Http\Controllers;

use App\Notification\EnquiryNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EnquiryController
 */
class EnquiryControllerTest extends TestCase
{
    use AdditionalAssertions, WithFaker;

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EnquiryController::class,
            'store',
            \App\Http\Requests\EnquiryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_redirects()
    {
        $name = $this->faker->name;
        $message = $this->faker->text;

        Notification::fake();

        $response = $this->post(route('enquiry.store'), [
            'name' => $name,
            'message' => $message,
        ]);

        $response->assertRedirect(route('back'));
        $response->assertSessionHas('Message sent.', $Message sent->);

        Notification::assertSentTo($enquiry->team, EnquiryNotification::class, function ($notification) use ($enquiry) {
            return $notification->enquiry->is($enquiry);
        });
    }
}
