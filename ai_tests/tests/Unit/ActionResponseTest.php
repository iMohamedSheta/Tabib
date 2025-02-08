<?php

use App\Enums\Actions\ActionResponseStatusEnum;
use App\Responses\ActionResponse;


describe('ActionResponse', function () {
    it('can create a new ActionResponse instance', function () {
        $status = ActionResponseStatusEnum::SUCCESS;
        $message = 'Operation successful';
        $data = ['key' => 'value'];

        $actionResponse = new ActionResponse(true, $status, $message, $data);

        expect($actionResponse)->toBeInstanceOf(ActionResponse::class);
        expect($actionResponse->success)->toBeTrue();
        expect($actionResponse->status)->toBe($status);
        expect($actionResponse->message)->toBe($message);
        expect($actionResponse->data)->toEqual((object)$data);
    });

    it('can get the data', function () {
        $status = ActionResponseStatusEnum::SUCCESS;
        $message = 'Operation successful';
        $data = ['key' => 'value'];

        $actionResponse = new ActionResponse(true, $status, $message, $data);

        expect($actionResponse->getData())->toEqual((object)$data);
    });

    it('can check if the operation was successful', function () {
        $status = ActionResponseStatusEnum::SUCCESS;
        $message = 'Operation successful';
        $data = ['key' => 'value'];

        $actionResponse = new ActionResponse(true, $status, $message, $data);

        expect($actionResponse->isSuccess())->toBeTrue();

        $actionResponse = new ActionResponse(false, $status, $message, $data);

        expect($actionResponse->isSuccess())->toBeFalse();
    });

    it('can get the status', function () {
        $status = ActionResponseStatusEnum::SUCCESS;
        $message = 'Operation successful';
        $data = ['key' => 'value'];

        $actionResponse = new ActionResponse(true, $status, $message, $data);

        expect($actionResponse->getStatus())->toBe($status);
    });

    it('can get the message', function () {
        $status = ActionResponseStatusEnum::SUCCESS;
        $message = 'Operation successful';
        $data = ['key' => 'value'];

        $actionResponse = new ActionResponse(true, $status, $message, $data);

        expect($actionResponse->getMessage())->toBe($message);
    });

    it('handles non-array data correctly', function () {
        $status = ActionResponseStatusEnum::SUCCESS;
        $message = 'Operation successful';
        $data = 'string data';

        $actionResponse = new ActionResponse(true, $status, $message, $data);

        expect($actionResponse->getData())->toBe($data);
    });
});
