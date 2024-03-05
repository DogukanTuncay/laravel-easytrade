<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kullanıcıya Git</th>
                                <th>Adı</th>
                                <th>Soyadı</th>
                                <th>E-posta</th>
                                <th>Telefon</th>
                                <th>Şirket İsmi</th>
                                <th>Hesap Oluşturulma Tarihi</th>
                                <!-- Diğer sütun başlıkları -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <<tr>
                                <td class="btn btn-primary mt-2 mb-2"><a href="{{ route('users.show', $user->id) }}">Kullanıcıya Git</a></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->company_name }}</td>
                                <td>{{ $user->created_at->format('Y/m/d - H:i') }}</td>
                                <!-- Diğer sütun değerleri -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Sayfalama Linkleri -->
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
