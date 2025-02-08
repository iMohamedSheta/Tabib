<?php

use App\Enums\Media\MediaTypeEnum;

it('can get the correct label for FILE', function () {
    expect(MediaTypeEnum::FILE->label())->toBe('ملف');
});

it('can get the correct label for RADIOLOGY', function () {
    expect(MediaTypeEnum::RADIOLOGY->label())->toBe('اشعة');
});
