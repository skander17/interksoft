@extends('layouts.app', ['activePage' => 'clients', 'titlePage' => __('Clientes')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('clients.store')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-info row">
                            <h4 class="col-12 card-title ">Clientes</h4>
                            <p class="col-8 card-category"> Lista de clientes</p>
                            <a href="{{ url('report/clients')}}" target="_blank"  class="col-4">
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
                                        <th>Dni</th>
                                        <th>Email</th>
                                        <th>Pasaporte</th>
                                        <th>Fecha Exp. Pasaporte</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($clients as $client)
                                        <tr data-id = "{{$client->id}}">
                                            <td> {{ $client->full_name }} </td>

                                            <td> {{ $client->dni }} </td>

                                            <td> {{ $client->email }} </td>

                                            <td> {{ $client->passport }} </td>

                                            <td> {{ $client->passport_exp }} </td>

                                            <td> {{ $client->created_at }} </td>
                                            <td class="td-actions">
                                                <button type="button" class="btn btn-info btn-link throw-modal"
                                                        data-toggle="modal" data-target="#exampleModal"
                                                        title="Editar Usuario"
                                                        data-action="edit"
                                                        data-id="{{$client->id}}">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button type="button" class="delete btn btn-danger btn-link"
                                                        title="Borrar Usuario"
                                                        data-id="{{$client->id}}">
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
        setDataTable("#datatable");

        md.resolveStorageMessage();
        md.shotNotification('success','Clientes cargados con éxito')
        $(".delete").on('click',function () {
            const client_id = $(this).data('id')
            Swal.fire({
                title: '¿Estás seguro de borrar el Cliente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    let message = 'Error al borrar el cliente';
                    window.axios({
                        url: `api/clients/${client_id}`,
                        method: 'DELETE'
                    }).then(async (result) => {
                        if(result.data.message !== undefined){
                            message = result.data.message;
                        }
                        if (result.status === 206){
                            md.setAfterReload('success',message)
                            window.location.reload();
                        }else{
                            md.shotNotification('danger',message)
                        }
                    }).catch((error) => {
                        console.log(error.message)
                        md.shotNotification('danger',message)
                    });

                }
            })
        });

        $(".throw-modal").on('click',function () {
            const action = $(this).data('action');
            const client_id = $(this).closest('tr').data('id');
            throw_modal(action,client_id);
        });
    </script>
@endpush
