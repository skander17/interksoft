@extends('layouts.app', ['activePage' => 'countries', 'titlePage' => __('Paises')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('countries.store')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-info row">
                            <h4 class="col-12 card-title ">Paises</h4>
                            <p class="col-8 card-category"> Lista de paises</p>
                            <a href="{{ url('report/contries')}}" target="_blank"  class="col-4">
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
        $(document).on('click','.delete', async function (){
            const country_id = $(this).closest('tr').data('id')
            try{
                const swal = await Swal.fire({
                    title: '¿Estás seguro de borrar el país?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar!',
                    reverseButtons: true
                });

                if (swal.value) {
                    const result = await window.Country.deleteCountry(country_id);
                    if (result){
                        window.location.reload();
                    }
                }
            }catch (e){
                md.shotNotification('danger',"Error al borrar el país")
            }

        });

        $(".throw-modal").on('click',function () {
            const action = $(this).data('action');
            const country_id = $(this).closest('tr').data('id');
            throw_modal(action,country_id);
        });
    </script>
@endpush
