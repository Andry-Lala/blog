<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- SEO Meta Tags -->
        <meta name="description" content="Unicorn Madagascar is a web platform of investment" />
        <meta name="author" content="Unicorn Madagascar" />
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="" /> <!-- website name -->
        <meta property="og:site" content="" /> <!-- website link -->
        <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Unicorn Madagascar</title>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />
        <link href="assets/css/fontawesome-all.css" rel="stylesheet" />
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
        <link href="assets/css/swiper.css" rel="stylesheet" />
        <link href="assets/css/magnific-popup.css" rel="stylesheet" />
        <link href="assets/css/styles.css" rel="stylesheet" />

        <!-- Favicon  -->
        <link rel="icon" href="assets/images/logounicorn.png" />
    </head>
    <body data-spy="scroll" data-target=".fixed-top">

        <!-- Navigation -->
        <nav class="navbar fixed-top">
            <div class="container sm:px-4 lg:px-8 flex flex-wrap items-center justify-between lg:flex-nowrap">

                <!-- Text Logo - Use this if you don't have a graphic logo -->
                <!-- <a class="text-gray-800 font-semibold text-3xl leading-4 no-underline page-scroll" href="index.html">Pavo</a> -->

                <!-- Image Logo -->
                <a class="inline-block mr-4 py-0.5 text-xl whitespace-nowrap hover:no-underline focus:no-underline" href="#header">
                    <div class="flex items-center space-x-3">
                        <img src="assets/images/logounicorn.png" alt="alternative" class="h-14 w-14" />
                        <span class="text-blue-600 font-bold text-lg">Unicorn Madagascar</span>
                    </div>
                </a>

                <button class="background-transparent rounded text-xl leading-none hover:no-underline focus:no-underline lg:hidden lg:text-gray-400" type="button" data-toggle="offcanvas">
                    <span class="navbar-toggler-icon inline-block w-8 h-8 align-middle"></span>
                </button>

                <div class="navbar-collapse offcanvas-collapse lg:flex lg:flex-grow lg:items-center" id="navbarsExampleDefault">
                    <ul class="pl-0 mt-3 mb-2 ml-auto flex flex-col list-none lg:mt-0 lg:mb-0 lg:flex-row">
                        <li>
                            <a class="nav-link page-scroll active" href="#header">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li>
                            <a class="nav-link page-scroll" href="#services">Services</a>
                        </li>
                        <li>
                            <a class="nav-link page-scroll" href="#plan">Investment Plan</a>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Others</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item page-scroll popup-with-move-anim" href="#details-about-us">About Us</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item page-scroll popup-with-move-anim" href="#details-term-of-use">Terms of Use</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item page-scroll popup-with-move-anim" href="#details-privacy-policy">Privacy Policy</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item page-scroll popup-with-move-anim" href="#details-cookies">Cookies Policy</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex space-x-4 items-center">
                                <!-- Language switcher -->
                                <div class="language-switcher-container">
                                    <x-language-switcher />
                                </div>
                                <!-- Bouton Login -->
                                <a href="/login" class="px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition font-medium">Log In</a>
                            </div>

                        </li>
                    </ul>
                </div> <!-- end of navbar-collapse -->
            </div> <!-- end of container -->
        </nav> <!-- end of navbar -->
        <!-- end of navigation -->

        <!-- Header -->
        <header id="header" class="header py-28 text-center md:pt-36 lg:text-left xl:pt-44 xl:pb-32">
            <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
                <div class="mb-16  xl:mr-12">
                    <!-- Badge security payment and transfer -->
                    <div class="grid grid-rows-1 gap-3 p-3 lg:-ml-10 lg:-mt-16">
                        <div class="grid grid-cols-3 gap-8">

                        <!-- Sécurité Paiement -->
                            <div class="group flex flex-col items-center text-center lg:items-start lg:text-left">
                                <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center shadow-md group-hover:bg-teal-600 group-hover:shadow-xl transition-all duration-300 border-blue-500 border-2">
                                    <h3 class=" text-sm font-semibold text-white">PAYMENT</h3>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                     Your transactions are protected by an advanced security system.
                                </p>
                            </div>

                        <!-- Fiabilité -->
                            <div class="group flex flex-col items-center text-center lg:items-start lg:text-left">
                                <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center shadow-md group-hover:bg-teal-600 group-hover:shadow-xl transition-all duration-300 border-blue-500 border-2">
                                    <h3 class="text-sm font-semibold text-white">SECURITY</h3>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 opacity-0 group-hover:opacity-100  transition-opacity duration-300">
                                    A stable, reliable, and thoroughly tested platform for your needs.
                                </p>
                            </div>

                        <!-- Rapidité Transfert -->
                            <div class="group flex flex-col items-center text-center lg:items-start lg:text-left">
                                <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center shadow-md group-hover:bg-teal-500 group-hover:shadow-xl transition-all duration-300 border-blue-500 border-2">
                                    <h3 class="text-sm font-semibold text-white">TRANSFER</h3>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Make your transfers in just a few seconds.
                                </p>
                            </div>

                        </div>
                    </div>
                    <h1 class="h1-large mb-5 ">Invest <span class="text-red-500 font-bold">in</span> <br>Earn <span class="text-red-500 font-bold">Money</span> <br>Get <span class="text-red-500 font-bold">Paid</span></h1>
                    <p class="p-large mb-8">Come in to check out our online offers</p>
                    <a class="btn-solid-lg px-4 py-2 text-sm" href="/register"><i class="fas fa-user-plus fa-sm mr-2"></i>Sign up now</a>
                </div>
                <div class="xl:text-right">
                    <div class="grid grid-rows-1 gap-3 p-3">
                         <img class="mt-5 rounded" src="assets/images/pctrade.png" alt="alternative" />
                    </div>
                </div>
            </div> <!-- end of container -->
        </header> <!-- end of header -->
        <!-- end of header -->

        <div class="flex justify-center bg-gray-300 lg:-mt-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 p-4 justify-items-center">
                <div class="flex flex-col items-center w-3/4">    
                    <img src="assets/images/alphaCapital.jpeg" alt="Alpha Capital" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(0)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Alpha Capital</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/deriv.jpeg" alt="Deriv" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(1)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Deriv</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/exness.jpeg" alt="Exness" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(2)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Exness</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/FBS.jpeg" alt="FBS" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(3)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">FBS</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/fusionMarket.jpeg" alt="Fusion Markets" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(4)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Fusion Markets</span>
                </div>
                <div class="flex flex-col items-center w-3/4">    
                    <img src="assets/images/grandCapital.jpeg" alt="Grand Capital" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(5)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Grand Capital</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/interactiveBrokers.jpeg" alt="Interactive Brokers" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(6)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Interactive Brokers</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/octaFX.jpeg" alt="Octa FX" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(7)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Octa FX</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/onFin.jpeg" alt="On Fin" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(8)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">On Fin</span>
                </div>
                <div class="flex flex-col items-center w-3/4">    
                    <img src="assets/images/raiseFX.jpeg" alt="Raise FX" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(9)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Raise FX</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/vantageFoundation.jpeg" alt="Vantage Foundation" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(10)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Vantage Foundation</span>
                </div>
                <div class="flex flex-col items-center w-3/4">
                    <img src="assets/images/welTrade.jpeg" alt="WELTRADE" class="w-full h-24 object-cover cursor-pointer" onclick="openLightbox(11)">
                    <span class="w-full px-2 py-1 bg-gray-200 text-gray-800 font-semibold text-center">Weltrade</span>
                </div>
            </div>
        </div>
        <!-- Lightbox pour image broker-->
        <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
            <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeLightbox()">&times;</span>
            <span class="absolute left-6 text-gray-400 text-4xl cursor-pointer select-none" onclick="prevImage()">&#10094;</span>
            <span class="absolute right-6 text-gray-400 text-4xl cursor-pointer select-none" onclick="nextImage()">&#10095;</span>
            <div class="flex flex-col items-center">
                <img id="lightboxImg" src="" class="max-w-full lg:max-w-3xl max-h-[80vh] rounded-lg shadow-lg">
                <span id="lightboxName" class="mt-4 text-white text-xl font-semibold text-center"></span>
            </div>
        </div>


        <!-- Introduction -->
        <div class="py-22 my-24">
            <div class="container px-4 sm:px-8 lg:grid lg:grid-cols-12 lg:gap-x-12" >
                <div class="lg:col-span-7">
                    <div class="mb-12 lg:mb-0 xl:mr-14">
                        <img class="inline" src="assets/images/trade-agent.avif" alt="trade-agent" id="services" />
                    </div>
                </div> <!-- end of col -->
                <div class="lg:col-span-5">
                    <div class="xl:mt-2">
                        <h2 class="mb-6">Our Services</h2>
                        <div class="max-w-xl mx-auto">
                            <p id="text-paragraph" class="text-gray-700 overflow-hidden h-24">Unicorn Madagascar offers a cutting-edge investment plan focused on synthetic indices, designed for investors seeking high returns in a controlled market environment. Our strategy leverages the unique characteristics of synthetic indices, which mimic real-world market volatility without being affected by external events like economic shifts or geopolitical tensions. With 24/7 availability and a transparent pricing model, our synthetic indices investment plan provides flexibility and consistent opportunities for growth. Investors benefit from advanced market insights and risk management tools, ensuring a well-balanced portfolio tailored to their risk tolerance. At Unicorn Madagascar, we help you navigate the dynamic world of synthetic indices with confidence and precision.</p>
                            <button id="toggle-btn" class="mt-2 text-blue-600 hover:underline font-medium">Read more</button>
                            <br><br><a class="btn-solid-reg popup-with-move-anim mr-1.5" href="#details-service">Learn more about our service</a>
                        </div>
                    </div>
                </div> <!-- end of col -->
            </div> <!-- end of container -->
        </div>
        <!-- end of service-->


        <!-- Details service -->
        <!-- box-dialog -->
        <div id="details-service" class="lightbox-basic zoom-anim-dialog mfp-hide">
            <div class="flex items-center justify-center">
                <img src="assets/images/logounicorn.png" alt="alternative" class="h-14 w-14" />
                <span class="text-blue-600 font-bold text-lg">Unicorn Madagascar</span>
            </div>
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="lg:col-span-12">
                    <h3 class="mb-2">Our Services</h3>
                    <hr class="w-11 h-0.5 mt-0.5 mb-4 ml-0 border-none bg-indigo-600" />
                    <h6 class="mt-7 mb-2.5">Unicorn Madagascar's Synthetic Indices Investment Service</h6>
                    <p>Unicorn Madagascar offers a specialized investment service focused on synthetic indices, designed to provide investors with exposure to market-like conditions in a controlled and transparent environment. Synthetic indices replicate the volatility and movement patterns of real financial markets, yet remain insulated from external factors such as geopolitical events or economic shifts. This makes them an attractive option for investors seeking stability and predictability while still capitalizing on market movements. Our team of financial experts provides tailored guidance, ensuring that every investor's portfolio is optimized to meet their specific financial goals.</p>
                    <h6 class="mt-7 mb-2.5">Innovative and Consistent Investment Opportunities</h6>
                    <p>At Unicorn Madagascar, we believe in creating innovative solutions for forward-thinking investors. With our synthetic indices, trading is available 24/7, offering continuous access to market opportunities without the restrictions of traditional markets. This round-the-clock availability enables investors to react to price movements at any time, creating more opportunities to maximize returns. The price movements in these indices are based on a carefully designed algorithm that mirrors the randomness and volatility of real markets, providing consistent opportunities for growth.</p>
                    <h6 class="mt-7 mb-2.5">Tailored Investment Plans for Diverse Risk Profiles</h6>
                    <p>Our investment plans are designed to cater to a range of risk appetites. Whether you are a conservative investor looking for steady returns or a high-risk investor aiming for rapid growth, Unicorn Madagascar has a plan for you. Each plan includes a combination of synthetic indices that are tailored to your personal financial objectives. We also provide real-time updates, detailed performance tracking, and advanced risk management tools to help you stay informed and make the best investment decisions possible.</p>
                    <h6 class="mt-7 mb-2.5">Expert Support and Transparent Pricing</h6>
                    <p>Transparency is at the core of our service. Unicorn Madagascar offers clear and competitive pricing models with no hidden fees, ensuring that you know exactly what you are paying for. Our platform is supported by a team of financial analysts and customer support professionals who are available around the clock to answer any questions and provide personalized advice. By choosing our synthetic indices investment service, you are partnering with a company committed to helping you succeed in the ever-evolving world of financial markets.</p>
                    <br><br>
                    <button class="btn-outline-reg mfp-close as-button" type="button">Back</button>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div><!-- end of service pop up  -->

        <!-- Details About us -->
        <!-- box-dialog -->

        <div id="details-about-us" class="lightbox-basic zoom-anim-dialog mfp-hide">
            <div class="flex items-center justify-center">
                <img src="assets/images/logounicorn.png" alt="alternative" class="h-14 w-14" />
                <span class="text-blue-600 font-bold text-lg">Unicorn Madagascar</span>
            </div>
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="lg:col-span-12">
                    <h3 class="mb-2 text-blue-500">About Us</h3>
                    <hr class="w-11 h-0.5 mt-0.5 mb-4 ml-0 border-none bg-indigo-600" />
                    <h6 class="mt-7 mb-2.5">Unicorn Madagascar</h6>
                    <p>Unicorn Madagascar is a forward-thinking investment platform specializing in synthetic indices. We are committed to providing investors with innovative and stable investment opportunities that mimic real market conditions without the influence of external factors like economic or political events. With a focus on transparency and accessibility, our synthetic indices are available for trading 24/7, offering consistent opportunities for growth in a secure and predictable environment. Our mission is to empower investors with the tools and knowledge needed to navigate the complexities of these unique financial instruments.</p>
                    <h6 class="mt-7 mb-2.5">Our Expertise in Synthetic Indices</h6>
                    <p>At Unicorn Madagascar, we pride ourselves on our deep understanding of synthetic indices and the value they offer to modern investors. These indices simulate real-world market volatility, offering a unique investment vehicle for those seeking diversification beyond traditional assets. Our team of financial experts continuously monitors market trends and developments to ensure our platform delivers up-to-date, high-quality investment opportunities. Whether you’re new to synthetic indices or an experienced trader, we provide the insights and guidance necessary to make informed decisions and optimize your returns.</p>
                    <h6 class="mt-7 mb-2.5">Affiliations with Leading Online Work Platforms</h6>
                    <p>In addition to our synthetic indices offerings, Unicorn Madagascar has developed strategic affiliations with leading online work platforms and financial advisors. These partnerships allow us to expand our network and offer our clients access to a wealth of resources and professional guidance. By collaborating with well-established platforms and certified experts, we ensure that our investors receive trusted advice and access to a broader range of investment options. Our affiliates provide essential tools and insights to help you achieve your financial goals efficiently and responsibly.</p>
                    <h6 class="mt-7 mb-2.5">A Commitment to Your Success</h6>
                    <p>At Unicorn Madagascar, our success is measured by the success of our clients. We believe in building long-term relationships based on trust, transparency, and personalized service. Whether you’re looking to diversify your portfolio with synthetic indices or explore additional opportunities through our affiliated advisors, we are here to support your financial journey. Our platform is built with user-friendly technology, detailed performance tracking, and dedicated customer service to help you make the most of your investments. Join Unicorn Madagascar today and discover a world of innovative investment solutions tailored to your needs.</p>
                    <br><br>
                    <button class="btn-outline-reg mfp-close as-button" type="button">Back</button>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div>
        <!-- end of about us pop up -->

        <!-- Details terms of use -->
        <!-- box-dialog -->

        <div id="details-term-of-use" class="lightbox-basic zoom-anim-dialog mfp-hide">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="lg:col-span-12">
                    <h3 class="mb-2">Terms of Use</h3>
                    <hr class="w-11 h-0.5 mt-0.5 mb-4 ml-0 border-none bg-indigo-600" />
                    <h6 class="mt-7 mb-2.5">1. Acceptance of Terms :</h6>
                    <p>By accessing or using Online job portal, you agree to comply with and be bound by these Terms of Use. If you do not agree with these terms, please do not use the Website.</p>
                    <h6 class="mt-7 mb-2.5">2. User Accounts :</h6>
                    <p>2.1 You may need to create a user account to access certain features of the Website. You are responsible for maintaining the confidentiality of your account information and agree to accept responsibility for all activities that occur under your account.</p>
                    <p>2.2 You must provide accurate and complete information when creating an account.</p>
                    <h6 class="mt-7 mb-2.5">3. User Conduct :</h6>
                    <p>3.1 You agree to use the Website only for lawful purposes and in a manner that does not infringe upon the rights of others or restrict their use and enjoyment of the Website.</p>
                    <p>3.2 You agree not to engage in any unauthorized access, data mining, or any activity that disrupts or interferes with the Website's functionality.</p>
                    <h6 class="mt-7 mb-2.5">4. Content :</h6>
                    <p>4.1 Users may submit content, including job postings, resumes, and reviews. By submitting content, you grant Online Job Portal a non-exclusive, royalty-free, perpetual, and worldwide license to use, modify, and distribute the content.</p>
                    <p>4.2 You agree not to submit false, misleading, or offensive content.</p>
                    <h6 class="mt-7 mb-2.5">5. Intellectual Property :</h6>
                    <p>5.1 The Website and its original content (excluding user-generated content) are owned by us and are protected by intellectual property laws.</p>
                    <p>5.2 You may not use the Website's content without explicit permission from us.</p>
                    <h6 class="mt-7 mb-2.5">6. Privacy :</h6>
                    <p>6.1 Your use of the Website is also governed by our <a class="popup-with-move-anim underline" href="#details-privacy-policy">Privacy Policy</a>.</p>
                    <h6 class="mt-7 mb-2.5">7. Limitation of Liability :</h6>
                    <p>7.1 We are not responsible for any damages, direct or indirect, arising from your use of the Website.</p>
                    <p>7.2 The Website may include links to third-party websites. We are not responsible for the content or actions of these third parties</p>
                    <h6 class="mt-7 mb-2.5">8. Indemnification :</h6>
                    <p>You agree to indemnify and hold us harmless from any claims, losses, or damages arising out of your use of the Website or violation of these Terms of Use.</p>
                    <h6 class="mt-7 mb-2.5">9. Termination :</h6>
                    <p>We reserve the right to terminate or suspend your account and access to the Website at its sole discretion.</p>
                    <h6 class="mt-7 mb-2.5">10. Governing Law :</h6>
                    <p>These Terms of Use are governed by the laws of  Jurisdiction, without regard to its conflict of law principles.</p>
                    <h6 class="mt-7 mb-2.5">11. Changes to Terms :</h6>
                    <p>We reserve the right to update or modify these Terms of Use at any time without prior notice.</p>
                    <h6 class="mt-7 mb-2.5">12. Contact Us :</h6>
                    <p>If you have any questions about these Terms of Use, please contact us at <a class="text-indigo-600 hover:text-gray-500" href="mailto:e.serasera.malalaka@gmail.com">e.serasera.malalaka@gmail.com</a></p>
                    <br><br>
                    <button class="btn-outline-reg mfp-close as-button" type="button">I Accept</button>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div>
        <!-- end of terms of use pop up -->

        <!-- Details Privacy policy -->
        <!-- box-dialog -->
        <div id="details-privacy-policy" class="lightbox-basic zoom-anim-dialog mfp-hide">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="lg:col-span-12">
                    <h3 class="mb-2">Privacy Policy</h3>
                    <span>Last updated: 08/22/2023</span>
                    <hr class="w-11 h-0.5 mt-0.5 mb-4 ml-0 border-none bg-indigo-600" />
                    <h6 class="mt-7 mb-2.5">Introduction :</h6>
                    <p>Welcome to our website. This Privacy Policy is intended to inform you about how we collect, use, disclose, and protect your personal information when you use our website [<a href="www.yourjobportalwebsite.com">www.yourjobportalwebsite.com</a>] and the services provided through it. By accessing or using the Website, you consent to the practices described in this policy</p>
                    <h6 class="mt-7 mb-2.5">Information We Collect :</h6>
                    <ol class="list-decimal ml-6">
                        <li>Personal Information: We may collect personal information from you when you register an account, submit a job application, post a job listing, or communicate with us. This may include your name, email address, phone number, resume, and other relevant details.</li>
                        <li>Usage Information: We collect information about how you interact with the Website, including the pages you visit, the jobs you view, and the actions you take. This data helps us improve the user experience and tailor our services to your preferences.</li>
                        <li>Device and Log Information: We automatically collect information about the device you use to access the Website and your usage of the Website. This includes your IP address, browser type, operating system, and other technical information.</li>
                    </ol>
                    <h6 class="mt-7 mb-2.5">How We Use Your Information :</h6>
                    <p>We use the information we collect for various purposes, including:</p>
                    <ol class="list-decimal ml-6">
                        <li>Providing Services: To facilitate job searches, match job seekers with employers, and enable communication between users.</li>
                        <li>Improving User Experience: To personalize your experience on the Website, optimize content, and provide relevant recommendations.</li>
                        <li>Communication: To send you notifications, updates, and promotional materials related to our services.</li>
                        <li>Analytics: To analyze trends, track usage patterns, and gather statistical data to improve our offerings.</li>
                    </ol>
                    <h6 class="mt-7 mb-2.5">Sharing Your Information :</h6>
                    <p>We may share your information with the following parties:</p>
                    <ol class="list-decimal ml-6">
                        <li>Employers and Job Seekers: Depending on your user role, we may share your information with employers or job seekers to facilitate job matching and communication.</li>
                        <li>Service Providers: We may engage third-party service providers to assist with various aspects of our services, such as analytics, hosting, and customer support.</li>
                        <li>Legal Compliance: We may disclose information if required by law, to protect our rights, or in response to legal requests.</li>
                    </ol>
                    <h6 class="mt-7 mb-2.5">Your Choices :</h6>
                    <ol class="list-decimal ml-6">
                        <li>Access and Update: You can access and update your personal information through your account settings on the Website.</li>
                        <li>Opt-Out: You can opt out of receiving promotional emails by following the instructions provided in the email.</li>
                        <li>Cookies: You can manage your cookie preferences through your browser settings.</li>
                    </ol>
                    <h6 class="mt-7 mb-2.5">Security :</h6>
                    <p>We implement security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure, so we cannot guarantee absolute security.</p>
                    <h6 class="mt-7 mb-2.5">Children's Privacy :</h6>
                    <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children. If you believe we have inadvertently collected such information, please contact us.</p>
                    <h6 class="mt-7 mb-2.5">Changes to this Policy :</h6>
                    <p>We may update this Privacy Policy to reflect changes in our practices or applicable laws. We will notify you of any material changes via the Website or other communication methods.</p>
                    <h6 class="mt-7 mb-2.5">Contact Us</h6>
                    <p>If you have any questions about this Privacy Policy, please contact us at [<a class="text-indigo-600 hover:text-gray-500" href="mailto:contact@yourjobportalwebsite.com">contact@yourjobportalwebsite.com</a>].</p>
                    <br><br>
                    <button class="btn-outline-reg mfp-close as-button text-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white" type="button">Accept Privacy</button>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div><!-- end of privacy policy pop up  -->

        <!-- Details cookies policy -->
        <!-- box-dialog -->
        <div id="details-cookies" class="lightbox-basic zoom-anim-dialog mfp-hide">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                <div class="lg:col-span-12">
                    <h3 class="mb-2">Cookies Policy</h3>
                    <span>Last updated: 08/22/2023</span>
                    <hr class="w-11 h-0.5 mt-0.5 mb-4 ml-0 border-none bg-indigo-600" />
                    <h6 class="mt-7 mb-2.5">Introduction :</h6>
                    <p>Welcome to Online Job Portal. This Cookies Policy is designed to help you understand how we use cookies, web beacons, and similar technologies on our website [<a href="www.yourjobportalwebsite.com">www.yourjobportalwebsite.com</a>] to enhance your experience and provide you with relevant information and services. By continuing to use our Website, you consent to the use of these technologies as described in this policy.</p>
                    <h6 class="mt-7 mb-2.5">What Are Cookies?</h6>
                    <p>Cookies are small text files that are stored on your device (computer, tablet, or mobile phone) when you visit certain websites. They are commonly used to remember your preferences, keep you logged in, and provide anonymized tracking data to help website owners understand how users interact with their sites.</p>
                    <h6 class="mt-7 mb-2.5">How We Use Cookies ?</h6>
                    <p>We use cookies for various purposes on Online Job Portal:</p>
                    <ol class="list-decimal ml-6">
                        <li>Essential Cookies: These cookies are necessary for the basic functionality of our Website. They allow you to navigate the site, log in to your account, and access secure areas. Without these cookies, certain features of the Website may not function properly.</li>
                        <li>Analytics and Performance Cookies: These cookies help us analyze how visitors use our Website. They provide us with valuable information about which pages are visited most often, how users navigate through the site, and if they encounter any errors. This data helps us improve the overall user experience.</li>
                        <li>Functionality Cookies: Functionality cookies allow the Website to remember your preferences and choices, such as your preferred language, location, and job search settings. This enables us to provide you with a more personalized experience.</li>
                        <li>Advertising and Targeting Cookies: These cookies are used to deliver relevant advertisements to you based on your interests and browsing behavior. They also help us measure the effectiveness of our advertising campaigns.</li>
                    </ol>
                    <h6 class="mt-7 mb-2.5 italic">Third-Party Cookies</h6>
                    <p>We may also allow third-party service providers to place cookies on your device through our Website to help us analyze usage statistics, provide you with social sharing features, and deliver advertisements tailored to your interests. These providers have their own privacy policies and may collect your information, including personal data, through the cookies they set.</p>
                    <h6 class="mt-7 mb-2.5 italic">Managing Cookies</h6>
                    <p>Most web browsers allow you to manage your cookie preferences. You can usually set your browser to refuse cookies or to alert you when cookies are being sent. However, please note that blocking or deleting cookies may impact your ability to use certain features of our Website.</p>
                    <h6 class="mt-7 mb-2.5 italic">Updates to this Policy</h6>
                    <p>We may update this Cookies Policy from time to time to reflect changes in technology or applicable laws. When we make changes, we will revise the "Last updated" date at the beginning of this policy. We encourage you to review this policy periodically to stay informed about how we use cookies.</p>
                    <h6 class="mt-7 mb-2.5">Contact Us</h6>
                    <p>If you have any questions about our Cookies Policy, please contact us at [<a class="text-indigo-600 hover:text-gray-500" href="mailto:contact@yourjobportalwebsite.com">contact@yourjobportalwebsite.com</a>].Remember to customize the placeholders and details in the policy to match your website and its practices. Also, consult with legal professionals to ensure that your Cookies Policy complies with relevant laws and regulations.</p>
                    <br><br>
                    <button class="btn-outline-reg mfp-close as-button" type="button">Accept Cookies</button>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div><!-- end of cookies policy pop up  -->

        <!-- investment plan -->
        <div id="plan" class="cards-1 px-4 md:px-8 lg:px-16 my-20">
            <h1 class="text-5xl font-bold text-center mb-12 bg-clip-text text-transparent bg-gradient-to-r from-red-500 via-pink-500 to-pink-400">
                Investment Plan
            </h1>



        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $investmentTypes = \App\Models\InvestmentType::getActiveTypes();
                @endphp
                @foreach($investmentTypes as $index => $type)
                @php
                $amountsInAriary = $type->getAmountsInAriary();
                $colorSchemes = [
                    [
                        'gradient' => 'from-gray-100 to-gray-200',
                        'border' => 'border-gray-300',
                        'icon' => 'bg-gray-300',
                        'button' => 'bg-gray-500 hover:bg-gray-600'
                    ],
                    [
                        'gradient' => 'from-yellow-100 to-yellow-200',
                        'border' => 'border-yellow-300',
                        'icon' => 'bg-yellow-400',
                        'button' => 'bg-yellow-500 hover:bg-yellow-600'
                    ],
                    [
                        'gradient' => 'from-purple-100 to-purple-200',
                        'border' => 'border-purple-300',
                        'icon' => 'bg-purple-400',
                        'button' => 'bg-purple-500 hover:bg-purple-600'
                    ],
                    [
                        'gradient' => 'from-blue-100 to-blue-200',
                        'border' => 'border-blue-300',
                        'icon' => 'bg-blue-400',
                        'button' => 'bg-blue-500 hover:bg-blue-600'
                    ]
                    ];
                $colorScheme = $colorSchemes[$index % count($colorSchemes)];
                @endphp
                <div class="bg-gradient-to-br {{ $colorScheme['gradient'] }} rounded-lg p-6 border {{ $colorScheme['border'] }} hover:shadow-lg transition-all duration-300 {{ $index === 3 ? 'relative' : '' }}">
                    @if($index === 3)
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-400 text-white text-xs px-2 py-1 rounded-full font-semibold">Premium</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-center w-12 h-12 {{ $colorScheme['icon'] }} rounded-full mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $type->name }}</h4>
                    <p class="text-sm text-gray-600 mb-4">{{ $type->description }}</p>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Min Amount:</span>
                            <span class="font-medium text-gray-900">{{ number_format($amountsInAriary['min_ariary'], 0, ',', ' ') }} Ar</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Max Amount:</span>
                            <span class="font-medium text-gray-900">
                                @if($amountsInAriary['max_ariary'])
                                    {{ number_format($amountsInAriary['max_ariary'], 0, ',', ' ') }} Ar
                                @else
                                    Unlimited
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">USD Equivalent:</span>
                            <span class="font-medium text-gray-900">
                                ${{ number_format($type->min_amount_usd, 0) }}
                                @if($type->max_amount_usd)
                                    - ${{ number_format($type->max_amount_usd, 0) }}
                                @else
                                    or more
                                @endif
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('investments.create') }}?type={{ $type->slug }}" class="w-full {{ $colorScheme['button'] }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center block">
                        Invest now
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        </div>
        <!-- Contrat terms -->
        <div class="pt-4 pb-6 text-center">
            <h1 class="text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-500 via-pink-500 to-pink-400">
                Terms of Contract
            </h1>
        </div>

        <div class="flex flex-col md:flex-row gap-6 justify-center mx-4 md:mx-8 my-20">
        <!-- Short-Term -->
            <div class="bg-gradient-to-br from-black via-gray-500 to-black p-6 rounded-lg flex-1">
                <div class="text-center">
                    <span class="px-6 py-2 mt-5 rounded-xl font-bold text-lg text-white bg-black bg-opacity-20">
                        Short - Term
                    </span>
                    <h3 class="mt-4 text-white text-xl font-semibold">3 to 7 days</h3>
                </div>
                <p class="mt-6 mb-4 text-white text-sm md:text-base">
                    Short-term contracts are ideal for urgent needs and rapid execution. They offer maximum flexibility and quick delivery, allowing clients to test our services, complete short missions, or react rapidly to business opportunities. This option is perfect for businesses seeking fast results without long commitments.
                </p>
            

                <div class="flex justify-center mt-6">
                    <a href="#short-term-details" class="open-popup inline-block bg-transparent text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:bg-transparent hover:text-white">
                        More details 
                        <span class="ml-2 inline-block transform transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </a>
                </div>
            <!-- Popup -->
                <div id="short-term-details" class="popup mt-20 hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 pointer-events-auto px-4">
                    <div class="popup-content bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-12 lg:p-16 max-w-full sm:max-w-md md:max-w-lg lg:max-w-4xl w-full relative z-50 overflow-y-auto max-h-[90vh]">
            <!-- Bouton fermeture en X -->
                        <button class="popup-close absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl sm:text-3xl">&times;</button>

            <!-- Contenu du popup statique -->
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 text-gray-800">Short-Term</h2>

                        <p class="text-gray-700 mb-4 text-sm sm:text-base md:text-lg">
                            Park your funds safely and earn quick returns with our ultra-short-term investment. 
                            Designed for <strong>3 to 7 days</strong>, this option gives you fast access to your money, 
                            low risk, and modest profits—perfect for managing temporary cash, emergency funds, or short-term financial goals.
                        </p>

                        <h3 class="text-lg sm:text-xl md:text-2xl font-semibold mb-2 text-gray-800">Key Features:</h3>
                        <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm sm:text-base md:text-lg">
                            <li><strong>Duration:</strong> 3–7 days</li>
                            <li><strong>Liquidity:</strong> Instant access after maturity</li>
                            <li><strong>Risk:</strong> Low-risk, capital preservation</li>
                            <li><strong>Returns:</strong> Modest but reliable</li>
                            <li><strong>Ideal for:</strong> Individuals or businesses needing quick, safe, and flexible investment options</li>
                        </ul>

                        <p class="text-gray-700 font-semibold text-sm sm:text-base md:text-lg">
                            Take control of your short-term funds without locking them away for months—<span class="text-blue-600">invest smart, invest short!</span>
                        </p>

                        <div class="mt-4 text-right">
                            <button class="popup-close-bottom bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                Close
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        <!-- Mean-Term -->
            <div class="bg-gradient-to-br from-black via-gray-500 to-black p-6 rounded-lg flex-1">
                <div class="text-center">
                    <span class="px-6 py-2 mt-5 rounded-xl font-bold text-lg text-white bg-black bg-opacity-20">
                        Mean - Term
                    </span>
                    <h3 class="mt-4 text-white text-xl font-semibold">7 to 15 days</h3>
                </div>
                <p class="mt-6 mb-4 text-white text-sm md:text-base">
                    Mean-term contracts provide a balanced solution between stability and speed. They allow for deeper work, better organization, and improved efficiency. This duration is suitable for projects requiring more coordination, follow-up, or continuous support while still remaining relatively flexible.
                </p>
                <div class="flex justify-center mt-6">
                    <a href="#mean-term-details" class="open-popup inline-block bg-transparent text-white font-bold py-3 px-6 rounded-xl shadow-lg">
                        More details 
                        <span class="ml-2 inline-block transform transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </a>
                </div>
            <!-- Popup -->
                <div id="mean-term-details" class="popup mt-20 hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 pointer-events-auto px-4">
                    <div class="popup-content bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-12 lg:p-16 max-w-full sm:max-w-md md:max-w-lg lg:max-w-4xl w-full relative z-50 overflow-y-auto max-h-[90vh]">
            <!-- Bouton fermeture en X -->
                        <button class="popup-close absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl sm:text-3xl">&times;</button>

            <!-- Contenu du popup statique -->
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 text-gray-800">Mean-Term</h2>

                        <p class="text-gray-700 mb-4 text-sm sm:text-base md:text-lg">
                            Secure your funds while earning reliable returns with our mean-term investment. 
                            Designed for <strong>7 to 15 days</strong>, this option provides quick access to your money, 
                            low risk, and moderate profits—perfect for managing temporary cash, emergency funds, or mean-term financial objectives.
                        </p>

                        <h3 class="text-lg sm:text-xl md:text-2xl font-semibold mb-2 text-gray-800">Key Features:</h3>
                        <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm sm:text-base md:text-lg">
                            <li><strong>Duration:</strong> 7–15 days</li>
                            <li><strong>Liquidity:</strong> Funds accessible after maturity</li>
                            <li><strong>Risk:</strong> Low-risk, capital preservation</li>
                            <li><strong>Returns:</strong> Moderate but consistent</li>
                            <li><strong>Ideal for:</strong> Individuals or businesses planning for long-term financial objectives</li>
                        </ul>

                        <p class="text-gray-700 font-semibold text-sm sm:text-base md:text-lg">
                            Manage your mid-term funds efficiently without long-term commitments—<span class="text-blue-600">invest smart, invest mean!</span>
                        </p>

                        <div class="mt-4 text-right">
                            <button class="popup-close-bottom bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Long-Term -->
            <div class="bg-gradient-to-br from-black via-gray-500 to-black p-6 rounded-lg flex-1">
                <div class="text-center">
                    <span class="px-6 py-2 mt-5 rounded-xl font-bold text-lg text-white bg-black bg-opacity-20">
                        Long - Term
                    </span>
                    <h3 class="mt-4 text-white text-xl font-semibold">1 to 2 months</h3>
                </div>
                <p class="mt-6 mb-4 text-white text-sm md:text-base">
                    Long-term contracts are designed for clients who want consistent results and long-lasting collaboration. They offer better planning, optimized performance, and stronger integration into your workflow. This is the best option for long projects, ongoing tasks, or when you need a dedicated and reliable team over an extended period.
                </p>
                <div class="flex justify-center mt-6">
                    <a href="#long-term-details" class="open-popup inline-block bg-transparent text-white font-bold py-3 px-6 rounded-xl shadow-lg">
                        More details 
                        <span class="ml-2 inline-block transform transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </a>
                </div>
            </div>
        </div>
                    <!-- popup long term -->
            <div id="long-term-details" class="popup mt-20 hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 pointer-events-auto px-4">
                <div class="popup-content bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-12 lg:p-16 max-w-full sm:max-w-md md:max-w-lg lg:max-w-4xl w-full relative z-50 overflow-y-auto max-h-[90vh]">
                <!-- Bouton fermeture en X -->
                    <button class="popup-close absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl sm:text-3xl">&times;</button>

                    <!-- Contenu du popup statique -->
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 text-gray-800">Long-Term</h2>

                    <p class="text-gray-700 mb-4 text-sm sm:text-base md:text-lg">
                        Secure your funds for the long haul and earn stable, higher returns with our long-term investment option. 
                        Designed for <strong>30 days or more</strong>, this option balances growth and stability, allowing you to plan ahead while enjoying reliable profits. 
                        Perfect for building wealth, planning major expenses, or achieving long-term financial goals.
                    </p>

                    <h3 class="text-lg sm:text-xl md:text-2xl font-semibold mb-2 text-gray-800">Key Features:</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm sm:text-base md:text-lg">
                        <li><strong>Duration:</strong> 1-2 months</li>
                        <li><strong>Liquidity:</strong> Accessible at maturity</li>
                        <li><strong>Risk:</strong> Low to moderate, capital growth focus</li>
                        <li><strong>Returns:</strong> Higher and more reliable than short-term options</li>
                        <li><strong>Ideal for:</strong> Individuals or businesses needing quick, safe, and flexible investment options</li>
                    </ul>

                    <p class="text-gray-700 font-semibold text-sm sm:text-base md:text-lg">
                        Take control of your long-term funds with confidence—<span class="text-blue-600">invest smart, invest long!</span>
                    </p>

                    <div class="mt-4 text-right">
                        <button class="popup-close-bottom bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                        Close
                        </button>
                    </div>
                </div>
            </div>


        <!-- avis -->
        <div class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-lg mt-10 mb-10">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Your opinion</h2>

    <form action="{{ route('envoyer.avis') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Your e-mail *</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="your@email.com"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none
                       focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required>
        </div>

        <!-- Avis -->
        <div id="opinion">
            <label for="avis" class="block text-gray-700 font-medium mb-1">Your opinion</label>
            <textarea id="avis" name="avis"  rows="4" placeholder="Your opinion here..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" required></textarea>
        </div>

        <!-- Bouton Envoyer -->
        <div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl shadow-lg transition">
                Send
            </button>
        </div>

        @if(session('success'))
            <p class="text-green-600 mt-2">{{ session('success') }}</p>
        @endif

    </form>
</div>




        <!-- Footer -->
        <div class="footer">
            <div class="container px-4 sm:px-8">
                <p class="mb-8 lg:max-w-3xl lg:mx-auto">Unicorn Madagascar is a web platform of investment and you can reach the team at <a class="text-indigo-600 hover:text-gray-500" href="mailto:e.serasera.malalaka@gmail.com">e.serasera.malalaka@gmail.com</a></p>
                <div class="social-container">
                    <span class="fa-stack">
                        <a href="https://www.facebook.com/profile.php?id=61578242373490&mibextid=ZbWKwL">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-facebook-f fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="https://whatsapp.com/channel/0029VbBpSdNFXUuhEBZ2xJ3h">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-whatsapp fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="https://www.instagram.com/world.unicorn.17?igsh=ZGUzMzM3NWJiOQ==">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-instagram fa-stack-1x"></i>
                        </a>
                    </span>
                </div> <!-- end of social-container -->
            </div> <!-- end of container -->
        </div> <!-- end of footer -->
        <!-- end of footer -->


        <!-- Copyright -->
        <div class="copyright">
            <div class="container px-2 sm:px-8 lg:grid lg:grid-cols-2">
                <ul class="mb-4 list-unstyled p-small">
                    <li class="mb-2 "><a class="popup-with-move-anim" href="#details-about-us">About us</a></li>
                    <li class="mb-2 "><a class="popup-with-move-anim" href="#details-term-of-use">Terms of Use</a></li>
                    <li class="mb-2 "><a class="popup-with-move-anim" href="#details-privacy-policy">Privacy Policy</a></li>
                    <li class="mb-2"><a class="popup-with-move-anim" href="#details-cookies">Cookies Policy</a></li>
                </ul>
                <p class="pb-2 p-small statement">Copyright © <a href="" class="no-underline">Unicorn Madagascar</a></p>
            </div>

        <!-- end of container -->
        </div> <!-- end of copyright -->
        <!-- end of copyright -->


        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script> <!-- jQuery for JavaScript plugins -->
        <script src="assets/js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
        <script src="assets/js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
        <script src="assets/js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
        <script src="assets/js/scripts.js"></script> <!-- Custom scripts -->
        <script>
            const btn = document.getElementById('toggle-btn');
            const para = document.getElementById('text-paragraph');

            btn.addEventListener('click', () => {
                para.classList.toggle('h-auto');   // Affiche tout le texte
                para.classList.toggle('overflow-hidden'); // Active/désactive le masquage
            btn.textContent = para.classList.contains('h-auto') ? 'Read less' : 'Read more';
            });
            

            // Popup functionality for term of contract section
            // Sélection des éléments
            const popup = document.querySelector('.popup');
            const openLinks = document.querySelectorAll('.open-popup');
            const closeBtn = popup.querySelector('.popup-close');
            const closeBottomBtn = popup.querySelector('.popup-close-bottom');

            // Ouvrir le popup
            openLinks.forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const popupId = link.getAttribute('href'); // get href like "#mean-term-popup"
                    const popup = document.querySelector(popupId);
                    if (popup) popup.classList.remove('hidden');
                });
            });


            // Fermer le popup
            document.querySelectorAll('.popup').forEach(popup => {
            // Close buttons (X and bottom)
                popup.querySelectorAll('.popup-close, .popup-close-bottom').forEach(btn => {
                    btn.addEventListener('click', () => popup.classList.add('hidden'));
                });

                // Close when clicking on overlay
                popup.addEventListener('click', e => {
                    if (e.target === popup) popup.classList.add('hidden');
                    });
                });

            // Fermer le popup avec la touche Échap
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.popup').forEach(popup => {
                        popup.classList.add('hidden');
                    });
                }
            }); 

            // End of popup functionality

            // broker image toggle
            const images = [
                "assets/images/alphaCapital.jpeg",
                "assets/images/deriv.jpeg",
                "assets/images/exness.jpeg",
                "assets/images/FBS.jpeg",
                "assets/images/fusionMarket.jpeg",
                "assets/images/grandCapital.jpeg",
                "assets/images/interactiveBrokers.jpeg",
                "assets/images/octaFX.jpeg",
                "assets/images/onFin.jpeg",
                "assets/images/raiseFX.jpeg",
                "assets/images/vantageFoundation.jpeg",
                "assets/images/welTrade.jpeg"
            ];

            const names = [
                "Alpha Capital",
                "Deriv",
                "Exness",
                "FBS",
                "Fusion Market",
                "Grand Capital",
                "Interactive Brokers",
                "OctaFX",
                "OnFin",
                "Raise FX",
                "Vantage Foundation",
                "WelTrade"
            ];

            let currentIndex = 0;

            function openLightbox(index) {
                currentIndex = index;
                document.getElementById('lightboxImg').src = images[currentIndex];
                document.getElementById('lightboxName').innerText = names[currentIndex];
                document.getElementById('lightbox').classList.remove('hidden');
                document.getElementById('lightbox').classList.add('flex');

                //desactiver le scroll de la page principale
                document.body.style.overflow = 'hidden';
                //desactiver le navbar
                const navbar = document.querySelector('.navbar.fixed-top');
                if (navbar) navbar.style.display = 'none';
            }
            function closeLightbox() {
                document.getElementById('lightbox').classList.add('hidden');
                document.getElementById('lightbox').classList.remove('flex');

                //reactiver le scroll de la page principale
                document.body.style.overflow = 'auto';

                // Afficher la navbar
                const navbar = document.querySelector('.navbar.fixed-top');
                if (navbar) navbar.style.display = 'flex';
            }
            function nextImage() {
                currentIndex = (currentIndex + 1) % images.length;
                document.getElementById('lightboxImg').src = images[currentIndex];
                document.getElementById('lightboxName').innerText = names[currentIndex];    
            }
            function prevImage() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                document.getElementById('lightboxImg').src = images[currentIndex];
                document.getElementById('lightboxName').innerText = names[currentIndex];
            }
        </script>
    </body>
</html>
