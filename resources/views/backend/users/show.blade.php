<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container">
                        <h2>Kullanıcı Detayları</h2><hr>
                        <p>Adı: {{ $user->name }}</p>
                        <p>Soyadı: {{ $user->surname }}</p>
                        <p>E-posta: {{ $user->email }}</p>
                        <p>Telefon: {{ $user->phone }}</p>
                        <p>Şirket İsmi: {{ $user->company_name }}</p>
                        <!-- Diğer kullanıcı bilgileri -->

                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container">
                    <h3>Kullanıcı İletişim Formları</h3><hr>
                    @foreach ($user->contactForms as $contactForm)
                        <p>Mesaj: {{ $contactForm->message }}</p>
                        <p>Telefon: {{ $contactForm->phone }}</p>
                        <p>Email: {{ $contactForm->email }}</p>
                        <!-- Diğer iletişim formu bilgileri -->
                        <hr>
                    @endforeach
                    </div>


                </div>
            </div>
        </div>

    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container">
                        <h3>Kullanıcı Meta Bilgileri</h3><hr>
                        @foreach ($user->metas as $meta)
                            <p>Şirket adı / Şehri : {{ $meta->company_name }} - {{ $meta->company_city }}</p>
                            <p>Şirket Bütçesi : {{ $meta->company_budget }}</p>
                            <!-- Diğer meta bilgileri -->
                        @endforeach
                    </div>


                </div>
            </div>
        </div>

    </div>
</x-app-layout>

