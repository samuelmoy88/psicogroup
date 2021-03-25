<x-admin-layout>
    <form action="{{ route('config.roles.update', ['role' => $role->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('config.edit_role') }}</h2>
                <a class="text-blue-500" href="{{ route('config.roles.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('config.roles_go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="name">{{ __("common.name") }} *</x-label>
                <x-input type="text" value="{{ $role->name }}" id="name" name="name"/>
            </div>
            <div class="mb-4 text-sm">
                <x-label class="mb-1">{{ __("config.permissions") }}</x-label>
                <div class="mb-3">
                    <x-checkbox type="checkbox" id="select_all" class="select_all "/>
                    <label class="cursor-pointer" for="select_all">{{ __('common.select_all') }}</label>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($permissions as $permission)
                        <div class="">
                            <label for="{{ $permission->id }}" class="cursor-pointer">
                                <input type="hidden" name="permissions[{{ $permission->id }}]" value="0">
                                <x-checkbox class="permission" value="1" name="permissions[{{ $permission->id }}]" id="{{ $permission->id }}"
                                    checked="{{ $role->permissions->contains($permission->id) ? true : false }}"/>
                                <span>{{ $permission->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
    <script>
        let parent = document.getElementById('select_all');

        parent.addEventListener('click', function () {
            let permissions = document.querySelectorAll('.permission');

            let checkAll = false;

            if (parent.checked === true) {
                checkAll = true;
            }

            for (let i = 0; i < permissions.length; i++) {
                permissions[i].checked = checkAll;
            }
        });
    </script>
</x-admin-layout>
