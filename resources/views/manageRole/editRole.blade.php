<x-app-layout>
    <x-slot name="header">  
            {{ __('Edit Role') }}
    </x-slot>

    <div class="container border mb-5 rounded-4 shadow-sm" style="margin-top: 120px">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="my-3">
                <label class="form-label">Role Name</label>
                <input type="text" class="form-control" name="name" value="{{ $role->name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div class="row">
                    @foreach($permissions as $permission)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   name="permissions[]" 
                                   value="{{ $permission->name }}"
                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Role</button>
                <a href="{{ route('manageRole.list') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>