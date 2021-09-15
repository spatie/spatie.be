<?php

namespace Tests\Http\Controllers;


use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Http\Controllers\DownloadPurchasableController;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;

it('can download a purchasable', function () {
    /** @var PurchaseAssignment $assignment */
    $assignment = PurchaseAssignment::factory()->create();
    /** @var Purchasable $purchasable */
    $purchasable = $assignment->purchase->getPurchasables()->first();
    $media = $purchasable->addMedia(UploadedFile::fake()->create('some-file.pdf'))->toMediaCollection('downloads');

    $downloadUrl =  URL::temporarySignedRoute(
        'purchase.download',
        now()->addMinutes(30),
        [$assignment->purchasable->product, $assignment->purchase, $media]
    );

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this
        ->actingAs($assignment->user)
        ->get($downloadUrl);

    $response->assertSuccessful();
    $response->assertDownload('some-file.pdf');
});

it('aborts when the user isnt assigned', function () {
    /** @var PurchaseAssignment $assignment */
    $assignment = PurchaseAssignment::factory()->create();
    /** @var Purchasable $purchasable */
    $purchasable = $assignment->purchase->getPurchasables()->first();
    $media = $purchasable->addMedia(UploadedFile::fake()->create('some-file.pdf'))->toMediaCollection('downloads');

    $downloadUrl =  URL::temporarySignedRoute(
        'purchase.download',
        now()->addMinutes(30),
        [$assignment->purchasable->product, $assignment->purchase, $media]
    );

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get($downloadUrl);

    $response->assertForbidden();
    $response->assertSee('Purchase missing');
});

it('aborts when the file is from a different purchasable', function () {
    /** @var PurchaseAssignment $assignment */
    $assignment = PurchaseAssignment::factory()->create();

    $otherPurchasable = Purchasable::factory()->create();
    $media = $otherPurchasable->addMedia(UploadedFile::fake()->create('some-file.pdf'))->toMediaCollection('downloads');

    $downloadUrl =  URL::temporarySignedRoute(
        'purchase.download',
        now()->addMinutes(30),
        [$assignment->purchasable->product, $assignment->purchase, $media]
    );

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this
        ->actingAs($assignment->user)
        ->get($downloadUrl);

    $response->assertForbidden();
    $response->assertSee('File does not belong to purchasable');
});
