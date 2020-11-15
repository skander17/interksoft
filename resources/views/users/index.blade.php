@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Usuarios')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('users.store')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-info row">
                            <h4 class="col-12 card-title ">Usuarios</h4>
                            <p class="col-8 card-category"> Lista de usuarios</p>
                            <a href="{{ url('report/users')}}" target="_blank"  class="col-4">
                                <button class="btn btn-danger btn-fab btn-round btn-md"
                                        data-toggle="tooltip" data-placement="bottom" title="Exportar">
                                    <i class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table material-datatables" id="datatable" style="display: none">
                                    <thead class="text-body">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($users as $user)
                                    <tr data-id = "{{$user->id}}">
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->roles[0]->name}}
                                        </td>
                                        <td>
                                            {{ $user->created_at }}
                                        </td>
                                        <td class="td-actions">
                                            <button type="button" class="btn btn-dark btn-link throw-modal"
                                                    data-toggle="modal" data-target="#exampleModal"
                                                    title="Editar contraseña"
                                                    data-action="password"
                                            >
                                                <i class="material-icons">fingerprint</i>
                                            </button>
                                            <button type="button" class="btn btn-info btn-link throw-modal"
                                                    data-toggle="modal" data-target="#exampleModal"
                                                    title="Editar Usuario"
                                                    data-action="edit">
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button type="button" class="delete btn btn-danger btn-link"
                                                    title="Borrar Usuario"
                                                    data-id="{{$user->id}}">
                                                <i class="material-icons">delete</i>
                                            </button>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row fixed-bottom mx-4 my-5">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-info btn-round btn-fab throw-modal"
                            data-toggle="modal" data-target="#exampleModal"
                            data-action="create"
                            title="Agregar"
                    >
                        <i class="material-icons">add</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        setDataTable("#datatable")

        md.resolveStorageMessage();
        md.shotNotification('success','Usuarios cargados con éxito')
        $(document).on('click','.delete', async function (){
            const user_id = $(this).closest('tr').data('id')
            try{
                const swal = await Swal.fire({
                    title: '¿Estás seguro de borrar el usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar!',
                    reverseButtons: true
                });

                if (swal.value) {
                    const result = await window.Users.deleteUser(user_id);
                    if (result){
                        window.location.reload();
                    }
                }
            }catch (e){
                md.shotNotification('danger',"Error al borrar el usuario")
            }

        });

        $(document).on('click','.throw-modal',function () {
            const action = $(this).data('action');
            const user_id = $(this).closest('tr').data('id');
            throw_modal(action,user_id);
        });
    </script>
@endpush
