<?php

use App\Enums\Actions\ActionResponseStatusEnum;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;

uses(Tests\TestCase::class);

class ActionResponseTraitTestClass {
    use ActionResponseTrait;
}

beforeEach(function () {
    $this->trait = new ActionResponseTraitTestClass();
});

describe('success', function () {
    it('returns a successful ActionResponse', function () {
        $message = 'Success message';
        $data = ['key' => 'value'];

        $response = $this->trait->success($message, $data);

        expect($response)->toBeInstanceOf(ActionResponse::class)
            ->success->toBeTrue()
            ->status->toBe(ActionResponseStatusEnum::SUCCESS)
            ->message->toBe($message)
            ->data->toBe($data);
    });

    it('returns a successful ActionResponse with default values', function () {
        $response = $this->trait->success();

        expect($response)->toBeInstanceOf(ActionResponse::class)
            ->success->toBeTrue()
            ->status->toBe(ActionResponseStatusEnum::SUCCESS)
            ->message->toBe('')
            ->data->toBeEmpty();
    });
});

describe('error', function () {
    it('returns an error ActionResponse', function () {
        $message = 'Error message';
        $data = ['key' => 'value'];

        $response = $this->trait->error($message, $data);

        expect($response)->toBeInstanceOf(ActionResponse::class)
            ->success->toBeFalse()
            ->status->toBe(ActionResponseStatusEnum::ERROR)
            ->message->toBe($message)
            ->data->toBe($data);
    });

    it('returns an error ActionResponse with default values', function () {
        $response = $this->trait->error();

        expect($response)->toBeInstanceOf(ActionResponse::class)
            ->success->toBeFalse()
            ->status->toBe(ActionResponseStatusEnum::ERROR)
            ->message->toBe('')
            ->data->toBeEmpty();
    });
});

describe('authorizeError', function () {
    it('returns an authorize error ActionResponse', function () {
        $message = 'Authorize error message';
        $data = ['key' => 'value'];

        $response = $this->trait->authorizeError($message, $data);

        expect($response)->toBeInstanceOf(ActionResponse::class)
            ->success->toBeFalse()
            ->status->toBe(ActionResponseStatusEnum::AUTHORIZE_ERROR)
            ->message->toBe($message)
            ->data->toBe($data);
    });

    it('returns an authorize error ActionResponse with default values', function () {
        $response = $this->trait->authorizeError();

        expect($response)->toBeInstanceOf(ActionResponse::class)
            ->success->toBeFalse()
            ->status->toBe(ActionResponseStatusEnum::AUTHORIZE_ERROR)
            ->message->toBe('')
            ->data->toBeEmpty();
    });
});
