<div class="container mx-auto grid place-items-center h-full my-10">
    <button data-ripple-light="true" data-popover-target="menu"
        class="select-none rounded-lg bg-gray-900 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
        By category
    </button>
    <ul role="menu" data-popover="menu" data-popover-placement="bottom-start"
        class="bg-white min-w-[180px] p-3 mt-1 border border-blue-gray-50 rounded-md shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 overflow-auto focus:outline-none z-[999] !w-72">
        <li role="menuitem"
            class="flex justify-between w-full cursor-pointer select-none rounded-md px-3 pt-[9px] pb-2 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
            <button class="font-medium text-gray-600">Filter</button>
            <button class="text-gray-900 font-medium">Clear All</button>
        </li>
        <li role="menuitem"
            class="block w-full cursor-pointer select-none rounded-md px-3 pt-[9px] pb-2 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
            <div class="relative w-full min-w-[200px] h-10">
                <div
                    class="grid place-items-center absolute text-blue-gray-500 top-2/4 right-3 -translate-y-2/4 w-5 h-5">
                    <i class="fa fa-search text-gray-400" aria-hidden="true"></i>
                </div>
                <input
                    class="peer w-full h-full bg-transparent text-blue-gray-700 font-sans font-normal outline outline-0 focus:outline-0 disabled:bg-blue-gray-50 disabled:border-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 border focus:border-2 border-t-transparent focus:border-t-transparent text-sm px-3 py-2.5 rounded-[7px] !pr-9 border-blue-gray-200 focus:border-gray-900"
                    placeholder=" " />
                <label
                    class="flex w-full h-full select-none pointer-events-none absolute left-0 font-normal !overflow-visible truncate peer-placeholder-shown:text-blue-gray-500 leading-tight peer-focus:leading-tight peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 transition-all -top-1.5 peer-placeholder-shown:text-sm text-[11px] peer-focus:text-[11px] before:content[' '] before:block before:box-border before:w-2.5 before:h-1.5 before:mt-[6.5px] before:mr-1 peer-placeholder-shown:before:border-transparent before:rounded-tl-md before:border-t peer-focus:before:border-t-2 before:border-l peer-focus:before:border-l-2 before:pointer-events-none before:transition-all peer-disabled:before:border-transparent after:content[' '] after:block after:flex-grow after:box-border after:w-2.5 after:h-1.5 after:mt-[6.5px] after:ml-1 peer-placeholder-shown:after:border-transparent after:rounded-tr-md after:border-t peer-focus:after:border-t-2 after:border-r peer-focus:after:border-r-2 after:pointer-events-none after:transition-all peer-disabled:after:border-transparent peer-placeholder-shown:leading-[3.75] text-gray-500 peer-focus:text-gray-900 before:border-blue-gray-200 peer-focus:before:!border-gray-900 after:border-blue-gray-200 peer-focus:after:!border-gray-900">Search
                </label>
            </div>
        </li>
        <li role="menuitem"
            class="block w-full cursor-pointer select-none rounded-md px-3 pt-[9px] pb-2 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
            <div class="block relative w-full">
                <button type="button"
                    class="flex justify-between items-center w-full py-4 border-b border-b-blue-gray-100 text-gray-700 antialiased font-sans text-xl text-left font-semibold leading-snug select-none hover:text-gray-900 transition-colors text-gray-900 py-0 !border-0">
                    <p
                        class="block antialiased font-sans text-sm font-light leading-normal text-inherit font-medium text-gray-600">
                        Marketing
                    </p>
                    <span class="ml-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3" stroke="#9E9E9E" class="rotate-180 h-4 w-4 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5">
                            </path>
                        </svg></span>
                </button>
                <div class="overflow-hidden" style="height: auto">
                    <div
                        class="block w-full py-4 text-gray-700 antialiased font-sans text-sm font-light leading-normal !py-1 px-0.5">
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r0:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r0:" checked="" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                            fill="currentColor" stroke="currentColor" stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r0:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                        Social Media Campaigns
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                23
                            </p>
                        </div>
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r1:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r1:" checked="" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                            fill="currentColor" stroke="currentColor" stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r1:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                        SEO Optimization
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                15
                            </p>
                        </div>
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r2:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r2:" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                            fill="currentColor" stroke="currentColor" stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r2:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-gray-700 font-medium">
                                        Content Strategy
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-gray-700 font-medium">
                                8
                            </p>
                        </div>
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r3:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r3:" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                            stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r3:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-gray-700 font-medium">
                                        Email Marketing
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-gray-700 font-medium">
                                19
                            </p>
                        </div>
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r4:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r4:" checked="" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                            stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r4:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                        Brand Management
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                12
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li role="menuitem"
            class="flex justify-between w-full cursor-pointer select-none rounded-md px-3 pt-[9px] pb-2 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
            <div class="block relative w-full">
                <button type="button"
                    class="flex justify-between items-center w-full py-4 border-b border-b-blue-gray-100 text-gray-700 antialiased font-sans text-xl text-left font-semibold leading-snug select-none hover:text-gray-900 transition-colors py-0 !border-0">
                    <p
                        class="block antialiased font-sans text-sm font-light leading-normal text-inherit font-medium text-gray-600">
                        Product Development
                    </p>
                    <span class="ml-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3" stroke="#9E9E9E" class="h-4 w-4 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5">
                            </path>
                        </svg></span>
                </button>
                <div class="overflow-hidden" style="height: 0px">
                    <div
                        class="block w-full py-4 text-gray-700 antialiased font-sans text-sm font-light leading-normal">
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r5:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r5:" checked="" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                            stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r5:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                        Marketings
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                12
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li role="menuitem"
            class="flex justify-between w-full cursor-pointer select-none rounded-md px-3 pt-[9px] pb-2 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
            <div class="block relative w-full">
                <button type="button"
                    class="flex justify-between items-center w-full py-4 border-b border-b-blue-gray-100 text-gray-700 antialiased font-sans text-xl text-left font-semibold leading-snug select-none hover:text-gray-900 transition-colors py-0 !border-0">
                    <p
                        class="block antialiased font-sans text-sm font-light leading-normal text-inherit font-medium text-gray-600">
                        Customer Support
                    </p>
                    <span class="ml-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3" stroke="#9E9E9E" class="h-4 w-4 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5">
                            </path>
                        </svg></span>
                </button>
                <div class="overflow-hidden" style="height: 0px">
                    <div
                        class="block w-full py-4 text-gray-700 antialiased font-sans text-sm font-light leading-normal">
                        <div class="flex !justify-between items-center">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer p-3 rounded-full -ml-3 py-2"
                                    for=":r6:"><input type="checkbox"
                                        class="peer relative appearance-none w-5 h-5 border rounded-md border-blue-gray-200 cursor-pointer transition-all before:content[''] before:block before:bg-blue-gray-500 before:w-12 before:h-12 before:rounded-full before:absolute before:top-2/4 before:left-2/4 before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 hover:before:opacity-10 before:transition-opacity checked:bg-gray-900 checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0"
                                        id=":r6:" /><span
                                        class="text-white absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                            stroke-width="1">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg></span></label><label
                                    class="text-gray-700 font-light select-none cursor-pointer mt-px" for=":r6:">
                                    <p
                                        class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                        Support
                                    </p>
                                </label>
                            </div>
                            <p
                                class="block antialiased font-sans text-sm font-light leading-normal text-blue-gray-900 font-medium">
                                20
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

@push('scripts')
    <script type="module" src="https://unpkg.com/@material-tailwind/html@latest/scripts/popover.js"></script>
@endpush
