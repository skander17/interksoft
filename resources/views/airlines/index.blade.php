@extends('layouts.app', ['activePage' => 'airlines', 'titlePage' => __('Aerolineas')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('airlines.store')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-info row">
                            <h4 class="col-12 card-title ">Aerolineas</h4>
                            <p class="col-8 card-category"> Lista de aerolineas</p>
                            <a href="{{ url('report/airlines')}}" target="_blank"  class="col-4">
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
                                        <th>Descripción</th>
                                        <th>Código</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($airlines as $airline)
                                        <tr data-id = "{{$airline->id}}">
                                            <td> {{ $airline->ful_name }} </td>

                                            <td> {{ $airline->description }} </td>

                                            <td> {{ $airline->code }} </td>

                                            <td> {{ $airline->created_at }} </td>
                                            <td class="td-actions">
                                                <button type="button" class="btn btn-info btn-link throw-modal"
                                                        data-toggle="modal" data-target="#airlineModal"
                                                        title="Editar Usuario"
                                                        data-action="edit"
                                                        data-id="{{$airline->id}}">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button type="button" class="delete btn btn-danger btn-link"
                                                        title="Borrar Usuario"
                                                        data-id="{{$airline->id}}">
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
                            data-toggle="modal" data-target="#airlineModal"
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
        md.shotNotification('success','Aerolineas cargados con éxito')
        $(".delete").on('click',function () {
            const client_id = $(this).data('id')
            Swal.fire({
                title: '¿Estás seguro de borrar la Aerolinea?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    let message = 'Error al borrar la aerolinea';
                    window.axios.delete(
                         `api/airlines/${client_id}`
                    ).then(async (result) => {
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
            const airline_id = $(this).closest('tr').data('id');
            throw_modal(action,airline_id);
        });
    </script>
@endpush
