@extends('layouts.guest')

@section('main')
    <nav
        class="block py-4 backdrop-saturate-200 backdrop-blur-2xl  bg-opacity-100 border-white/80 w-full max-w-full rounded-none px-4 bg-c-gray-900  text-white border-0">
        <div class="container mx-auto flex items-center justify-between">
            <p class="block antialiased  leading-relaxed  text-lg font-bold">
                Material Tailwind
            </p>
            <ul class="ml-10 hidden items-center gap-6 lg:flex">
                <li>
                    <a href="#"
                        class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="h-5 w-5">
                            <path
                                d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z">
                            </path>
                        </svg>Pages</a>
                </li>
                <li>
                    <a href="#"
                        class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                clip-rule="evenodd"></path>
                        </svg>Account</a>
                </li>
                <li>
                    <a href="#"
                        class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M3 6a3 3 0 013-3h2.25a3 3 0 013 3v2.25a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm9.75 0a3 3 0 013-3H18a3 3 0 013 3v2.25a3 3 0 01-3 3h-2.25a3 3 0 01-3-3V6zM3 15.75a3 3 0 013-3h2.25a3 3 0 013 3V18a3 3 0 01-3 3H6a3 3 0 01-3-3v-2.25zm9.75 0a3 3 0 013-3H18a3 3 0 013 3V18a3 3 0 01-3 3h-2.25a3 3 0 01-3-3v-2.25z"
                                clip-rule="evenodd"></path>
                        </svg>Blocks</a>
                </li>
                <li>
                    <a href="#"
                        class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M2.25 6a3 3 0 013-3h13.5a3 3 0 013 3v12a3 3 0 01-3 3H5.25a3 3 0 01-3-3V6zm3.97.97a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 01-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06zm4.28 4.28a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                                clip-rule="evenodd"></path>
                        </svg>Docs</a>
                </li>
            </ul>
            <div class="hidden items-center gap-4 lg:flex">
                <a href="{{ route('login') }}"
                    class="align-middle select-none  font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg text-gray-900 hover:bg-gray-900/10 active:bg-gray-900/20"
                    type="button" data-ripple-light="true">
                    Log in</ش><button
                        class="align-middle select-none  font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none"
                        type="button" data-ripple-light="true">
                        تسجيل الدخول
                    </button>
            </div>
            <button
                class="relative ml-auto inline-block h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle  text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden"
                type="button" data-ripple-dark="true" data-collapse-target="navbar">
                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg></span>
            </button>
        </div>
        <div data-collapse="navbar"
            class="block h-0 w-full basis-full overflow-hidden transition-all duration-300 ease-in lg:hidden">
            <div class="container mx-auto mt-3 border-t border-blue-gray-50 px-2 pt-4">
                <ul class="flex flex-col gap-4">
                    <li>
                        <a href="#"
                            class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5">
                                <path
                                    d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z">
                                </path>
                            </svg>Pages</a>
                    </li>
                    <li>
                        <a href="#"
                            class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5">
                                <path fill-rule="evenodd"
                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    clip-rule="evenodd"></path>
                            </svg>Account</a>
                    </li>
                    <li>
                        <a href="#"
                            class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5">
                                <path fill-rule="evenodd"
                                    d="M3 6a3 3 0 013-3h2.25a3 3 0 013 3v2.25a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm9.75 0a3 3 0 013-3H18a3 3 0 013 3v2.25a3 3 0 01-3 3h-2.25a3 3 0 01-3-3V6zM3 15.75a3 3 0 013-3h2.25a3 3 0 013 3V18a3 3 0 01-3 3H6a3 3 0 01-3-3v-2.25zm9.75 0a3 3 0 013-3H18a3 3 0 013 3V18a3 3 0 01-3 3h-2.25a3 3 0 01-3-3v-2.25z"
                                    clip-rule="evenodd"></path>
                            </svg>Blocks</a>
                    </li>
                    <li>
                        <a href="#"
                            class="antialiased  text-base leading-relaxed  text-gray-50 flex items-center gap-2 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5">
                                <path fill-rule="evenodd"
                                    d="M2.25 6a3 3 0 013-3h13.5a3 3 0 013 3v12a3 3 0 01-3 3H5.25a3 3 0 01-3-3V6zm3.97.97a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 01-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06zm4.28 4.28a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                                    clip-rule="evenodd"></path>
                            </svg>Docs</a>
                    </li>
                </ul>
                <div class="mt-6 mb-4 flex items-center gap-4">
                    <button
                        class="align-middle select-none  font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg text-gray-900 hover:bg-gray-900/10 active:bg-gray-900/20"
                        type="button" data-ripple-dark="true">
                        Log in</button><button
                        class="align-middle select-none  font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none"
                        type="button" data-ripple-light="true">
                        تسجيل الدخول
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-white p-8">
        <div
            class="grid mt-16 min-h-[82vh] w-full lg:h-[54rem] md:h-[34rem] place-items-stretch bg-[url('/image/bg-hero-17.svg')] bg-center bg-contain bg-no-repeat">
            <div class="container mx-auto px-4 text-center">
                <p
                    class="antialiased  leading-relaxed text-inherit inline-flex text-xs rounded-lg border-[1.5px] border-blue-gray-50 bg-white py-1 lg:px-4 px-1 font-medium text-primary">
                    Exciting News! Introducing our latest innovation
                </p>
                <h1
                    class="block antialiased tracking-normal  font-semibold  mx-auto my-6 w-full leading-snug !text-2xl lg:max-w-3xl lg:!text-5xl">
                    Get ready to experience a new level of
                    <span class="text-green-500 leading-snug">performance</span> and
                    <span class="leading-snug text-green-500">functionality</span>.
                </h1>
                <p
                    class="block antialiased  font-normal leading-relaxed text-inherit mx-auto w-full !text-gray-500 lg:text-lg text-base">
                    The time is now for it to be okay to be great. For being a bright color.
                    For standing out.
                </p>
                <div class="mt-8 grid w-full place-items-start md:justify-center">
                    <div class="mb-2 flex w-full flex-col gap-4 md:flex-row">
                        <div class="relative w-full min-w-[200px] h-11">
                            <input
                                class="peer w-full h-full bg-transparent text-gray-50  font-normal outline outline-0 focus:outline-0 disabled:bg-blue-gray-50 disabled:border-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 border focus:border-2 border-t-transparent focus:border-t-transparent text-sm px-3 py-3 rounded-md border-blue-gray-200 focus:border-gray-900"
                                placeholder=" " /><label
                                class="flex w-full h-full select-none pointer-events-none absolute left-0 font-normal !overflow-visible truncate peer-placeholder-shown:text-blue-gray-500 leading-tight peer-focus:leading-tight peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 transition-all -top-1.5 peer-placeholder-shown:text-sm text-[11px] peer-focus:text-[11px] before:content[' '] before:block before:box-border before:w-2.5 before:h-1.5 before:mt-[6.5px] before:mr-1 peer-placeholder-shown:before:border-transparent before:rounded-tl-md before:border-t peer-focus:before:border-t-2 before:border-l peer-focus:before:border-l-2 before:pointer-events-none before:transition-all peer-disabled:before:border-transparent after:content[' '] after:block after:flex-grow after:box-border after:w-2.5 after:h-1.5 after:mt-[6.5px] after:ml-1 peer-placeholder-shown:after:border-transparent after:rounded-tr-md after:border-t peer-focus:after:border-t-2 after:border-r peer-focus:after:border-r-2 after:pointer-events-none after:transition-all peer-disabled:after:border-transparent peer-placeholder-shown:leading-[4.1] text-gray-500 peer-focus:text-gray-900 before:border-blue-gray-200 peer-focus:before:!border-gray-900 after:border-blue-gray-200 peer-focus:after:!border-gray-900">Enter
                                your email<!-- -->
                            </label>
                        </div>
                        <button
                            class="align-middle select-none  font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none w-full md:w-[12rem]"
                            type="button" data-ripple-light="true">
                            get started
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection
