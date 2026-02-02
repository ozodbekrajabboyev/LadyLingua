@extends('layouts.app')

@section('content')
    <main class="max-w-[1200px] mx-auto py-8 px-4 md:px-10">

        <x-profile-header
            name="Alex Chen"
            title="Certified Japanese Translator | 10+ Years Experience"
        />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <x-sidebar>
                Expertise in high-stakes document localization with a focus on cultural nuance.
                Specializing in legal contracts, technical manuals, and contemporary literary works.
                Fluent in both Tokyo standard and Kansai dialects.
            </x-sidebar>

            <section class="lg:col-span-9">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-[#121117] dark:text-white">Past Works</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-work-card
                        image="https://lh3.googleusercontent.com/aida-public/AB6AXuAX0PQvgLJoc3lKlw0yEvffJQS5MhW4bOksGFM1rr34GxhF_2GaWHR3m4-7DlSJ6olrlQkc84z98N6h6oB1bbQc0-B0K6-vSVR6-J8qIQuVTOEYzsYA_4JgaAhaJFGx7tnvOGvGsEp0BikDWUKtWZtEXl_0D6tiwMJ999WpZa8i-zx82oIMCHPWy13wb1OGIrMUbnMgkBVPuDDn4UsV5gLL50OvmxHCx2jabrIAy9AqMemhDhQrAFJNetU2Si4S6gsU-rnk3aYpDIk"
                        category="Technical"
                        title="Automotive Operating Manual"
                        description="Translation of a 200-page diagnostic manual for a leading electric vehicle manufacturer."
                        wordCount="54,000"
                    />

                    <x-work-card
                        image="https://lh3.googleusercontent.com/aida-public/AB6AXuAN5k471p3UtjdMK06EcFLsz1n7I_dH25Yxma-1M2f-kLQlwtpsfimn7Etih_Kns6fT48ZZyI6w65AbHGJ-mRgzdRAZkyF48KkI-82kuHzqVVMxR_8uvWSxqO6gCX5siGVENONKA_XDCcRwwi2EfEuF6Xs6HbyS0e8Ch4IGCbqOTirvtnsxyci3ZC4hRF_a84d3s1OAw5rI1Q5V66Tnc0n0Qv700x4oWqTk6b5-F0R9R9eryjRc7Xzu8JPBqiwVMiQISBRp_05ryg8"
                        category="Legal"
                        title="Cross-Border M&A Contracts"
                        description="Localization of complex acquisition agreements between Tokyo and NYC firms."
                        wordCount="12,500"
                    />

                    <x-work-card
                        image="https://lh3.googleusercontent.com/aida-public/AB6AXuDmpU1-Mu6YHdxaMDr9ilCO3pokLARKrk4rCgWZEPfKRTLfYIwumzWzxVOlV-WmPvpvXvks9PbqTk7GOxObYfXT1tcOPG52eQQnHUVK3Eil83BX8Pdz5cX2joosTSWCcwHEw5Qi_NM0zeQHa_Iy05E-ZyWNFupWG6pt9DB9m5a6LJoOzhuWLTkNGcyKEvmQZhnch3Sx0IzQs6I5MIyn9AV3AQiWPqBtSN1r2mBdUW7Q9fsVUdM-pWm3OIk4wg2vpA-zcJEnga0JjSo"
                        category="Literary"
                        title="Modern Poetry Collection"
                        description="Nuanced English translation of contemporary Japanese avant-garde poetry anthology."
                        wordCount="8,000"
                    />

                    <x-work-card
                        image="https://lh3.googleusercontent.com/aida-public/AB6AXuDQBX_IDwEykKqtvTxUAIdgBuFDMPQC_DQ76VrMlFbffDZo2x5S0UXGdTBpggef_2mdyjebhEaT-V0NUOLdVA9hhs8jWpiY_Ba9Nbw3xCAQQ2ZPHA774MQ0zm8cUDwYf3tR9rqf1mQFkDa2Swedx7fWOkdwIbtgbpgwR60EYjlTYuTlj_5LPfMEo13ahVa_cJ2KzS7pV-OCSvbE4JD9OrC2JaN2tFlY0tPD7Wg2bSKNnxEvL1-dY5NjkJH4UhX3lHNfrOwldW-BI88"
                        category="Software"
                        title="Fintech App Localization"
                        description="Complete translation of UI strings and help documentation for a mobile trading app."
                        wordCount="15,000"
                    />
                </div>

                <div class="mt-10 flex justify-center">
                    <button class="px-8 py-3 rounded-lg border border-[#e5e7eb] dark:border-[#3a3a4a] text-sm font-bold text-[#121117] dark:text-white hover:bg-white dark:hover:bg-gray-800 transition-all">
                        Show More Projects
                    </button>
                </div>
            </section>
        </div>
    </main>
@endsection
