@extends('layouts.app', ['activePage' => 'countries', 'titlePage' => __('Paises')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('countries.store')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title ">Paises</h4>
                            <p class="card-category"> Lista de Paises</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table material-datatables" id="datatable" style="display: none">
                                    <thead class="text-body">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Código ISO</th>
                                        <th>Código Continente</th>
                                        <th>Acciones</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($countries as $country)
                                        <tr data-id = "{{$country->id}}">
                                            <td> {{ $country->name }} </td>

                                            <td> {{ $country->code }} </td>

                                            <td> {{ $country->continent_code ?: "No registra "}} </td>

                                            <td class="td-actions">
                                                <button type="button" class="btn btn-info btn-link throw-modal"
                                                        data-toggle="modal" data-target="#countryModal"
                                                        title="Editar Pais"
                                                        data-action="edit"
                                                        data-id="{{$country->id}}">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button type="button" class="delete btn btn-danger btn-link"
                                                        title="Borrar Pais"
                                                        data-id="{{$country->id}}">
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
                            data-toggle="modal" data-target="#countryModal"
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
        md.shotNotification('success','Paises cargados con éxito')
        $(".delete").on('click',function () {
            const client_id = $(this).data('id')
            Swal.fire({
                title: '¿Estás seguro de borrar el Pais?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    let message = 'Error al borrar el Pais';
                    window.axios({
                        url: `api/countries/${client_id}`,
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
            const country_id = $(this).closest('tr').data('id');
            throw_modal(action,country_id);
        });
    </script>
@endpush
