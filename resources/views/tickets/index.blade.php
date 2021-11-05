@extends('layouts.app', ['activePage' => 'tickets', 'titlePage' => __('Boletos')])
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('tickets.store')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info row">
                        <h4 class="col-12 card-title ">Boletos</h4>
                        <p class="col-8 card-category"> Lista de boletos</p>
                        <a href="{{ url('report/tickets')}}" target="_blank"  class="col-4">
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
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Aeropuerto Origen</th>
                                        <th>Fecha-Hora Despegue</th>
                                        <th>Aeropuerto Destino</th>
                                        <th>Fecha-Hora Aterrizaje</th>
                                        <th>Estado</th>
                                        <th>Usuario Registrador</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($tickets as $ticket)
                                <tr data-id = "{{$ticket->id}}">
                                    <td> {{ $ticket->code }} </td>

                                    <td> {{ $ticket->client->full_name }} </td>

                                    <td> {{ $ticket->airport_origin->name }} </td>

                                    <td> {{ $ticket->date_start}} </td>

                                    <td> {{ $ticket->airport_arrival->name}} </td>

                                    <td> {{ $ticket->date_arrival}} </td>

                                    <td> {{ $ticket->operation->state->name }} </td>

                                    <td> {{ $ticket->user->name }} </td>


                                    <td class="td-actions">
                                        <button type="button" class="btn btn-info btn-link throw-modal"
                                                data-toggle="modal" data-target="#ticketModal"
                                                title="Editar Boleto"
                                                data-action="edit"
                                                data-id="{{$ticket->id}}">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" class="delete btn btn-danger btn-link"
                                                title="Borrar Boleto"
                                                data-id="{{$ticket->id}}">
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
                        data-toggle="modal" data-target="#ticketModal"
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
    md.shotNotification('success','Boletos cargados con éxito')
    $(document).on('click','.delete', async function (){
        const ticket_id = $(this).closest('tr').data('id')
        try{
            const swal = await Swal.fire({
                title: '¿Estás seguro de borrar el boleto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            });

            if (swal.value) {
                const result = await window.Ticket.deleteTicket(ticket_id);
                if (result){
                    window.location.reload();
                }
            }
        }catch (e){
            console.log(e)
            md.shotNotification('danger',"Error al borrar el boleto")
        }

    });

    $(document).on('click','.throw-modal',function () {
        const action = $(this).data('action');
        const ticket_id = $(this).closest('tr').data('id');
        throw_modal(action,ticket_id);
    });
</script>
@endpush
