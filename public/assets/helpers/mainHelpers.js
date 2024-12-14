function log(...text) {
    console.log(...text);
    return;
}


function dd(...text) {
    console.log(...text);
    return;
}

function triggerLivewireInputEvent(ref) {
    ref.dispatchEvent(new Event('input', {
        bubbles: true
    })); // Notify Livewire that input value is changed
}
