<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YEN BANGUNAN - Toko Bangunan Cikarang Terlengkap & Terbesar</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/logo-crop.png') }}"/>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Flowbite CSS -->
        <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.cdnfonts.com/css/d-din" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Special+Gothic+Condensed+One&display=swap" rel="stylesheet">

        <!-- Box Icons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                video {
                    min-width: 100%;
                    min-height: 100%;
                    width: auto;
                    height: auto;
                    transform: translate(-50%, -50%);
                    object-fit: cover;
                    z-index: -1;
                };
                video.fullscreen-video {
                    width: 100vw;
                    height: 100vh;
                    object-fit: cover;
                    z-index: -1;
                }
                @keyframes marquee {
                    0% {
                        transform: translateX(0);
                    }
                    100% {
                        transform: translateX(-50%);
                    }
                }
                
                .animate-marquee {
                    animation: marquee 30s linear infinite;
                }
                
                .animate-marquee:hover {
                    animation-play-state: paused;
                }
                @keyframes pulse-ring {
                    0% {
                        transform: scale(0.8);
                        opacity: 1;
                    }
                    100% {
                        transform: scale(1.2);
                        opacity: 0;
                    }
                }
                
                .whatsapp-pulse::before {
                    content: '';
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    background-color: rgba(34, 197, 94, 0.5);
                    animation: pulse-ring 1.5s infinite;
                }
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--color-red-50:oklch(.971 .013 17.38);--color-red-100:oklch(.936 .032 17.717);--color-red-200:oklch(.885 .062 18.334);--color-red-300:oklch(.808 .114 19.571);--color-red-400:oklch(.704 .191 22.216);--color-red-500:oklch(.637 .237 25.331);--color-red-600:oklch(.577 .245 27.325);--color-red-700:oklch(.505 .213 27.518);--color-red-800:oklch(.444 .177 26.899);--color-red-900:oklch(.396 .141 25.723);--color-red-950:oklch(.258 .092 26.042);--color-orange-50:oklch(.98 .016 73.684);--color-orange-100:oklch(.954 .038 75.164);--color-orange-200:oklch(.901 .076 70.697);--color-orange-300:oklch(.837 .128 66.29);--color-orange-400:oklch(.75 .183 55.934);--color-orange-500:oklch(.705 .213 47.604);--color-orange-600:oklch(.646 .222 41.116);--color-orange-700:oklch(.553 .195 38.402);--color-orange-800:oklch(.47 .157 37.304);--color-orange-900:oklch(.408 .123 38.172);--color-orange-950:oklch(.266 .079 36.259);--color-amber-50:oklch(.987 .022 95.277);--color-amber-100:oklch(.962 .059 95.617);--color-amber-200:oklch(.924 .12 95.746);--color-amber-300:oklch(.879 .169 91.605);--color-amber-400:oklch(.828 .189 84.429);--color-amber-500:oklch(.769 .188 70.08);--color-amber-600:oklch(.666 .179 58.318);--color-amber-700:oklch(.555 .163 48.998);--color-amber-800:oklch(.473 .137 46.201);--color-amber-900:oklch(.414 .112 45.904);--color-amber-950:oklch(.279 .077 45.635);--color-yellow-50:oklch(.987 .026 102.212);--color-yellow-100:oklch(.973 .071 103.193);--color-yellow-200:oklch(.945 .129 101.54);--color-yellow-300:oklch(.905 .182 98.111);--color-yellow-400:oklch(.852 .199 91.936);--color-yellow-500:oklch(.795 .184 86.047);--color-yellow-600:oklch(.681 .162 75.834);--color-yellow-700:oklch(.554 .135 66.442);--color-yellow-800:oklch(.476 .114 61.907);--color-yellow-900:oklch(.421 .095 57.708);--color-yellow-950:oklch(.286 .066 53.813);--color-lime-50:oklch(.986 .031 120.757);--color-lime-100:oklch(.967 .067 122.328);--color-lime-200:oklch(.938 .127 124.321);--color-lime-300:oklch(.897 .196 126.665);--color-lime-400:oklch(.841 .238 128.85);--color-lime-500:oklch(.768 .233 130.85);--color-lime-600:oklch(.648 .2 131.684);--color-lime-700:oklch(.532 .157 131.589);--color-lime-800:oklch(.453 .124 130.933);--color-lime-900:oklch(.405 .101 131.063);--color-lime-950:oklch(.274 .072 132.109);--color-green-50:oklch(.982 .018 155.826);--color-green-100:oklch(.962 .044 156.743);--color-green-200:oklch(.925 .084 155.995);--color-green-300:oklch(.871 .15 154.449);--color-green-400:oklch(.792 .209 151.711);--color-green-500:oklch(.723 .219 149.579);--color-green-600:oklch(.627 .194 149.214);--color-green-700:oklch(.527 .154 150.069);--color-green-800:oklch(.448 .119 151.328);--color-green-900:oklch(.393 .095 152.535);--color-green-950:oklch(.266 .065 152.934);--color-emerald-50:oklch(.979 .021 166.113);--color-emerald-100:oklch(.95 .052 163.051);--color-emerald-200:oklch(.905 .093 164.15);--color-emerald-300:oklch(.845 .143 164.978);--color-emerald-400:oklch(.765 .177 163.223);--color-emerald-500:oklch(.696 .17 162.48);--color-emerald-600:oklch(.596 .145 163.225);--color-emerald-700:oklch(.508 .118 165.612);--color-emerald-800:oklch(.432 .095 166.913);--color-emerald-900:oklch(.378 .077 168.94);--color-emerald-950:oklch(.262 .051 172.552);--color-teal-50:oklch(.984 .014 180.72);--color-teal-100:oklch(.953 .051 180.801);--color-teal-200:oklch(.91 .096 180.426);--color-teal-300:oklch(.855 .138 181.071);--color-teal-400:oklch(.777 .152 181.912);--color-teal-500:oklch(.704 .14 182.503);--color-teal-600:oklch(.6 .118 184.704);--color-teal-700:oklch(.511 .096 186.391);--color-teal-800:oklch(.437 .078 188.216);--color-teal-900:oklch(.386 .063 188.416);--color-teal-950:oklch(.277 .046 192.524);--color-cyan-50:oklch(.984 .019 200.873);--color-cyan-100:oklch(.956 .045 203.388);--color-cyan-200:oklch(.917 .08 205.041);--color-cyan-300:oklch(.865 .127 207.078);--color-cyan-400:oklch(.789 .154 211.53);--color-cyan-500:oklch(.715 .143 215.221);--color-cyan-600:oklch(.609 .126 221.723);--color-cyan-700:oklch(.52 .105 223.128);--color-cyan-800:oklch(.45 .085 224.283);--color-cyan-900:oklch(.398 .07 227.392);--color-cyan-950:oklch(.302 .056 229.695);--color-sky-50:oklch(.977 .013 236.62);--color-sky-100:oklch(.951 .026 236.824);--color-sky-200:oklch(.901 .058 230.902);--color-sky-300:oklch(.828 .111 230.318);--color-sky-400:oklch(.746 .16 232.661);--color-sky-500:oklch(.685 .169 237.323);--color-sky-600:oklch(.588 .158 241.966);--color-sky-700:oklch(.5 .134 242.749);--color-sky-800:oklch(.443 .11 240.79);--color-sky-900:oklch(.391 .09 240.876);--color-sky-950:oklch(.293 .066 243.157);--color-blue-50:oklch(.97 .014 254.604);--color-blue-100:oklch(.932 .032 255.585);--color-blue-200:oklch(.882 .059 254.128);--color-blue-300:oklch(.809 .105 251.813);--color-blue-400:oklch(.707 .165 254.624);--color-blue-500:oklch(.623 .214 259.815);--color-blue-600:oklch(.546 .245 262.881);--color-blue-700:oklch(.488 .243 264.376);--color-blue-800:oklch(.424 .199 265.638);--color-blue-900:oklch(.379 .146 265.522);--color-blue-950:oklch(.282 .091 267.935);--color-indigo-50:oklch(.962 .018 272.314);--color-indigo-100:oklch(.93 .034 272.788);--color-indigo-200:oklch(.87 .065 274.039);--color-indigo-300:oklch(.785 .115 274.713);--color-indigo-400:oklch(.673 .182 276.935);--color-indigo-500:oklch(.585 .233 277.117);--color-indigo-600:oklch(.511 .262 276.966);--color-indigo-700:oklch(.457 .24 277.023);--color-indigo-800:oklch(.398 .195 277.366);--color-indigo-900:oklch(.359 .144 278.697);--color-indigo-950:oklch(.257 .09 281.288);--color-violet-50:oklch(.969 .016 293.756);--color-violet-100:oklch(.943 .029 294.588);--color-violet-200:oklch(.894 .057 293.283);--color-violet-300:oklch(.811 .111 293.571);--color-violet-400:oklch(.702 .183 293.541);--color-violet-500:oklch(.606 .25 292.717);--color-violet-600:oklch(.541 .281 293.009);--color-violet-700:oklch(.491 .27 292.581);--color-violet-800:oklch(.432 .232 292.759);--color-violet-900:oklch(.38 .189 293.745);--color-violet-950:oklch(.283 .141 291.089);--color-purple-50:oklch(.977 .014 308.299);--color-purple-100:oklch(.946 .033 307.174);--color-purple-200:oklch(.902 .063 306.703);--color-purple-300:oklch(.827 .119 306.383);--color-purple-400:oklch(.714 .203 305.504);--color-purple-500:oklch(.627 .265 303.9);--color-purple-600:oklch(.558 .288 302.321);--color-purple-700:oklch(.496 .265 301.924);--color-purple-800:oklch(.438 .218 303.724);--color-purple-900:oklch(.381 .176 304.987);--color-purple-950:oklch(.291 .149 302.717);--color-fuchsia-50:oklch(.977 .017 320.058);--color-fuchsia-100:oklch(.952 .037 318.852);--color-fuchsia-200:oklch(.903 .076 319.62);--color-fuchsia-300:oklch(.833 .145 321.434);--color-fuchsia-400:oklch(.74 .238 322.16);--color-fuchsia-500:oklch(.667 .295 322.15);--color-fuchsia-600:oklch(.591 .293 322.896);--color-fuchsia-700:oklch(.518 .253 323.949);--color-fuchsia-800:oklch(.452 .211 324.591);--color-fuchsia-900:oklch(.401 .17 325.612);--color-fuchsia-950:oklch(.293 .136 325.661);--color-pink-50:oklch(.971 .014 343.198);--color-pink-100:oklch(.948 .028 342.258);--color-pink-200:oklch(.899 .061 343.231);--color-pink-300:oklch(.823 .12 346.018);--color-pink-400:oklch(.718 .202 349.761);--color-pink-500:oklch(.656 .241 354.308);--color-pink-600:oklch(.592 .249 .584);--color-pink-700:oklch(.525 .223 3.958);--color-pink-800:oklch(.459 .187 3.815);--color-pink-900:oklch(.408 .153 2.432);--color-pink-950:oklch(.284 .109 3.907);--color-rose-50:oklch(.969 .015 12.422);--color-rose-100:oklch(.941 .03 12.58);--color-rose-200:oklch(.892 .058 10.001);--color-rose-300:oklch(.81 .117 11.638);--color-rose-400:oklch(.712 .194 13.428);--color-rose-500:oklch(.645 .246 16.439);--color-rose-600:oklch(.586 .253 17.585);--color-rose-700:oklch(.514 .222 16.935);--color-rose-800:oklch(.455 .188 13.697);--color-rose-900:oklch(.41 .159 10.272);--color-rose-950:oklch(.271 .105 12.094);--color-slate-50:oklch(.984 .003 247.858);--color-slate-100:oklch(.968 .007 247.896);--color-slate-200:oklch(.929 .013 255.508);--color-slate-300:oklch(.869 .022 252.894);--color-slate-400:oklch(.704 .04 256.788);--color-slate-500:oklch(.554 .046 257.417);--color-slate-600:oklch(.446 .043 257.281);--color-slate-700:oklch(.372 .044 257.287);--color-slate-800:oklch(.279 .041 260.031);--color-slate-900:oklch(.208 .042 265.755);--color-slate-950:oklch(.129 .042 264.695);--color-gray-50:oklch(.985 .002 247.839);--color-gray-100:oklch(.967 .003 264.542);--color-gray-200:oklch(.928 .006 264.531);--color-gray-300:oklch(.872 .01 258.338);--color-gray-400:oklch(.707 .022 261.325);--color-gray-500:oklch(.551 .027 264.364);--color-gray-600:oklch(.446 .03 256.802);--color-gray-700:oklch(.373 .034 259.733);--color-gray-800:oklch(.278 .033 256.848);--color-gray-900:oklch(.21 .034 264.665);--color-gray-950:oklch(.13 .028 261.692);--color-zinc-50:oklch(.985 0 0);--color-zinc-100:oklch(.967 .001 286.375);--color-zinc-200:oklch(.92 .004 286.32);--color-zinc-300:oklch(.871 .006 286.286);--color-zinc-400:oklch(.705 .015 286.067);--color-zinc-500:oklch(.552 .016 285.938);--color-zinc-600:oklch(.442 .017 285.786);--color-zinc-700:oklch(.37 .013 285.805);--color-zinc-800:oklch(.274 .006 286.033);--color-zinc-900:oklch(.21 .006 285.885);--color-zinc-950:oklch(.141 .005 285.823);--color-neutral-50:oklch(.985 0 0);--color-neutral-100:oklch(.97 0 0);--color-neutral-200:oklch(.922 0 0);--color-neutral-300:oklch(.87 0 0);--color-neutral-400:oklch(.708 0 0);--color-neutral-500:oklch(.556 0 0);--color-neutral-600:oklch(.439 0 0);--color-neutral-700:oklch(.371 0 0);--color-neutral-800:oklch(.269 0 0);--color-neutral-900:oklch(.205 0 0);--color-neutral-950:oklch(.145 0 0);--color-stone-50:oklch(.985 .001 106.423);--color-stone-100:oklch(.97 .001 106.424);--color-stone-200:oklch(.923 .003 48.717);--color-stone-300:oklch(.869 .005 56.366);--color-stone-400:oklch(.709 .01 56.259);--color-stone-500:oklch(.553 .013 58.071);--color-stone-600:oklch(.444 .011 73.639);--color-stone-700:oklch(.374 .01 67.558);--color-stone-800:oklch(.268 .007 34.298);--color-stone-900:oklch(.216 .006 56.043);--color-stone-950:oklch(.147 .004 49.25);--color-black:#000;--color-white:#fff;--spacing:.25rem;--breakpoint-sm:40rem;--breakpoint-md:48rem;--breakpoint-lg:64rem;--breakpoint-xl:80rem;--breakpoint-2xl:96rem;--container-3xs:16rem;--container-2xs:18rem;--container-xs:20rem;--container-sm:24rem;--container-md:28rem;--container-lg:32rem;--container-xl:36rem;--container-2xl:42rem;--container-3xl:48rem;--container-4xl:56rem;--container-5xl:64rem;--container-6xl:72rem;--container-7xl:80rem;--text-xs:.75rem;--text-xs--line-height:calc(1/.75);--text-sm:.875rem;--text-sm--line-height:calc(1.25/.875);--text-base:1rem;--text-base--line-height: 1.5 ;--text-lg:1.125rem;--text-lg--line-height:calc(1.75/1.125);--text-xl:1.25rem;--text-xl--line-height:calc(1.75/1.25);--text-2xl:1.5rem;--text-2xl--line-height:calc(2/1.5);--text-3xl:1.875rem;--text-3xl--line-height: 1.2 ;--text-4xl:2.25rem;--text-4xl--line-height:calc(2.5/2.25);--text-5xl:3rem;--text-5xl--line-height:1;--text-6xl:3.75rem;--text-6xl--line-height:1;--text-7xl:4.5rem;--text-7xl--line-height:1;--text-8xl:6rem;--text-8xl--line-height:1;--text-9xl:8rem;--text-9xl--line-height:1;--font-weight-thin:100;--font-weight-extralight:200;--font-weight-light:300;--font-weight-normal:400;--font-weight-medium:500;--font-weight-semibold:600;--font-weight-bold:700;--font-weight-extrabold:800;--font-weight-black:900;--tracking-tighter:-.05em;--tracking-tight:-.025em;--tracking-normal:0em;--tracking-wide:.025em;--tracking-wider:.05em;--tracking-widest:.1em;--leading-tight:1.25;--leading-snug:1.375;--leading-normal:1.5;--leading-relaxed:1.625;--leading-loose:2;--radius-xs:.125rem;--radius-sm:.25rem;--radius-md:.375rem;--radius-lg:.5rem;--radius-xl:.75rem;--radius-2xl:1rem;--radius-3xl:1.5rem;--radius-4xl:2rem;--shadow-2xs:0 1px #0000000d;--shadow-xs:0 1px 2px 0 #0000000d;--shadow-sm:0 1px 3px 0 #0000001a,0 1px 2px -1px #0000001a;--shadow-md:0 4px 6px -1px #0000001a,0 2px 4px -2px #0000001a;--shadow-lg:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--shadow-xl:0 20px 25px -5px #0000001a,0 8px 10px -6px #0000001a;--shadow-2xl:0 25px 50px -12px #00000040;--inset-shadow-2xs:inset 0 1px #0000000d;--inset-shadow-xs:inset 0 1px 1px #0000000d;--inset-shadow-sm:inset 0 2px 4px #0000000d;--drop-shadow-xs:0 1px 1px #0000000d;--drop-shadow-sm:0 1px 2px #00000026;--drop-shadow-md:0 3px 3px #0000001f;--drop-shadow-lg:0 4px 4px #00000026;--drop-shadow-xl:0 9px 7px #0000001a;--drop-shadow-2xl:0 25px 25px #00000026;--ease-in:cubic-bezier(.4,0,1,1);--ease-out:cubic-bezier(0,0,.2,1);--ease-in-out:cubic-bezier(.4,0,.2,1);--animate-spin:spin 1s linear infinite;--animate-ping:ping 1s cubic-bezier(0,0,.2,1)infinite;--animate-pulse:pulse 2s cubic-bezier(.4,0,.6,1)infinite;--animate-bounce:bounce 1s infinite;--blur-xs:4px;--blur-sm:8px;--blur-md:12px;--blur-lg:16px;--blur-xl:24px;--blur-2xl:40px;--blur-3xl:64px;--perspective-dramatic:100px;--perspective-near:300px;--perspective-normal:500px;--perspective-midrange:800px;--perspective-distant:1200px;--aspect-video:16/9;--default-transition-duration:.15s;--default-transition-timing-function:cubic-bezier(.4,0,.2,1);--default-font-family:var(--font-sans);--default-font-feature-settings:var(--font-sans--font-feature-settings);--default-font-variation-settings:var(--font-sans--font-variation-settings);--default-mono-font-family:var(--font-mono);--default-mono-font-feature-settings:var(--font-mono--font-feature-settings);--default-mono-font-variation-settings:var(--font-mono--font-variation-settings)}}@layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}::file-selector-button{box-sizing:border-box;border:0 solid;margin:0;padding:0}html,:host{-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;line-height:1.5;font-family:var(--default-font-family,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji");font-feature-settings:var(--default-font-feature-settings,normal);font-variation-settings:var(--default-font-variation-settings,normal);-webkit-tap-highlight-color:transparent}body{line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;-webkit-text-decoration:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:var(--default-mono-font-family,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace);font-feature-settings:var(--default-mono-font-feature-settings,normal);font-variation-settings:var(--default-mono-font-variation-settings,normal);font-size:1em}small{font-size:80%}sub,sup{vertical-align:baseline;font-size:75%;line-height:0;position:relative}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}:-moz-focusring{outline:auto}progress{vertical-align:baseline}summary{display:list-item}ol,ul,menu{list-style:none}img,svg,video,canvas,audio,iframe,embed,object{vertical-align:middle;display:block}img,video{max-width:100%;height:auto}button,input,select,optgroup,textarea{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}::file-selector-button{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}:where(select:is([multiple],[size])) optgroup{font-weight:bolder}:where(select:is([multiple],[size])) optgroup option{padding-inline-start:20px}::file-selector-button{margin-inline-end:4px}::placeholder{opacity:1;color:color-mix(in oklab,currentColor 50%,transparent)}textarea{resize:vertical}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-date-and-time-value{min-height:1lh;text-align:inherit}::-webkit-datetime-edit{display:inline-flex}::-webkit-datetime-edit-fields-wrapper{padding:0}::-webkit-datetime-edit{padding-block:0}::-webkit-datetime-edit-year-field{padding-block:0}::-webkit-datetime-edit-month-field{padding-block:0}::-webkit-datetime-edit-day-field{padding-block:0}::-webkit-datetime-edit-hour-field{padding-block:0}::-webkit-datetime-edit-minute-field{padding-block:0}::-webkit-datetime-edit-second-field{padding-block:0}::-webkit-datetime-edit-millisecond-field{padding-block:0}::-webkit-datetime-edit-meridiem-field{padding-block:0}:-moz-ui-invalid{box-shadow:none}button,input:where([type=button],[type=reset],[type=submit]){-webkit-appearance:button;-moz-appearance:button;appearance:button}::file-selector-button{-webkit-appearance:button;-moz-appearance:button;appearance:button}::-webkit-inner-spin-button{height:auto}::-webkit-outer-spin-button{height:auto}[hidden]:where(:not([hidden=until-found])){display:none!important}}@layer components;@layer utilities{.absolute{position:absolute}.relative{position:relative}.static{position:static}.inset-0{inset:calc(var(--spacing)*0)}.-mt-\[4\.9rem\]{margin-top:-4.9rem}.-mb-px{margin-bottom:-1px}.mb-1{margin-bottom:calc(var(--spacing)*1)}.mb-2{margin-bottom:calc(var(--spacing)*2)}.mb-4{margin-bottom:calc(var(--spacing)*4)}.mb-6{margin-bottom:calc(var(--spacing)*6)}.-ml-8{margin-left:calc(var(--spacing)*-8)}.flex{display:flex}.hidden{display:none}.inline-block{display:inline-block}.inline-flex{display:inline-flex}.table{display:table}.aspect-\[335\/376\]{aspect-ratio:335/376}.h-1{height:calc(var(--spacing)*1)}.h-1\.5{height:calc(var(--spacing)*1.5)}.h-2{height:calc(var(--spacing)*2)}.h-2\.5{height:calc(var(--spacing)*2.5)}.h-3{height:calc(var(--spacing)*3)}.h-3\.5{height:calc(var(--spacing)*3.5)}.h-14{height:calc(var(--spacing)*14)}.h-14\.5{height:calc(var(--spacing)*14.5)}.min-h-screen{min-height:100vh}.w-1{width:calc(var(--spacing)*1)}.w-1\.5{width:calc(var(--spacing)*1.5)}.w-2{width:calc(var(--spacing)*2)}.w-2\.5{width:calc(var(--spacing)*2.5)}.w-3{width:calc(var(--spacing)*3)}.w-3\.5{width:calc(var(--spacing)*3.5)}.w-\[448px\]{width:448px}.w-full{width:100%}.max-w-\[335px\]{max-width:335px}.max-w-none{max-width:none}.flex-1{flex:1}.shrink-0{flex-shrink:0}.translate-y-0{--tw-translate-y:calc(var(--spacing)*0);translate:var(--tw-translate-x)var(--tw-translate-y)}.transform{transform:var(--tw-rotate-x)var(--tw-rotate-y)var(--tw-rotate-z)var(--tw-skew-x)var(--tw-skew-y)}.flex-col{flex-direction:column}.flex-col-reverse{flex-direction:column-reverse}.items-center{align-items:center}.justify-center{justify-content:center}.justify-end{justify-content:flex-end}.gap-3{gap:calc(var(--spacing)*3)}.gap-4{gap:calc(var(--spacing)*4)}:where(.space-x-1>:not(:last-child)){--tw-space-x-reverse:0;margin-inline-start:calc(calc(var(--spacing)*1)*var(--tw-space-x-reverse));margin-inline-end:calc(calc(var(--spacing)*1)*calc(1 - var(--tw-space-x-reverse)))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:3.40282e38px}.rounded-sm{border-radius:var(--radius-sm)}.rounded-t-lg{border-top-left-radius:var(--radius-lg);border-top-right-radius:var(--radius-lg)}.rounded-br-lg{border-bottom-right-radius:var(--radius-lg)}.rounded-bl-lg{border-bottom-left-radius:var(--radius-lg)}.border{border-style:var(--tw-border-style);border-width:1px}.border-\[\#19140035\]{border-color:#19140035}.border-\[\#e3e3e0\]{border-color:#e3e3e0}.border-black{border-color:var(--color-black)}.border-transparent{border-color:#0000}.bg-\[\#1b1b18\]{background-color:#1b1b18}.bg-\[\#FDFDFC\]{background-color:#fdfdfc}.bg-\[\#dbdbd7\]{background-color:#dbdbd7}.bg-\[\#fff2f2\]{background-color:#fff2f2}.bg-white{background-color:var(--color-white)}.p-6{padding:calc(var(--spacing)*6)}.px-5{padding-inline:calc(var(--spacing)*5)}.py-1{padding-block:calc(var(--spacing)*1)}.py-1\.5{padding-block:calc(var(--spacing)*1.5)}.py-2{padding-block:calc(var(--spacing)*2)}.pb-12{padding-bottom:calc(var(--spacing)*12)}.text-sm{font-size:var(--text-sm);line-height:var(--tw-leading,var(--text-sm--line-height))}.text-\[13px\]{font-size:13px}.leading-\[20px\]{--tw-leading:20px;line-height:20px}.leading-normal{--tw-leading:var(--leading-normal);line-height:var(--leading-normal)}.font-medium{--tw-font-weight:var(--font-weight-medium);font-weight:var(--font-weight-medium)}.text-\[\#1b1b18\]{color:#1b1b18}.text-\[\#706f6c\]{color:#706f6c}.text-\[\#F53003\],.text-\[\#f53003\]{color:#f53003}.text-white{color:var(--color-white)}.underline{text-decoration-line:underline}.underline-offset-4{text-underline-offset:4px}.opacity-100{opacity:1}.shadow-\[0px_0px_1px_0px_rgba\(0\,0\,0\,0\.03\)\,0px_1px_2px_0px_rgba\(0\,0\,0\,0\.06\)\]{--tw-shadow:0px 0px 1px 0px var(--tw-shadow-color,#00000008),0px 1px 2px 0px var(--tw-shadow-color,#0000000f);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.shadow-\[inset_0px_0px_0px_1px_rgba\(26\,26\,0\,0\.16\)\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#1a1a0029);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.\!filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)!important}.filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)}.transition-all{transition-property:all;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.transition-opacity{transition-property:opacity;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.delay-300{transition-delay:.3s}.duration-750{--tw-duration:.75s;transition-duration:.75s}.not-has-\[nav\]\:hidden:not(:has(:is(nav))){display:none}.before\:absolute:before{content:var(--tw-content);position:absolute}.before\:top-0:before{content:var(--tw-content);top:calc(var(--spacing)*0)}.before\:top-1\/2:before{content:var(--tw-content);top:50%}.before\:bottom-0:before{content:var(--tw-content);bottom:calc(var(--spacing)*0)}.before\:bottom-1\/2:before{content:var(--tw-content);bottom:50%}.before\:left-\[0\.4rem\]:before{content:var(--tw-content);left:.4rem}.before\:border-l:before{content:var(--tw-content);border-left-style:var(--tw-border-style);border-left-width:1px}.before\:border-\[\#e3e3e0\]:before{content:var(--tw-content);border-color:#e3e3e0}@media (hover:hover){.hover\:border-\[\#1915014a\]:hover{border-color:#1915014a}.hover\:border-\[\#19140035\]:hover{border-color:#19140035}.hover\:border-black:hover{border-color:var(--color-black)}.hover\:bg-black:hover{background-color:var(--color-black)}}@media (width>=64rem){.lg\:-mt-\[6\.6rem\]{margin-top:-6.6rem}.lg\:mb-0{margin-bottom:calc(var(--spacing)*0)}.lg\:mb-6{margin-bottom:calc(var(--spacing)*6)}.lg\:-ml-px{margin-left:-1px}.lg\:ml-0{margin-left:calc(var(--spacing)*0)}.lg\:block{display:block}.lg\:aspect-auto{aspect-ratio:auto}.lg\:w-\[438px\]{width:438px}.lg\:max-w-4xl{max-width:var(--container-4xl)}.lg\:grow{flex-grow:1}.lg\:flex-row{flex-direction:row}.lg\:justify-center{justify-content:center}.lg\:rounded-t-none{border-top-left-radius:0;border-top-right-radius:0}.lg\:rounded-tl-lg{border-top-left-radius:var(--radius-lg)}.lg\:rounded-r-lg{border-top-right-radius:var(--radius-lg);border-bottom-right-radius:var(--radius-lg)}.lg\:rounded-br-none{border-bottom-right-radius:0}.lg\:p-8{padding:calc(var(--spacing)*8)}.lg\:p-20{padding:calc(var(--spacing)*20)}}@media (prefers-color-scheme:dark){.dark\:block{display:block}.dark\:hidden{display:none}.dark\:border-\[\#3E3E3A\]{border-color:#3e3e3a}.dark\:border-\[\#eeeeec\]{border-color:#eeeeec}.dark\:bg-\[\#0a0a0a\]{background-color:#0a0a0a}.dark\:bg-\[\#1D0002\]{background-color:#1d0002}.dark\:bg-\[\#3E3E3A\]{background-color:#3e3e3a}.dark\:bg-\[\#161615\]{background-color:#161615}.dark\:bg-\[\#eeeeec\]{background-color:#eeeeec}.dark\:text-\[\#1C1C1A\]{color:#1c1c1a}.dark\:text-\[\#A1A09A\]{color:#a1a09a}.dark\:text-\[\#EDEDEC\]{color:#ededec}.dark\:text-\[\#F61500\]{color:#f61500}.dark\:text-\[\#FF4433\]{color:#f43}.dark\:shadow-\[inset_0px_0px_0px_1px_\#fffaed2d\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#fffaed2d);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.dark\:before\:border-\[\#3E3E3A\]:before{content:var(--tw-content);border-color:#3e3e3a}@media (hover:hover){.dark\:hover\:border-\[\#3E3E3A\]:hover{border-color:#3e3e3a}.dark\:hover\:border-\[\#62605b\]:hover{border-color:#62605b}.dark\:hover\:border-white:hover{border-color:var(--color-white)}.dark\:hover\:bg-white:hover{background-color:var(--color-white)}}}@starting-style{.starting\:translate-y-4{--tw-translate-y:calc(var(--spacing)*4);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:translate-y-6{--tw-translate-y:calc(var(--spacing)*6);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:opacity-0{opacity:0}}}@keyframes spin{to{transform:rotate(360deg)}}@keyframes ping{75%,to{opacity:0;transform:scale(2)}}@keyframes pulse{50%{opacity:.5}}@keyframes bounce{0%,to{animation-timing-function:cubic-bezier(.8,0,1,1);transform:translateY(-25%)}50%{animation-timing-function:cubic-bezier(0,0,.2,1);transform:none}}@property --tw-translate-x{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-y{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-z{syntax:"*";inherits:false;initial-value:0}@property --tw-rotate-x{syntax:"*";inherits:false;initial-value:rotateX(0)}@property --tw-rotate-y{syntax:"*";inherits:false;initial-value:rotateY(0)}@property --tw-rotate-z{syntax:"*";inherits:false;initial-value:rotateZ(0)}@property --tw-skew-x{syntax:"*";inherits:false;initial-value:skewX(0)}@property --tw-skew-y{syntax:"*";inherits:false;initial-value:skewY(0)}@property --tw-space-x-reverse{syntax:"*";inherits:false;initial-value:0}@property --tw-border-style{syntax:"*";inherits:false;initial-value:solid}@property --tw-leading{syntax:"*";inherits:false}@property --tw-font-weight{syntax:"*";inherits:false}@property --tw-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-shadow-color{syntax:"*";inherits:false}@property --tw-inset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-shadow-color{syntax:"*";inherits:false}@property --tw-ring-color{syntax:"*";inherits:false}@property --tw-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-ring-color{syntax:"*";inherits:false}@property --tw-inset-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-ring-inset{syntax:"*";inherits:false}@property --tw-ring-offset-width{syntax:"<length>";inherits:false;initial-value:0}@property --tw-ring-offset-color{syntax:"*";inherits:false;initial-value:#fff}@property --tw-ring-offset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-blur{syntax:"*";inherits:false}@property --tw-brightness{syntax:"*";inherits:false}@property --tw-contrast{syntax:"*";inherits:false}@property --tw-grayscale{syntax:"*";inherits:false}@property --tw-hue-rotate{syntax:"*";inherits:false}@property --tw-invert{syntax:"*";inherits:false}@property --tw-opacity{syntax:"*";inherits:false}@property --tw-saturate{syntax:"*";inherits:false}@property --tw-sepia{syntax:"*";inherits:false}@property --tw-drop-shadow{syntax:"*";inherits:false}@property --tw-duration{syntax:"*";inherits:false}@property --tw-content{syntax:"*";inherits:false;initial-value:""}
            </style>
        @endif
    </head>
    <body class="relative bg-[#FDFDFC] text-[#1b1b18] flex items-center lg:justify-center min-h-screen flex-col">
        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya" 
        target="_blank"
        class="fixed whatsapp-pulse whatsapp-bounce bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg hover:scale-110 transition-all duration-300 z-50" aria-label="WhatsApp">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </a>
        <style>
            /* Bouncing animation for WhatsApp floating button */
            .whatsapp-bounce {
                animation: whatsappBounce 2s cubic-bezier(.28,.84,.42,1) infinite;
                transform-origin: center;
            }
            @keyframes whatsappBounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-20px); }
                60% { transform: translateY(-1px); }
            }
        </style>
        <div class="w-full bg-[#e58039] text-white py-3 overflow-hidden shadow-lg fixed top-0 z-50">
            <div class="flex items-center">
                <!-- Label -->
                <div class="bg-white text-red-600 px-4 py-1 font-bold text-sm uppercase flex-shrink-0">
                    PROMO
                </div>
                
                <!-- Scrolling Text Container -->
                <div class="flex-1 overflow-hidden ml-4 relative">
                    <div id="tickerContent" class="whitespace-nowrap inline-block text-black text-lg font-semibold" style="position: relative;">
                        <!-- Konten akan di-generate oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        <div class="relative mt-13">
            <video autoplay muted loop id="myVideo" class="h-screen w-full object-cover -z-10 brightness-50">
                <source src="/assets/newvideo-1.mp4" type="video/mp4">
            </video>
            <div class="w-full h-screen grid content-center p-8 text-white absolute top-0 left-0">
                <nav class="absolute w-full z-40 top-0 start-0 text-white p-1 font-d-din uppercase">
                    <div class="flex flex-wrap items-center justify-between mx-auto py-1 px-2">
                        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                            <img src="/assets/logo.png" class="h-5" alt="Yen Bangunan Logo" />
                        </a>
                        <div class="z-50 flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                            <button class="hidden lg:block bg-[#e05534] border border-[#e05534] text-white px-4 py-2 rounded-full text-xs uppercase font-mono font-bold">Kebutuhan Projek</button>
                            <button type="button" class="hidden text-sm bg-neutral-primary rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="/assets/product.jpg" alt="user photo">
                            </button>

                            
                            <div class="z-50 bg-white hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44" id="user-dropdown">
                                <div class="px-4 py-3 text-sm border-b border-default">
                                <span class="block text-heading font-medium">Joseph McFall</span>
                                <span class="block text-body truncate">name@flowbite.com</span>
                                </div>
                                <ul class="p-2 text-sm text-body font-medium" aria-labelledby="user-menu-button">
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Earnings</a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Sign out</a>
                                </li>
                                </ul>
                            </div>
                            <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-user" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
                            </button>
                        </div>
                        <div class="bg-white lg:bg-transparent lg:text-white text-black font-special-gothic items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                            <ul class="font-medium text-lg flex flex-col p-4 md:p-0 mt-1 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
                                <li>
                                    <a href="/" class="block py-2 px-3 bg-brand rounded md:bg-transparent md:text-fg-brand md:p-0" aria-current="page">Home</a>
                                </li>
                                <li>
                                    <a href="/product" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Product</a>
                                </li>
                                <li>
                                    <a href="/about-us" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">About Us</a>
                                </li>
                                <li>
                                    <a href="/blog" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Blog</a>
                                </li>
                                <button class="lg:hidden w-fit bg-[#e05534] border border-[#e05534] text-white px-4 py-2 rounded-full text-xs uppercase font-mono font-bold">Kebutuhan Projek</button>

                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="transition-opacity opacity-100 duration-750 starting:opacity-0 lg:p-8">
                    <div class="w-10/12 lg:w-1/2">
                        <h1 class="font-special-gothic text-4xl font-bold">One-Stop Solution Untuk Segala Kebutuhan Anda</h1>
                        <p class="font-montserrat mt-2 leading-7 text-sm">
                            Yen Bangunan® merupakan toko material bangunan terbesar dan terlengkap di Cikarang. 
                            Kami hadir sebagai solusi untuk kebutuhan proyek dan industri sejak 2008. 
                            Dengan standar kualitas tinggi, layanan yang andal, dan pengalaman bertahun-tahun. 
                            Kami memastikan setiap pelanggan mendapatkan yang terbaik untuk keberhasilan proyek mereka.
                        </p>
                    </div>
                    <div class="font-montserrat font-bold flex mt-2 gap-4">
                        <button class="bg-[#e05534] border border-[#e05534] text-white px-4 py-2 rounded-full text-xs uppercase">Hubungi Kami</button>
                        <button class="border border-white text-heading px-4 py-2 rounded-full text-xs uppercase">Tentang Kami</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row-reverse w-full">
            <div class="font-montserrat px-6 py-16 lg:w-1/2 lg:flex lg:flex-col lg:justify-center">
                <h1 class="text-4xl font-extrabold lg:w-5/6">YEN BANGUNAN FOR EVERYTHING & EVERYONE</h1>
                <p class="mt-2 leading-7 text-base lg:w-5/6">
                    Yen Bangunan adalah solusi tepat untuk segala kebutuhan konstruksi, renovasi, dan pengadaan material, baik untuk individu, kontraktor, maupun perusahaan. Dengan layanan andal dan produk lengkap, kami hadir untuk anda, di segala kondisi.
                </p>
            </div>
            <div style="background-image: url('/assets/home-1.jpeg'); height: 70vh;" class="position-center bg-cover no-repeat bg-center lg:w-1/2">
                <img src="/assets/home-1.jpeg" alt="Home" class="invisible">
            </div>
        </div>

        <div class="flex flex-col lg:flex-row w-full">
            <div class="font-montserrat px-6 py-16 lg:w-1/2 lg:flex lg:flex-col lg:justify-center">
                <h1 class="text-4xl font-extrabold">YEN BANGUNAN SERVICES & DELIVERY</h1>
                <ul class="list-disc mt-2 leading-7 text-base pl-4">
                    <li class="font-semibold">Free Delivery</li>
                        [Nikmati layanan pengiriman gratis untuk seluruh area Cikarang]
                    <li class="font-semibold">24 Hour Customer Service</li>
                    Tim kami siap melayani Anda 24 jam penuh untuk membantu setiap kebutuhan dan pertanyaan anda
                    <li class="font-semibold">All products in One Place</li>
                    Kami menyediakan berbagai kebutuhan material proyek dan pabrik dalam satu tempat
                </ul>
            </div>
            <div style="background-image: url('/assets/home-2.jpeg'); height: 70vh;" class="position-center bg-cover no-repeat bg-center lg:w-1/2">
                <img src="/assets/home-2.jpeg" alt="Home" class="invisible">
            </div>
        </div>

        <div class="mt-8">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">Produk Kami</h1>
            <div class="grid grid-cols-4 lg:grid-cols-6 gap-8 conte p-4">
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/besi-dan-baja.png" alt="Product">
                    <p>Besi & Baja</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/hebel-dan-bata.png" alt="Product">
                    <p>Hebel & Bata</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/atap.png" alt="Product">
                    <p>Atap</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/pipa-dan-sanitasi.png" alt="Product">
                    <p>Pipa & Sanitasi</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/lampu-dan-kelistrikan.png" alt="Product">
                    <p>Lampu & Kelistrikan</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/mesin.png" alt="Product">
                    <p>Mesin</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/perkakas.png" alt="Product">
                    <p>Perkakas</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/paku-dan-baut.png" alt="Product">
                    <p>Paku & Baut</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/consumable-industri.png" alt="Product">
                    <p>Consumable Industry</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/safety.png" alt="Product">
                    <p>Safety Industry</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/keramik-dan-granit.png" alt="Product">
                    <p>Keramik & Granit</p>
                </div>
                <div class="font-d-din font-bold uppercase text-center">
                    <img src="/assets/product/cat.png" alt="Product">
                    <p>Cat</p>
                </div>
            </div>
        </div>

        <div class="mt-4 w-full">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">Brand Produk</h1>
            <div class="container mx-auto px-4 py-8">
                <!-- Carousel Container -->
                <div class="relative max-w-4xl mx-auto lg:hidden">
                    
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden">
                        <div id="carousel" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-1.png');">
                                <img src="/assets/brand-1.png" 
                                    alt="Slide 1" 
                                    class="w-full invisible"/>
                            </div>
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-2.png');">
                                <img src="/assets/brand-2.png" 
                                    alt="Slide 2" 
                                    class="w-full invisible"/>
                            </div>
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-3.png');">
                                <img src="/assets/brand-3.png" 
                                    alt="Slide 3" 
                                    class="w-full invisible" />
                            </div>
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-4.png');">
                                <img src="/assets/brand-4.png" 
                                    alt="Slide 4" 
                                    class="w-full invisible" />
                            </div>
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-5.png');">
                                <img src="/assets/brand-5.png" 
                                    alt="Slide 5" 
                                    class="w-full invisible" />
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn" 
                            class="invisible absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn" 
                            class="invisible absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                        <button class="indicator w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="2"></button>
                        <button class="indicator w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="3"></button>
                        <button class="indicator w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="4"></button>
                    </div>

                </div>
                <div class="relative max-w-4xl mx-auto hidden lg:block">
                    
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden rounded-lg">
                        <div id="carousel6" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-desktop-1.png');">
                                <img src="/assets/brand-desktop-1.png" 
                                    alt="Slide 1" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 2 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-desktop-2.png');">
                                <img src="/assets/brand-desktop-2.png" 
                                    alt="Slide 2" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 3 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/brand-desktop-3.png');">
                                <img src="/assets/brand-desktop-3.png" 
                                    alt="Slide 3" 
                                    class="w-full object-cover invisible">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn6" 
                            class="invisible absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn6" 
                            class="invisible absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator6 w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator6 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                        <button class="indicator6 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="2"></button>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-4 w-full p-4 font-montserrat">
            <h1 class="text-xl font-extrabold uppercase text-center">WHY CHOOSE YEN BANGUNAN?</h1>
            <p class="mt-4 text-center text-sm">Yen Bangunan hadir sebagai one-stop solution terpercaya bagi kontraktor, pabrik, dan khususnya 
                tim purchasing. dengan menyediakan kelengkapan kebutuhan serta harga yang kompetitif untuk memastikan 
                efisiensi dan kemudahan dalam setiap pengadaan.
            </p>
            <div class="flex flex-col mt-4 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-4 lg:gap-10">
                    <div class="border-2 border-black p-3 lg:w-1/2">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/whychooseyen-1.png') }}" alt="Free Delivery" class="w-2/12">
                            <h1 class="text-2xl font-bold">Free Delivery</h1>
                        </div>
                        <p class="mt-2">
                            Kami menyediakan layanan free delivery untuk pengiriman di area Cikarang, memastikan kemudahan dan efisiensi bagi setiap pelanggan.
                        </p>
                    </div>
                    <div class="border-2 border-black p-3 bg-black text-white lg:w-1/2">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/whychooseyen-2.png') }}" alt="Request Order" class="w-2/12 invert">
                            <h1 class="text-2xl font-bold">Request Order</h1>
                        </div>
                        <p class="mt-2">
                            Kami menyediakan layanan request order untuk memenuhi kebutuhan pelanggan, memastikan kemudahan pengadaan dalam satu tempat.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col lg:flex-row-reverse gap-4 mt-4 lg:gap-10">
                    <div class="border-2 border-black p-3 lg:w-1/2">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/whychooseyen-4.png') }}" alt="All in One and Competitive" class="w-2/12">
                            <h1 class="text-2xl font-bold">All in One and Competitive</h1>
                        </div>
                        <p class="mt-2">
                            Kami menyediakan all-around product dalam satu tempat, menghadirkan solusi lengkap dengan harga kompetitif untuk memenuhi setiap kebutuhan pelanggan.
                        </p>
                    </div>
                    <div class="border-2 border-black p-3 bg-black text-white lg:w-1/2">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/whychooseyen-3.png') }}" alt="24 Hours Customer Service" class="w-2/12 invert">
                            <h1 class="text-2xl font-bold">24 Hours Customer Service</h1>
                        </div>
                        <p class="mt-2">
                            Kami menghadirkan layanan customer service 24 jam untuk memastikan setiap kebutuhan pelanggan terpenuhi dengan cepat dan responsif.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 w-full">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">Klien Kami</h1>
            <div class="container mx-auto px-4 py-8">
                <!-- Carousel Container 2 -->
                <div class="relative max-w-4xl mx-auto">
                    
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden rounded-lg">
                        <div id="carousel2" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/mobile-client-1.png');">
                                <img src="/assets/mobile-client-1.png" 
                                    alt="Slide 1" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 2 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/mobile-client-2.png');">
                                <img src="/assets/mobile-client-2.png" 
                                    alt="Slide 2" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 3 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/mobile-client-3.png');">
                                <img src="/assets/mobile-client-3.png" 
                                    alt="Slide 3" 
                                    class="w-full object-cover invisible">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn2" 
                            class="invisible absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn2" 
                            class="invisible absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator2 w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator2 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                        <button class="indicator2 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="2"></button>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-4 w-full px-4">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">Layanan Supplier</h1>
            <p class="text-center mt-3 w-2/3 mx-auto">Yen Bangunan juga siap menjadi suplier bahan bangunan terpercaya untuk proyek perkantoran, perumahan. dan pabrik. Menyediakan produk berkualitas tinggi dengan harga kompetitif dan layanan profesional di area Cikarang.</p>
            <div class="container mx-auto px-4 py-8">
                <!-- Carousel Container 3 -->
                <div class="lg:hidden relative max-w-4xl mx-auto">
                    
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden rounded-lg shadow-lg">
                        <div id="carousel3" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/pabrik.jpeg');">
                                <img src="/assets/pabrik.jpeg" 
                                    alt="Slide 1" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 2 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/perkantoran.jpeg');">
                                <img src="/assets/perkantoran.jpeg" 
                                    alt="Slide 2" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 3 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/perumahan.jpeg');">
                                <img src="/assets/perumahan.jpeg" 
                                    alt="Slide 3" 
                                    class="w-full object-cover invisible">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn3" 
                            class="absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn3" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator3 w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator3 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                        <button class="indicator3 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="2"></button>
                    </div>

                </div>
                <div class="hidden lg:flex items-center justify-center gap-8">
                    <img src="/assets/pabrik.jpeg" 
                                    alt="Pabrik" 
                                    class="w-1/4 object-cover">
                    <img src="/assets/perkantoran.jpeg" 
                                    alt="Perkantoran" 
                                    class="w-1/4 object-cover">
                    <img src="/assets/perumahan.jpeg" 
                                    alt="Perumahan" 
                                    class="w-1/4 object-cover">
                </div>
            </div>
        </div>

        <div class="mt-4 w-full px-4">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">Projek</h1>
            <div class="container mx-auto px-4 py-8">
                <!-- Carousel Container 4 -->
                <div class="relative max-w-4xl mx-auto">
                    
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden rounded-lg">
                        <div id="carousel4" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/project-1.png');">
                                <img src="/assets/project-1.png" 
                                    alt="Slide 1" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 2 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/project-2.png');">
                                <img src="/assets/project-2.png" 
                                    alt="Slide 2" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 3 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/project-3.png');">
                                <img src="/assets/project-3.png" 
                                    alt="Slide 3" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 4 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/project-4.png');">
                                <img src="/assets/project-4.png" 
                                    alt="Slide 4" 
                                    class="w-full object-cover invisible">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn4" 
                            class="absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn4" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator4 w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator4 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                        <button class="indicator4 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="2"></button>
                        <button class="indicator4 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="3"></button>
                    </div>

                </div>
            </div>
        </div>
            
        <div class="mt-4 w-full px-4 font-montserrat">
            <h1 class="font-medium font-lg text-center">Dalam lebih dari <span class="font-bold">15</span> tahun pelayanan kami, kami telah mencapai</h1>
            <div class="flex flex-col items-center gap-8 mt-4">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="text-4xl lg:text-7xl flex items-center gap-6 font-extrabold border-y-2 border-black py-4">
                        <span>
                            <span class="counter-number" data-target="5000">0</span><span>+</span>
                        </span> 
                        <span class="text-2xl font-semibold">SKU Produk</span>
                    </div>
                    <div class="text-4xl lg:text-7xl flex items-center gap-6 font-extrabold border-y-2 border-black py-4">
                        <span>
                            <span class="counter-number" data-target="700">0</span><span>+</span>
                        </span> 
                        <span class="text-2xl font-semibold">Projek</span>
                    </div>
                </div>
                <div class="text-4xl lg:text-7xl flex items-center gap-6 font-extrabold border-y-2 border-black py-4">
                    <span>
                        <span class="counter-number" data-target="400">0</span><span>+</span>
                    </span> 
                    <span class="text-2xl font-semibold">Pelanggan</span>
                </div>
            </div>
        </div>

        <div class="mt-6 w-full px-4">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">Galeri Yen Bangunan</h1>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-base" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg" alt="">
                </div>
            </div>
        </div>

        <div class="w-full px-4 mt-5">
            <h1 class="text-3xl font-extrabold uppercase text-center font-d-din">APA KATA MEREKA TENTANG YENBANGUNAN?</h1>
            <div class="container mx-auto px-4 py-8">
                <!-- Carousel Container 5 -->
                <div class="relative max-w-4xl mx-auto lg:hidden">
                    
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden rounded-lg">
                        <div id="carousel5" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-1.png');">
                                <img src="/assets/review-1.png" 
                                    alt="Slide 1" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 2 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-2.png');">
                                <img src="/assets/review-2.png" 
                                    alt="Slide 2" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 3 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-3.png');">
                                <img src="/assets/review-3.png" 
                                    alt="Slide 3" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 4 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-4.png');">
                                <img src="/assets/review-4.png" 
                                    alt="Slide 4" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 5 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-5.png');">
                                <img src="/assets/review-5.png" 
                                    alt="Slide 5" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 6 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-6.png');">
                                <img src="/assets/review-6.png" 
                                    alt="Slide 6" 
                                    class="w-full object-cover invisible">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn5" 
                            class="invisible absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn5" 
                            class="invisible absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator5 w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator5 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                        <button class="indicator5 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="2"></button>
                        <button class="indicator5 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="3"></button>
                        <button class="indicator5 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="4"></button>
                        <button class="indicator5 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="5"></button>
                    </div>

                </div>
                <div class="relative max-w-4xl mx-auto hidden lg:block">
        
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden rounded-lg">
                        <div id="carousel6" class="flex transition-transform duration-500 ease-in-out">
                            
                            <!-- Slide 1 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-combine-1.png');">
                                <img src="/assets/review-combine-1.png" 
                                    alt="Slide 1" 
                                    class="w-full object-cover invisible">
                            </div>
                            <!-- Slide 2 -->
                            <div class="min-w-full bg-center bg-no-repeat bg-contain" style="background-image: url('/assets/review-combine-2.png');">
                                <img src="/assets/review-combine-2.png" 
                                    alt="Slide 2" 
                                    class="w-full object-cover invisible">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Button -->
                    <button id="prevBtn6" 
                            class="invisible absolute left-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button id="nextBtn6" 
                            class="invisible absolute right-4 top-1/2 -translate-y-1/2 hover:bg-white text-gray-800 rounded-full p-3 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="indicator6 w-3 h-3 rounded-full bg-gray-800 transition-all duration-300" data-index="0"></button>
                        <button class="indicator6 w-3 h-3 rounded-full bg-gray-400 transition-all duration-300" data-index="1"></button>
                    </div>

                </div>
            </div>
        </div>

        <footer class="bg-black text-white">
            <div class="flex items-start gap-6 p-6 lg:px-20 lg:py-12 ">
                <div class="flex flex-col gap-4 w-5/12">
                    <img src="/assets/logo.png" class="w-2/3 lg:w-1/3" alt="Yen Bangunan Logo" />
                    <p class="text-sm lg:text-base">Lippo Cikarang Sukadami, Cikarang Selatan, Kabupaten Bekasi, Jawa Barat, 17530</p>
                    <div class="flex items-center gap-2">
                        <i class='bx bxl-whatsapp  bx-sm'></i>
                        <p class="text-sm">081315147952</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-4/12">
                    <h1 class="font-bold">LINK</h1>
                    <ul class="flex flex-col gap-4 text-sm lg:text-base lg:gap-6">
                        <li>Home</li>
                        <li>Produk</li>
                        <li>Tentang Kami</li>
                        <li>Blok</li>
                    </ul>
                </div>
                <div class="flex flex-col gap-2 w-3/12">
                    <h1 class="font-bold">Follow Kami</h1>
                    <p>@yenbangunan</p>
                </div>
            </div>
            <div class="w-full border-t border-white flex items-center gap-5 justify-center p-3">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-3/12 md:w-2/12 lg:w-1/12">
                <p class="text-center text-sm p-4">© 2009</p>
            </div>

        </footer>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
        <script>
            // News Ticker dengan JavaScript
            const messages = [
                '      POTONGAN 25%!!! UNTUK PEMBELIAN PERTAMA (S&K Berlaku)!      ',
                '      POTONGAN 25%!!! UNTUK PEMBELIAN PERTAMA (S&K Berlaku)!      ',
                '      POTONGAN 25%!!! UNTUK PEMBELIAN PERTAMA (S&K Berlaku)!      ',
                '      POTONGAN 25%!!! UNTUK PEMBELIAN PERTAMA (S&K Berlaku)!      ',
            ];

            const tickerContent = document.getElementById('tickerContent');
            const fullText = messages.join('    •    ') + ' • ' + messages.join('      •      ');
            
            // Create ticker text
            tickerContent.innerHTML = `<span class="inline-block px-4">${fullText}</span>`;
            
            let position = 0;
            const speed = 0.5; // pixel per frame
            let animationId;
            let isPaused = false;

            function animate() {
                if (!isPaused) {
                    position -= speed;
                    
                    // Reset position for seamless loop
                    if (Math.abs(position) >= tickerContent.scrollWidth / 2) {
                        position = 0;
                    }
                    
                    tickerContent.style.transform = `translateX(${position}px)`;
                }
                
                animationId = requestAnimationFrame(animate);
            }

            // Start animation
            animate();

            // Pause on hover
            tickerContent.addEventListener('mouseenter', () => {
                isPaused = true;
            });

            tickerContent.addEventListener('mouseleave', () => {
                isPaused = false;
            });
        </script>
        <script>
            // Carousel 6 JavaScript
            const carousel6 = document.getElementById('carousel6');
            const prevBtn6 = document.getElementById('prevBtn6');
            const nextBtn6 = document.getElementById('nextBtn6');
            const indicators6 = document.querySelectorAll('.indicator6');
            
            let currentIndex6 = 0;
            const totalSlides6 = 2; // 2 slides
            let autoPlayInterval6;

            // Function to update carousel position
            function updateCarousel6() {
                carousel6.style.transform = `translateX(-${currentIndex6 * 100}%)`;
                
                // Update indicators
                indicators6.forEach((indicator, index) => {
                    if (index === currentIndex6) {
                        indicator.classList.remove('bg-gray-400');
                        indicator.classList.add('bg-gray-800', 'w-8');
                    } else {
                        indicator.classList.remove('bg-gray-800', 'w-8');
                        indicator.classList.add('bg-gray-400');
                    }
                });
            }

            // Next slide
            function nextSlide6() {
                currentIndex6 = (currentIndex6 + 1) % totalSlides6;
                updateCarousel6();
            }

            // Previous slide
            function prevSlide6() {
                currentIndex6 = (currentIndex6 - 1 + totalSlides6) % totalSlides6;
                updateCarousel6();
            }

            // Event listeners
            nextBtn6.addEventListener('click', () => {
                nextSlide6();
                resetAutoPlay6();
            });

            prevBtn6.addEventListener('click', () => {
                prevSlide6();
                resetAutoPlay6();
            });

            // Indicator click
            indicators6.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex6 = index;
                    updateCarousel6();
                    resetAutoPlay6();
                });
            });

            // Auto play
            function startAutoPlay6() {
                autoPlayInterval6 = setInterval(nextSlide6, 3000);
            }

            function resetAutoPlay6() {
                clearInterval(autoPlayInterval6);
                startAutoPlay6();
            }

            // Touch/Swipe support
            let touchStartX6 = 0;
            let touchEndX6 = 0;

            carousel6.addEventListener('touchstart', (e) => {
                touchStartX6 = e.changedTouches[0].screenX;
            });

            carousel6.addEventListener('touchend', (e) => {
                touchEndX6 = e.changedTouches[0].screenX;
                handleSwipe6();
            });

            function handleSwipe6() {
                if (touchStartX6 - touchEndX6 > 50) {
                    nextSlide6();
                    resetAutoPlay6();
                }
                if (touchEndX6 - touchStartX6 > 50) {
                    prevSlide6();
                    resetAutoPlay6();
                }
            }

            // Start autoplay on load
            startAutoPlay6();

            // Pause autoplay on hover
            carousel6.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval6);
            });

            carousel6.addEventListener('mouseleave', () => {
                startAutoPlay6();
            });
        </script>
        <script>
            // Counter Animation
            function animateCounter(element, target, duration = 2000) {
                let start = 0;
                const increment = target / (duration / 16); // 60fps
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(start);
                    }
                }, 16);
            }

            // Intersection Observer untuk detect ketika elemen masuk viewport
            const observerOptions = {
                threshold: 0.5, // Trigger ketika 50% elemen terlihat
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                        // Tandai sudah dianimasi agar tidak repeat
                        entry.target.classList.add('animated');
                        
                        // Ambil target number dari data attribute
                        const targetNumber = parseInt(entry.target.getAttribute('data-target'));
                        
                        // Jalankan animasi
                        animateCounter(entry.target, targetNumber, 2000);
                    }
                });
            }, observerOptions);

            // Observe semua counter elements
            document.addEventListener('DOMContentLoaded', () => {
                const counters = document.querySelectorAll('.counter-number');
                counters.forEach(counter => observer.observe(counter));
            });
        </script>
        <script>
            // Carousel 5 JavaScript
            const carousel5 = document.getElementById('carousel5');
            const prevBtn5 = document.getElementById('prevBtn5');
            const nextBtn5 = document.getElementById('nextBtn5');
            const indicators5 = document.querySelectorAll('.indicator5');
            
            let currentIndex5 = 0;
            const totalSlides5 = 6; // 6 slides
            let autoPlayInterval5;

            // Function to update carousel position
            function updateCarousel5() {
                carousel5.style.transform = `translateX(-${currentIndex5 * 100}%)`;
                
                // Update indicators
                indicators5.forEach((indicator, index) => {
                    if (index === currentIndex5) {
                        indicator.classList.remove('bg-gray-400');
                        indicator.classList.add('bg-gray-800', 'w-8');
                    } else {
                        indicator.classList.remove('bg-gray-800', 'w-8');
                        indicator.classList.add('bg-gray-400');
                    }
                });
            }

            // Next slide
            function nextSlide5() {
                currentIndex5 = (currentIndex5 + 1) % totalSlides5;
                updateCarousel5();
            }

            // Previous slide
            function prevSlide5() {
                currentIndex5 = (currentIndex5 - 1 + totalSlides5) % totalSlides5;
                updateCarousel5();
            }

            // Event listeners
            nextBtn5.addEventListener('click', () => {
                nextSlide5();
                resetAutoPlay5();
            });

            prevBtn5.addEventListener('click', () => {
                prevSlide5();
                resetAutoPlay5();
            });

            // Indicator click
            indicators5.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex5 = index;
                    updateCarousel5();
                    resetAutoPlay5();
                });
            });

            // Auto play
            function startAutoPlay5() {
                autoPlayInterval5 = setInterval(nextSlide5, 3000);
            }

            function resetAutoPlay5() {
                clearInterval(autoPlayInterval5);
                startAutoPlay5();
            }

            // Touch/Swipe support
            let touchStartX5 = 0;
            let touchEndX5 = 0;

            carousel5.addEventListener('touchstart', (e) => {
                touchStartX5 = e.changedTouches[0].screenX;
            });

            carousel5.addEventListener('touchend', (e) => {
                touchEndX5 = e.changedTouches[0].screenX;
                handleSwipe5();
            });

            function handleSwipe5() {
                if (touchStartX5 - touchEndX5 > 50) {
                    nextSlide5();
                    resetAutoPlay5();
                }
                if (touchEndX5 - touchStartX5 > 50) {
                    prevSlide5();
                    resetAutoPlay5();
                }
            }

            // Start autoplay on load
            startAutoPlay5();

            // Pause autoplay on hover
            carousel5.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval5);
            });

            carousel5.addEventListener('mouseleave', () => {
                startAutoPlay5();
            });
        </script>
        <script>
            // Carousel 4 JavaScript
            const carousel4 = document.getElementById('carousel4');
            const prevBtn4 = document.getElementById('prevBtn4');
            const nextBtn4 = document.getElementById('nextBtn4');
            const indicators4 = document.querySelectorAll('.indicator4');
            
            let currentIndex4 = 0;
            const totalSlides4 = 4; // 4 slides
            let autoPlayInterval4;

            // Function to update carousel position
            function updateCarousel4() {
                carousel4.style.transform = `translateX(-${currentIndex4 * 100}%)`;
                
                // Update indicators
                indicators4.forEach((indicator, index) => {
                    if (index === currentIndex4) {
                        indicator.classList.remove('bg-gray-400');
                        indicator.classList.add('bg-gray-800', 'w-8');
                    } else {
                        indicator.classList.remove('bg-gray-800', 'w-8');
                        indicator.classList.add('bg-gray-400');
                    }
                });
            }

            // Next slide
            function nextSlide4() {
                currentIndex4 = (currentIndex4 + 1) % totalSlides4;
                updateCarousel4();
            }

            // Previous slide
            function prevSlide4() {
                currentIndex4 = (currentIndex4 - 1 + totalSlides4) % totalSlides4;
                updateCarousel4();
            }

            // Event listeners
            nextBtn4.addEventListener('click', () => {
                nextSlide4();
                resetAutoPlay4();
            });

            prevBtn4.addEventListener('click', () => {
                prevSlide4();
                resetAutoPlay4();
            });

            // Indicator click
            indicators4.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex4 = index;
                    updateCarousel4();
                    resetAutoPlay4();
                });
            });

            // Auto play
            function startAutoPlay4() {
                autoPlayInterval4 = setInterval(nextSlide4, 3000);
            }

            function resetAutoPlay4() {
                clearInterval(autoPlayInterval4);
                startAutoPlay4();
            }

            // Touch/Swipe support
            let touchStartX4 = 0;
            let touchEndX4 = 0;

            carousel4.addEventListener('touchstart', (e) => {
                touchStartX4 = e.changedTouches[0].screenX;
            });

            carousel4.addEventListener('touchend', (e) => {
                touchEndX4 = e.changedTouches[0].screenX;
                handleSwipe4();
            });

            function handleSwipe4() {
                if (touchStartX4 - touchEndX4 > 50) {
                    nextSlide4();
                    resetAutoPlay4();
                }
                if (touchEndX4 - touchStartX4 > 50) {
                    prevSlide4();
                    resetAutoPlay4();
                }
            }

            // Start autoplay on load
            startAutoPlay4();

            // Pause autoplay on hover
            carousel4.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval4);
            });

            carousel4.addEventListener('mouseleave', () => {
                startAutoPlay4();
            });
        </script>
        <script>
            // Carousel 2 JavaScript
            const carousel2 = document.getElementById('carousel2');
            const prevBtn2 = document.getElementById('prevBtn2');
            const nextBtn2 = document.getElementById('nextBtn2');
            const indicators2 = document.querySelectorAll('.indicator2');
            
            let currentIndex2 = 0;
            const totalSlides2 = 3;
            let autoPlayInterval2;

            // Function to update carousel position
            function updateCarousel2() {
                carousel2.style.transform = `translateX(-${currentIndex2 * 100}%)`;
                
                // Update indicators
                indicators2.forEach((indicator, index) => {
                    if (index === currentIndex2) {
                        indicator.classList.remove('bg-gray-400');
                        indicator.classList.add('bg-gray-800', 'w-8');
                    } else {
                        indicator.classList.remove('bg-gray-800', 'w-8');
                        indicator.classList.add('bg-gray-400');
                    }
                });
            }

            // Next slide
            function nextSlide2() {
                currentIndex2 = (currentIndex2 + 1) % totalSlides2;
                updateCarousel2();
            }

            // Previous slide
            function prevSlide2() {
                currentIndex2 = (currentIndex2 - 1 + totalSlides2) % totalSlides2;
                updateCarousel2();
            }

            // Event listeners
            nextBtn2.addEventListener('click', () => {
                nextSlide2();
                resetAutoPlay2();
            });

            prevBtn2.addEventListener('click', () => {
                prevSlide2();
                resetAutoPlay2();
            });

            // Indicator click
            indicators2.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex2 = index;
                    updateCarousel2();
                    resetAutoPlay2();
                });
            });

            // Auto play
            function startAutoPlay2() {
                autoPlayInterval2 = setInterval(nextSlide2, 3000);
            }

            function resetAutoPlay2() {
                clearInterval(autoPlayInterval2);
                startAutoPlay2();
            }

            // Touch/Swipe support
            let touchStartX2 = 0;
            let touchEndX2 = 0;

            carousel2.addEventListener('touchstart', (e) => {
                touchStartX2 = e.changedTouches[0].screenX;
            });

            carousel2.addEventListener('touchend', (e) => {
                touchEndX2 = e.changedTouches[0].screenX;
                handleSwipe2();
            });

            function handleSwipe2() {
                if (touchStartX2 - touchEndX2 > 50) {
                    nextSlide2();
                    resetAutoPlay2();
                }
                if (touchEndX2 - touchStartX2 > 50) {
                    prevSlide2();
                    resetAutoPlay2();
                }
            }

            // Start autoplay on load
            startAutoPlay2();

            // Pause autoplay on hover
            carousel2.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval2);
            });

            carousel2.addEventListener('mouseleave', () => {
                startAutoPlay2();
            });
        </script>
       <script>
            // Carousel JavaScript
            const carousel = document.getElementById('carousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.querySelectorAll('.indicator');
            
            let currentIndex = 0;
            const totalSlides = 5; // Ubah menjadi 5 slides
            let autoPlayInterval;

            // Function to update carousel position
            function updateCarousel() {
                carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.remove('bg-gray-400');
                        indicator.classList.add('bg-gray-800', 'w-8');
                    } else {
                        indicator.classList.remove('bg-gray-800', 'w-8');
                        indicator.classList.add('bg-gray-400');
                    }
                });
            }

            // Next slide
            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }

            // Previous slide
            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            // Event listeners
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoPlay();
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoPlay();
            });

            // Indicator click
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                    resetAutoPlay();
                });
            });

            // Auto play
            function startAutoPlay() {
                autoPlayInterval = setInterval(nextSlide, 3000); // Change slide every 3 seconds
            }

            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                startAutoPlay();
            }

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                    resetAutoPlay();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                    resetAutoPlay();
                }
            });

            // Touch/Swipe support
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchStartX - touchEndX > 50) {
                    nextSlide();
                    resetAutoPlay();
                }
                if (touchEndX - touchStartX > 50) {
                    prevSlide();
                    resetAutoPlay();
                }
            }

            // Start autoplay on load
            startAutoPlay();

            // Pause autoplay on hover
            carousel.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });

            carousel.addEventListener('mouseleave', () => {
                startAutoPlay();
            });
        </script>
        <script>
            // Carousel 3 JavaScript
            const carousel3 = document.getElementById('carousel3');
            const prevBtn3 = document.getElementById('prevBtn3');
            const nextBtn3 = document.getElementById('nextBtn3');
            const indicators3 = document.querySelectorAll('.indicator3');
            
            let currentIndex3 = 0;
            const totalSlides3 = 3; // 3 slides
            let autoPlayInterval3;

            // Function to update carousel position
            function updateCarousel3() {
                carousel3.style.transform = `translateX(-${currentIndex3 * 100}%)`;
                
                // Update indicators
                indicators3.forEach((indicator, index) => {
                    if (index === currentIndex3) {
                        indicator.classList.remove('bg-gray-400');
                        indicator.classList.add('bg-gray-800', 'w-8');
                    } else {
                        indicator.classList.remove('bg-gray-800', 'w-8');
                        indicator.classList.add('bg-gray-400');
                    }
                });
            }

            // Next slide
            function nextSlide3() {
                currentIndex3 = (currentIndex3 + 1) % totalSlides3;
                updateCarousel3();
            }

            // Previous slide
            function prevSlide3() {
                currentIndex3 = (currentIndex3 - 1 + totalSlides3) % totalSlides3;
                updateCarousel3();
            }

            // Event listeners
            nextBtn3.addEventListener('click', () => {
                nextSlide3();
                resetAutoPlay3();
            });

            prevBtn3.addEventListener('click', () => {
                prevSlide3();
                resetAutoPlay3();
            });

            // Indicator click
            indicators3.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex3 = index;
                    updateCarousel3();
                    resetAutoPlay3();
                });
            });

            // Auto play
            function startAutoPlay3() {
                autoPlayInterval3 = setInterval(nextSlide3, 3000);
            }

            function resetAutoPlay3() {
                clearInterval(autoPlayInterval3);
                startAutoPlay3();
            }

            // Touch/Swipe support
            let touchStartX3 = 0;
            let touchEndX3 = 0;

            carousel3.addEventListener('touchstart', (e) => {
                touchStartX3 = e.changedTouches[0].screenX;
            });

            carousel3.addEventListener('touchend', (e) => {
                touchEndX3 = e.changedTouches[0].screenX;
                handleSwipe3();
            });

            function handleSwipe3() {
                if (touchStartX3 - touchEndX3 > 50) {
                    nextSlide3();
                    resetAutoPlay3();
                }
                if (touchEndX3 - touchStartX3 > 50) {
                    prevSlide3();
                    resetAutoPlay3();
                }
            }

            // Start autoplay on load
            startAutoPlay3();

            // Pause autoplay on hover
            carousel3.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval3);
            });

            carousel3.addEventListener('mouseleave', () => {
                startAutoPlay3();
            });
        </script>
    </body>
</html>
