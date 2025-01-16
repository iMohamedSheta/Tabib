<p class="px-4 pb-6">
    مذكرة المريض هي مكان يمكن فيه للطبيب أو المريض كتابة ملاحظات هامة تتعلق بالحالة الصحية للمريض،
    مثل
    الأعراض، التشخيصات، التعليمات الطبية، أو أي معلومات أخرى قد تكون مفيدة لمتابعة العلاج.
</p>
<div class="flex flex-wrap">
    <x-cells.cell label="مذكرة المريض" :isText="true" :border="false" minHeight="200px">
        {{ $patient->notes }}
    </x-cells.cell>
</div>
